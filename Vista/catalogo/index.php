<div class="container mt-4">
    <h2 class="text-center mb-4">Catálogo de Productos</h2>

    <!-- FILTROS -->
    <form method="get" action="<?php echo BASE_URL . 'catalogo/index'; ?>" class="mb-4">
        <div class="d-flex flex-wrap align-items-end gap-3">
            <!-- Filtro por categoría -->
            <div class="flex-fill">
                <div>
                    <?php if (!empty($productosBajos)): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>⚠️ Atención:</strong> Hay <?php echo count($productosBajos); ?> productos con stock bajo.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                        <ul class="mt-2 mb-0">
                            <?php foreach ($productosBajos as $p): ?>
                                <li><?php echo htmlspecialchars($p['nombre']); ?> — Stock: <?php echo $p['stock']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                </div>
                <label class="form-label fw-bold">Categoría</label>
                <select name="categoria" class="form-select">
                    <option value="">Todas</option>
                    <option value="accesorio" <?php echo ($categoria == 'accesorio') ? 'selected' : ''; ?>>Accesorios</option>
                    <option value="periferico" <?php echo ($categoria == 'periferico') ? 'selected' : ''; ?>>Periféricos</option>
                </select>
            </div>

            <!-- Filtro por precio -->
            <div class="flex-fill">
                <label class="form-label fw-bold">Ordenar por Precio</label>
                <select name="orden_precio" class="form-select">
                    <option value="">-- Seleccionar --</option>
                    <option value="asc" <?php echo ($orden_precio == 'asc') ? 'selected' : ''; ?>>Menor a Mayor</option>
                    <option value="desc" <?php echo ($orden_precio == 'desc') ? 'selected' : ''; ?>>Mayor a Menor</option>
                </select>
            </div>

            <!-- Filtro por stock -->
            <div class="flex-fill">
                <label class="form-label fw-bold">Ordenar por Stock</label>
                <select name="orden_stock" class="form-select">
                    <option value="">-- Seleccionar --</option>
                    <option value="asc" <?php echo ($orden_stock == 'asc') ? 'selected' : ''; ?>>Menor a Mayor</option>
                    <option value="desc" <?php echo ($orden_stock == 'desc') ? 'selected' : ''; ?>>Mayor a Menor</option>
                </select>
            </div>

            <div class="flex-fill">
                <button type="submit" class="btn btn-primary w-100">Aplicar Filtros 🔍</button>
            </div>
        </div>
    </form>

    <!-- GRID DE PRODUCTOS -->
    <div class="row">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $p): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo BASE_URL . htmlspecialchars($p['imagen']); ?>" class="card-img-top" alt="Imagen del producto">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($p['nombre']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($p['descripcion']); ?></p>
                            <p><strong>Precio de venta:</strong> Bs <?= number_format($p['precio_venta'] ?? $p['precio'], 2) ?></p>
                            <p><strong>Stock:</strong> <?php echo $p['stock']; ?></p>

                            <form action="<?php echo BASE_URL . 'catalogo/agregar/' . $p['id_producto']; ?>" method="post">
                                <div class="input-group mb-2">
                                    <input type="number" name="cantidad" class="form-control"
                                        value="1" min="1" max="<?php echo $p['stock']; ?>"
                                        <?php echo ($p['stock'] == 0) ? 'disabled' : ''; ?>>
                                    <button type="submit"
                                        class="btn <?php echo ($p['stock'] == 0) ? 'btn-danger' : 'btn-success'; ?>"
                                        <?php echo ($p['stock'] == 0) ? 'disabled' : ''; ?>>
                                        <?php echo ($p['stock'] == 0) ? 'Agotado' : 'Agregar 🛒'; ?>
                                    </button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">No se encontraron productos con los filtros seleccionados.</p>
        <?php endif; ?>
    </div>

    <div class="text-center mt-3">
        <a href="<?php echo BASE_URL . 'catalogo/carrito'; ?>" class="btn btn-primary">Ver carrito 🛍️</a>
    </div>
</div>