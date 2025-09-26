-- Script SQL para crear la base de datos EduFix
CREATE DATABASE IF NOT EXISTS edufix_webapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE edufix_webapp;

-- Tabla de usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    role ENUM('admin', 'instructor', 'student') DEFAULT 'student',
    status ENUM('active', 'inactive') DEFAULT 'active',
    profile_image VARCHAR(255),
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de cursos
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NOT NULL,
    short_description TEXT,
    featured_image VARCHAR(255),
    price DECIMAL(10,2) DEFAULT 0.00,
    duration VARCHAR(50),
    level ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
    status ENUM('published', 'draft', 'archived') DEFAULT 'draft',
    instructor_id INT NOT NULL,
    category_id INT,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabla de categorías de cursos
CREATE TABLE course_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    icon VARCHAR(100),
    color VARCHAR(7) DEFAULT '#007bff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de posts/blog
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT,
    featured_image VARCHAR(255),
    status ENUM('published', 'draft', 'archived') DEFAULT 'draft',
    author_id INT NOT NULL,
    category_id INT,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES course_categories(id) ON DELETE SET NULL
);

-- Tabla de eventos
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NOT NULL,
    featured_image VARCHAR(255),
    event_date DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) DEFAULT 0.00,
    max_attendees INT,
    current_attendees INT DEFAULT 0,
    status ENUM('published', 'draft', 'cancelled') DEFAULT 'draft',
    organizer_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabla de inscripciones a cursos
CREATE TABLE course_enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'completed', 'dropped') DEFAULT 'active',
    progress INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (user_id, course_id)
);

-- Tabla de inscripciones a eventos
CREATE TABLE event_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('confirmed', 'waiting', 'cancelled') DEFAULT 'confirmed',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    UNIQUE KEY unique_registration (user_id, event_id)
);

-- Tabla de configuraciones del sitio
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertar usuario administrador por defecto
INSERT INTO users (username, email, password, first_name, last_name, role) VALUES 
('admin', 'admin@edufix.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'EduFix', 'admin');

-- Insertar configuraciones por defecto
INSERT INTO settings (setting_key, setting_value, description) VALUES 
('site_title', 'EduFix - Distance Learning, Boundless Possibilities!', 'Título del sitio web'),
('site_description', 'Education is a key to success and freedom from all the forces is a power and makes a person powerful', 'Descripción del sitio web'),
('courses_per_page', '9', 'Número de cursos por página'),
('posts_per_page', '6', 'Número de posts por página'),
('events_per_page', '6', 'Número de eventos por página'),
('allow_registrations', '1', 'Permitir registros de usuarios'),
('maintenance_mode', '0', 'Modo de mantenimiento');

-- Insertar categorías de cursos
INSERT INTO course_categories (name, slug, description, icon, color) VALUES 
('Faculty Of Science', 'faculty-of-science', 'Ciencias y tecnología', 'fas fa-flask', '#007bff'),
('Economics, BA', 'economics-ba', 'Economía y negocios', 'fas fa-chart-line', '#28a745'),
('M.A. in Education', 'ma-education', 'Educación y pedagogía', 'fas fa-graduation-cap', '#ffc107'),
('Business Media', 'business-media', 'Medios y comunicación', 'fas fa-broadcast-tower', '#dc3545');

-- Insertar algunos cursos de ejemplo
INSERT INTO courses (title, slug, description, short_description, price, duration, level, status, instructor_id, category_id) VALUES 
('Faculty Of Science', 'faculty-of-science-course', 
'Embark on a journey of knowledge discovery and growth very university. This comprehensive program covers all aspects of modern science and technology.',
'Embark on a journey of knowledge discovery and growth very university.', 2000.00, '4 years', 'beginner', 'published', 1, 1),
('Economics, BA', 'economics-ba-course', 
'Regular edu on a journey of knowledge discovery and growth at university. Learn the fundamentals of economics and business.',
'Regular edu on a journey of knowledge discovery and growth at university.', 2600.00, '3 years', 'intermediate', 'published', 1, 2),
('M.A. in Education', 'ma-education-course', 
'Emergency park on a journey of knowledge discovery and growth track. Advanced studies in education and pedagogy.',
'Emergency park on a journey of knowledge discovery and growth track.', 1300.00, '2 years', 'advanced', 'published', 1, 3);

-- Insertar algunos posts de ejemplo
INSERT INTO posts (title, slug, content, excerpt, status, author_id, category_id) VALUES 
('Distance Learning, Boundless Possibilities!', 'distance-learning-boundless-possibilities', 
'<p>Education is a key to success and freedom from all the forces is a power and makes a person powerful. In today\'s digital age, distance learning has revolutionized how we approach education.</p><p>With EduFix, you can access world-class education from anywhere in the world, at your own pace, and with the support of expert instructors.</p>', 
'Education is a key to success and freedom from all the forces is a power and makes a person powerful', 'published', 1, 1),
('World best higher University ranking', 'world-best-higher-university-ranking', 
'<p>Our university has consistently ranked among the world\'s best institutions for higher education. We are committed to academic excellence and innovation.</p><p>With state-of-the-art facilities and world-renowned faculty, we provide students with the tools they need to succeed in their chosen fields.</p>', 
'Our university has consistently ranked among the world\'s best institutions for higher education', 'published', 1, 2);

-- Insertar algunos eventos de ejemplo
INSERT INTO events (title, slug, description, event_date, location, price, max_attendees, status, organizer_id) VALUES 
('Cultural exchange: building global connections', 'cultural-exchange-building-global-connections', 
'Join us for an exciting cultural exchange event where students from around the world come together to share their traditions and learn from each other.',
'2025-10-04 08:00:00', 'NewYork, USA', 50.00, 100, 'published', 1),
('Literary voices: celebrating diverse narratives', 'literary-voices-celebrating-diverse-narratives', 
'An evening of readings and discussions featuring diverse voices from around the world, celebrating the power of storytelling.',
'2025-11-16 08:00:00', 'Spar, Australia', 25.00, 80, 'published', 1),
('Bridging cultures: global perspectives', 'bridging-cultures-global-perspectives', 
'A conference exploring how different cultures can work together to solve global challenges and build a better future.',
'2025-12-15 08:00:00', 'Western Hill, Canada', 75.00, 150, 'published', 1);
