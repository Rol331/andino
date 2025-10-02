<?php
// Vista para listar cursos en el panel administrativo
require_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Cursos</li>
                    </ol>
                </div>
                <h4 class="page-title">Gestión de Cursos</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Lista de Cursos</h5>
                    <a href="<?php echo BASE_URL; ?>admin/courses/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Curso
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

                    <?php if (empty($courses)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay cursos registrados</h5>
                            <p class="text-muted">Comienza creando tu primer curso</p>
                            <a href="<?php echo BASE_URL; ?>admin/courses/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear Primer Curso
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
                                        <th>Categoría</th>
                                        <th>Precio</th>
                                        <th>Duración</th>
                                        <th>Nivel</th>
                                        <th>Estado</th>
                                        <th>Vistas</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($course['id']); ?></td>
                                            <td>
                                                <?php if (!empty($course['featured_image'])): ?>
                                                    <img src="<?php echo BASE_URL . 'assets/images/' . htmlspecialchars($course['featured_image']); ?>" 
                                                         alt="<?php echo htmlspecialchars($course['title']); ?>" 
                                                         class="rounded" width="50" height="40" style="object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 40px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?php echo htmlspecialchars($course['title']); ?></strong>
                                                    <?php if (!empty($course['short_description'])): ?>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars(substr($course['short_description'], 0, 100)); ?>...</small>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if (!empty($course['category_name'])): ?>
                                                    <span class="badge" style="background-color: <?php echo htmlspecialchars($course['category_color'] ?? '#007bff'); ?>">
                                                        <?php echo htmlspecialchars($course['category_name']); ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">Sin categoría</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="fw-bold">$<?php echo number_format($course['price'], 2); ?></span>
                                            </td>
                                            <td><?php echo htmlspecialchars($course['duration'] ?? 'N/A'); ?></td>
                                            <td>
                                                <?php
                                                $levelLabels = [
                                                    'beginner' => 'Principiante',
                                                    'intermediate' => 'Intermedio',
                                                    'advanced' => 'Avanzado'
                                                ];
                                                $levelColors = [
                                                    'beginner' => 'success',
                                                    'intermediate' => 'warning',
                                                    'advanced' => 'danger'
                                                ];
                                                ?>
                                                <span class="badge bg-<?php echo $levelColors[$course['level']] ?? 'secondary'; ?>">
                                                    <?php echo $levelLabels[$course['level']] ?? ucfirst($course['level']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $statusLabels = [
                                                    'published' => 'Publicado',
                                                    'draft' => 'Borrador',
                                                    'archived' => 'Archivado'
                                                ];
                                                $statusColors = [
                                                    'published' => 'success',
                                                    'draft' => 'warning',
                                                    'archived' => 'secondary'
                                                ];
                                                ?>
                                                <span class="badge bg-<?php echo $statusColors[$course['status']] ?? 'secondary'; ?>">
                                                    <?php echo $statusLabels[$course['status']] ?? ucfirst($course['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?php echo number_format($course['views']); ?></span>
                                            </td>
                                            <td>
                                                <small><?php echo date('d/m/Y', strtotime($course['created_at'])); ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?php echo BASE_URL; ?>admin/courses/edit/<?php echo $course['id']; ?>" 
                                                       class="btn btn-outline-primary" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>courses/<?php echo htmlspecialchars($course['slug']); ?>" 
                                                       class="btn btn-outline-info" title="Ver" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger" 
                                                            onclick="confirmDelete(<?php echo $course['id']; ?>, '<?php echo htmlspecialchars($course['title']); ?>')" 
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
                <p>¿Estás seguro de que quieres eliminar el curso "<span id="courseTitle"></span>"?</p>
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
function confirmDelete(courseId, courseTitle) {
    document.getElementById('courseTitle').textContent = courseTitle;
    document.getElementById('deleteForm').action = '<?php echo BASE_URL; ?>admin/courses/delete/' + courseId;
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
