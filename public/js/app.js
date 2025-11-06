// public/js/app.js
// Funcionalidades JavaScript se agregarán según necesidades
// public/js/app.js
// Funciones para el formulario de ventas
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
    nuevoDetalle.querySelector('input[name="cantidad[]"]').addEventListener('input', calcularTotal);
    nuevoDetalle.querySelector('select').addEventListener('change', function() { updatePrecio(this); });
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