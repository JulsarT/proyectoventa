<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo BASE_URL; ?>home/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-store"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Accesorios</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>home/dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Nav Item - Usuarios -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>usuario">
                <i class="fas fa-users"></i>
                <span>Usuarios</span>
            </a>
        </li>

        <!-- Nav Item - Productos -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>producto">
                <i class="fas fa-boxes"></i>
                <span>Productos</span>
            </a>
        </li>

        <!-- Nav Item - Clientes -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>cliente">
                <i class="fas fa-user-friends"></i>
                <span>Clientes</span>
            </a>
        </li>

        <!-- Nav Item - Proveedores -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>proveedor">
                <i class="fas fa-truck"></i>
                <span>Proveedores</span>
            </a>
        </li>

        <!-- Nav Item - Ventas -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>venta">
                <i class="fas fa-shopping-cart"></i>
                <span>Ventas</span>
            </a>
        </li>

        <!-- Nav Item - Compras -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>compra">
                <i class="fas fa-clipboard-list"></i>
                <span>Compras</span>
            </a>
        </li>

    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>