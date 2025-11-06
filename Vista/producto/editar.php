<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary"><?php echo $title; ?></h1>
            <a href="<?php echo BASE_URL; ?>producto" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Productos
            </a>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle"></i>
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo BASE_URL; ?>producto/actualizar/<?php echo $producto['id_producto']; ?>" enctype="multipart/form-data" id="productoForm">
            
            <!-- Información básica del producto -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">
                            <i class="fas fa-tag"></i> Nombre del Producto
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required 
                               value="<?php echo htmlspecialchars($producto['nombre']); ?>"
                               placeholder="Ingrese el nombre del producto">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tipo_producto" class="form-label fw-bold">
                            <i class="fas fa-layer-group"></i> Tipo de Producto
                        </label>
                        <select name="tipo_producto" id="tipo_producto" class="form-select" required onchange="mostrarCamposEspecificos()">
                            <option value="">Seleccione el tipo de producto</option>
                            <option value="general" <?php echo $producto['tipo_producto'] === 'general' ? 'selected' : ''; ?>>General</option>
                            <option value="accesorio" <?php echo $producto['tipo_producto'] === 'accesorio' ? 'selected' : ''; ?>>Accesorio</option>
                            <option value="periferico" <?php echo $producto['tipo_producto'] === 'periferico' ? 'selected' : ''; ?>>Periférico</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-bold">
                            <i class="fas fa-align-left"></i> Descripción
                        </label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3" 
                                  placeholder="Ingrese la descripción del producto"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="precio" class="form-label fw-bold">
                            <i class="fas fa-dollar-sign"></i> Precio
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="precio" id="precio" class="form-control" 
                                   step="0.01" required placeholder="0.00"
                                   value="<?php echo $producto['precio']; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="stock" class="form-label fw-bold">
                            <i class="fas fa-boxes"></i> Stock
                        </label>
                        <input type="number" name="stock" id="stock" class="form-control" required 
                               min="0" placeholder="Cantidad en stock"
                               value="<?php echo $producto['stock']; ?>">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="id_proveedor" class="form-label fw-bold">
                            <i class="fas fa-truck"></i> Proveedor
                        </label>
                        <select name="id_proveedor" id="id_proveedor" class="form-select" required>
                            <option value="">Seleccione un proveedor</option>
                            <?php foreach ($proveedores as $proveedor): ?>
                                <option value="<?php echo $proveedor['id_proveedor']; ?>"
                                        <?php echo $producto['id_proveedor'] == $proveedor['id_proveedor'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($proveedor['razon_social']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Imagen actual y nueva -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        <i class="fas fa-image"></i> Imagen Actual
                    </label>
                    <div class="border rounded p-3 text-center bg-light">
                        <?php if ($producto['imagen']): ?>
                            <img src="<?php echo BASE_URL . $producto['imagen']; ?>" 
                                 alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                                 class="img-fluid rounded"
                                 style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="text-muted">
                                <i class="fas fa-image fa-3x"></i>
                                <p class="mt-2">Sin imagen</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="imagen" class="form-label fw-bold">
                        <i class="fas fa-upload"></i> Cambiar Imagen
                    </label>
                    <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" 
                           onchange="previewImage(this)">
                    <div class="form-text">
                        <small class="text-muted">Formatos permitidos: JPG, PNG, GIF. Máximo 2MB.</small>
                    </div>
                    <!-- Preview de la nueva imagen -->
                    <div id="imagePreview" class="mt-3" style="display: none;">
                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail" 
                             style="max-width: 200px; max-height: 200px; object-fit: cover;">
                    </div>
                </div>
            </div>

            <!-- Campos específicos para Accesorio -->
            <div id="camposAccesorio" class="campos-especificos" style="display: none;">
                <div class="card border-success mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-plug"></i> Información del Accesorio</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="material" class="form-label fw-bold">
                                        <i class="fas fa-hammer"></i> Material
                                    </label>
                                    <input type="text" name="material" id="material" class="form-control" 
                                           placeholder="Ej: Plástico, Metal, Goma"
                                           value="<?php echo htmlspecialchars($producto['material'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="color" class="form-label fw-bold">
                                        <i class="fas fa-palette"></i> Color
                                    </label>
                                    <input type="color" name="color" id="color" class="form-control form-control-color" 
                                           value="<?php echo $producto['color'] ?? '#000000'; ?>" title="Seleccione un color">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="compatibilidad" class="form-label fw-bold">
                                        <i class="fas fa-puzzle-piece"></i> Compatibilidad
                                    </label>
                                    <input type="text" name="compatibilidad" id="compatibilidad" class="form-control" 
                                           placeholder="Ej: iPhone, Android, Universal"
                                           value="<?php echo htmlspecialchars($producto['compatibilidad'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campos específicos para Periférico -->
            <div id="camposPeriferico" class="campos-especificos" style="display: none;">
                <div class="card border-info mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-keyboard"></i> Información del Periférico</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tipo_conexion" class="form-label fw-bold">
                                        <i class="fas fa-plug"></i> Tipo de Conexión
                                    </label>
                                    <select name="tipo_conexion" id="tipo_conexion" class="form-select">
                                        <option value="">Seleccione tipo de conexión</option>
                                        <option value="USB" <?php echo ($producto['tipo_conexion'] ?? '') === 'USB' ? 'selected' : ''; ?>>USB</option>
                                        <option value="USB-C" <?php echo ($producto['tipo_conexion'] ?? '') === 'USB-C' ? 'selected' : ''; ?>>USB-C</option>
                                        <option value="Bluetooth" <?php echo ($producto['tipo_conexion'] ?? '') === 'Bluetooth' ? 'selected' : ''; ?>>Bluetooth</option>
                                        <option value="WiFi" <?php echo ($producto['tipo_conexion'] ?? '') === 'WiFi' ? 'selected' : ''; ?>>WiFi</option>
                                        <option value="3.5mm Jack" <?php echo ($producto['tipo_conexion'] ?? '') === '3.5mm Jack' ? 'selected' : ''; ?>>3.5mm Jack</option>
                                        <option value="HDMI" <?php echo ($producto['tipo_conexion'] ?? '') === 'HDMI' ? 'selected' : ''; ?>>HDMI</option>
                                        <option value="VGA" <?php echo ($producto['tipo_conexion'] ?? '') === 'VGA' ? 'selected' : ''; ?>>VGA</option>
                                        <option value="Ethernet" <?php echo ($producto['tipo_conexion'] ?? '') === 'Ethernet' ? 'selected' : ''; ?>>Ethernet</option>
                                        <option value="Inalámbrico" <?php echo ($producto['tipo_conexion'] ?? '') === 'Inalámbrico' ? 'selected' : ''; ?>>Inalámbrico</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="marca" class="form-label fw-bold">
                                        <i class="fas fa-trademark"></i> Marca
                                    </label>
                                    <input type="text" name="marca" id="marca" class="form-control" 
                                           placeholder="Ej: Logitech, Razer, HP"
                                           value="<?php echo htmlspecialchars($producto['marca'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="garantia_meses" class="form-label fw-bold">
                                        <i class="fas fa-shield-alt"></i> Garantía (meses)
                                    </label>
                                    <input type="number" name="garantia_meses" id="garantia_meses" class="form-control" 
                                           min="0" max="120" placeholder="12"
                                           value="<?php echo $producto['garantia_meses'] ?? ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-3 border-top">
                <a href="<?php echo BASE_URL; ?>producto" class="btn btn-secondary me-md-2">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check"></i> Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>

<!-- CSS adicional -->
<style>
.campos-especificos {
    transition: all 0.3s ease-in-out;
}

.card {
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 500;
}

/* Animación para mostrar campos */
.fade-in {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Color picker styling */
.form-control-color {
    width: 60px;
    height: 38px;
}

/* Preview image styling */
#imagePreview {
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    background-color: #f8f9fa;
}

#previewImg {
    border-radius: 8px;
}

/* Espaciado adicional para evitar conflictos */
.container {
    padding-bottom: 80px !important;
    min-height: calc(100vh - 200px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        padding-bottom: 120px !important;
    }
}
</style>

<!-- JavaScript para funcionalidad dinámica -->
<script>
function mostrarCamposEspecificos() {
    const tipoSeleccionado = document.getElementById('tipo_producto').value;
    const camposAccesorio = document.getElementById('camposAccesorio');
    const camposPeriferico = document.getElementById('camposPeriferico');
    
    // Ocultar todos los campos específicos primero
    camposAccesorio.style.display = 'none';
    camposPeriferico.style.display = 'none';
    
    // Limpiar campos requeridos anteriores
    limpiarCamposRequeridos();
    
    // Mostrar campos según el tipo seleccionado
    if (tipoSeleccionado === 'accesorio') {
        camposAccesorio.style.display = 'block';
        camposAccesorio.classList.add('fade-in');
        
    } else if (tipoSeleccionado === 'periferico') {
        camposPeriferico.style.display = 'block';
        camposPeriferico.classList.add('fade-in');
    }
}

function limpiarCamposRequeridos() {
    // Remover atributo required de campos específicos
    const camposEspecificos = ['material', 'color', 'compatibilidad', 'tipo_conexion', 'marca', 'garantia_meses'];
    camposEspecificos.forEach(campo => {
        const elemento = document.getElementById(campo);
        if (elemento) {
            elemento.required = false;
        }
    });
}

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            preview.classList.add('fade-in');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

// Validación del formulario antes del envío
document.getElementById('productoForm').addEventListener('submit', function(e) {
    const tipoProducto = document.getElementById('tipo_producto').value;
    
    if (!tipoProducto) {
        e.preventDefault();
        alert('Por favor seleccione el tipo de producto');
        return false;
    }
    
    // Validaciones adicionales según el tipo
    if (tipoProducto === 'accesorio') {
        const material = document.getElementById('material').value.trim();
        if (!material) {
            e.preventDefault();
            alert('Por favor ingrese el material del accesorio');
            document.getElementById('material').focus();
            return false;
        }
    }
    
    if (tipoProducto === 'periferico') {
        const tipoConexion = document.getElementById('tipo_conexion').value;
        if (!tipoConexion) {
            e.preventDefault();
            alert('Por favor seleccione el tipo de conexión del periférico');
            document.getElementById('tipo_conexion').focus();
            return false;
        }
    }
    
    return true;
});

// Inicialización - mostrar campos según el tipo actual
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar los campos específicos según el tipo actual del producto
    mostrarCamposEspecificos();
    
    // Animación suave para el formulario
    const form = document.getElementById('productoForm');
    form.style.opacity = '0';
    form.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        form.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        form.style.opacity = '1';
        form.style.transform = 'translateY(0)';
    }, 100);
});
</script>