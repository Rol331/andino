-- Actualizar estructura de la tabla page_content para soportar múltiples secciones por página
DROP TABLE IF EXISTS page_content;

CREATE TABLE page_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_key VARCHAR(100) NOT NULL,
    page_title VARCHAR(255) NOT NULL,
    section_key VARCHAR(100) NOT NULL,
    content_type ENUM('text', 'html', 'image', 'number') DEFAULT 'text',
    content_value TEXT,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_page_section (page_key, section_key),
    INDEX idx_page_key (page_key),
    INDEX idx_section_key (section_key)
);

-- Insertar contenido para la página principal (home)
INSERT INTO page_content (page_key, page_title, section_key, content_type, content_value, display_order) VALUES
-- Hero Section
('home', 'Página Principal', 'hero_title', 'text', 'Distance Learning, Boundless Possibilities!', 1),
('home', 'Página Principal', 'hero_subtitle', 'text', 'Education is a key to success and freedom from all the forces is a power and makes a person powerful', 2),
('home', 'Página Principal', 'hero_button_text', 'text', 'Apply Now', 3),

-- Statistics Section
('home', 'Página Principal', 'stat_1_number', 'text', '15,000+', 4),
('home', 'Página Principal', 'stat_1_label', 'text', 'Students Enrolled', 5),
('home', 'Página Principal', 'stat_2_number', 'text', '500+', 6),
('home', 'Página Principal', 'stat_2_label', 'text', 'Expert Instructors', 7),
('home', 'Página Principal', 'stat_3_number', 'text', '50+', 8),
('home', 'Página Principal', 'stat_3_label', 'text', 'Courses Available', 9),
('home', 'Página Principal', 'stat_4_number', 'text', '95%', 10),
('home', 'Página Principal', 'stat_4_label', 'text', 'Success Rate', 11),

-- Courses Section
('home', 'Página Principal', 'courses_title', 'text', 'Featured Courses', 12),
('home', 'Página Principal', 'courses_subtitle', 'text', 'Discover our most popular courses designed to help you achieve your goals', 13),

-- Events Section
('home', 'Página Principal', 'events_title', 'text', 'Upcoming Events', 14),
('home', 'Página Principal', 'events_subtitle', 'text', 'Join our exciting events and connect with the community', 15),

-- Blog Section
('home', 'Página Principal', 'blog_title', 'text', 'Latest News & Updates', 16),
('home', 'Página Principal', 'blog_subtitle', 'text', 'Stay informed with our latest news and educational content', 17);

-- Insertar contenido para la página About
INSERT INTO page_content (page_key, page_title, section_key, content_type, content_value, display_order) VALUES
('about', 'Acerca de Nosotros', 'about_title', 'text', 'About EduFix University', 1),
('about', 'Acerca de Nosotros', 'about_subtitle', 'text', 'Empowering students through innovative distance learning', 2),
('about', 'Acerca de Nosotros', 'about_description', 'html', '<p>EduFix University is a leading institution in distance learning, committed to providing high-quality education accessible to students worldwide. Our innovative approach combines cutting-edge technology with proven pedagogical methods.</p><p>Founded with the vision of making education accessible to everyone, we have grown to serve thousands of students across the globe, offering diverse programs and courses designed to meet the needs of modern learners.</p><p>Our faculty consists of experienced educators and industry professionals who bring real-world expertise to the virtual classroom. We believe in fostering a supportive learning environment where students can thrive and achieve their academic and professional goals.</p>', 3);

-- Insertar contenido para la página Contact
INSERT INTO page_content (page_key, page_title, section_key, content_type, content_value, display_order) VALUES
('contact', 'Contacto', 'contact_title', 'text', 'Get In Touch', 1),
('contact', 'Contacto', 'contact_subtitle', 'text', 'We would love to hear from you. Send us a message and we will respond as soon as possible.', 2),
('contact', 'Contacto', 'contact_address', 'text', '123 Education Street, Learning City, LC 12345', 3),
('contact', 'Contacto', 'contact_phone', 'text', '+1 (555) 123-4567', 4),
('contact', 'Contacto', 'contact_email', 'text', 'info@edufix.com', 5);
