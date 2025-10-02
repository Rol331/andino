<?php
// Modelo para manejar posts/blog
class Post extends Model {
    protected $table = 'posts';
    
    // Obtener posts publicados
    public function getPublished($limit = null, $offset = 0) {
        $query = "SELECT p.*, u.first_name, u.last_name, cc.name as category_name 
                  FROM {$this->table} p 
                  LEFT JOIN users u ON p.author_id = u.id 
                  LEFT JOIN course_categories cc ON p.category_id = cc.id 
                  WHERE p.status = 'published' 
                  ORDER BY p.created_at DESC";
        
        if ($limit) {
            $query .= " LIMIT {$limit} OFFSET {$offset}";
        }
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Obtener post por slug
    public function findBySlug($slug) {
        $query = "SELECT p.*, u.first_name, u.last_name, cc.name as category_name 
                  FROM {$this->table} p 
                  LEFT JOIN users u ON p.author_id = u.id 
                  LEFT JOIN course_categories cc ON p.category_id = cc.id 
                  WHERE p.slug = :slug AND p.status = 'published'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Crear nuevo post
    public function create($data) {
        $query = "INSERT INTO {$this->table} (title, slug, content, excerpt, featured_image, status, author_id, category_id) 
                  VALUES (:title, :slug, :content, :excerpt, :featured_image, :status, :author_id, :category_id)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':excerpt', $data['excerpt']);
        $stmt->bindParam(':featured_image', $data['featured_image']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':author_id', $data['author_id']);
        $stmt->bindParam(':category_id', $data['category_id']);
        
        return $stmt->execute();
    }
    
    // Actualizar post
    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET 
                  title = :title, 
                  slug = :slug, 
                  content = :content, 
                  excerpt = :excerpt, 
                  featured_image = :featured_image,
                  status = :status,
                  category_id = :category_id
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':excerpt', $data['excerpt']);
        $stmt->bindParam(':featured_image', $data['featured_image']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':category_id', $data['category_id']);
        
        return $stmt->execute();
    }
    
    // Obtener posts por autor
    public function getByAuthor($author_id) {
        $query = "SELECT p.*, cc.name as category_name 
                  FROM {$this->table} p 
                  LEFT JOIN course_categories cc ON p.category_id = cc.id 
                  WHERE p.author_id = :author_id 
                  ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Obtener posts por categoría
    public function getByCategory($category_id) {
        $query = "SELECT p.*, u.first_name, u.last_name 
                  FROM {$this->table} p 
                  LEFT JOIN users u ON p.author_id = u.id 
                  WHERE p.category_id = :category_id AND p.status = 'published' 
                  ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Incrementar vistas
    public function incrementViews($id) {
        $query = "UPDATE {$this->table} SET views = views + 1 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Obtener posts más populares
    public function getPopular($limit = 5) {
        $query = "SELECT p.*, u.first_name, u.last_name 
                  FROM {$this->table} p 
                  LEFT JOIN users u ON p.author_id = u.id 
                  WHERE p.status = 'published' 
                  ORDER BY p.views DESC 
                  LIMIT {$limit}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Buscar posts
    public function search($keyword) {
        $query = "SELECT p.*, u.first_name, u.last_name, cc.name as category_name 
                  FROM {$this->table} p 
                  LEFT JOIN users u ON p.author_id = u.id 
                  LEFT JOIN course_categories cc ON p.category_id = cc.id 
                  WHERE p.status = 'published' 
                  AND (p.title LIKE :keyword OR p.content LIKE :keyword OR p.excerpt LIKE :keyword) 
                  ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Obtener estadísticas de posts
    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN status = 'published' THEN 1 END) as published,
                    COUNT(CASE WHEN status = 'draft' THEN 1 END) as drafts,
                    SUM(views) as total_views
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
