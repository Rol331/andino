<!-- Page Header Start -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <h1>Blog y Noticias</h1>
                    <p>Mantente informado con nuestras últimas noticias y contenido educativo</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Page Header End -->

<!-- Blog Section Start -->
<section class="blog-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-posts">
                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <article class="blog-post">
                                <div class="post-image">
                                    <img src="<?php echo $post['featured_image'] ? BASE_URL . $post['featured_image'] : BASE_URL . 'assets/images/blog-placeholder.jpg'; ?>" alt="<?php echo $post['title']; ?>" class="img-fluid">
                                </div>
                                <div class="post-content">
                                    <div class="post-meta">
                                        <span class="category">Educación</span>
                                        <span class="date"><?php echo date('F d, Y', strtotime($post['created_at'])); ?></span>
                                    </div>
                                    <h2><?php echo $post['title']; ?></h2>
                                    <p><?php echo $post['excerpt']; ?></p>
                                    <a href="<?php echo BASE_URL; ?>blog/<?php echo $post['slug']; ?>" class="read-more">Leer más</a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                        
                        <!-- Paginación -->
                        <?php if ($totalPages > 1): ?>
                            <div class="pagination-wrapper">
                                <nav aria-label="Paginación del blog">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($currentPage > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?php echo BASE_URL; ?>blog?page=<?php echo $currentPage - 1; ?>">Anterior</a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                                <a class="page-link" href="<?php echo BASE_URL; ?>blog?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <?php if ($currentPage < $totalPages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?php echo BASE_URL; ?>blog?page=<?php echo $currentPage + 1; ?>">Siguiente</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="no-posts">
                            <div class="text-center">
                                <i class="fas fa-newspaper fa-3x mb-3"></i>
                                <h3>No hay artículos disponibles</h3>
                                <p>Pronto tendremos nuevo contenido. ¡Mantente atento!</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog-sidebar">
                    <div class="sidebar-widget">
                        <h4>Categorías</h4>
                        <ul class="category-list">
                            <li><a href="#">Educación</a></li>
                            <li><a href="#">Tecnología</a></li>
                            <li><a href="#">Noticias</a></li>
                            <li><a href="#">Eventos</a></li>
                        </ul>
                    </div>
                    
                    <div class="sidebar-widget">
                        <h4>Artículos Recientes</h4>
                        <div class="recent-posts">
                            <?php if (!empty($posts)): ?>
                                <?php foreach (array_slice($posts, 0, 3) as $recentPost): ?>
                                    <div class="recent-post">
                                        <div class="post-thumb">
                                            <img src="<?php echo $recentPost['featured_image'] ? BASE_URL . $recentPost['featured_image'] : BASE_URL . 'assets/images/blog-placeholder.jpg'; ?>" alt="<?php echo $recentPost['title']; ?>" class="img-fluid">
                                        </div>
                                        <div class="post-info">
                                            <h5><a href="<?php echo BASE_URL; ?>blog/<?php echo $recentPost['slug']; ?>"><?php echo $recentPost['title']; ?></a></h5>
                                            <span class="date"><?php echo date('M d, Y', strtotime($recentPost['created_at'])); ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->
