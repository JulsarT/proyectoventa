<div class="container my-4">
    <h1><?php echo $title; ?></h1>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id_usuario']; ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['apellido_paterno']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['apellido_materno']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['tipo_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['estado']); ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>usuario/activar/<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-success me-1">Activar</a>
                            <a href="<?php echo BASE_URL; ?>usuario/eliminar/<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que desea eliminar este usuario permanentemente?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="<?php echo BASE_URL; ?>usuario" class="btn btn-secondary mt-3">Volver a Usuarios Activos</a>
</div>
