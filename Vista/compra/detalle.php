<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1 class="mb-4"><?php echo $title; ?></h1>

        <h3 class="mb-3">Información de la Compra</h3>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>ID Compra:</strong> <?php echo $compra['id_compra']; ?></li>
            <li class="list-group-item"><strong>Usuario:</strong> <?php echo $compra['usuario_nombre'] ?: 'N/A'; ?></li>
            <li class="list-group-item"><strong>Proveedor:</strong> <?php echo $compra['proveedor_nombre'] ?: 'N/A'; ?></li>
            <li class="list-group-item"><strong>Fecha:</strong> <?php echo $compra['fecha']; ?></li>
            <li class="list-group-item"><strong>Total:</strong> Bs. <?php echo number_format($compra['total'], 2); ?></li>
        </ul>

        <h3 class="mb-3">Detalles de la Compra</h3>
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID Detalle</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario (Bs.)</th>
                        <th>Subtotal (Bs.)</th>
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

        <a href="<?php echo BASE_URL; ?>compra" class="btn btn-secondary">Volver a Compras</a>
    </div>
</div>
