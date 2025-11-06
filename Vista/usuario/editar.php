<div class="container my-4">
    <h1 class="mb-4"><?php echo $title; ?></h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo BASE_URL; ?>usuario/actualizar/<?php echo $usuario['id_usuario']; ?>" class="row g-3">
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
        </div>

        <div class="col-md-6">
            <label for="apellido_paterno" class="form-label">Apellido Paterno:</label>
            <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" value="<?php echo htmlspecialchars($usuario['apellido_paterno']); ?>" required>
        </div>

        <div class="col-md-6">
            <label for="apellido_materno" class="form-label">Apellido Materno:</label>
            <input type="text" id="apellido_materno" name="apellido_materno" class="form-control" value="<?php echo htmlspecialchars($usuario['apellido_materno']); ?>" required>
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
        </div>

        <div class="col-md-6">
            <label for="password" class="form-label">Contraseña (dejar en blanco si no desea cambiar):</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>

        <div class="col-md-6">
            <label for="tipo_usuario" class="form-label">Tipo de Usuario:</label>
            <select id="tipo_usuario" name="tipo_usuario" class="form-select" required>
                <option value="administrador" <?php echo $usuario['tipo_usuario'] === 'administrador' ? 'selected' : ''; ?>>Administrador</option>
                <option value="vendedor" <?php echo $usuario['tipo_usuario'] === 'vendedor' ? 'selected' : ''; ?>>Vendedor</option>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="<?php echo BASE_URL; ?>usuario" class="btn btn-secondary ms-2">Cancelar</a>
        </div>
    </form>
</div>
