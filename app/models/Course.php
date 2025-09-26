<?php
// Modelo para manejar cursos
class Course extends Model {
    protected $table = 'courses';
    
    // Método para crear un nuevo curso
    public function create($data) {
        $query = "INSERT INTO {$this->table} (title, slug, description, short_description, featured_image, price, duration, level, status, instructor_id, category_id) 
                  VALUES (:title, :slug, :description, :short_description, :featured_image, :price, :duration, :level, :status, :instructor_id, :category_id)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':short_description', $data['short_description']);
        $stmt->bindParam(':featured_image', $data['featured_image']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':duration', $data['duration']);
        $stmt->bindParam(':level', $data['level']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':instructor_id', $data['instructor_id']);
        $stmt->bindParam(':category_id', $data['category_id']);
        
        return $stmt->execute();
    }
    
    // Método para actualizar un curso
    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET title = :title, slug = :slug, description = :description, 
                  short_description = :short_description, featured_image = :featured_image, price = :price, 
                  duration = :duration, level = :level, status = :status, category_id = :category_id 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':short_description', $data['short_description']);
        $stmt->bindParam(':featured_image', $data['featured_image']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':duration', $data['duration']);
        $stmt->bindParam(':level', $data['level']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':category_id', $data['category_id']);
        
        return $stmt->execute();
    }
    
    // Método para obtener cursos publicados
    public function getPublished($limit = null, $offset = 0) {
        $query = "SELECT c.*, u.first_name, u.last_name, cc.name as category_name, cc.color as category_color
                  FROM {$this->table} c 
                  JOIN users u ON c.instructor_id = u.id 
                  LEFT JOIN course_categories cc ON c.category_id = cc.id
                  WHERE c.status = 'published' 
                  ORDER BY c.created_at DESC";
        
        if ($limit) {
            $query .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->db->prepare($query);
        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Método para obtener un curso por slug
    public function findBySlug($slug) {
        $query = "SELECT c.*, u.first_name, u.last_name, cc.name as category_name, cc.color as category_color
                  FROM {$this->table} c 
                  JOIN users u ON c.instructor_id = u.id 
                  LEFT JOIN course_categories cc ON c.category_id = cc.id
                  WHERE c.slug = :slug AND c.status = 'published'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    // Método para incrementar vistas
    public function incrementViews($id) {
        $query = "UPDATE {$this->table} SET views = views + 1 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Método para buscar cursos
    public function search($term) {
        $query = "SELECT c.*, u.first_name, u.last_name, cc.name as category_name
                  FROM {$this->table} c 
                  JOIN users u ON c.instructor_id = u.id 
                  LEFT JOIN course_categories cc ON c.category_id = cc.id
                  WHERE (c.title LIKE :term OR c.description LIKE :term OR c.short_description LIKE :term) 
                  AND c.status = 'published'
                  ORDER BY c.created_at DESC";
        $stmt = $this->db->prepare($query);
        $searchTerm = "%{$term}%";
        $stmt->bindParam(':term', $searchTerm);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Método para obtener cursos por categoría
    public function getByCategory($categoryId, $limit = null, $offset = 0) {
        $query = "SELECT c.*, u.first_name, u.last_name, cc.name as category_name
                  FROM {$this->table} c 
                  JOIN users u ON c.instructor_id = u.id 
                  LEFT JOIN course_categories cc ON c.category_id = cc.id
                  WHERE c.category_id = :category_id AND c.status = 'published' 
                  ORDER BY c.created_at DESC";
        
        if ($limit) {
            $query .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Método para obtener estadísticas
    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published,
                    SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as drafts,
                    SUM(views) as total_views,
                    AVG(price) as avg_price
                  FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    // Método para generar slug único
    public function generateSlug($title) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    // Método para verificar si un slug existe
    private function slugExists($slug) {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE slug = :slug";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
}
?>
