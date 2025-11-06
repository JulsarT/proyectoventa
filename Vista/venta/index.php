<div class="container my-4">
    <h1><?php echo $title; ?></h1>

    <a href="<?php echo BASE_URL; ?>venta/crear" class="btn btn-primary mb-3">Crear Nueva Venta</a>
    <a href="<?php echo BASE_URL; ?>venta/generarPDF" class="btn btn-success mb-3 ms-2" target="_blank">Generar PDF</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <td><?php echo $venta['id_venta']; ?></td>
                        <td><?php echo htmlspecialchars($venta['usuario_nombre'] . ' ' . $venta['usuario_apellido_paterno'] . ' ' . $venta['usuario_apellido_materno']); ?></td>
                        <td><?php echo htmlspecialchars($venta['cliente_nombre'] . ' ' . $venta['cliente_apellido_paterno'] . ' ' . $venta['cliente_apellido_materno']); ?></td>
                        <td><?php echo htmlspecialchars($venta['fecha']); ?></td>
                        <td><?php echo number_format($venta['total'], 2); ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>venta/detalle/<?php echo $venta['id_venta']; ?>" class="btn btn-sm btn-info me-1">Ver Detalle</a>
                            <a href="<?php echo BASE_URL; ?>venta/eliminar/<?php echo $venta['id_venta']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que desea eliminar esta venta?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
