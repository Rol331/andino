<!-- Hero Section Start -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1><?php echo htmlspecialchars($pageContent['hero_title'] ?? 'Aprendizaje a distancia, ¡posibilidades sin límites!'); ?></h1>
                    <p><?php echo htmlspecialchars($pageContent['hero_subtitle'] ?? 'La educación es la clave del éxito y te da el poder para transformar tu futuro'); ?></p>
                    <div class="hero-buttons">
                        <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary btn-lg"><?php echo htmlspecialchars($pageContent['hero_button_text'] ?? 'Postúlate ahora'); ?></a>
                    </div>
                    <div class="hero-features">
                        <div class="feature-item">
                            <h5>Pregrado</h5>
                            <p>Explora las carreras de pregrado</p>
                        </div>
                        <div class="feature-item">
                            <h5>Posgrado</h5>
                            <p>Explora los programas de posgrado</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="assets/images/hero-image.jpg" alt="Distance Learning" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- University Ranking Section Start -->
<section class="university-ranking-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="ranking-image">
                    <img src="assets/images/university-ranking.jpg" alt="Ranking universitario" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ranking-content">
                    <h2>Mejor ranking de educación superior</h2>
                    <p>La educación es la clave del éxito y te brinda la libertad para crecer y superarte</p>
                    <div class="ranking-buttons">
                        <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary btn-lg">Postúlate ahora</a>
                    </div>
                    <div class="ranking-features">
                        <div class="feature-item">
                            <h5>Pregrado</h5>
                            <p>Explora las carreras de pregrado</p>
                        </div>
                        <div class="feature-item">
                            <h5>Posgrado</h5>
                            <p>Explora los programas de posgrado</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- University Ranking Section End -->

<!-- Statistics Section Start -->
<section class="statistics-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number"><?php echo htmlspecialchars($pageContent['stat_1_number'] ?? '15,000+'); ?></div>
                    <h4><?php echo htmlspecialchars($pageContent['stat_1_label'] ?? 'Estudiantes inscritos'); ?></h4>
                    <p>Estudiantes activos a nivel mundial</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number"><?php echo htmlspecialchars($pageContent['stat_2_number'] ?? '500+'); ?></div>
                    <h4><?php echo htmlspecialchars($pageContent['stat_2_label'] ?? 'Instructores expertos'); ?></h4>
                    <p>Educadores profesionales</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number"><?php echo htmlspecialchars($pageContent['stat_3_number'] ?? '50+'); ?></div>
                    <h4><?php echo htmlspecialchars($pageContent['stat_3_label'] ?? 'Cursos disponibles'); ?></h4>
                    <p>Rutas de aprendizaje diversas</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number"><?php echo htmlspecialchars($pageContent['stat_4_number'] ?? '95%'); ?></div>
                    <h4><?php echo htmlspecialchars($pageContent['stat_4_label'] ?? 'Tasa de éxito'); ?></h4>
                    <p>Satisfacción estudiantil</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Statistics Section End -->

<!-- Features Section Start -->
<section class="features-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="feature-content">
                    <h2>Instalaciones de becas</h2>
                    <p>Contamos con programas de apoyo económico para impulsar tu formación académica.</p>
                    <div class="feature-number">01</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-content">
                    <h2>Biblioteca y tienda</h2>
                    <p>Accede a una amplia biblioteca y recursos para potenciar tu aprendizaje.</p>
                    <div class="feature-number">02</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Features Section End -->

<!-- About Section Start -->
<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="about-badge">Desde <strong>1996</strong></div>
                    <h3>Conócenos</h3>
                    <h2>Comprometidos con la excelencia académica, la inclusión y la investigación</h2>
                    <p>Ofrecemos educación de calidad con un enfoque innovador, inclusivo y centrado en el estudiante.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image">
                    <img src="assets/images/about-image.jpg" alt="Sobre nosotros" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<!-- Courses Section Start -->
<section class="courses-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center">
                    <h3><?php echo htmlspecialchars($pageContent['courses_title'] ?? 'Cursos destacados'); ?></h3>
                    <h2><?php echo htmlspecialchars($pageContent['courses_subtitle'] ?? 'Descubre nuestros cursos más populares diseñados para ayudarte a lograr tus metas'); ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($featuredCourses)): ?>
                <?php foreach ($featuredCourses as $course): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="course-card">
                            <div class="course-image">
                                <img src="<?php echo $course['featured_image'] ?: 'assets/images/course-placeholder.jpg'; ?>" alt="<?php echo $course['title']; ?>" class="img-fluid">
                            </div>
                            <div class="course-content">
                                <h4><?php echo $course['title']; ?></h4>
                                <p><?php echo $course['short_description']; ?></p>
                                <ul class="course-features">
                                    <li><i class="fas fa-utensils"></i> Cafetería</li>
                                    <li><i class="fas fa-bed"></i> Residencia</li>
                                    <li><i class="fas fa-book"></i> Biblioteca</li>
                                    <li><i class="fas fa-gamepad"></i> Áreas recreativas</li>
                                    <li><i class="fas fa-flask"></i> Laboratorio</li>
                                </ul>
                                <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary">Postúlate ahora</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Courses Section End -->

<!-- Campus Highlights Section Start -->
<section class="campus-highlights-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="highlights-content">
                    <h2>Aspectos destacados del campus</h2>
                    <p>Conoce nuestras actividades, recursos y espacios pensados para tu desarrollo integral.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="highlights-grid">
                    <div class="highlight-item">
                        <h4>Vida estudiantil</h4>
                        <p>Participa en experiencias que enriquecen tu aprendizaje dentro y fuera del aula.</p>
                    </div>
                    <div class="highlight-item">
                        <h4>Arte y clubes</h4>
                        <p>Únete a clubes y actividades artísticas para potenciar tu creatividad.</p>
                    </div>
                    <div class="highlight-item">
                        <h4>Deportes y bienestar</h4>
                        <p>Accede a espacios y programas orientados a tu salud y rendimiento.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Campus Highlights Section End -->

<!-- Tuition Section Start -->
<section class="tuition-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center">
                    <h3>Matrículas y tarifas</h3>
                    <h2>Matrículas y tarifas de la universidad</h2>
                    <p>Consulta los costos y beneficios de cada programa académico disponible.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="tuition-card">
                    <h4>Facultad de Ciencias</h4>
                    <div class="tuition-details">
                        <div class="program-duration">2025 - 2029</div>
                        <div class="department">Departamento de Posgrado</div>
                        <div class="fees">
                            <p>Tiempo completo (por semestre): <strong>$20,00</strong></p>
                            <p>Medio tiempo (por crédito): <strong>$16,00</strong></p>
                        </div>
                        <div class="additional-fees">
                            <p>Tarifa de tecnología: <strong>$14,000</strong></p>
                            <p>Tarifa de actividades estudiantiles: <strong>$10,000</strong></p>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary">Postúlate ahora</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="tuition-card">
                    <h4>Economía, BA</h4>
                    <div class="tuition-details">
                        <div class="program-duration">2025 - 2027</div>
                        <div class="department">Departamento de Posgrado</div>
                        <div class="fees">
                            <p>Tiempo completo (por semestre): <strong>$26,00</strong></p>
                            <p>Medio tiempo (por crédito): <strong>$38,00</strong></p>
                        </div>
                        <div class="additional-fees">
                            <p>Tarifa de tecnología: <strong>$18,000</strong></p>
                            <p>Tarifa de actividades estudiantiles: <strong>$20,000</strong></p>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary">Postúlate ahora</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="tuition-card">
                    <h4>Maestría en Educación</h4>
                    <div class="tuition-details">
                        <div class="program-duration">2025 - 2027</div>
                        <div class="department">Departamento de Posgrado</div>
                        <div class="fees">
                            <p>Tiempo completo (por semestre): <strong>$13,00</strong></p>
                            <p>Medio tiempo (por crédito): <strong>$18,00</strong></p>
                        </div>
                        <div class="additional-fees">
                            <p>Tarifa de tecnología: <strong>$15,000</strong></p>
                            <p>Tarifa de actividades estudiantiles: <strong>$14,000</strong></p>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary">Postúlate ahora</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="tuition-card">
                    <h4>Medios de negocios</h4>
                    <div class="tuition-details">
                        <div class="program-duration">2025 - 2028</div>
                        <div class="department">Departamento de Posgrado</div>
                        <div class="fees">
                            <p>Tiempo completo (por semestre): <strong>$23,00</strong></p>
                            <p>Medio tiempo (por crédito): <strong>$12,00</strong></p>
                        </div>
                        <div class="additional-fees">
                            <p>Tarifa de tecnología: <strong>$17,000</strong></p>
                            <p>Tarifa de actividades estudiantiles: <strong>$15,000</strong></p>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary">Postúlate ahora</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Tuition Section End -->

<!-- Events Section Start -->
<section class="events-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center">
                    <h3><?php echo htmlspecialchars($pageContent['events_title'] ?? 'Próximos eventos'); ?></h3>
                    <h2><?php echo htmlspecialchars($pageContent['events_subtitle'] ?? 'Únete a nuestros eventos y conecta con la comunidad'); ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($upcomingEvents)): ?>
                <?php foreach ($upcomingEvents as $event): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="event-card">
                            <div class="event-date">
                                <span class="day"><?php echo date('d', strtotime($event['event_date'])); ?></span>
                                <span class="month"><?php echo date('M', strtotime($event['event_date'])); ?>, <?php echo date('Y', strtotime($event['event_date'])); ?></span>
                            </div>
                            <div class="event-content">
                                <h4><?php echo $event['title']; ?></h4>
                                <div class="event-meta">
                                    <span><i class="fas fa-clock"></i> <?php echo date('g:i A', strtotime($event['event_date'])); ?></span>
                                    <span><i class="fas fa-map-marker-alt"></i> <?php echo $event['location']; ?></span>
                                </div>
                                <a href="<?php echo BASE_URL; ?>events" class="btn btn-outline-primary">Reservar entrada</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Events Section End -->

<!-- Admission Form Section Start -->
<section class="admission-form-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="admission-form">
                    <h3>Formulario de admisión</h3>
                    <p>Completa el formulario cuidadosamente y asegúrate de que toda la información sea correcta*</p>
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Apellido</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Correo electrónico</label>
                                    <input type="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="tel" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>País</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Estado / Provincia</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Selecciona departamento</label>
                            <select class="form-control" required>
                                <option value="">Elige un departamento</option>
                                <option value="faculty-of-science">Facultad de Ciencias</option>
                                <option value="economics-ba">Economía, BA</option>
                                <option value="ma-education">Maestría en Educación</option>
                                <option value="business-media">Medios de negocios</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Postúlate ahora</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Admission Form Section End -->

<!-- Blog Section Start -->
<section class="blog-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center">
                    <h3><?php echo htmlspecialchars($pageContent['blog_title'] ?? 'Últimas noticias y novedades'); ?></h3>
                    <h2><?php echo htmlspecialchars($pageContent['blog_subtitle'] ?? 'Mantente informado con nuestras noticias y contenido educativo'); ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($recentPosts)): ?>
                <?php foreach ($recentPosts as $post): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-card">
                            <div class="blog-image">
                                <img src="<?php echo $post['featured_image'] ?: 'assets/images/blog-placeholder.jpg'; ?>" alt="<?php echo $post['title']; ?>" class="img-fluid">
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span class="category">Cursos</span>
                                    <span class="date"><?php echo date('F d, Y', strtotime($post['created_at'])); ?></span>
                                </div>
                                <h4><?php echo $post['title']; ?></h4>
                                <p><?php echo $post['excerpt']; ?></p>
                                <a href="<?php echo BASE_URL; ?>blog" class="read-more">Leer más</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Blog Section End -->
