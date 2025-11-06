<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-primary"><?php echo $title; ?></h1>
            
            <!-- Estadísticas rápidas -->
            <?php if (isset($estadisticas)): ?>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Productos</h6>
                                    <h3 class="mb-0"><?php echo $estadisticas['total_productos']; ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-box fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Accesorios</h6>
                                    <h3 class="mb-0"><?php echo $estadisticas['total_accesorios']; ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-plug fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Periféricos</h6>
                                    <h3 class="mb-0"><?php echo $estadisticas['total_perifericos']; ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-keyboard fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Generales</h6>
                                    <h3 class="mb-0"><?php echo $estadisticas['total_generales']; ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-cube fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Botones de filtro y acciones -->
            <div class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Botones de filtro -->
                        <div class="btn-group mb-3" role="group" aria-label="Filtros de productos">
                            <a href="<?php echo BASE_URL; ?>producto" 
                               class="btn <?php echo $mostrar_tipo === 'todos' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                <i class="fas fa-list"></i> Todos los Productos
                            </a>
                            <a href="<?php echo BASE_URL; ?>producto/accesorios" 
                               class="btn <?php echo $mostrar_tipo === 'accesorio' ? 'btn-success' : 'btn-outline-success'; ?>">
                                <i class="fas fa-plug"></i> Accesorios
                            </a>
                            <a href="<?php echo BASE_URL; ?>producto/perifericos" 
                               class="btn <?php echo $mostrar_tipo === 'periferico' ? 'btn-info' : 'btn-outline-info'; ?>">
                                <i class="fas fa-keyboard"></i> Periféricos
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <!-- Botones de acción -->
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
                            <a href="<?php echo BASE_URL; ?>producto/crear" class="btn btn-primary me-2">
                                <i class="fas fa-plus"></i> Crear Nuevo Producto
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo BASE_URL; ?>producto/generarPDF" class="btn btn-success" target="_blank">
                            <i class="fas fa-file-pdf"></i> Generar PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tabla responsive -->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col" class="text-center">Precio</th>
                            <th scope="col" class="text-center">Imagen</th>
                            <th scope="col" class="text-center">Stock</th>
                            <th scope="col">Proveedor</th>
                            
                            <?php if ($mostrar_tipo === 'todos'): ?>
                                <th scope="col" class="text-center">Tipo</th>
                            <?php endif; ?>
                            
                            <?php if ($mostrar_tipo === 'accesorio'): ?>
                                <th scope="col">Material</th>
                                <th scope="col">Color</th>
                                <th scope="col">Compatibilidad</th>
                            <?php endif; ?>
                            
                            <?php if ($mostrar_tipo === 'periferico'): ?>
                                <th scope="col">Tipo Conexión</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Garantía (meses)</th>
                            <?php endif; ?>
                            
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
                                <th scope="col" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td class="text-center fw-bold"><?php echo $producto['id_producto']; ?></td>
                                <td class="fw-semibold"><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                                <td class="text-center">
                                    <span class="badge bg-success fs-6">
                                        $<?php echo number_format($producto['precio'], 2); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($producto['imagen']): ?>
                                        <img src="<?php echo BASE_URL . $producto['imagen']; ?>" 
                                             alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                                             class="img-thumbnail imagen-hover" 
                                             style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                             data-bs-toggle="modal" 
                                             data-bs-target="#imagenModal"
                                             onclick="mostrarImagenGrande(this)">
                                    <?php else: ?>
                                        <span class="text-muted">
                                            <i class="fas fa-image"></i> Sin imagen
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($producto['stock'] > 10): ?>
                                        <span class="badge bg-success"><?php echo $producto['stock']; ?></span>
                                    <?php elseif ($producto['stock'] > 0): ?>
                                        <span class="badge bg-warning"><?php echo $producto['stock']; ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Agotado</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($producto['razon_social'] ?: 'Sin proveedor'); ?></td>
                                
                                <?php if ($mostrar_tipo === 'todos'): ?>
                                    <td class="text-center">
                                        <?php
                                        $tipoBadge = '';
                                        $tipoIcon = '';
                                        switch($producto['tipo_producto']) {
                                            case 'accesorio':
                                                $tipoBadge = 'bg-success';
                                                $tipoIcon = 'fas fa-plug';
                                                $tipoTexto = 'Accesorio';
                                                break;
                                            case 'periferico':
                                                $tipoBadge = 'bg-info';
                                                $tipoIcon = 'fas fa-keyboard';
                                                $tipoTexto = 'Periférico';
                                                break;
                                            default:
                                                $tipoBadge = 'bg-secondary';
                                                $tipoIcon = 'fas fa-cube';
                                                $tipoTexto = 'General';
                                        }
                                        ?>
                                        <span class="badge <?php echo $tipoBadge; ?>">
                                            <i class="<?php echo $tipoIcon; ?>"></i> <?php echo $tipoTexto; ?>
                                        </span>
                                    </td>
                                <?php endif; ?>
                                
                                <?php if ($mostrar_tipo === 'accesorio'): ?>
                                    <td><?php echo htmlspecialchars($producto['material'] ?: '-'); ?></td>
                                    <td>
                                        <?php if ($producto['color']): ?>
                                            <span class="badge" style="background-color: <?php echo htmlspecialchars($producto['color']); ?>; color: white;">
                                                <?php echo htmlspecialchars($producto['color']); ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($producto['compatibilidad'] ?: '-'); ?></td>
                                <?php endif; ?>
                                
                                <?php if ($mostrar_tipo === 'periferico'): ?>
                                    <td>
                                        <?php if ($producto['tipo_conexion']): ?>
                                            <span class="badge bg-primary">
                                                <?php echo htmlspecialchars($producto['tipo_conexion']); ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($producto['marca'] ?: '-'); ?></td>
                                    <td class="text-center">
                                        <?php if ($producto['garantia_meses']): ?>
                                            <span class="badge bg-warning">
                                                <?php echo $producto['garantia_meses']; ?> meses
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                                
                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo BASE_URL; ?>producto/editar/<?php echo $producto['id_producto']; ?>" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Editar producto">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>producto/eliminar/<?php echo $producto['id_producto']; ?>" 
                                               class="btn btn-outline-danger btn-sm" 
                                               title="Eliminar producto"
                                               onclick="return confirm('¿Seguro que desea eliminar este producto?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mensaje si no hay productos -->
            <?php if (empty($productos)): ?>
                <div class="alert alert-info text-center" role="alert">
                    <i class="fas fa-info-circle"></i>
                    No hay productos registrados en el sistema.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal para mostrar imagen grande -->
<div class="modal fade" id="imagenModal" tabindex="-1" aria-labelledby="imagenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagenModalLabel">Imagen del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="imagenGrande" src="" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<!-- CSS adicional -->
<style>
.imagen-hover {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.imagen-hover:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    z-index: 10;
    position: relative;
}

.table td {
    vertical-align: middle;
}

/* Efecto adicional para toda la fila */
.table tbody tr:hover {
    background-color: rgba(0,123,255,0.1);
    transform: scale(1.01);
    transition: all 0.2s ease-in-out;
}

/* Asegurar que el hover de la fila no interfiera con el de la imagen */
.table tbody tr:hover .imagen-hover:hover {
    transform: scale(1.15);
}

/* Estilos para las estadísticas */
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}

/* Botones de filtro activos */
.btn-group .btn.btn-primary,
.btn-group .btn.btn-success,
.btn-group .btn.btn-info {
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    transform: translateY(-1px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-group {
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    
    .btn-group .btn {
        margin-bottom: 5px;
        border-radius: 5px !important;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
}
</style>

<!-- JavaScript para funcionalidad -->
<script>
function mostrarImagenGrande(img) {
    const modal = document.getElementById('imagenModal');
    const imagenGrande = document.getElementById('imagenGrande');
    const modalTitle = document.getElementById('imagenModalLabel');
    
    // Establecer la imagen y el título del modal
    imagenGrande.src = img.src;
    imagenGrande.alt = img.alt;
    modalTitle.textContent = img.alt || 'Imagen del Producto';
}

// Efecto adicional: preview en hover (opcional)
document.addEventListener('DOMContentLoaded', function() {
    const imagenes = document.querySelectorAll('.imagen-hover');
    
    imagenes.forEach(function(img) {
        // Crear elemento de preview
        const preview = document.createElement('div');
        preview.className = 'imagen-preview';
        preview.style.cssText = `
            position: absolute;
            display: none;
            z-index: 1000;
            background: white;
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            pointer-events: none;
            max-width: 200px;
            max-height: 200px;
        `;
        
        const previewImg = document.createElement('img');
        previewImg.src = img.src;
        previewImg.style.cssText = `
            width: 100%;
            height: auto;
            border-radius: 4px;
        `;
        
        preview.appendChild(previewImg);
        document.body.appendChild(preview);
        
        // Mostrar preview en hover
        img.addEventListener('mouseenter', function(e) {
            preview.style.display = 'block';
        });
        
        // Mover preview con el mouse
        img.addEventListener('mousemove', function(e) {
            preview.style.left = (e.pageX + 10) + 'px';
            preview.style.top = (e.pageY + 10) + 'px';
        });
        
        // Ocultar preview
        img.addEventListener('mouseleave', function() {
            preview.style.display = 'none';
        });
    });
    
    // Animación suave para las tarjetas de estadísticas
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>