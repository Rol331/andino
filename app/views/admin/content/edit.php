<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
        }
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
        }
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-header h3 {
            color: white;
            font-weight: 800;
            margin: 0;
        }
        .sidebar-menu {
            padding: 20px 0;
        }
        .sidebar-menu .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 0;
            transition: all 0.3s;
        }
        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .sidebar-menu .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .top-bar {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .content-form {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f8f9fa;
        }
        .form-section:last-child {
            border-bottom: none;
        }
        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .section-title i {
            margin-right: 10px;
            color: #007bff;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }
        .btn-save {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: transform 0.3s;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            color: white;
        }
        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.3s;
        }
        .btn-cancel:hover {
            transform: translateY(-2px);
            color: white;
        }
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .content-type-badge {
            font-size: 0.8rem;
            padding: 4px 8px;
            border-radius: 5px;
            font-weight: 600;
        }
        .badge-title { background: #007bff; color: white; }
        .badge-subtitle { background: #6c757d; color: white; }
        .badge-text { background: #28a745; color: white; }
        .badge-html { background: #dc3545; color: white; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-graduation-cap me-2"></i>EduFix Admin</h3>
        </div>
        <nav class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>admin/dashboard">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>admin/courses">
                        <i class="fas fa-book"></i>Cursos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>admin/posts">
                        <i class="fas fa-newspaper"></i>Posts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>admin/users">
                        <i class="fas fa-users"></i>Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo BASE_URL; ?>admin/content">
                        <i class="fas fa-edit"></i>Contenido
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>">
                        <i class="fas fa-globe"></i>Ver Sitio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>admin/logout">
                        <i class="fas fa-sign-out-alt"></i>Cerrar Sesión
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div>
                <h4 class="mb-0"><?php echo $pageTitle; ?></h4>
                <small class="text-muted">Editar contenido de la página</small>
            </div>
            <div>
                <a href="<?php echo BASE_URL; ?>admin/content/preview/<?php echo $pageKey; ?>" class="btn btn-outline-primary me-2" target="_blank">
                    <i class="fas fa-eye me-1"></i>Vista Previa
                </a>
                <a href="<?php echo BASE_URL; ?>admin/content" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver
                </a>
            </div>
        </div>

        <!-- Mensajes Flash -->
        <?php if (getFlashMessage('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i><?php echo getFlashMessage('success'); ?>
            </div>
        <?php endif; ?>

        <?php if (getFlashMessage('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo getFlashMessage('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Content Form -->
        <div class="content-form">
            <form method="POST" action="<?php echo BASE_URL; ?>admin/content/update">
                <input type="hidden" name="page_key" value="<?php echo $pageKey; ?>">
                
                <?php 
                $currentSection = '';
                foreach ($content as $item): 
                    if ($currentSection !== $item['section_key']):
                        $currentSection = $item['section_key'];
                        $sectionNames = [
                            'hero_title' => 'Sección Hero',
                            'hero_subtitle' => 'Sección Hero',
                            'hero_button_text' => 'Sección Hero',
                            'stats_title' => 'Estadísticas',
                            'stat_1_number' => 'Estadísticas',
                            'stat_1_label' => 'Estadísticas',
                            'stat_2_number' => 'Estadísticas',
                            'stat_2_label' => 'Estadísticas',
                            'stat_3_number' => 'Estadísticas',
                            'stat_3_label' => 'Estadísticas',
                            'stat_4_number' => 'Estadísticas',
                            'stat_4_label' => 'Estadísticas',
                            'courses_title' => 'Cursos',
                            'courses_subtitle' => 'Cursos',
                            'events_title' => 'Eventos',
                            'events_subtitle' => 'Eventos',
                            'blog_title' => 'Blog',
                            'blog_subtitle' => 'Blog',
                            'about_title' => 'Título Principal',
                            'about_subtitle' => 'Título Principal',
                            'about_description' => 'Descripción',
                            'contact_title' => 'Título Principal',
                            'contact_subtitle' => 'Título Principal',
                            'contact_address' => 'Información de Contacto',
                            'contact_phone' => 'Información de Contacto',
                            'contact_email' => 'Información de Contacto'
                        ];
                        $sectionName = $sectionNames[$currentSection] ?? 'Contenido';
                        $sectionIcons = [
                            'Sección Hero' => 'fas fa-star',
                            'Estadísticas' => 'fas fa-chart-bar',
                            'Cursos' => 'fas fa-book',
                            'Eventos' => 'fas fa-calendar',
                            'Blog' => 'fas fa-newspaper',
                            'Título Principal' => 'fas fa-heading',
                            'Descripción' => 'fas fa-paragraph',
                            'Información de Contacto' => 'fas fa-info-circle'
                        ];
                        $icon = $sectionIcons[$sectionName] ?? 'fas fa-file';
                ?>
                        <div class="form-section">
                            <div class="section-title">
                                <i class="<?php echo $icon; ?>"></i>
                                <?php echo $sectionName; ?>
                            </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label class="form-label">
                        <?php
                        $labels = [
                            'hero_title' => 'Título Principal',
                            'hero_subtitle' => 'Subtítulo',
                            'hero_button_text' => 'Texto del Botón',
                            'stats_title' => 'Título de Estadísticas',
                            'stat_1_number' => 'Número Estadística 1',
                            'stat_1_label' => 'Etiqueta Estadística 1',
                            'stat_2_number' => 'Número Estadística 2',
                            'stat_2_label' => 'Etiqueta Estadística 2',
                            'stat_3_number' => 'Número Estadística 3',
                            'stat_3_label' => 'Etiqueta Estadística 3',
                            'stat_4_number' => 'Número Estadística 4',
                            'stat_4_label' => 'Etiqueta Estadística 4',
                            'courses_title' => 'Título de Cursos',
                            'courses_subtitle' => 'Subtítulo de Cursos',
                            'events_title' => 'Título de Eventos',
                            'events_subtitle' => 'Subtítulo de Eventos',
                            'blog_title' => 'Título del Blog',
                            'blog_subtitle' => 'Subtítulo del Blog',
                            'about_title' => 'Título Principal',
                            'about_subtitle' => 'Subtítulo',
                            'about_description' => 'Descripción',
                            'contact_title' => 'Título Principal',
                            'contact_subtitle' => 'Subtítulo',
                            'contact_address' => 'Dirección',
                            'contact_phone' => 'Teléfono',
                            'contact_email' => 'Email'
                        ];
                        echo $labels[$item['section_key']] ?? $item['section_key'];
                        ?>
                        <span class="content-type-badge badge-<?php echo $item['content_type']; ?> ms-2">
                            <?php echo strtoupper($item['content_type']); ?>
                        </span>
                    </label>
                    
                    <?php if ($item['content_type'] === 'html'): ?>
                        <textarea class="form-control" name="content[<?php echo $item['section_key']; ?>]" rows="6" placeholder="Contenido HTML..."><?php echo htmlspecialchars($item['content_value']); ?></textarea>
                    <?php else: ?>
                        <input type="text" class="form-control" name="content[<?php echo $item['section_key']; ?>]" value="<?php echo htmlspecialchars($item['content_value']); ?>" placeholder="Ingresa el contenido...">
                    <?php endif; ?>
                </div>
                
                <?php endforeach; ?>
                
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="<?php echo BASE_URL; ?>admin/content" class="btn-cancel">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save me-1"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
