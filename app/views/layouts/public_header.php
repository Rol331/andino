<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>EduFix - Educación a Distancia</title>
    <meta name="description" content="<?php echo isset($description) ? $description : 'EduFix - Educación a distancia, posibilidades sin límites. Ofrecemos cursos de calidad con instructores expertos.'; ?>">
    
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/edufix-style.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                    <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt="EduFix" height="40">
                </a>
                
                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- Navigation Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == '' || basename($_SERVER['REQUEST_URI']) == 'home') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'about') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>about">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'courses') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>courses">Cursos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'events') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>events">Eventos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'blog') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>blog">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'contact') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>contact">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-primary ms-2" href="<?php echo BASE_URL; ?>admin/login">Admin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Main Content -->
    <main>
