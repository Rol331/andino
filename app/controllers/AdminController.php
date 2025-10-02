<?php
// Controlador para el panel administrativo
class AdminController extends Controller {
    
    public function index() {
        if ($this->isAuthenticated()) {
            $this->dashboard();
        } else {
            $this->login();
        }
    }
    
    public function login() {
        if ($this->isAuthenticated()) {
            redirect('admin/dashboard');
        }
        
        $data = [
            'title' => 'Iniciar Sesión - Panel Administrativo EduFix'
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = sanitize($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Debug: mostrar datos recibidos
            error_log("Login attempt - Username: $username, Password length: " . strlen($password));
            error_log("POST data: " . print_r($_POST, true));
            
            if (empty($username) || empty($password)) {
                setFlashMessage('error', 'Por favor completa todos los campos');
                error_log("Login failed: Empty username or password");
            } else {
                try {
                    $userModel = $this->model('User');
                    error_log("User model loaded successfully");
                    
                    $user = $userModel->authenticate($username, $password);
                    error_log("Authentication result: " . ($user ? "SUCCESS" : "FAILED"));
                    
                    if ($user) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['user_role'] = $user['role'];
                        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                        
                        error_log("Session variables set for user: " . $user['username']);
                        setFlashMessage('success', '¡Bienvenido, ' . $user['first_name'] . '!');
                        
                        // Redireccionar manualmente
                        $redirectUrl = BASE_URL . "admin/dashboard";
                        error_log("Redirecting to: $redirectUrl");
                        header("Location: $redirectUrl");
                        exit();
                    } else {
                        setFlashMessage('error', 'Credenciales incorrectas. Verifica tu usuario y contraseña.');
                        error_log("Login failed: Invalid credentials for user: $username");
                    }
                } catch (Exception $e) {
                    setFlashMessage('error', 'Error del sistema: ' . $e->getMessage());
                    error_log("Login error: " . $e->getMessage());
                    error_log("Stack trace: " . $e->getTraceAsString());
                }
            }
        }
        
        $this->view('admin/login', $data);
    }
    
    public function logout() {
        session_destroy();
        redirect('admin/login');
    }
    
    public function dashboard() {
        $this->requireAuth();
        
        $courseModel = $this->model('Course');
        $postModel = $this->model('Post');
        $eventModel = $this->model('Event');
        $userModel = $this->model('User');
        $categoryModel = $this->model('CourseCategory');
        
        // Obtener estadísticas
        $courseStats = $courseModel->getStats();
        $postStats = $postModel->getStats();
        $eventStats = $eventModel->getStats();
        $userStats = $userModel->getStats();
        
        // Obtener datos recientes
        $recentCourses = $courseModel->findAll(5);
        $recentPosts = $postModel->findAll(5);
        $recentEvents = $eventModel->findAll(5);
        $recentUsers = $userModel->findAll(5);
        
        $data = [
            'title' => 'Dashboard - Panel Administrativo EduFix',
            'courseStats' => $courseStats,
            'postStats' => $postStats,
            'eventStats' => $eventStats,
            'userStats' => $userStats,
            'recentCourses' => $recentCourses,
            'recentPosts' => $recentPosts,
            'recentEvents' => $recentEvents,
            'recentUsers' => $recentUsers
        ];
        
        $this->view('admin/dashboard', $data);
    }
    
    public function events() {
        $this->requireAuth();
        
        $eventModel = $this->model('Event');
        $page = $_GET['page'] ?? 1;
        $limit = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        
        $events = $eventModel->findAll($limit, $offset);
        $totalEvents = $eventModel->count();
        $totalPages = ceil($totalEvents / $limit);
        
        $data = [
            'title' => 'Gestión de Eventos - Panel Administrativo',
            'events' => $events,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalEvents' => $totalEvents
        ];
        
        $this->view('admin/events/index', $data);
    }
    
    public function createEvent() {
        $this->requireAuth();
        
        $data = [
            'title' => 'Nuevo Evento - Panel Administrativo'
        ];
        
        $this->view('admin/events/edit', $data);
    }
    
    public function storeEvent() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/events');
        }
        
        $eventModel = $this->model('Event');
        
        // Validar datos
        $errors = $this->validateEventData($_POST);
        
        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            $data = [
                'title' => 'Nuevo Evento - Panel Administrativo',
                'event' => $_POST // Mantener datos del formulario
            ];
            $this->view('admin/events/edit', $data);
            return;
        }
        
        try {
            // Procesar imagen
            $imageName = $this->processImageUpload();
            
            // Generar slug si no se proporciona
            $slug = !empty($_POST['slug']) ? $_POST['slug'] : $eventModel->generateSlug($_POST['title']);
            
            // Preparar datos
            $eventData = [
                'title' => sanitize($_POST['title']),
                'slug' => $slug,
                'description' => sanitize($_POST['description']),
                'featured_image' => $imageName,
                'event_date' => $_POST['event_date'],
                'location' => sanitize($_POST['location']),
                'price' => floatval($_POST['price'] ?? 0),
                'max_attendees' => !empty($_POST['max_attendees']) ? intval($_POST['max_attendees']) : null,
                'status' => $_POST['status'],
                'organizer_id' => $_SESSION['user_id']
            ];
            
            // Crear evento
            if ($eventModel->create($eventData)) {
                setFlashMessage('success', 'Evento creado exitosamente.');
                redirect('admin/events');
            } else {
                throw new Exception('Error al crear el evento en la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error creating event: " . $e->getMessage());
            setFlashMessage('error', 'Error al crear el evento: ' . $e->getMessage());
            redirect('admin/events/create');
        }
    }
    
    public function editEvent($id) {
        $this->requireAuth();
        
        $eventModel = $this->model('Event');
        
        $event = $eventModel->find($id);
        if (!$event) {
            setFlashMessage('error', 'Evento no encontrado.');
            redirect('admin/events');
        }
        
        // Verificar permisos (organizadores solo pueden editar sus propios eventos, admins pueden editar todos)
        if ($_SESSION['user_role'] !== 'admin' && $event['organizer_id'] != $_SESSION['user_id']) {
            setFlashMessage('error', 'No tienes permisos para editar este evento.');
            redirect('admin/events');
        }
        
        $data = [
            'title' => 'Editar Evento - Panel Administrativo',
            'event' => $event
        ];
        
        $this->view('admin/events/edit', $data);
    }
    
    public function updateEvent($id) {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/events');
        }
        
        $eventModel = $this->model('Event');
        
        $event = $eventModel->find($id);
        if (!$event) {
            setFlashMessage('error', 'Evento no encontrado.');
            redirect('admin/events');
        }
        
        // Verificar permisos
        if ($_SESSION['user_role'] !== 'admin' && $event['organizer_id'] != $_SESSION['user_id']) {
            setFlashMessage('error', 'No tienes permisos para editar este evento.');
            redirect('admin/events');
        }
        
        // Validar datos
        $errors = $this->validateEventData($_POST, $id);
        
        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('admin/events/edit/' . $id);
        }
        
        try {
            // Procesar imagen
            $imageName = $this->processImageUpload($event['featured_image']);
            
            // Generar slug si no se proporciona
            $slug = !empty($_POST['slug']) ? $_POST['slug'] : $eventModel->generateSlug($_POST['title']);
            
            // Preparar datos
            $eventData = [
                'title' => sanitize($_POST['title']),
                'slug' => $slug,
                'description' => sanitize($_POST['description']),
                'featured_image' => $imageName,
                'event_date' => $_POST['event_date'],
                'location' => sanitize($_POST['location']),
                'price' => floatval($_POST['price'] ?? 0),
                'max_attendees' => !empty($_POST['max_attendees']) ? intval($_POST['max_attendees']) : null,
                'status' => $_POST['status']
            ];
            
            // Actualizar evento
            if ($eventModel->update($id, $eventData)) {
                setFlashMessage('success', 'Evento actualizado exitosamente.');
                redirect('admin/events');
            } else {
                throw new Exception('Error al actualizar el evento en la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error updating event: " . $e->getMessage());
            setFlashMessage('error', 'Error al actualizar el evento: ' . $e->getMessage());
            redirect('admin/events/edit/' . $id);
        }
    }
    
    public function deleteEvent($id) {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/events');
        }
        
        $eventModel = $this->model('Event');
        
        $event = $eventModel->find($id);
        if (!$event) {
            setFlashMessage('error', 'Evento no encontrado.');
            redirect('admin/events');
        }
        
        // Verificar permisos
        if ($_SESSION['user_role'] !== 'admin' && $event['organizer_id'] != $_SESSION['user_id']) {
            setFlashMessage('error', 'No tienes permisos para eliminar este evento.');
            redirect('admin/events');
        }
        
        try {
            // Eliminar imagen si existe
            if (!empty($event['featured_image'])) {
                $imagePath = __DIR__ . '/../../assets/images/' . $event['featured_image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            // Eliminar evento
            if ($eventModel->delete($id)) {
                setFlashMessage('success', 'Evento eliminado exitosamente.');
            } else {
                throw new Exception('Error al eliminar el evento de la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error deleting event: " . $e->getMessage());
            setFlashMessage('error', 'Error al eliminar el evento: ' . $e->getMessage());
        }
        
        redirect('admin/events');
    }
    
    private function validateEventData($data, $eventId = null) {
        $errors = [];
        
        // Validar título
        if (empty($data['title'])) {
            $errors[] = 'El título del evento es requerido.';
        } elseif (strlen($data['title']) > 255) {
            $errors[] = 'El título no puede exceder 255 caracteres.';
        }
        
        // Validar descripción
        if (empty($data['description'])) {
            $errors[] = 'La descripción del evento es requerida.';
        }
        
        // Validar fecha
        if (empty($data['event_date'])) {
            $errors[] = 'La fecha del evento es requerida.';
        } else {
            $eventDate = new DateTime($data['event_date']);
            $now = new DateTime();
            if ($eventDate < $now) {
                $errors[] = 'La fecha del evento debe ser futura.';
            }
        }
        
        // Validar ubicación
        if (empty($data['location'])) {
            $errors[] = 'La ubicación del evento es requerida.';
        } elseif (strlen($data['location']) > 255) {
            $errors[] = 'La ubicación no puede exceder 255 caracteres.';
        }
        
        // Validar estado
        if (empty($data['status']) || !in_array($data['status'], ['published', 'draft', 'cancelled'])) {
            $errors[] = 'El estado del evento es requerido y debe ser válido.';
        }
        
        // Validar precio
        if (isset($data['price']) && (!is_numeric($data['price']) || $data['price'] < 0)) {
            $errors[] = 'El precio debe ser un número válido mayor o igual a 0.';
        }
        
        // Validar máximo de asistentes
        if (!empty($data['max_attendees']) && (!is_numeric($data['max_attendees']) || $data['max_attendees'] < 1)) {
            $errors[] = 'El máximo de asistentes debe ser un número válido mayor a 0.';
        }
        
        // Validar slug único
        if (!empty($data['slug'])) {
            $eventModel = $this->model('Event');
            $existingEvent = $eventModel->findBySlug($data['slug']);
            if ($existingEvent && $existingEvent['id'] != $eventId) {
                $errors[] = 'El slug ya está en uso por otro evento.';
            }
        }
        
        return $errors;
    }
    
    public function users() {
        $this->requireAdmin();
        
        $userModel = $this->model('User');
        $page = $_GET['page'] ?? 1;
        $limit = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        
        $users = $userModel->findAll($limit, $offset);
        $totalUsers = $userModel->count();
        $totalPages = ceil($totalUsers / $limit);
        
        $data = [
            'title' => 'Gestión de Usuarios - Panel Administrativo',
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalUsers' => $totalUsers
        ];
        
        $this->view('admin/users/index', $data);
    }
    
    public function createUser() {
        $this->requireAdmin();
        
        $data = [
            'title' => 'Nuevo Usuario - Panel Administrativo'
        ];
        
        $this->view('admin/users/edit', $data);
    }
    
    public function storeUser() {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/users');
        }
        
        $userModel = $this->model('User');
        
        // Validar datos
        $errors = $this->validateUserData($_POST);
        
        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            $data = [
                'title' => 'Nuevo Usuario - Panel Administrativo',
                'user' => $_POST // Mantener datos del formulario
            ];
            $this->view('admin/users/edit', $data);
            return;
        }
        
        try {
            // Procesar imagen
            $imageName = $this->processImageUpload();
            
            // Preparar datos
            $userData = [
                'username' => sanitize($_POST['username']),
                'email' => sanitize($_POST['email']),
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'first_name' => sanitize($_POST['first_name']),
                'last_name' => sanitize($_POST['last_name']),
                'role' => $_POST['role'],
                'status' => $_POST['status'],
                'profile_image' => $imageName,
                'bio' => sanitize($_POST['bio'] ?? '')
            ];
            
            // Crear usuario
            if ($userModel->create($userData)) {
                setFlashMessage('success', 'Usuario creado exitosamente.');
                redirect('admin/users');
            } else {
                throw new Exception('Error al crear el usuario en la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error creating user: " . $e->getMessage());
            setFlashMessage('error', 'Error al crear el usuario: ' . $e->getMessage());
            redirect('admin/users/create');
        }
    }
    
    public function editUser($id) {
        $this->requireAdmin();
        
        $userModel = $this->model('User');
        
        $user = $userModel->find($id);
        if (!$user) {
            setFlashMessage('error', 'Usuario no encontrado.');
            redirect('admin/users');
        }
        
        $data = [
            'title' => 'Editar Usuario - Panel Administrativo',
            'user' => $user
        ];
        
        $this->view('admin/users/edit', $data);
    }
    
    public function updateUser($id) {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/users');
        }
        
        $userModel = $this->model('User');
        
        $user = $userModel->find($id);
        if (!$user) {
            setFlashMessage('error', 'Usuario no encontrado.');
            redirect('admin/users');
        }
        
        // Validar datos
        $errors = $this->validateUserData($_POST, $id);
        
        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('admin/users/edit/' . $id);
        }
        
        try {
            // Procesar imagen
            $imageName = $this->processImageUpload($user['profile_image']);
            
            // Preparar datos
            $userData = [
                'username' => sanitize($_POST['username']),
                'email' => sanitize($_POST['email']),
                'first_name' => sanitize($_POST['first_name']),
                'last_name' => sanitize($_POST['last_name']),
                'role' => $_POST['role'],
                'status' => $_POST['status'],
                'profile_image' => $imageName,
                'bio' => sanitize($_POST['bio'] ?? '')
            ];
            
            // Actualizar usuario
            if ($userModel->update($id, $userData)) {
                setFlashMessage('success', 'Usuario actualizado exitosamente.');
                redirect('admin/users');
            } else {
                throw new Exception('Error al actualizar el usuario en la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            setFlashMessage('error', 'Error al actualizar el usuario: ' . $e->getMessage());
            redirect('admin/users/edit/' . $id);
        }
    }
    
    public function deleteUser($id) {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/users');
        }
        
        $userModel = $this->model('User');
        
        $user = $userModel->find($id);
        if (!$user) {
            setFlashMessage('error', 'Usuario no encontrado.');
            redirect('admin/users');
        }
        
        // No permitir eliminar el propio usuario
        if ($user['id'] == $_SESSION['user_id']) {
            setFlashMessage('error', 'No puedes eliminar tu propia cuenta.');
            redirect('admin/users');
        }
        
        try {
            // Eliminar imagen si existe
            if (!empty($user['profile_image'])) {
                $imagePath = __DIR__ . '/../../assets/images/' . $user['profile_image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            // Eliminar usuario
            if ($userModel->delete($id)) {
                setFlashMessage('success', 'Usuario eliminado exitosamente.');
            } else {
                throw new Exception('Error al eliminar el usuario de la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error deleting user: " . $e->getMessage());
            setFlashMessage('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
        
        redirect('admin/users');
    }
    
    public function resetPassword($id) {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/users');
        }
        
        $userModel = $this->model('User');
        
        $user = $userModel->find($id);
        if (!$user) {
            setFlashMessage('error', 'Usuario no encontrado.');
            redirect('admin/users');
        }
        
        try {
            // Generar contraseña temporal
            $tempPassword = $this->generateTempPassword();
            $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);
            
            // Actualizar contraseña
            if ($userModel->updatePassword($id, $hashedPassword)) {
                setFlashMessage('success', 'Contraseña reseteada exitosamente. Nueva contraseña temporal: <strong>' . $tempPassword . '</strong>');
            } else {
                throw new Exception('Error al resetear la contraseña en la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error resetting password: " . $e->getMessage());
            setFlashMessage('error', 'Error al resetear la contraseña: ' . $e->getMessage());
        }
        
        redirect('admin/users');
    }
    
    private function validateUserData($data, $userId = null) {
        $errors = [];
        
        // Validar nombre
        if (empty($data['first_name'])) {
            $errors[] = 'El nombre es requerido.';
        } elseif (strlen($data['first_name']) > 50) {
            $errors[] = 'El nombre no puede exceder 50 caracteres.';
        }
        
        // Validar apellido
        if (empty($data['last_name'])) {
            $errors[] = 'El apellido es requerido.';
        } elseif (strlen($data['last_name']) > 50) {
            $errors[] = 'El apellido no puede exceder 50 caracteres.';
        }
        
        // Validar username
        if (empty($data['username'])) {
            $errors[] = 'El nombre de usuario es requerido.';
        } elseif (strlen($data['username']) > 50) {
            $errors[] = 'El nombre de usuario no puede exceder 50 caracteres.';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
            $errors[] = 'El nombre de usuario solo puede contener letras, números y guiones bajos.';
        } else {
            // Verificar username único
            $userModel = $this->model('User');
            $existingUser = $userModel->findByUsername($data['username']);
            if ($existingUser && $existingUser['id'] != $userId) {
                $errors[] = 'El nombre de usuario ya está en uso.';
            }
        }
        
        // Validar email
        if (empty($data['email'])) {
            $errors[] = 'El email es requerido.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El email no tiene un formato válido.';
        } elseif (strlen($data['email']) > 100) {
            $errors[] = 'El email no puede exceder 100 caracteres.';
        } else {
            // Verificar email único
            $userModel = $this->model('User');
            $existingUser = $userModel->findByEmail($data['email']);
            if ($existingUser && $existingUser['id'] != $userId) {
                $errors[] = 'El email ya está en uso.';
            }
        }
        
        // Validar contraseña para nuevos usuarios
        if (!$userId) {
            if (empty($data['password'])) {
                $errors[] = 'La contraseña es requerida.';
            } elseif (strlen($data['password']) < 6) {
                $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
            }
            
            if (empty($data['password_confirm'])) {
                $errors[] = 'La confirmación de contraseña es requerida.';
            } elseif ($data['password'] !== $data['password_confirm']) {
                $errors[] = 'Las contraseñas no coinciden.';
            }
        }
        
        // Validar rol
        if (empty($data['role']) || !in_array($data['role'], ['admin', 'instructor', 'student'])) {
            $errors[] = 'El rol es requerido y debe ser válido.';
        }
        
        // Validar estado
        if (empty($data['status']) || !in_array($data['status'], ['active', 'inactive'])) {
            $errors[] = 'El estado es requerido y debe ser válido.';
        }
        
        return $errors;
    }
    
    private function generateTempPassword($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
    }
    
    public function posts() {
        $this->requireAuth();
        
        $postModel = $this->model('Post');
        $page = $_GET['page'] ?? 1;
        $limit = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        
        $posts = $postModel->findAll($limit, $offset);
        $totalPosts = $postModel->count();
        $totalPages = ceil($totalPosts / $limit);
        
        $data = [
            'title' => 'Gestión de Posts - Panel Administrativo',
            'posts' => $posts,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPosts' => $totalPosts
        ];
        
        $this->view('admin/posts/index', $data);
    }
    
    public function createPost() {
        $this->requireAuth();
        
        $categoryModel = $this->model('CourseCategory');
        $categories = $categoryModel->findAll();
        
        $data = [
            'title' => 'Nuevo Post - Panel Administrativo',
            'categories' => $categories
        ];
        
        $this->view('admin/posts/edit', $data);
    }
    
    public function storePost() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/posts');
        }
        
        $postModel = $this->model('Post');
        $categoryModel = $this->model('CourseCategory');
        
        // Validar datos
        $errors = $this->validatePostData($_POST);
        
        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            $categories = $categoryModel->findAll();
            $data = [
                'title' => 'Nuevo Post - Panel Administrativo',
                'categories' => $categories,
                'post' => $_POST // Mantener datos del formulario
            ];
            $this->view('admin/posts/edit', $data);
            return;
        }
        
        try {
            // Procesar imagen
            $imageName = $this->processImageUpload();
            
            // Generar slug si no se proporciona
            $slug = !empty($_POST['slug']) ? $_POST['slug'] : $postModel->generateSlug($_POST['title']);
            
            // Preparar datos
            $postData = [
                'title' => sanitize($_POST['title']),
                'slug' => $slug,
                'content' => sanitize($_POST['content']),
                'excerpt' => sanitize($_POST['excerpt'] ?? ''),
                'featured_image' => $imageName,
                'status' => $_POST['status'],
                'author_id' => $_SESSION['user_id'],
                'category_id' => !empty($_POST['category_id']) ? intval($_POST['category_id']) : null
            ];
            
            // Crear post
            if ($postModel->create($postData)) {
                setFlashMessage('success', 'Post creado exitosamente.');
                redirect('admin/posts');
            } else {
                throw new Exception('Error al crear el post en la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error creating post: " . $e->getMessage());
            setFlashMessage('error', 'Error al crear el post: ' . $e->getMessage());
            redirect('admin/posts/create');
        }
    }
    
    public function editPost($id) {
        $this->requireAuth();
        
        $postModel = $this->model('Post');
        $categoryModel = $this->model('CourseCategory');
        
        $post = $postModel->find($id);
        if (!$post) {
            setFlashMessage('error', 'Post no encontrado.');
            redirect('admin/posts');
        }
        
        // Verificar permisos (autores solo pueden editar sus propios posts, admins pueden editar todos)
        if ($_SESSION['user_role'] !== 'admin' && $post['author_id'] != $_SESSION['user_id']) {
            setFlashMessage('error', 'No tienes permisos para editar este post.');
            redirect('admin/posts');
        }
        
        $categories = $categoryModel->findAll();
        
        $data = [
            'title' => 'Editar Post - Panel Administrativo',
            'post' => $post,
            'categories' => $categories
        ];
        
        $this->view('admin/posts/edit', $data);
    }
    
    public function updatePost($id) {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/posts');
        }
        
        $postModel = $this->model('Post');
        
        $post = $postModel->find($id);
        if (!$post) {
            setFlashMessage('error', 'Post no encontrado.');
            redirect('admin/posts');
        }
        
        // Verificar permisos
        if ($_SESSION['user_role'] !== 'admin' && $post['author_id'] != $_SESSION['user_id']) {
            setFlashMessage('error', 'No tienes permisos para editar este post.');
            redirect('admin/posts');
        }
        
        // Validar datos
        $errors = $this->validatePostData($_POST, $id);
        
        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('admin/posts/edit/' . $id);
        }
        
        try {
            // Procesar imagen
            $imageName = $this->processImageUpload($post['featured_image']);
            
            // Generar slug si no se proporciona
            $slug = !empty($_POST['slug']) ? $_POST['slug'] : $postModel->generateSlug($_POST['title']);
            
            // Preparar datos
            $postData = [
                'title' => sanitize($_POST['title']),
                'slug' => $slug,
                'content' => sanitize($_POST['content']),
                'excerpt' => sanitize($_POST['excerpt'] ?? ''),
                'featured_image' => $imageName,
                'status' => $_POST['status'],
                'category_id' => !empty($_POST['category_id']) ? intval($_POST['category_id']) : null
            ];
            
            // Actualizar post
            if ($postModel->update($id, $postData)) {
                setFlashMessage('success', 'Post actualizado exitosamente.');
                redirect('admin/posts');
            } else {
                throw new Exception('Error al actualizar el post en la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error updating post: " . $e->getMessage());
            setFlashMessage('error', 'Error al actualizar el post: ' . $e->getMessage());
            redirect('admin/posts/edit/' . $id);
        }
    }
    
    public function deletePost($id) {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/posts');
        }
        
        $postModel = $this->model('Post');
        
        $post = $postModel->find($id);
        if (!$post) {
            setFlashMessage('error', 'Post no encontrado.');
            redirect('admin/posts');
        }
        
        // Verificar permisos
        if ($_SESSION['user_role'] !== 'admin' && $post['author_id'] != $_SESSION['user_id']) {
            setFlashMessage('error', 'No tienes permisos para eliminar este post.');
            redirect('admin/posts');
        }
        
        try {
            // Eliminar imagen si existe
            if (!empty($post['featured_image'])) {
                $imagePath = __DIR__ . '/../../assets/images/' . $post['featured_image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            // Eliminar post
            if ($postModel->delete($id)) {
                setFlashMessage('success', 'Post eliminado exitosamente.');
            } else {
                throw new Exception('Error al eliminar el post de la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error deleting post: " . $e->getMessage());
            setFlashMessage('error', 'Error al eliminar el post: ' . $e->getMessage());
        }
        
        redirect('admin/posts');
    }
    
    private function validatePostData($data, $postId = null) {
        $errors = [];
        
        // Validar título
        if (empty($data['title'])) {
            $errors[] = 'El título del post es requerido.';
        } elseif (strlen($data['title']) > 255) {
            $errors[] = 'El título no puede exceder 255 caracteres.';
        }
        
        // Validar contenido
        if (empty($data['content'])) {
            $errors[] = 'El contenido del post es requerido.';
        }
        
        // Validar estado
        if (empty($data['status']) || !in_array($data['status'], ['published', 'draft', 'archived'])) {
            $errors[] = 'El estado del post es requerido y debe ser válido.';
        }
        
        // Validar slug único
        if (!empty($data['slug'])) {
            $postModel = $this->model('Post');
            $existingPost = $postModel->findBySlug($data['slug']);
            if ($existingPost && $existingPost['id'] != $postId) {
                $errors[] = 'El slug ya está en uso por otro post.';
            }
        }
        
        return $errors;
    }
    
    public function courses() {
        $this->requireInstructor();
        
        $courseModel = $this->model('Course');
        $categoryModel = $this->model('CourseCategory');
        
        $page = $_GET['page'] ?? 1;
        $limit = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        
        $courses = $courseModel->findAll($limit, $offset);
        $categories = $categoryModel->findAll();
        $totalCourses = $courseModel->count();
        $totalPages = ceil($totalCourses / $limit);
        
        $data = [
            'title' => 'Gestión de Cursos - Panel Administrativo',
            'courses' => $courses,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCourses' => $totalCourses
        ];
        
        $this->view('admin/courses/index', $data);
    }
    
    public function create() {
        $this->requireInstructor();
        
        $categoryModel = $this->model('CourseCategory');
        $categories = $categoryModel->findAll();
        
        $data = [
            'title' => 'Nuevo Curso - Panel Administrativo',
            'categories' => $categories
        ];
        
        $this->view('admin/courses/edit', $data);
    }
    
    public function store() {
        $this->requireInstructor();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/courses');
        }
        
        $courseModel = $this->model('Course');
        $categoryModel = $this->model('CourseCategory');
        
        // Validar datos
        $errors = $this->validateCourseData($_POST);
        
        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            $categories = $categoryModel->findAll();
            $data = [
                'title' => 'Nuevo Curso - Panel Administrativo',
                'categories' => $categories,
                'course' => $_POST // Mantener datos del formulario
            ];
            $this->view('admin/courses/edit', $data);
            return;
        }
        
        try {
            // Procesar imagen
            $imageName = $this->processImageUpload();
            
            // Generar slug si no se proporciona
            $slug = !empty($_POST['slug']) ? $_POST['slug'] : $courseModel->generateSlug($_POST['title']);
            
            // Preparar datos
            $courseData = [
                'title' => sanitize($_POST['title']),
                'slug' => $slug,
                'description' => sanitize($_POST['description']),
                'short_description' => sanitize($_POST['short_description'] ?? ''),
                'featured_image' => $imageName,
                'price' => floatval($_POST['price'] ?? 0),
                'duration' => sanitize($_POST['duration'] ?? ''),
                'level' => $_POST['level'],
                'status' => $_POST['status'],
                'instructor_id' => $_SESSION['user_id'],
                'category_id' => !empty($_POST['category_id']) ? intval($_POST['category_id']) : null
            ];
            
            // Crear curso
            if ($courseModel->create($courseData)) {
                setFlashMessage('success', 'Curso creado exitosamente.');
                redirect('admin/courses');
            } else {
                throw new Exception('Error al crear el curso en la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error creating course: " . $e->getMessage());
            setFlashMessage('error', 'Error al crear el curso: ' . $e->getMessage());
            redirect('admin/courses/create');
        }
    }
    
    public function edit($id) {
        $this->requireInstructor();
        
        $courseModel = $this->model('Course');
        $categoryModel = $this->model('CourseCategory');
        
        $course = $courseModel->find($id);
        if (!$course) {
            setFlashMessage('error', 'Curso no encontrado.');
            redirect('admin/courses');
        }
        
        // Verificar permisos (instructores solo pueden editar sus propios cursos, admins pueden editar todos)
        if ($_SESSION['user_role'] !== 'admin' && $course['instructor_id'] != $_SESSION['user_id']) {
            setFlashMessage('error', 'No tienes permisos para editar este curso.');
            redirect('admin/courses');
        }
        
        $categories = $categoryModel->findAll();
        
        $data = [
            'title' => 'Editar Curso - Panel Administrativo',
            'course' => $course,
            'categories' => $categories
        ];
        
        $this->view('admin/courses/edit', $data);
    }
    
    public function update($id) {
        $this->requireInstructor();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/courses');
        }
        
        $courseModel = $this->model('Course');
        
        $course = $courseModel->find($id);
        if (!$course) {
            setFlashMessage('error', 'Curso no encontrado.');
            redirect('admin/courses');
        }
        
        // Verificar permisos
        if ($_SESSION['user_role'] !== 'admin' && $course['instructor_id'] != $_SESSION['user_id']) {
            setFlashMessage('error', 'No tienes permisos para editar este curso.');
            redirect('admin/courses');
        }
        
        // Validar datos
        $errors = $this->validateCourseData($_POST, $id);
        
        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('admin/courses/edit/' . $id);
        }
        
        try {
            // Procesar imagen
            $imageName = $this->processImageUpload($course['featured_image']);
            
            // Generar slug si no se proporciona
            $slug = !empty($_POST['slug']) ? $_POST['slug'] : $courseModel->generateSlug($_POST['title']);
            
            // Preparar datos
            $courseData = [
                'title' => sanitize($_POST['title']),
                'slug' => $slug,
                'description' => sanitize($_POST['description']),
                'short_description' => sanitize($_POST['short_description'] ?? ''),
                'featured_image' => $imageName,
                'price' => floatval($_POST['price'] ?? 0),
                'duration' => sanitize($_POST['duration'] ?? ''),
                'level' => $_POST['level'],
                'status' => $_POST['status'],
                'category_id' => !empty($_POST['category_id']) ? intval($_POST['category_id']) : null
            ];
            
            // Actualizar curso
            if ($courseModel->update($id, $courseData)) {
                setFlashMessage('success', 'Curso actualizado exitosamente.');
                redirect('admin/courses');
            } else {
                throw new Exception('Error al actualizar el curso en la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error updating course: " . $e->getMessage());
            setFlashMessage('error', 'Error al actualizar el curso: ' . $e->getMessage());
            redirect('admin/courses/edit/' . $id);
        }
    }
    
    public function delete($id) {
        $this->requireInstructor();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/courses');
        }
        
        $courseModel = $this->model('Course');
        
        $course = $courseModel->find($id);
        if (!$course) {
            setFlashMessage('error', 'Curso no encontrado.');
            redirect('admin/courses');
        }
        
        // Verificar permisos
        if ($_SESSION['user_role'] !== 'admin' && $course['instructor_id'] != $_SESSION['user_id']) {
            setFlashMessage('error', 'No tienes permisos para eliminar este curso.');
            redirect('admin/courses');
        }
        
        try {
            // Eliminar imagen si existe
            if (!empty($course['featured_image'])) {
                $imagePath = __DIR__ . '/../../assets/images/' . $course['featured_image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            // Eliminar curso
            if ($courseModel->delete($id)) {
                setFlashMessage('success', 'Curso eliminado exitosamente.');
            } else {
                throw new Exception('Error al eliminar el curso de la base de datos.');
            }
            
        } catch (Exception $e) {
            error_log("Error deleting course: " . $e->getMessage());
            setFlashMessage('error', 'Error al eliminar el curso: ' . $e->getMessage());
        }
        
        redirect('admin/courses');
    }
    
    private function validateCourseData($data, $courseId = null) {
        $errors = [];
        
        // Validar título
        if (empty($data['title'])) {
            $errors[] = 'El título del curso es requerido.';
        } elseif (strlen($data['title']) > 255) {
            $errors[] = 'El título no puede exceder 255 caracteres.';
        }
        
        // Validar descripción
        if (empty($data['description'])) {
            $errors[] = 'La descripción del curso es requerida.';
        }
        
        // Validar nivel
        if (empty($data['level']) || !in_array($data['level'], ['beginner', 'intermediate', 'advanced'])) {
            $errors[] = 'El nivel del curso es requerido y debe ser válido.';
        }
        
        // Validar estado
        if (empty($data['status']) || !in_array($data['status'], ['published', 'draft', 'archived'])) {
            $errors[] = 'El estado del curso es requerido y debe ser válido.';
        }
        
        // Validar precio
        if (isset($data['price']) && (!is_numeric($data['price']) || $data['price'] < 0)) {
            $errors[] = 'El precio debe ser un número válido mayor o igual a 0.';
        }
        
        // Validar slug único
        if (!empty($data['slug'])) {
            $courseModel = $this->model('Course');
            $existingCourse = $courseModel->findBySlug($data['slug']);
            if ($existingCourse && $existingCourse['id'] != $courseId) {
                $errors[] = 'El slug ya está en uso por otro curso.';
            }
        }
        
        return $errors;
    }
    
    private function processImageUpload($currentImage = null) {
        $uploadDir = __DIR__ . '/../../assets/images/';
        
        // Si no hay nueva imagen, mantener la actual
        if (!isset($_FILES['featured_image']) || $_FILES['featured_image']['error'] === UPLOAD_ERR_NO_FILE) {
            return $currentImage;
        }
        
        $file = $_FILES['featured_image'];
        
        // Validar errores de subida
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Error al subir la imagen: ' . $this->getUploadErrorMessage($file['error']));
        }
        
        // Validar tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $allowedTypes)) {
            throw new Exception('Tipo de archivo no válido. Solo se permiten imágenes JPG, PNG, GIF y WebP.');
        }
        
        // Validar tamaño (2MB máximo)
        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception('El archivo es demasiado grande. El tamaño máximo es 2MB.');
        }
        
        // Generar nombre único para el archivo
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = 'course-' . uniqid() . '.' . $extension;
        $filePath = $uploadDir . $fileName;
        
        // Crear directorio si no existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Mover archivo
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception('Error al mover el archivo subido.');
        }
        
        // Eliminar imagen anterior si existe
        if ($currentImage && file_exists($uploadDir . $currentImage)) {
            unlink($uploadDir . $currentImage);
        }
        
        return $fileName;
    }
    
    private function getUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return 'El archivo es demasiado grande.';
            case UPLOAD_ERR_PARTIAL:
                return 'El archivo se subió parcialmente.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Directorio temporal no encontrado.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Error al escribir el archivo.';
            case UPLOAD_ERR_EXTENSION:
                return 'Subida detenida por extensión.';
            default:
                return 'Error desconocido al subir el archivo.';
        }
    }
}
?>
