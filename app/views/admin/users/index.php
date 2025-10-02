<?php
// Vista para listar usuarios en el panel administrativo
require_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Usuarios</li>
                    </ol>
                </div>
                <h4 class="page-title">Gestión de Usuarios</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Lista de Usuarios</h5>
                    <a href="<?php echo BASE_URL; ?>admin/users/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Usuario
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

                    <?php if (empty($users)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay usuarios registrados</h5>
                            <p class="text-muted">Comienza creando tu primer usuario</p>
                            <a href="<?php echo BASE_URL; ?>admin/users/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear Primer Usuario
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Avatar</th>
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Fecha Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                                            <td>
                                                <?php if (!empty($user['profile_image'])): ?>
                                                    <img src="<?php echo BASE_URL . 'assets/images/' . htmlspecialchars($user['profile_image']); ?>" 
                                                         alt="<?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>" 
                                                         class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" 
                                                         style="width: 40px; height: 40px;">
                                                        <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></strong>
                                                    <br><small class="text-muted">@<?php echo htmlspecialchars($user['username']); ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>" class="text-decoration-none">
                                                    <?php echo htmlspecialchars($user['email']); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php
                                                $roleLabels = [
                                                    'admin' => 'Administrador',
                                                    'instructor' => 'Instructor',
                                                    'student' => 'Estudiante'
                                                ];
                                                $roleColors = [
                                                    'admin' => 'danger',
                                                    'instructor' => 'warning',
                                                    'student' => 'info'
                                                ];
                                                ?>
                                                <span class="badge bg-<?php echo $roleColors[$user['role']] ?? 'secondary'; ?>">
                                                    <?php echo $roleLabels[$user['role']] ?? ucfirst($user['role']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $statusLabels = [
                                                    'active' => 'Activo',
                                                    'inactive' => 'Inactivo'
                                                ];
                                                $statusColors = [
                                                    'active' => 'success',
                                                    'inactive' => 'secondary'
                                                ];
                                                ?>
                                                <span class="badge bg-<?php echo $statusColors[$user['status']] ?? 'secondary'; ?>">
                                                    <?php echo $statusLabels[$user['status']] ?? ucfirst($user['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?php echo BASE_URL; ?>admin/users/edit/<?php echo $user['id']; ?>" 
                                                       class="btn btn-outline-primary" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-warning" 
                                                            onclick="resetPassword(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['username']); ?>')" 
                                                            title="Resetear Contraseña">
                                                        <i class="fas fa-key"></i>
                                                    </button>
                                                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                        <button type="button" class="btn btn-outline-danger" 
                                                                onclick="confirmDelete(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['username']); ?>')" 
                                                                title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
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
                <p>¿Estás seguro de que quieres eliminar el usuario "<span id="userTitle"></span>"?</p>
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

<!-- Modal para resetear contraseña -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel">Resetear Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres resetear la contraseña del usuario "<span id="resetUserTitle"></span>"?</p>
                <p class="text-warning"><small><strong>Se generará una nueva contraseña temporal.</strong></small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="resetPasswordForm" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="PATCH">
                    <button type="submit" class="btn btn-warning">Resetear Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(userId, userTitle) {
    document.getElementById('userTitle').textContent = userTitle;
    document.getElementById('deleteForm').action = '<?php echo BASE_URL; ?>admin/users/delete/' + userId;
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

function resetPassword(userId, userTitle) {
    document.getElementById('resetUserTitle').textContent = userTitle;
    document.getElementById('resetPasswordForm').action = '<?php echo BASE_URL; ?>admin/users/reset-password/' + userId;
    
    var resetModal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
    resetModal.show();
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
