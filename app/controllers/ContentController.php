<?php
// Controlador para gestión de contenido de páginas
class ContentController extends Controller {
    
    public function index() {
        $this->requireAdmin();
        
        $contentModel = $this->model('PageContent');
        $pages = $contentModel->getAllPages();
        
        $data = [
            'title' => 'Gestión de Contenido - Panel Administrativo',
            'pages' => $pages
        ];
        
        $this->view('admin/content/index', $data);
    }

    public function edit($pageKey = null) {
        $this->requireAdmin();
        
        if (!$pageKey) {
            setFlashMessage('error', 'Página no especificada');
            redirect('admin/content');
        }
        
        $contentModel = $this->model('PageContent');
        $pageContent = $contentModel->getPageForEdit($pageKey);
        
        if (empty($pageContent)) {
            setFlashMessage('error', 'Página no encontrada');
            redirect('admin/content');
        }
        
        $data = [
            'title' => 'Editar Contenido - ' . $pageContent[0]['page_title'],
            'pageKey' => $pageKey,
            'pageTitle' => $pageContent[0]['page_title'],
            'content' => $pageContent
        ];
        
        $this->view('admin/content/edit', $data);
    }

    public function update() {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            setFlashMessage('error', 'Método no permitido');
            redirect('admin/content');
        }
        
        $pageKey = $_POST['page_key'] ?? '';
        $contentData = $_POST['content'] ?? [];
        
        if (empty($pageKey) || empty($contentData)) {
            setFlashMessage('error', 'Datos incompletos');
            redirect('admin/content/edit/' . $pageKey);
        }
        
        $contentModel = $this->model('PageContent');
        
        if ($contentModel->updateMultipleContent($pageKey, $contentData)) {
            setFlashMessage('success', 'Contenido actualizado exitosamente');
        } else {
            setFlashMessage('error', 'Error al actualizar el contenido');
        }
        
        redirect('admin/content/edit/' . $pageKey);
    }

    public function preview($pageKey = null) {
        $this->requireAdmin();
        
        if (!$pageKey) {
            setFlashMessage('error', 'Página no especificada');
            redirect('admin/content');
        }
        
        // Redirigir a la página pública correspondiente
        $publicUrls = [
            'home' => '',
            'about' => 'about',
            'contact' => 'contact',
            'courses' => 'courses',
            'events' => 'events',
            'blog' => 'blog'
        ];
        
        if (isset($publicUrls[$pageKey])) {
            redirect($publicUrls[$pageKey]);
        } else {
            setFlashMessage('error', 'Página no encontrada');
            redirect('admin/content');
        }
    }
}
?>
