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
            
            if (empty($username) || empty($password)) {
                setFlashMessage('error', 'Por favor completa todos los campos');
            } else {
                try {
                    $userModel = $this->model('User');
                    $user = $userModel->authenticate($username, $password);
                    
                    if ($user) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['user_role'] = $user['role'];
                        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                        
                        setFlashMessage('success', '¡Bienvenido, ' . $user['first_name'] . '!');
                        
                        // Redireccionar manualmente
                        header("Location: " . BASE_URL . "admin/dashboard");
                        exit();
                    } else {
                        setFlashMessage('error', 'Credenciales incorrectas');
                    }
                } catch (Exception $e) {
                    setFlashMessage('error', 'Error del sistema: ' . $e->getMessage());
                    error_log("Login error: " . $e->getMessage());
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
        
        $this->view('admin/users', $data);
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
        
        $this->view('admin/posts', $data);
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
        
        $this->view('admin/courses', $data);
    }
}
?>
