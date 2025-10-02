<!-- Page Header Start -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <h1>Próximos Eventos</h1>
                    <p>Únete a nuestros eventos y conecta con la comunidad educativa</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Page Header End -->

<!-- Events Section Start -->
<section class="events-section">
    <div class="container">
        <div class="row">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="event-card">
                            <div class="event-image">
                                <img src="<?php echo $event['featured_image'] ? BASE_URL . $event['featured_image'] : BASE_URL . 'assets/images/event-placeholder.jpg'; ?>" alt="<?php echo $event['title']; ?>" class="img-fluid">
                            </div>
                            <div class="event-content">
                                <div class="event-date">
                                    <span class="day"><?php echo date('d', strtotime($event['event_date'])); ?></span>
                                    <span class="month"><?php echo date('M', strtotime($event['event_date'])); ?></span>
                                </div>
                                <h4><?php echo $event['title']; ?></h4>
                                <p><?php echo $event['description']; ?></p>
                                <div class="event-meta">
                                    <span><i class="fas fa-clock"></i> <?php echo date('g:i A', strtotime($event['event_date'])); ?></span>
                                    <span><i class="fas fa-map-marker-alt"></i> <?php echo $event['location']; ?></span>
                                </div>
                                <a href="<?php echo BASE_URL; ?>events/<?php echo $event['slug']; ?>" class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="no-events">
                        <div class="text-center">
                            <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                            <h3>No hay eventos próximos</h3>
                            <p>Pronto tendremos nuevos eventos. ¡Mantente informado!</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Paginación -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination-wrapper mt-5">
                <nav aria-label="Paginación de eventos">
                    <ul class="pagination justify-content-center">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo BASE_URL; ?>events?page=<?php echo $currentPage - 1; ?>">Anterior</a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo BASE_URL; ?>events?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo BASE_URL; ?>events?page=<?php echo $currentPage + 1; ?>">Siguiente</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- Events Section End -->
