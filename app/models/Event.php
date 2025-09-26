<?php
// Modelo para manejar eventos
class Event extends Model {
    protected $table = 'events';
    
    // Método para crear un nuevo evento
    public function create($data) {
        $query = "INSERT INTO {$this->table} (title, slug, description, featured_image, event_date, location, price, max_attendees, status, organizer_id) 
                  VALUES (:title, :slug, :description, :featured_image, :event_date, :location, :price, :max_attendees, :status, :organizer_id)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':featured_image', $data['featured_image']);
        $stmt->bindParam(':event_date', $data['event_date']);
        $stmt->bindParam(':location', $data['location']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':max_attendees', $data['max_attendees']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':organizer_id', $data['organizer_id']);
        
        return $stmt->execute();
    }
    
    // Método para actualizar un evento
    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET title = :title, slug = :slug, description = :description, 
                  featured_image = :featured_image, event_date = :event_date, location = :location, 
                  price = :price, max_attendees = :max_attendees, status = :status 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':featured_image', $data['featured_image']);
        $stmt->bindParam(':event_date', $data['event_date']);
        $stmt->bindParam(':location', $data['location']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':max_attendees', $data['max_attendees']);
        $stmt->bindParam(':status', $data['status']);
        
        return $stmt->execute();
    }
    
    // Método para obtener eventos próximos
    public function getUpcoming($limit = null, $offset = 0) {
        $query = "SELECT e.*, u.first_name, u.last_name 
                  FROM {$this->table} e 
                  JOIN users u ON e.organizer_id = u.id 
                  WHERE e.status = 'published' AND e.event_date > NOW()
                  ORDER BY e.event_date ASC";
        
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
    
    // Método para obtener eventos pasados
    public function getPast($limit = null, $offset = 0) {
        $query = "SELECT e.*, u.first_name, u.last_name 
                  FROM {$this->table} e 
                  JOIN users u ON e.organizer_id = u.id 
                  WHERE e.status = 'published' AND e.event_date < NOW()
                  ORDER BY e.event_date DESC";
        
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
    
    // Método para obtener un evento por slug
    public function findBySlug($slug) {
        $query = "SELECT e.*, u.first_name, u.last_name 
                  FROM {$this->table} e 
                  JOIN users u ON e.organizer_id = u.id 
                  WHERE e.slug = :slug AND e.status = 'published'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    // Método para buscar eventos
    public function search($term) {
        $query = "SELECT e.*, u.first_name, u.last_name 
                  FROM {$this->table} e 
                  JOIN users u ON e.organizer_id = u.id 
                  WHERE (e.title LIKE :term OR e.description LIKE :term OR e.location LIKE :term) 
                  AND e.status = 'published'
                  ORDER BY e.event_date ASC";
        $stmt = $this->db->prepare($query);
        $searchTerm = "%{$term}%";
        $stmt->bindParam(':term', $searchTerm);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Método para obtener estadísticas
    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published,
                    SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as drafts,
                    SUM(CASE WHEN event_date > NOW() THEN 1 ELSE 0 END) as upcoming,
                    SUM(current_attendees) as total_attendees
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
