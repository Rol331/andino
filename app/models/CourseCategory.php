<?php
// Modelo para manejar categorías de cursos
class CourseCategory extends Model {
    protected $table = 'course_categories';
    
    // Método para crear una nueva categoría
    public function create($data) {
        $query = "INSERT INTO {$this->table} (name, slug, description, icon, color) 
                  VALUES (:name, :slug, :description, :icon, :color)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':icon', $data['icon']);
        $stmt->bindParam(':color', $data['color']);
        
        return $stmt->execute();
    }
    
    // Método para actualizar una categoría
    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET name = :name, slug = :slug, description = :description, 
                  icon = :icon, color = :color WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':icon', $data['icon']);
        $stmt->bindParam(':color', $data['color']);
        
        return $stmt->execute();
    }
    
    // Método para obtener categorías con conteo de cursos
    public function getAllWithCourseCount() {
        $query = "SELECT c.*, COUNT(co.id) as course_count 
                  FROM {$this->table} c 
                  LEFT JOIN courses co ON c.id = co.category_id AND co.status = 'published'
                  GROUP BY c.id 
                  ORDER BY c.name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Método para obtener una categoría por slug
    public function findBySlug($slug) {
        $query = "SELECT * FROM {$this->table} WHERE slug = :slug";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    // Método para generar slug único
    public function generateSlug($name) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
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
