-- Tabla para gestionar contenido de páginas
CREATE TABLE IF NOT EXISTS page_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_key VARCHAR(100) UNIQUE NOT NULL,
    page_title VARCHAR(255) NOT NULL,
    section_key VARCHAR(100) NOT NULL,
    content_type ENUM('text', 'html', 'title', 'subtitle', 'description') DEFAULT 'text',
    content_value TEXT,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertar contenido por defecto para la página principal
INSERT INTO page_content (page_key, page_title, section_key, content_type, content_value, display_order) VALUES 
-- Hero Section
('home', 'Página Principal', 'hero_title', 'title', 'Distance Learning, Boundless Possibilities!', 1),
('home', 'Página Principal', 'hero_subtitle', 'subtitle', 'Education is a key to success and freedom from all the forces is a power and makes a person powerful', 2),
('home', 'Página Principal', 'hero_button_text', 'text', 'Get Started Today', 3),

-- Stats Section
('home', 'Página Principal', 'stats_title', 'title', 'Our University Statistics', 4),
('home', 'Página Principal', 'stat_1_number', 'text', '15,000+', 5),
('home', 'Página Principal', 'stat_1_label', 'text', 'Students Enrolled', 6),
('home', 'Página Principal', 'stat_2_number', 'text', '500+', 7),
('home', 'Página Principal', 'stat_2_label', 'text', 'Expert Instructors', 8),
('home', 'Página Principal', 'stat_3_number', 'text', '50+', 9),
('home', 'Página Principal', 'stat_3_label', 'text', 'Courses Available', 10),
('home', 'Página Principal', 'stat_4_number', 'text', '95%', 11),
('home', 'Página Principal', 'stat_4_label', 'text', 'Success Rate', 12),

-- Courses Section
('home', 'Página Principal', 'courses_title', 'title', 'Featured Courses', 13),
('home', 'Página Principal', 'courses_subtitle', 'subtitle', 'Discover our most popular courses designed to help you achieve your goals', 14),

-- Events Section
('home', 'Página Principal', 'events_title', 'title', 'Upcoming Events', 15),
('home', 'Página Principal', 'events_subtitle', 'subtitle', 'Join our exciting events and connect with the community', 16),

-- Blog Section
('home', 'Página Principal', 'blog_title', 'title', 'Latest News & Updates', 17),
('home', 'Página Principal', 'blog_subtitle', 'subtitle', 'Stay informed with our latest news and educational content', 18),

-- About Page
('about', 'Acerca de Nosotros', 'about_title', 'title', 'About EduFix University', 1),
('about', 'Acerca de Nosotros', 'about_subtitle', 'subtitle', 'Empowering students through innovative distance learning', 2),
('about', 'Acerca de Nosotros', 'about_description', 'html', '<p>EduFix University is a leading institution in distance learning, committed to providing high-quality education accessible to students worldwide. Our innovative approach combines cutting-edge technology with proven pedagogical methods.</p><p>Founded with the vision of making education accessible to everyone, we have grown to serve thousands of students across the globe, offering diverse programs and courses designed to meet the needs of modern learners.</p>', 3),

-- Contact Page
('contact', 'Contacto', 'contact_title', 'title', 'Get In Touch', 1),
('contact', 'Contacto', 'contact_subtitle', 'subtitle', 'We would love to hear from you. Send us a message and we will respond as soon as possible.', 2),
('contact', 'Contacto', 'contact_address', 'text', '123 Education Street, Learning City, LC 12345', 3),
('contact', 'Contacto', 'contact_phone', 'text', '+1 (555) 123-4567', 4),
('contact', 'Contacto', 'contact_email', 'text', 'info@edufix.com', 5);
