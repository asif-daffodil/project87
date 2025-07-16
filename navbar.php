<?php  
  $pageName = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="#">eCommerce</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= $pageName === 'index.php' ? 'active' : '' ?>" aria-current="page" href="./">Home</a>
        </li>
        <?php if(!isset($_SESSION['user'])){  ?>
        <li class="nav-item">
          <a class="nav-link" href="./sign-in.php">Sign in</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./sign-up.php">Sign up</a>
        </li>
        <?php } else { ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION['user']['name']  ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="./password-change.php">Password Change</a></li>
            <li><a class="dropdown-item" href="./profile-picture.php">Update Profile Picture</a></li>
            <li><a class="dropdown-item" href="./settings.php">Settings</a></li>
            <?php if($_SESSION['user']['role'] == 'admin') { ?>
            <li><a class="dropdown-item" href="./admin">Admin Panel</a></li>
            <?php } ?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
          </ul>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link"><i class="fa-solid fa-cart-shopping"></i></a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>