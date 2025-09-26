<?php
// Controlador para API REST
class ApiController extends Controller {
    
    // Obtener posts
    public function posts() {
        header('Content-Type: application/json');
        
        try {
            $postModel = $this->model('Post');
            $posts = $postModel->getPublished();
            
            echo json_encode([
                'success' => true,
                'data' => $posts,
                'count' => count($posts)
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener posts: ' . $e->getMessage()
            ]);
        }
    }
    
    // Obtener usuarios (requiere autenticación)
    public function users() {
        header('Content-Type: application/json');
        
        // Verificar autenticación
        if (!$this->isAuthenticated()) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'No autorizado'
            ]);
            return;
        }
        
        try {
            $userModel = $this->model('User');
            $users = $userModel->getAll();
            
            // Remover información sensible
            foreach ($users as &$user) {
                unset($user['password']);
            }
            
            echo json_encode([
                'success' => true,
                'data' => $users,
                'count' => count($users)
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener usuarios: ' . $e->getMessage()
            ]);
        }
    }
    
    // Obtener cursos
    public function courses() {
        header('Content-Type: application/json');
        
        try {
            $courseModel = $this->model('Course');
            $courses = $courseModel->getPublished();
            
            echo json_encode([
                'success' => true,
                'data' => $courses,
                'count' => count($courses)
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener cursos: ' . $e->getMessage()
            ]);
        }
    }
    
    // Obtener eventos
    public function events() {
        header('Content-Type: application/json');
        
        try {
            $eventModel = $this->model('Event');
            $events = $eventModel->getUpcoming();
            
            echo json_encode([
                'success' => true,
                'data' => $events,
                'count' => count($events)
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener eventos: ' . $e->getMessage()
            ]);
        }
    }
}
?>
