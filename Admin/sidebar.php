<?php
$pageName = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-dark position-fixed z-3 start-0 w-max px-3">
    <ul class="navbar-nav flex-column">
        <li class="nav-item">
            <a class="nav-link fs-1 <?= $pageName === 'index.php' ? 'active' : '' ?>" href="/admin/index.php">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $pageName === 'products.php' ? 'active' : '' ?>" href="/admin/products.php">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $pageName === 'orders.php' ? 'active' : '' ?>" href="/admin/orders.php">Orders</a>
        </li>
    </ul>
</nav>