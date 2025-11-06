<div class="container my-4">
    <h1><?php echo $title; ?></h1>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
        <a href="<?php echo BASE_URL; ?>usuario/crear" class="btn btn-primary mb-3">Crear Nuevo Usuario</a>
    <?php endif; ?>

    <a href="<?php echo BASE_URL; ?>usuario/generarPDF" class="btn btn-success mb-3" target="_blank">Generar PDF</a>

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
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
                        <th>Acciones</th>
                    <?php endif; ?>
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
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
                            <td>
                                <a href="<?php echo BASE_URL; ?>usuario/editar/<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-warning me-1">Editar</a>
                                <a href="<?php echo BASE_URL; ?>usuario/desactivar/<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que desea desactivar este usuario?');">Desactivar</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'administrador'): ?>
        <a href="<?php echo BASE_URL; ?>usuario/inactivos" class="btn btn-secondary mt-3">Ver Usuarios Inactivos</a>
    <?php endif; ?>
</div>
