<?php
// Clase para manejar las vistas
class View {
    private $data = [];
    
    // Método para asignar datos a la vista
    public function assign($key, $value) {
        $this->data[$key] = $value;
    }
    
    // Método para renderizar una vista
    public function render($view, $data = []) {
        // Combinar datos
        $this->data = array_merge($this->data, $data);
        
        // Extraer variables para que estén disponibles en la vista
        extract($this->data);
        
        // Determinar si es una vista de admin o pública
        $isAdminView = strpos($view, 'admin/') === 0;
        
        if ($isAdminView) {
            // Usar layout de administración
            include "app/views/layouts/header.php";
        } else {
            // Usar layout público
            include "app/views/layouts/public_header.php";
        }
        
        // Incluir la vista específica
        $viewFile = "app/views/{$view}.php";
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            if ($isAdminView) {
                include "app/views/errors/404.php";
            } else {
                include "app/views/errors/404_public.php";
            }
        }
        
        if ($isAdminView) {
            // Usar footer de administración
            include "app/views/layouts/footer.php";
        } else {
            // Usar footer público
            include "app/views/layouts/public_footer.php";
        }
    }
    
    // Método para renderizar solo el contenido (sin layout)
    public function renderPartial($view, $data = []) {
        $this->data = array_merge($this->data, $data);
        extract($this->data);
        
        $viewFile = "app/views/{$view}.php";
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo "Vista no encontrada: {$view}";
        }
    }
}
?>
