<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1 class="mb-4"><?php echo $title; ?></h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo BASE_URL; ?>compra/guardar">
            <label>Usuario:</label>
            <select name="id_usuario" required>
                <option value="">Seleccione un usuario</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo $usuario['id_usuario']; ?>"><?php echo $usuario['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
            <label>Proveedor:</label>
            <select name="id_proveedor" required>
                <option value="">Seleccione un proveedor</option>
                <?php foreach ($proveedores as $proveedor): ?>
                    <option value="<?php echo $proveedor['id_proveedor']; ?>"><?php echo $proveedor['razon_social']; ?></option>
                <?php endforeach; ?>
            </select>
            <h3>Productos</h3>
            <div id="detalles">
                <div class="detalle">
                    <label>Producto:</label>
                    <select name="id_producto[]" onchange="updatePrecio(this)">
                        <option value="">Seleccione un producto</option>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?php echo $producto['id_producto']; ?>" data-precio="<?php echo $producto['precio']; ?>">
                                <?php echo $producto['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label>Cantidad:</label>
                    <input type="number" name="cantidad[]" min="1" required>
                    <label>Precio Unitario:</label>
                    <input type="number" name="precio_unitario[]" step="0.01" required>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarDetalle(this)">Eliminar</button>
                    
                </div>
            </div>
            <button type="button" onclick="agregarDetalle()">Agregar Producto</button>
            <label>Total:</label>
            <input type="number" name="total" id="total" step="0.01" readonly>
            <button type="submit">Guardar Compra</button>
        </form>
    </div>
</div>

<script>
function updatePrecio(select) {
    const precio = select.options[select.selectedIndex].dataset.precio || 0;
    const inputPrecio = select.parentElement.parentElement.querySelector('input[name="precio_unitario[]"]');
    inputPrecio.value = parseFloat(precio).toFixed(2);
    calcularTotal();
}

function agregarDetalle() {
    const detalles = document.getElementById('detalles');
    const nuevoDetalle = detalles.children[0].cloneNode(true);

    nuevoDetalle.querySelector('select').value = '';
    nuevoDetalle.querySelector('input[name="cantidad[]"]').value = '';
    nuevoDetalle.querySelector('input[name="precio_unitario[]"]').value = '';

    // Añadir el evento de cambio y cálculo
    nuevoDetalle.querySelector('input[name="cantidad[]"]').addEventListener('input', calcularTotal);
    nuevoDetalle.querySelector('select').addEventListener('change', function() { updatePrecio(this); });

    detalles.appendChild(nuevoDetalle);
}

function eliminarDetalle(boton) {
    const detalle = boton.closest('.detalle');
    const detalles = document.querySelectorAll('.detalle');

    if (detalles.length > 1) {
        detalle.remove();
        calcularTotal();
    } else {
        alert('Debe haber al menos un producto en la compra.');
    }
}

function calcularTotal() {
    let total = 0;
    const detalles = document.querySelectorAll('.detalle');

    detalles.forEach(detalle => {
        const cantidad = parseInt(detalle.querySelector('input[name="cantidad[]"]').value) || 0;
        const precio = parseFloat(detalle.querySelector('input[name="precio_unitario[]"]').value) || 0;
        total += cantidad * precio;
    });

    document.getElementById('total').value = total.toFixed(2);
}

document.querySelectorAll('input[name="cantidad[]"]').forEach(input => {
    input.addEventListener('input', calcularTotal);
});
</script>
