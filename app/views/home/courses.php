<!-- Page Header Start -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <h1>Nuestros Cursos</h1>
                    <p>Descubre nuestra amplia gama de programas académicos diseñados para tu éxito profesional</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Page Header End -->

<!-- Courses Section Start -->
<section class="courses-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="courses-sidebar">
                    <div class="sidebar-widget">
                        <h4>Categorías</h4>
                        <ul class="category-list">
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <li>
                                        <a href="<?php echo BASE_URL; ?>courses?category=<?php echo $category['id']; ?>">
                                            <?php echo $category['name']; ?>
                                            <span class="count">(<?php echo $category['course_count']; ?>)</span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="courses-grid">
                    <?php if (!empty($courses)): ?>
                        <div class="row">
                            <?php foreach ($courses as $course): ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="course-card">
                                        <div class="course-image">
                                            <img src="<?php echo $course['featured_image'] ? BASE_URL . $course['featured_image'] : BASE_URL . 'assets/images/course-placeholder.jpg'; ?>" alt="<?php echo $course['title']; ?>" class="img-fluid">
                                        </div>
                                        <div class="course-content">
                                            <h4><?php echo $course['title']; ?></h4>
                                            <p><?php echo $course['short_description']; ?></p>
                                            <div class="course-meta">
                                                <span class="duration"><i class="fas fa-clock"></i> <?php echo $course['duration']; ?> horas</span>
                                                <span class="level"><i class="fas fa-signal"></i> <?php echo ucfirst($course['level']); ?></span>
                                            </div>
                                            <div class="course-footer">
                                                <span class="price">$<?php echo number_format($course['price'], 2); ?></span>
                                                <a href="<?php echo BASE_URL; ?>courses/<?php echo $course['slug']; ?>" class="btn btn-primary">Ver detalles</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Paginación -->
                        <?php if ($totalPages > 1): ?>
                            <div class="pagination-wrapper">
                                <nav aria-label="Paginación de cursos">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($currentPage > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?php echo BASE_URL; ?>courses?page=<?php echo $currentPage - 1; ?>">Anterior</a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                                <a class="page-link" href="<?php echo BASE_URL; ?>courses?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <?php if ($currentPage < $totalPages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?php echo BASE_URL; ?>courses?page=<?php echo $currentPage + 1; ?>">Siguiente</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="no-courses">
                            <div class="text-center">
                                <i class="fas fa-book-open fa-3x mb-3"></i>
                                <h3>No hay cursos disponibles</h3>
                                <p>Pronto tendremos nuevos cursos disponibles. ¡Mantente atento!</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Courses Section End -->
