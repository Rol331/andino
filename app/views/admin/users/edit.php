<?php
// Vista para crear/editar usuarios en el panel administrativo
require_once __DIR__ . '/../../layouts/header.php';

$isEdit = isset($user) && !empty($user);
$pageTitle = $isEdit ? 'Editar Usuario' : 'Nuevo Usuario';
$formAction = $isEdit ? BASE_URL . 'admin/users/update/' . $user['id'] : BASE_URL . 'admin/users/store';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>admin/users">Usuarios</a></li>
                        <li class="breadcrumb-item active"><?php echo $pageTitle; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $pageTitle; ?></h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><?php echo $pageTitle; ?></h5>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['flash_type']; ?> alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['flash_message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo $formAction; ?>" enctype="multipart/form-data" id="userForm">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Información básica -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Información Personal</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="first_name" class="form-label">Nombre <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="first_name" name="first_name" 
                                                           value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" 
                                                           required maxlength="50">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="last_name" class="form-label">Apellido <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="last_name" name="last_name" 
                                                           value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>" 
                                                           required maxlength="50">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="bio" class="form-label">Biografía</label>
                                            <textarea class="form-control" id="bio" name="bio" 
                                                      rows="3" maxlength="500"><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                                            <div class="form-text">Información adicional sobre el usuario (máx. 500 caracteres).</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información de cuenta -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Información de Cuenta</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Nombre de Usuario <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username" 
                                                   value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" 
                                                   required maxlength="50" pattern="[a-zA-Z0-9_]+">
                                            <div class="form-text">Solo letras, números y guiones bajos.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" 
                                                   required maxlength="100">
                                        </div>

                                        <?php if (!$isEdit): ?>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" id="password" name="password" 
                                                       required minlength="6">
                                                <div class="form-text">Mínimo 6 caracteres.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password_confirm" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" id="password_confirm" name="password_confirm" 
                                                       required minlength="6">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- Configuración del usuario -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Configuración</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Rol <span class="text-danger">*</span></label>
                                            <select class="form-select" id="role" name="role" required>
                                                <option value="">Seleccionar rol</option>
                                                <option value="student" <?php echo (isset($user['role']) && $user['role'] == 'student') ? 'selected' : ''; ?>>Estudiante</option>
                                                <option value="instructor" <?php echo (isset($user['role']) && $user['role'] == 'instructor') ? 'selected' : ''; ?>>Instructor</option>
                                                <option value="admin" <?php echo (isset($user['role']) && $user['role'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Estado <span class="text-danger">*</span></label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="">Seleccionar estado</option>
                                                <option value="active" <?php echo (isset($user['status']) && $user['status'] == 'active') ? 'selected' : ''; ?>>Activo</option>
                                                <option value="inactive" <?php echo (isset($user['status']) && $user['status'] == 'inactive') ? 'selected' : ''; ?>>Inactivo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Imagen de perfil -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Imagen de Perfil</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($isEdit && !empty($user['profile_image'])): ?>
                                            <div class="mb-3">
                                                <label class="form-label">Imagen Actual</label>
                                                <div class="text-center">
                                                    <img src="<?php echo BASE_URL . 'assets/images/' . htmlspecialchars($user['profile_image']); ?>" 
                                                         alt="<?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>" 
                                                         class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="mb-3">
                                            <label for="profile_image" class="form-label">
                                                <?php echo $isEdit ? 'Nueva Imagen' : 'Imagen de Perfil'; ?>
                                            </label>
                                            <input type="file" class="form-control" id="profile_image" name="profile_image" 
                                                   accept="image/*">
                                            <div class="form-text">
                                                Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB.
                                                <?php if ($isEdit): ?>
                                                    Dejar vacío para mantener la imagen actual.
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="current_image" class="form-label">Imagen Actual</label>
                                            <input type="text" class="form-control" id="current_image" name="current_image" 
                                                   value="<?php echo htmlspecialchars($user['profile_image'] ?? ''); ?>" readonly>
                                            <div class="form-text">Nombre del archivo de imagen actual.</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Estadísticas (solo en modo edición) -->
                                <?php if ($isEdit): ?>
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Información del Usuario</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>ID:</span>
                                                <span class="badge bg-secondary"><?php echo $user['id']; ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Registrado:</span>
                                                <small><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></small>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>Última actualización:</span>
                                                <small><?php echo date('d/m/Y H:i', strtotime($user['updated_at'])); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Acciones -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> 
                                                <?php echo $isEdit ? 'Actualizar Usuario' : 'Crear Usuario'; ?>
                                            </button>
                                            <a href="<?php echo BASE_URL; ?>admin/users" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Cancelar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    const form = document.getElementById('userForm');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirm');
    
    form.addEventListener('submit', function(e) {
        const requiredFields = ['first_name', 'last_name', 'username', 'email', 'role', 'status'];
        let isValid = true;
        
        // Validar campos requeridos
        requiredFields.forEach(function(fieldName) {
            const field = document.getElementById(fieldName);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Validar contraseñas si es un nuevo usuario
        <?php if (!$isEdit): ?>
        if (passwordInput.value !== passwordConfirmInput.value) {
            passwordConfirmInput.classList.add('is-invalid');
            isValid = false;
        } else {
            passwordConfirmInput.classList.remove('is-invalid');
        }
        <?php endif; ?>
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor completa todos los campos requeridos correctamente.');
        }
    });

    // Validación en tiempo real de confirmación de contraseña
    <?php if (!$isEdit): ?>
    passwordConfirmInput.addEventListener('input', function() {
        if (this.value !== passwordInput.value) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    <?php endif; ?>

    // Preview de imagen
    const imageInput = document.getElementById('profile_image');
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validar tipo de archivo
            if (!file.type.startsWith('image/')) {
                alert('Por favor selecciona un archivo de imagen válido.');
                this.value = '';
                return;
            }
            
            // Validar tamaño (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('El archivo es demasiado grande. El tamaño máximo es 2MB.');
                this.value = '';
                return;
            }
        }
    });
});
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
