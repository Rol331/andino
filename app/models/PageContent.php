<?php
// Modelo para gestionar contenido de páginas
class PageContent extends Model {
    protected $table = 'page_content';
    
    // Obtener contenido por página
    public function getByPage($pageKey) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE page_key = :page_key AND is_active = 1 
                  ORDER BY display_order ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':page_key', $pageKey);
        $stmt->execute();
        
        $content = [];
        while ($row = $stmt->fetch()) {
            $content[$row['section_key']] = $row['content_value'];
        }
        
        return $content;
    }
    
    // Obtener contenido específico
    public function getContent($pageKey, $sectionKey) {
        $query = "SELECT content_value FROM {$this->table} 
                  WHERE page_key = :page_key AND section_key = :section_key AND is_active = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':page_key', $pageKey);
        $stmt->bindParam(':section_key', $sectionKey);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result ? $result['content_value'] : '';
    }
    
    // Actualizar contenido
    public function updateContent($pageKey, $sectionKey, $contentValue) {
        $query = "UPDATE {$this->table} 
                  SET content_value = :content_value, updated_at = CURRENT_TIMESTAMP 
                  WHERE page_key = :page_key AND section_key = :section_key";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':content_value', $contentValue);
        $stmt->bindParam(':page_key', $pageKey);
        $stmt->bindParam(':section_key', $sectionKey);
        
        return $stmt->execute();
    }
    
    // Crear nuevo contenido
    public function createContent($data) {
        $query = "INSERT INTO {$this->table} (page_key, page_title, section_key, content_type, content_value, display_order) 
                  VALUES (:page_key, :page_title, :section_key, :content_type, :content_value, :display_order)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':page_key', $data['page_key']);
        $stmt->bindParam(':page_title', $data['page_title']);
        $stmt->bindParam(':section_key', $data['section_key']);
        $stmt->bindParam(':content_type', $data['content_type']);
        $stmt->bindParam(':content_value', $data['content_value']);
        $stmt->bindParam(':display_order', $data['display_order']);
        
        return $stmt->execute();
    }
    
    // Obtener todas las páginas
    public function getAllPages() {
        $query = "SELECT DISTINCT page_key, page_title FROM {$this->table} 
                  WHERE is_active = 1 ORDER BY page_key";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Obtener contenido completo de una página para edición
    public function getPageForEdit($pageKey) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE page_key = :page_key AND is_active = 1 
                  ORDER BY display_order ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':page_key', $pageKey);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Actualizar múltiples contenidos
    public function updateMultipleContent($pageKey, $contentData) {
        $this->db->beginTransaction();
        
        try {
            foreach ($contentData as $sectionKey => $contentValue) {
                $this->updateContent($pageKey, $sectionKey, $contentValue);
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
}
?>
