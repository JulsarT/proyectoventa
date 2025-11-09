<div class="container mt-4">
    <h2 class="text-center mb-4">Carrito de Compras</h2>

    <!-- Seleccionar Cliente con Select2 -->
    <div class="card mb-3 p-3">
        <h5>Seleccionar Cliente</h5>
        <form action="<?php echo BASE_URL . 'catalogo/procesarVenta'; ?>" method="post" id="formVenta">
            <div class="mb-3">
                <select name="id_cliente" id="selectCliente" class="form-select" required>
                    <option value="">Buscar y seleccionar cliente...</option>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $c): ?>
                            <option value="<?php echo $c['id_cliente']; ?>">
                                <?php echo htmlspecialchars($c['nombre'] . ' ' . $c['apellido_paterno']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <a href="<?php echo BASE_URL . 'cliente/crear'; ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Nuevo Cliente
            </a>
    </div>

    <!-- Tabla del carrito -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0; 
                if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])):
                    foreach ($_SESSION['carrito'] as $id => $item): 
                        $subtotal = $item['precio'] * $item['cantidad'];
                        $total += $subtotal;
                ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($item['nombre']); ?></strong>
                        </td>
                        <td>Bs. <?php echo number_format($item['precio'], 2); ?></td>
                        <td>
                            <span class="badge bg-info"><?php echo $item['cantidad']; ?></span>
                        </td>
                        <td><strong>Bs. <?php echo number_format($subtotal, 2); ?></strong></td>
                        <td>
                            <a href="<?php echo BASE_URL . 'catalogo/eliminar/' . $id; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Eliminar este producto del carrito?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php 
                    endforeach; 
                else:
                ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                            <p>El carrito está vacío</p>
                            <a href="<?php echo BASE_URL . 'catalogo'; ?>" class="btn btn-primary">
                                Ir al catálogo
                            </a>
                        </td>
                    </tr>
                <?php
                endif;
                ?>
            </tbody>
        </table>
    </div>

    <?php if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
    <div class="row mt-4">
        <div class="col-md-6">
            <a href="<?php echo BASE_URL . 'catalogo'; ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Seguir Comprando
            </a>
            <a href="<?php echo BASE_URL . 'catalogo/vaciar'; ?>" 
               class="btn btn-warning"
               onclick="return confirm('¿Vaciar todo el carrito?')">
                <i class="fas fa-broom"></i> Vaciar Carrito
            </a>
        </div>
        <div class="col-md-6 text-end">
            <h3>Total: <span class="text-success">Bs. <?php echo number_format($total, 2); ?></span></h3>
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-check-circle"></i> Procesar Venta
            </button>
        </div>
    </div>
    <?php endif; ?>

        </form>
</div>

<!-- CSS para Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Inicializar Select2
    $('#selectCliente').select2({
        theme: 'bootstrap-5',
        placeholder: 'Buscar cliente por nombre o CI...',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "No se encontraron clientes";
            },
            searching: function() {
                return "Buscando...";
            }
        }
    });

    // Validación antes de enviar
    $('#formVenta').on('submit', function(e) {
        const clienteSeleccionado = $('#selectCliente').val();
        
        if (!clienteSeleccionado) {
            e.preventDefault();
            alert('Por favor, seleccione un cliente antes de procesar la venta.');
            return false;
        }
        
        return confirm('¿Confirmar la venta por Bs. <?php echo number_format($total, 2); ?>?');
    });
});
</script>

<style>
.select2-container--bootstrap-5 .select2-selection {
    min-height: 45px;
    padding: 5px;
}

.select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
    line-height: 35px;
}

.card {
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.table {
    margin-bottom: 0;
}

.badge {
    font-size: 0.9rem;
    padding: 0.5rem 0.8rem;
}
</style>