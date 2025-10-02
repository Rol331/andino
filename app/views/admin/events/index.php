<?php
// Vista para listar eventos en el panel administrativo
require_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Eventos</li>
                    </ol>
                </div>
                <h4 class="page-title">Gestión de Eventos</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Lista de Eventos</h5>
                    <a href="<?php echo BASE_URL; ?>admin/events/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Evento
                    </a>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['flash_type']; ?> alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['flash_message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
                    <?php endif; ?>

                    <?php if (empty($events)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-calendar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay eventos registrados</h5>
                            <p class="text-muted">Comienza creando tu primer evento</p>
                            <a href="<?php echo BASE_URL; ?>admin/events/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear Primer Evento
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Imagen</th>
                                        <th>Título</th>
                                        <th>Organizador</th>
                                        <th>Fecha</th>
                                        <th>Ubicación</th>
                                        <th>Precio</th>
                                        <th>Asistentes</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($events as $event): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($event['id']); ?></td>
                                            <td>
                                                <?php if (!empty($event['featured_image'])): ?>
                                                    <img src="<?php echo BASE_URL . 'assets/images/' . htmlspecialchars($event['featured_image']); ?>" 
                                                         alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                                         class="rounded" width="50" height="40" style="object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 40px;">
                                                        <i class="fas fa-calendar text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?php echo htmlspecialchars($event['title']); ?></strong>
                                                    <?php if (!empty($event['description'])): ?>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars(substr($event['description'], 0, 100)); ?>...</small>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?php echo htmlspecialchars($event['first_name'] . ' ' . $event['last_name']); ?></strong>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?php echo date('d/m/Y', strtotime($event['event_date'])); ?></strong>
                                                    <br><small class="text-muted"><?php echo date('H:i', strtotime($event['event_date'])); ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 150px;" title="<?php echo htmlspecialchars($event['location']); ?>">
                                                    <?php echo htmlspecialchars($event['location']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">
                                                    <?php if ($event['price'] > 0): ?>
                                                        $<?php echo number_format($event['price'], 2); ?>
                                                    <?php else: ?>
                                                        <span class="text-success">Gratis</span>
                                                    <?php endif; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="badge bg-info"><?php echo number_format($event['current_attendees'] ?? 0); ?></span>
                                                    <?php if ($event['max_attendees']): ?>
                                                        <span class="text-muted">/ <?php echo number_format($event['max_attendees']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php
                                                $statusLabels = [
                                                    'published' => 'Publicado',
                                                    'draft' => 'Borrador',
                                                    'cancelled' => 'Cancelado'
                                                ];
                                                $statusColors = [
                                                    'published' => 'success',
                                                    'draft' => 'warning',
                                                    'cancelled' => 'danger'
                                                ];
                                                ?>
                                                <span class="badge bg-<?php echo $statusColors[$event['status']] ?? 'secondary'; ?>">
                                                    <?php echo $statusLabels[$event['status']] ?? ucfirst($event['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?php echo BASE_URL; ?>admin/events/edit/<?php echo $event['id']; ?>" 
                                                       class="btn btn-outline-primary" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>events/<?php echo htmlspecialchars($event['slug']); ?>" 
                                                       class="btn btn-outline-info" title="Ver" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger" 
                                                            onclick="confirmDelete(<?php echo $event['id']; ?>, '<?php echo htmlspecialchars($event['title']); ?>')" 
                                                            title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($totalPages > 1): ?>
                            <nav aria-label="Navegación de páginas">
                                <ul class="pagination justify-content-center">
                                    <?php if ($currentPage > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">Anterior</a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <?php if ($currentPage < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Siguiente</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres eliminar el evento "<span id="eventTitle"></span>"?</p>
                <p class="text-danger"><small><strong>Esta acción no se puede deshacer.</strong></small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(eventId, eventTitle) {
    document.getElementById('eventTitle').textContent = eventTitle;
    document.getElementById('deleteForm').action = '<?php echo BASE_URL; ?>admin/events/delete/' + eventId;
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
