<?php
// Modelo para manejar usuarios
class User extends Model {
    protected $table = 'users';
    
    // Obtener usuario por email
    public function findByEmail($email) {
        $query = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Obtener usuario por username
    public function findByUsername($username) {
        $query = "SELECT * FROM {$this->table} WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Verificar credenciales de login
    public function authenticate($username, $password) {
        $user = $this->findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    
    // Crear nuevo usuario
    public function create($data) {
        $query = "INSERT INTO {$this->table} (username, email, password, first_name, last_name, role, status, profile_image, bio) 
                  VALUES (:username, :email, :password, :first_name, :last_name, :role, :status, :profile_image, :bio)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':profile_image', $data['profile_image']);
        $stmt->bindParam(':bio', $data['bio']);
        
        return $stmt->execute();
    }
    
    // Actualizar usuario
    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET 
                  username = :username, 
                  email = :email, 
                  first_name = :first_name, 
                  last_name = :last_name, 
                  role = :role,
                  status = :status,
                  profile_image = :profile_image,
                  bio = :bio
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':profile_image', $data['profile_image']);
        $stmt->bindParam(':bio', $data['bio']);
        
        return $stmt->execute();
    }
    
    // Actualizar contraseña de usuario
    public function updatePassword($id, $password) {
        $query = "UPDATE {$this->table} SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }
    
    // Obtener usuarios por rol
    public function getByRole($role) {
        $query = "SELECT * FROM {$this->table} WHERE role = :role ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Obtener instructores
    public function getInstructors() {
        return $this->getByRole('instructor');
    }
    
    // Obtener estudiantes
    public function getStudents() {
        return $this->getByRole('student');
    }
    
    // Contar usuarios por rol
    public function countByRole($role) {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE role = :role";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'];
    }
    
    // Obtener todos los usuarios (para API)
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Obtener estadísticas de usuarios
    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN role = 'admin' THEN 1 END) as admin,
                    COUNT(CASE WHEN role = 'instructor' THEN 1 END) as instructor,
                    COUNT(CASE WHEN role = 'student' THEN 1 END) as student,
                    COUNT(CASE WHEN status = 'active' THEN 1 END) as active
                  FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }
}
?>
