<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1 class="mb-4"><?php echo $title; ?></h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo BASE_URL; ?>proveedor/actualizar/<?php echo $proveedor['id_proveedor']; ?>">
            <div class="mb-3">
                <label for="razon_social" class="form-label">Razón Social:</label>
                <input type="text" name="razon_social" id="razon_social" class="form-control" value="<?php echo $proveedor['razon_social']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="nit" class="form-label">NIT:</label>
                <input type="text" name="nit" id="nit" class="form-control" value="<?php echo $proveedor['nit']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="contacto" class="form-label">Contacto:</label>
                <input type="text" name="contacto" id="contacto" class="form-control" value="<?php echo $proveedor['contacto']; ?>">
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo $proveedor['telefono']; ?>">
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <textarea name="direccion" id="direccion" class="form-control" rows="3"><?php echo $proveedor['direccion']; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</div>
