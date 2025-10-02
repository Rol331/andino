<?php
// Vista para crear/editar cursos en el panel administrativo
require_once __DIR__ . '/../../layouts/header.php';

$isEdit = isset($course) && !empty($course);
$pageTitle = $isEdit ? 'Editar Curso' : 'Nuevo Curso';
$formAction = $isEdit ? BASE_URL . 'admin/courses/update/' . $course['id'] : BASE_URL . 'admin/courses/store';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>admin/courses">Cursos</a></li>
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

                    <form method="POST" action="<?php echo $formAction; ?>" enctype="multipart/form-data" id="courseForm">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Información básica -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Información Básica</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Título del Curso <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="title" name="title" 
                                                   value="<?php echo htmlspecialchars($course['title'] ?? ''); ?>" 
                                                   required maxlength="255">
                                            <div class="form-text">El título debe ser descriptivo y atractivo.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Slug (URL)</label>
                                            <input type="text" class="form-control" id="slug" name="slug" 
                                                   value="<?php echo htmlspecialchars($course['slug'] ?? ''); ?>" 
                                                   maxlength="255">
                                            <div class="form-text">Se genera automáticamente basado en el título. Puedes editarlo manualmente.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="short_description" class="form-label">Descripción Corta</label>
                                            <textarea class="form-control" id="short_description" name="short_description" 
                                                      rows="3" maxlength="500"><?php echo htmlspecialchars($course['short_description'] ?? ''); ?></textarea>
                                            <div class="form-text">Descripción breve que aparecerá en las tarjetas del curso (máx. 500 caracteres).</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Descripción Completa <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="description" name="description" 
                                                      rows="8" required><?php echo htmlspecialchars($course['description'] ?? ''); ?></textarea>
                                            <div class="form-text">Descripción detallada del curso, objetivos, metodología, etc.</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Configuración del curso -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Configuración del Curso</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Precio ($)</label>
                                                    <input type="number" class="form-control" id="price" name="price" 
                                                           value="<?php echo htmlspecialchars($course['price'] ?? '0.00'); ?>" 
                                                           step="0.01" min="0">
                                                    <div class="form-text">Precio del curso en dólares. Use 0 para cursos gratuitos.</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="duration" class="form-label">Duración</label>
                                                    <input type="text" class="form-control" id="duration" name="duration" 
                                                           value="<?php echo htmlspecialchars($course['duration'] ?? ''); ?>" 
                                                           placeholder="ej: 4 semanas, 6 meses, 1 año">
                                                    <div class="form-text">Duración estimada del curso.</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="level" class="form-label">Nivel <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="level" name="level" required>
                                                        <option value="">Seleccionar nivel</option>
                                                        <option value="beginner" <?php echo (isset($course['level']) && $course['level'] == 'beginner') ? 'selected' : ''; ?>>Principiante</option>
                                                        <option value="intermediate" <?php echo (isset($course['level']) && $course['level'] == 'intermediate') ? 'selected' : ''; ?>>Intermedio</option>
                                                        <option value="advanced" <?php echo (isset($course['level']) && $course['level'] == 'advanced') ? 'selected' : ''; ?>>Avanzado</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Estado <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="status" name="status" required>
                                                        <option value="">Seleccionar estado</option>
                                                        <option value="draft" <?php echo (isset($course['status']) && $course['status'] == 'draft') ? 'selected' : ''; ?>>Borrador</option>
                                                        <option value="published" <?php echo (isset($course['status']) && $course['status'] == 'published') ? 'selected' : ''; ?>>Publicado</option>
                                                        <option value="archived" <?php echo (isset($course['status']) && $course['status'] == 'archived') ? 'selected' : ''; ?>>Archivado</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Categoría</label>
                                            <select class="form-select" id="category_id" name="category_id">
                                                <option value="">Seleccionar categoría</option>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?php echo $category['id']; ?>" 
                                                            <?php echo (isset($course['category_id']) && $course['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($category['name']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="form-text">Categoría a la que pertenece el curso.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- Imagen destacada -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Imagen Destacada</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($isEdit && !empty($course['featured_image'])): ?>
                                            <div class="mb-3">
                                                <label class="form-label">Imagen Actual</label>
                                                <div class="text-center">
                                                    <img src="<?php echo BASE_URL . 'assets/images/' . htmlspecialchars($course['featured_image']); ?>" 
                                                         alt="<?php echo htmlspecialchars($course['title']); ?>" 
                                                         class="img-fluid rounded" style="max-height: 200px;">
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="mb-3">
                                            <label for="featured_image" class="form-label">
                                                <?php echo $isEdit ? 'Nueva Imagen' : 'Imagen'; ?>
                                            </label>
                                            <input type="file" class="form-control" id="featured_image" name="featured_image" 
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
                                                   value="<?php echo htmlspecialchars($course['featured_image'] ?? ''); ?>" readonly>
                                            <div class="form-text">Nombre del archivo de imagen actual.</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Estadísticas (solo en modo edición) -->
                                <?php if ($isEdit): ?>
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Estadísticas</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Vistas:</span>
                                                <span class="badge bg-info"><?php echo number_format($course['views'] ?? 0); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Creado:</span>
                                                <small><?php echo date('d/m/Y H:i', strtotime($course['created_at'])); ?></small>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>Actualizado:</span>
                                                <small><?php echo date('d/m/Y H:i', strtotime($course['updated_at'])); ?></small>
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
                                                <?php echo $isEdit ? 'Actualizar Curso' : 'Crear Curso'; ?>
                                            </button>
                                            <a href="<?php echo BASE_URL; ?>admin/courses" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Cancelar
                                            </a>
                                            <?php if ($isEdit): ?>
                                                <a href="<?php echo BASE_URL; ?>courses/<?php echo htmlspecialchars($course['slug']); ?>" 
                                                   class="btn btn-outline-info" target="_blank">
                                                    <i class="fas fa-eye"></i> Ver Curso
                                                </a>
                                            <?php endif; ?>
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
    // Generar slug automáticamente basado en el título
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    titleInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.value === '') {
            const slug = this.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            slugInput.value = slug;
        }
    });

    // Validación del formulario
    const form = document.getElementById('courseForm');
    form.addEventListener('submit', function(e) {
        const requiredFields = ['title', 'description', 'level', 'status'];
        let isValid = true;
        
        requiredFields.forEach(function(fieldName) {
            const field = document.getElementById(fieldName);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor completa todos los campos requeridos.');
        }
    });

    // Preview de imagen
    const imageInput = document.getElementById('featured_image');
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
