<?php
$pageName = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-dark">
    <ul class="navbar-nav flex-column">
        <li class="nav-item">
            <a class="nav-link fs-1 <?= $pageName === 'index.php' ? 'active' : '' ?>" aria-current="page" href="./index.php">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $pageName === 'products.php' ? 'active' : '' ?>" aria-current="page" href="./products.php">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $pageName === 'orders.php' ? 'active' : '' ?>" href="./orders.php">Orders</a>
        </li>
    </ul>
</nav>