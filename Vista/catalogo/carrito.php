<div class="container mt-4">
    <h2 class="text-center mb-4">Carrito de Compras</h2>

    <!-- Seleccionar Cliente - DOS OPCIONES -->
    <div class="card mb-3 p-4">
        <h5 class="mb-3"><i class="fas fa-user"></i> Seleccionar Cliente</h5>
        
        <form action="<?php echo BASE_URL . 'catalogo/procesarVenta'; ?>" method="post" id="formVenta">
            <div class="row">
                <!-- OPCIÓN 1: Select con todos los clientes -->
                <div class="col-md-6">
                    <div class="card border-primary h-100">
                        <div class="card-header bg-primary text-white">
                            <strong>Opción 1: Seleccionar de la lista</strong>
                        </div>
                        <div class="card-body">
                            <label for="selectClienteLista" class="form-label">Lista de Clientes</label>
                            <select id="selectClienteLista" class="form-select" size="8">
                                <option value="">-- Seleccione un cliente --</option>
                                <?php if (!empty($clientes)): ?>
                                    <?php foreach ($clientes as $c): ?>
                                        <option value="<?php echo $c['id_cliente']; ?>" 
                                                data-nombre="<?php echo htmlspecialchars($c['nombre'] . ' ' . $c['apellido_paterno']); ?>">
                                            <?php echo htmlspecialchars($c['nombre'] . ' ' . $c['apellido_paterno']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- OPCIÓN 2: Buscar cliente -->
                <div class="col-md-6">
                    <div class="card border-success h-100">
                        <div class="card-header bg-success text-white">
                            <strong>Opción 2: Buscar cliente</strong>
                        </div>
                        <div class="card-body">
                            <label for="buscarInput" class="form-label">Buscar por nombre</label>
                            <div class="input-group mb-3">
                                <input type="text" id="buscarInput" class="form-control" 
                                       placeholder="Escribe el nombre del cliente...">
                                <button type="button" class="btn btn-success" onclick="buscarCliente()">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>

                            <label for="clienteEncontrado" class="form-label">Cliente encontrado</label>
                            <input type="text" id="clienteEncontrado" class="form-control" 
                                   placeholder="El resultado aparecerá aquí..." readonly>
                            <input type="hidden" id="clienteEncontradoId" value="">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cliente seleccionado final -->
            <div class="alert alert-info mt-3" id="alertClienteSeleccionado" style="display: none;">
                <strong><i class="fas fa-user-check"></i> Cliente seleccionado:</strong>
                <span id="nombreClienteSeleccionado"></span>
                <input type="hidden" name="id_cliente" id="id_cliente_final" value="">
            </div>

            <div class="mt-3">
                <a href="<?php echo BASE_URL . 'cliente/crear'; ?>" class="btn btn-warning">
                    <i class="fas fa-plus"></i> Registrar Nuevo Cliente
                </a>
            </div>
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

<style>
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

select[size] {
    height: auto !important;
}

#selectClienteLista option:hover {
    background-color: #e3f2fd;
    cursor: pointer;
}

.input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
</style>

<script>
// Seleccionar de la lista
document.getElementById('selectClienteLista').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    
    if (this.value) {
        const clienteId = this.value;
        const clienteNombre = selectedOption.dataset.nombre;
        
        // Limpiar búsqueda
        document.getElementById('buscarInput').value = '';
        document.getElementById('clienteEncontrado').value = '';
        document.getElementById('clienteEncontradoId').value = '';
        
        // Mostrar cliente seleccionado
        mostrarClienteSeleccionado(clienteId, clienteNombre);
    }
});

// Buscar cliente
function buscarCliente() {
    const busqueda = document.getElementById('buscarInput').value.trim().toLowerCase();
    
    if (!busqueda) {
        alert('Por favor ingrese un nombre para buscar');
        return;
    }
    
    const selectLista = document.getElementById('selectClienteLista');
    let encontrado = false;
    
    // Buscar en todas las opciones
    for (let i = 0; i < selectLista.options.length; i++) {
        const option = selectLista.options[i];
        const texto = option.text.toLowerCase();
        
        if (texto.includes(busqueda)) {
            // Cliente encontrado
            const clienteId = option.value;
            const clienteNombre = option.dataset.nombre;
            
            document.getElementById('clienteEncontrado').value = clienteNombre;
            document.getElementById('clienteEncontradoId').value = clienteId;
            
            // Limpiar selección de lista
            selectLista.value = '';
            
            // Mostrar cliente seleccionado
            mostrarClienteSeleccionado(clienteId, clienteNombre);
            
            encontrado = true;
            break;
        }
    }
    
    if (!encontrado) {
        alert('No se encontró ningún cliente con ese nombre');
        document.getElementById('clienteEncontrado').value = '';
        document.getElementById('clienteEncontradoId').value = '';
    }
}

// Permitir buscar con Enter
document.getElementById('buscarInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        buscarCliente();
    }
});

// Mostrar cliente seleccionado
function mostrarClienteSeleccionado(id, nombre) {
    document.getElementById('id_cliente_final').value = id;
    document.getElementById('nombreClienteSeleccionado').textContent = nombre;
    document.getElementById('alertClienteSeleccionado').style.display = 'block';
}

// Validación del formulario
document.getElementById('formVenta').addEventListener('submit', function(e) {
    const clienteSeleccionado = document.getElementById('id_cliente_final').value;
    
    if (!clienteSeleccionado) {
        e.preventDefault();
        alert('Por favor, seleccione un cliente antes de procesar la venta.');
        return false;
    }
    
    return true;
});
</script>