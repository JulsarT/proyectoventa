<h1><?php echo $title; ?></h1>
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<form method="POST" action="<?php echo BASE_URL; ?>venta/guardar">
    <label>Usuario:</label>
    <select name="id_usuario" required>
        <option value="">Seleccione un usuario</option>
        <?php foreach ($usuarios as $usuario): ?>
            <option value="<?php echo $usuario['id_usuario']; ?>"><?php echo $usuario['nombre']; ?></option>
        <?php endforeach; ?>
    </select>
    <label>Cliente:</label>
    <select name="id_cliente" required>
        <option value="">Seleccione un cliente</option>
        <?php foreach ($clientes as $cliente): ?>
            <option value="<?php echo $cliente['id_cliente']; ?>"><?php echo $cliente['nombre']; ?></option>
        <?php endforeach; ?>
    </select>
    <h3>Productos</h3>
    <div id="detalles">
        <div class="detalle">
            <label>Producto:</label>
            <select name="id_producto[]" onchange="updatePrecio(this)">
                <option value="">Seleccione un producto</option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?php echo $producto['id_producto']; ?>" data-precio="<?php echo $producto['precio_venta']; ?>">
                        <?php echo $producto['nombre'] . ' (Stock: ' . $producto['stock'] . ')'; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label>Cantidad:</label>
            <input type="number" name="cantidad[]" min="1" required>
            <label>Precio Unitario:</label>
            <input type="number" name="precio_unitario[]" step="0.01" readonly>
        </div>
    </div>
    <button type="button" onclick="agregarDetalle()">Agregar Producto</button>
    <label>Total:</label>
    <input type="number" name="total" id="total" step="0.01" readonly>
    <button type="submit">Guardar Venta</button>
</form>

<script>
function updatePrecio(select) {
    const precio = select.options[select.selectedIndex].dataset.precio || 0;
    const inputPrecio = select.parentElement.querySelector('input[name="precio_unitario[]"]');
    inputPrecio.value = parseFloat(precio).toFixed(2);
    calcularTotal();
}

function agregarDetalle() {
    const detalles = document.getElementById('detalles');
    const nuevoDetalle = detalles.children[0].cloneNode(true);
    nuevoDetalle.querySelector('select').value = '';
    nuevoDetalle.querySelector('input[name="cantidad[]"]').value = '';
    nuevoDetalle.querySelector('input[name="precio_unitario[]"]').value = '';
    detalles.appendChild(nuevoDetalle);
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