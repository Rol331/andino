<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'EduFix - Distance Learning, Boundless Possibilities!'; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    
    <!-- CSS Files -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/edufix-style.css" rel="stylesheet">
</head>
<body>
    <!-- Header Start -->
    <header class="header-area">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="top-bar-left">
                            <ul class="top-bar-info">
                                <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                                <li><i class="fas fa-envelope"></i> info@edufix.com</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="top-bar-right">
                            <ul class="top-bar-social">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Header -->
        <div class="main-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6">
                        <div class="logo">
                            <a href="<?php echo BASE_URL; ?>">
                                <img src="assets/images/logo.png" alt="EduFix" class="img-fluid">
                                <span class="logo-text">E D U F I X</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-6">
                        <div class="main-menu">
                            <nav class="navbar navbar-expand-lg">
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNav">
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                                Demos
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Main Home</a></li>
                                                <li><a class="dropdown-item" href="#">Digital Course Hub</a></li>
                                                <li><a class="dropdown-item" href="#">Online Academy</a></li>
                                                <li><a class="dropdown-item" href="#">Distance learning</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="<?php echo BASE_URL; ?>courses" role="button" data-bs-toggle="dropdown">
                                                Courses
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Course Style One</a></li>
                                                <li><a class="dropdown-item" href="#">Course Style Two</a></li>
                                                <li><a class="dropdown-item" href="#">Course Style Three</a></li>
                                                <li><a class="dropdown-item" href="#">Course Details</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                                Pages
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>about">About Us</a></li>
                                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>events">Events</a></li>
                                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>contact">Contact Us</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo BASE_URL; ?>blog">Blog</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo BASE_URL; ?>contact">Contact</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Mensajes Flash -->
    <?php if (getFlashMessage('success')): ?>
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo getFlashMessage('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (getFlashMessage('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo getFlashMessage('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (getFlashMessage('info')): ?>
        <div class="alert alert-info alert-dismissible fade show m-0" role="alert">
            <i class="fas fa-info-circle me-2"></i><?php echo getFlashMessage('info'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
