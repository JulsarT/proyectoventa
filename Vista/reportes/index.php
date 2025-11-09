<div class="container mt-4">
    <h2 class="text-center mb-4"><?php echo $title; ?></h2>

    <div class="row g-3">
        <div class="col-md-3">
            <a href="<?php echo BASE_URL; ?>reporte/ventasCompletas" class="btn btn-primary w-100" target="_blank">Reporte de Ventas Completas</a>
        </div>
        <div class="col-md-3">
            <a href="<?php echo BASE_URL; ?>reporte/productosStockMinimo" class="btn btn-warning w-100" target="_blank">Productos con Stock Mínimo</a>
        </div>
        <div class="col-md-3">
            <a href="<?php echo BASE_URL; ?>reporte/ventasDelDia" class="btn btn-success w-100" target="_blank">Ventas del Día</a>
        </div>
        <div class="col-md-3">
            <a href="<?php echo BASE_URL; ?>reporte/clientesMasCompras" class="btn btn-info w-100" target="_blank">Clientes con Más Compras</a>
        </div>
    </div>
</div>
