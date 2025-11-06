<div class="container my-4">
    <h1><?php echo $title; ?></h1>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
        <a href="<?php echo BASE_URL; ?>compra/crear" class="btn btn-primary mb-3">Crear Nueva Compra</a>
    <?php endif; ?>
    <a href="<?php echo BASE_URL; ?>compra/generarPDF" class="btn btn-success mb-3 ms-2" target="_blank">Generar PDF</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Proveedor</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($compras as $compra): ?>
                    <tr>
                        <td><?php echo $compra['id_compra']; ?></td>
                        <td>
                            <?php
                            echo isset($compra['nombre'])
                                ? htmlspecialchars($compra['nombre'] . ' ' . $compra['apellido_paterno'] . ' ' . $compra['apellido_materno'])
                                : 'N/A';
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($compra['proveedor_nombre'] ?: 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($compra['fecha']); ?></td>
                        <td><?php echo number_format($compra['total'], 2); ?></td>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
                            <td>
                                <a href="<?php echo BASE_URL; ?>compra/detalle/<?php echo $compra['id_compra']; ?>" class="btn btn-sm btn-info me-1">Ver Detalle</a>
                                <a href="<?php echo BASE_URL; ?>compra/eliminar/<?php echo $compra['id_compra']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que desea eliminar esta compra?');">Eliminar</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>