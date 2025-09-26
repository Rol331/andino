<?php
// Clase base para todos los controladores
abstract class Controller {
    protected $db;
    protected $view;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->view = new View();
    }
    
    // Método para cargar un modelo
    protected function model($model) {
        require_once "app/models/{$model}.php";
        return new $model($this->db);
    }
    
    // Método para renderizar una vista
    protected function view($view, $data = []) {
        $this->view->render($view, $data);
    }
    
    // Método para verificar si el usuario está autenticado
    protected function isAuthenticated() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    // Método para verificar si el usuario es administrador
    protected function isAdmin() {
        return $this->isAuthenticated() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
    
    // Método para verificar si el usuario es instructor
    protected function isInstructor() {
        return $this->isAuthenticated() && isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['admin', 'instructor']);
    }
    
    // Método para requerir autenticación
    protected function requireAuth() {
        if (!$this->isAuthenticated()) {
            redirect('admin/login');
        }
    }
    
    // Método para requerir permisos de administrador
    protected function requireAdmin() {
        $this->requireAuth();
        if (!$this->isAdmin()) {
            setFlashMessage('error', 'No tienes permisos para acceder a esta sección');
            redirect('admin/dashboard');
        }
    }
    
    // Método para requerir permisos de instructor o admin
    protected function requireInstructor() {
        $this->requireAuth();
        if (!$this->isInstructor()) {
            setFlashMessage('error', 'No tienes permisos para acceder a esta sección');
            redirect('admin/dashboard');
        }
    }
}
?>
