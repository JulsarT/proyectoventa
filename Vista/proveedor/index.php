<div class="container my-4">
    <h1><?php echo $title; ?></h1>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
        <a href="<?php echo BASE_URL; ?>proveedor/crear" class="btn btn-primary mb-3">Crear Nuevo Proveedor</a>
    <?php endif; ?>

    <a href="<?php echo BASE_URL; ?>proveedor/generarPDF" class="btn btn-success mb-3" target="_blank">Generar PDF</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Razón Social</th>
                    <th>NIT</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proveedores as $proveedor): ?>
                    <tr>
                        <td><?php echo $proveedor['id_proveedor']; ?></td>
                        <td><?php echo htmlspecialchars($proveedor['razon_social']); ?></td>
                        <td><?php echo htmlspecialchars($proveedor['nit']); ?></td>
                        <td><?php echo htmlspecialchars($proveedor['contacto'] ?: 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($proveedor['telefono'] ?: 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($proveedor['direccion'] ?: 'N/A'); ?></td>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
                            <td>
                                <a href="<?php echo BASE_URL; ?>proveedor/editar/<?php echo $proveedor['id_proveedor']; ?>" class="btn btn-sm btn-warning me-1">Editar</a>
                                <a href="<?php echo BASE_URL; ?>proveedor/eliminar/<?php echo $proveedor['id_proveedor']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que desea eliminar este proveedor?');">Eliminar</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
