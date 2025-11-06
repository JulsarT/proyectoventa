<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1 class="mb-4"><?php echo $title; ?></h1>

        <h3 class="mb-3">Información de la Venta</h3>

        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>ID Venta:</strong> <?php echo $venta['id_venta']; ?></li>
            <li class="list-group-item"><strong>Usuario:</strong> 
                <?php echo $venta['usuario_nombre'] . ' ' . $venta['usuario_apellido_paterno'] . ' ' . $venta['usuario_apellido_materno']; ?>
            </li>
            <li class="list-group-item"><strong>Cliente:</strong> 
                <?php echo $venta['cliente_nombre'] . ' ' . $venta['cliente_apellido_paterno'] . ' ' . $venta['cliente_apellido_materno']; ?>
            </li>
            <li class="list-group-item"><strong>Fecha:</strong> <?php echo $venta['fecha']; ?></li>
            <li class="list-group-item"><strong>Total:</strong> <?php echo number_format($venta['total'], 2); ?></li>
        </ul>

        <h3 class="mb-3">Detalles de la Venta</h3>

        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID Detalle</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $detalle): ?>
                        <tr>
                            <td><?php echo $detalle['id_detalle']; ?></td>
                            <td><?php echo $detalle['producto_nombre']; ?></td>
                            <td><?php echo $detalle['cantidad']; ?></td>
                            <td><?php echo number_format($detalle['precio_unitario'], 2); ?></td>
                            <td><?php echo number_format($detalle['cantidad'] * $detalle['precio_unitario'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <a href="<?php echo BASE_URL; ?>venta" class="btn btn-primary">Volver a Ventas</a>
    </div>
</div>
