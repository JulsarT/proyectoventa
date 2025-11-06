<div class="container my-4">
    <h1><?php echo $title; ?></h1>

    <a href="<?php echo BASE_URL; ?>cliente/crear" class="btn btn-primary mb-3">Crear Nuevo Cliente</a>
    <a href="<?php echo BASE_URL; ?>cliente/generarPDF" class="btn btn-success mb-3 ms-2" target="_blank">Generar PDF</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Dirección</th>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
                        <th scope="col" class="text-center">Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo $cliente['id_cliente']; ?></td>
                        <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['apellido_paterno']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['apellido_materno']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['telefono'] ?: 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($cliente['email'] ?: 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($cliente['direccion'] ?: 'N/A'); ?></td>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
                            <td>
                                <a href="<?php echo BASE_URL; ?>cliente/editar/<?php echo $cliente['id_cliente']; ?>" class="btn btn-sm btn-warning me-1">Editar</a>
                                <a href="<?php echo BASE_URL; ?>cliente/eliminar/<?php echo $cliente['id_cliente']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que desea eliminar este cliente?');">Eliminar</a>
                            </td>
                        <?php endif; ?>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>