<?php
// Vista para crear/editar eventos en el panel administrativo
require_once __DIR__ . '/../../layouts/header.php';

$isEdit = isset($event) && !empty($event);
$pageTitle = $isEdit ? 'Editar Evento' : 'Nuevo Evento';
$formAction = $isEdit ? BASE_URL . 'admin/events/update/' . $event['id'] : BASE_URL . 'admin/events/store';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>admin/events">Eventos</a></li>
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

                    <form method="POST" action="<?php echo $formAction; ?>" enctype="multipart/form-data" id="eventForm">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Información básica -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Información del Evento</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Título del Evento <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="title" name="title" 
                                                   value="<?php echo htmlspecialchars($event['title'] ?? ''); ?>" 
                                                   required maxlength="255">
                                            <div class="form-text">El título debe ser descriptivo y atractivo.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Slug (URL)</label>
                                            <input type="text" class="form-control" id="slug" name="slug" 
                                                   value="<?php echo htmlspecialchars($event['slug'] ?? ''); ?>" 
                                                   maxlength="255">
                                            <div class="form-text">Se genera automáticamente basado en el título. Puedes editarlo manualmente.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Descripción <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="description" name="description" 
                                                      rows="8" required><?php echo htmlspecialchars($event['description'] ?? ''); ?></textarea>
                                            <div class="form-text">Descripción detallada del evento, objetivos, agenda, etc.</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fecha y ubicación -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Fecha y Ubicación</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="event_date" class="form-label">Fecha y Hora <span class="text-danger">*</span></label>
                                                    <input type="datetime-local" class="form-control" id="event_date" name="event_date" 
                                                           value="<?php echo $isEdit ? date('Y-m-d\TH:i', strtotime($event['event_date'])) : ''; ?>" 
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="location" class="form-label">Ubicación <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="location" name="location" 
                                                           value="<?php echo htmlspecialchars($event['location'] ?? ''); ?>" 
                                                           required maxlength="255" placeholder="ej: Auditorio Principal, Ciudad, País">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- Configuración del evento -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Configuración</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Precio ($)</label>
                                                    <input type="number" class="form-control" id="price" name="price" 
                                                           value="<?php echo htmlspecialchars($event['price'] ?? '0.00'); ?>" 
                                                           step="0.01" min="0">
                                                    <div class="form-text">Precio del evento en dólares. Use 0 para eventos gratuitos.</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="max_attendees" class="form-label">Máximo de Asistentes</label>
                                                    <input type="number" class="form-control" id="max_attendees" name="max_attendees" 
                                                           value="<?php echo htmlspecialchars($event['max_attendees'] ?? ''); ?>" 
                                                           min="1" placeholder="Dejar vacío para ilimitado">
                                                    <div class="form-text">Número máximo de asistentes permitidos.</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Estado <span class="text-danger">*</span></label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="">Seleccionar estado</option>
                                                <option value="draft" <?php echo (isset($event['status']) && $event['status'] == 'draft') ? 'selected' : ''; ?>>Borrador</option>
                                                <option value="published" <?php echo (isset($event['status']) && $event['status'] == 'published') ? 'selected' : ''; ?>>Publicado</option>
                                                <option value="cancelled" <?php echo (isset($event['status']) && $event['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Imagen destacada -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Imagen Destacada</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($isEdit && !empty($event['featured_image'])): ?>
                                            <div class="mb-3">
                                                <label class="form-label">Imagen Actual</label>
                                                <div class="text-center">
                                                    <img src="<?php echo BASE_URL . 'assets/images/' . htmlspecialchars($event['featured_image']); ?>" 
                                                         alt="<?php echo htmlspecialchars($event['title']); ?>" 
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
                                                   value="<?php echo htmlspecialchars($event['featured_image'] ?? ''); ?>" readonly>
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
                                                <span>Asistentes:</span>
                                                <span class="badge bg-info"><?php echo number_format($event['current_attendees'] ?? 0); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Máximo:</span>
                                                <span class="badge bg-secondary"><?php echo $event['max_attendees'] ? number_format($event['max_attendees']) : 'Ilimitado'; ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Creado:</span>
                                                <small><?php echo date('d/m/Y H:i', strtotime($event['created_at'])); ?></small>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>Actualizado:</span>
                                                <small><?php echo date('d/m/Y H:i', strtotime($event['updated_at'])); ?></small>
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
                                                <?php echo $isEdit ? 'Actualizar Evento' : 'Crear Evento'; ?>
                                            </button>
                                            <a href="<?php echo BASE_URL; ?>admin/events" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Cancelar
                                            </a>
                                            <?php if ($isEdit): ?>
                                                <a href="<?php echo BASE_URL; ?>events/<?php echo htmlspecialchars($event['slug']); ?>" 
                                                   class="btn btn-outline-info" target="_blank">
                                                    <i class="fas fa-eye"></i> Ver Evento
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
    const form = document.getElementById('eventForm');
    form.addEventListener('submit', function(e) {
        const requiredFields = ['title', 'description', 'event_date', 'location', 'status'];
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
        
        // Validar fecha futura para nuevos eventos
        const eventDate = document.getElementById('event_date').value;
        if (eventDate && new Date(eventDate) < new Date()) {
            document.getElementById('event_date').classList.add('is-invalid');
            isValid = false;
        } else {
            document.getElementById('event_date').classList.remove('is-invalid');
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor completa todos los campos requeridos correctamente.');
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
