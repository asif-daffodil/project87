<nav class="navbar navbar-expand-lg bg-dark navbar-dark position-fixed z-2 top-0 start-0 w-100">
  <div class="container-fluid px-3">
    <a class="navbar-brand" href="#">eCommerce</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION['user']['name']  ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end bg-light">
            <li><a class="dropdown-item" href="../password-change.php">Password Change</a></li>
            <li><a class="dropdown-item" href="../profile-picture.php">Update Profile Picture</a></li>
            <li><a class="dropdown-item" href="../settings.php">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../">Home</a>
        </li>
      </ul>
    </div>
  </div>
</nav>