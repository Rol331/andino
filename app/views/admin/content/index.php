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
        .page-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .page-card:hover {
            transform: translateY(-5px);
        }
        .page-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-bottom: 15px;
        }
        .page-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        .page-description {
            color: #666;
            margin-bottom: 20px;
        }
        .btn-group-custom {
            display: flex;
            gap: 10px;
        }
        .btn-custom {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-edit {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
        }
        .btn-edit:hover {
            color: white;
            transform: translateY(-2px);
        }
        .btn-preview {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        .btn-preview:hover {
            color: white;
            transform: translateY(-2px);
        }
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
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
                <h4 class="mb-0">Gestión de Contenido</h4>
                <small class="text-muted">Edita el contenido de las páginas del sitio</small>
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

        <!-- Pages Grid -->
        <div class="row">
            <?php foreach ($pages as $page): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="page-card">
                        <div class="page-icon" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
                            <?php
                            $icons = [
                                'home' => 'fas fa-home',
                                'about' => 'fas fa-info-circle',
                                'contact' => 'fas fa-envelope',
                                'courses' => 'fas fa-book',
                                'events' => 'fas fa-calendar',
                                'blog' => 'fas fa-newspaper'
                            ];
                            $icon = $icons[$page['page_key']] ?? 'fas fa-file';
                            ?>
                            <i class="<?php echo $icon; ?>"></i>
                        </div>
                        <div class="page-title"><?php echo $page['page_title']; ?></div>
                        <div class="page-description">
                            <?php
                            $descriptions = [
                                'home' => 'Página principal con hero section, estadísticas y contenido destacado',
                                'about' => 'Información sobre la universidad y su misión',
                                'contact' => 'Datos de contacto y formulario de comunicación',
                                'courses' => 'Listado de cursos disponibles',
                                'events' => 'Eventos y actividades próximas',
                                'blog' => 'Noticias y artículos del blog'
                            ];
                            echo $descriptions[$page['page_key']] ?? 'Contenido de la página';
                            ?>
                        </div>
                        <div class="btn-group-custom">
                            <a href="<?php echo BASE_URL; ?>admin/content/edit/<?php echo $page['page_key']; ?>" class="btn-custom btn-edit">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            <a href="<?php echo BASE_URL; ?>admin/content/preview/<?php echo $page['page_key']; ?>" class="btn-custom btn-preview" target="_blank">
                                <i class="fas fa-eye me-1"></i>Vista Previa
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
