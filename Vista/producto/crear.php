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

        <form method="POST" action="<?php echo BASE_URL; ?>producto/guardar" enctype="multipart/form-data" id="productoForm">
            
            <!-- Información básica del producto -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">
                            <i class="fas fa-tag"></i> Nombre del Producto
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required 
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
                            <option value="general">General</option>
                            <option value="accesorio">Accesorio</option>
                            <option value="periferico">Periférico</option>
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
                                  placeholder="Ingrese la descripción del producto"></textarea>
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
                                   step="0.01" required placeholder="0.00">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="stock" class="form-label fw-bold">
                            <i class="fas fa-boxes"></i> Stock
                        </label>
                        <input type="number" name="stock" id="stock" class="form-control" required 
                               min="0" placeholder="Cantidad en stock">
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
                                <option value="<?php echo $proveedor['id_proveedor']; ?>">
                                    <?php echo htmlspecialchars($proveedor['razon_social']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label fw-bold">
                    <i class="fas fa-image"></i> Imagen del Producto
                </label>
                <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" 
                       onchange="previewImage(this)">
                <div class="form-text">
                    <small class="text-muted">Formatos permitidos: JPG, PNG, GIF. Máximo 2MB.</small>
                </div>
                <!-- Preview de la imagen -->
                <div id="imagePreview" class="mt-3" style="display: none;">
                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail" 
                         style="max-width: 200px; max-height: 200px; object-fit: cover;">
                </div>
            </div>

            <!-- Campos específicos para Accesorio (inicialmente ocultos) -->
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
                                           placeholder="Ej: Plástico, Metal, Goma">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="color" class="form-label fw-bold">
                                        <i class="fas fa-palette"></i> Color
                                    </label>
                                    <input type="color" name="color" id="color" class="form-control form-control-color" 
                                           value="#000000" title="Seleccione un color">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="compatibilidad" class="form-label fw-bold">
                                        <i class="fas fa-puzzle-piece"></i> Compatibilidad
                                    </label>
                                    <input type="text" name="compatibilidad" id="compatibilidad" class="form-control" 
                                           placeholder="Ej: iPhone, Android, Universal">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campos específicos para Periférico (inicialmente ocultos) -->
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
                                        <option value="USB">USB</option>
                                        <option value="USB-C">USB-C</option>
                                        <option value="Bluetooth">Bluetooth</option>
                                        <option value="WiFi">WiFi</option>
                                        <option value="3.5mm Jack">3.5mm Jack</option>
                                        <option value="HDMI">HDMI</option>
                                        <option value="VGA">VGA</option>
                                        <option value="Ethernet">Ethernet</option>
                                        <option value="Inalámbrico">Inalámbrico</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="marca" class="form-label fw-bold">
                                        <i class="fas fa-trademark"></i> Marca
                                    </label>
                                    <input type="text" name="marca" id="marca" class="form-control" 
                                           placeholder="Ej: Logitech, Razer, HP">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="garantia_meses" class="form-label fw-bold">
                                        <i class="fas fa-shield-alt"></i> Garantía (meses)
                                    </label>
                                    <input type="number" name="garantia_meses" id="garantia_meses" class="form-control" 
                                           min="0" max="120" placeholder="12">
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
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Guardar Producto
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
        
        // Hacer campos de accesorio requeridos (opcional)
        // document.getElementById('material').required = true;
        // document.getElementById('color').required = true;
        // document.getElementById('compatibilidad').required = true;
        
    } else if (tipoSeleccionado === 'periferico') {
        camposPeriferico.style.display = 'block';
        camposPeriferico.classList.add('fade-in');
        
        // Hacer campos de periférico requeridos (opcional)
        // document.getElementById('tipo_conexion').required = true;
        // document.getElementById('marca').required = true;
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

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
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