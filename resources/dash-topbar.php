<style>
  .navbar .navbar-brand-wrapper {
    background-color: #d9dadf;
  }

  .navbar-toggler {
    display: none;
  }

  @media screen and (max-width: 991px) {
    .img-brand {
      display: none;
    }

    .navbar-toggler {
      display: block;
    }

    .content-wrapper {
      margin-top: -30px;
    }

    .navbar .navbar-brand-wrapper {
      height: 65px;
      padding: 0;
      background-color: #d9dadf;
    }

    .sidebar {
      margin-top: -30px;
    }
  }
</style>
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
  <div class="navbar-custom navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
        <span class="mdi mdi-menu" style="color: #0C7DC4;"></span>
      </button>
    </div>
    <div>
      <a class="navbar-brand brand-logo d-flex" href="./">
        <img src="../assets/images/logo-asdp.png" alt="Logo Brand" class="img-brand" style="width: 150px;height: 90px;">
      </a>
      <a class="nav-link navbar-brand brand-logo-mini" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
        <img class="img-xs rounded-circle" src="../assets/images/user.png" style="width: 40px;height: 40px;" alt="Profile image" />
      </a>
      <div class="dropdown-menu dropdown-menu-right navbar-dropdown p-4" style="width: 250px;" aria-labelledby="UserDropdown">
        <div class="dropdown-header text-center">
          <img class="img-md rounded-circle" src="../assets/images/user.png" style="width: 50px;" alt="Profile image">
          <p class="mb-1 mt-3 font-weight-semibold"><?= $_SESSION["data-user"]["username"] ?><br><?= $_SESSION["data-user"]["email"] ?></p>
        </div>
        <a style="cursor: pointer;" onclick="window.location.href='profil'" class="dropdown-item pb-3">
          <i class="bi bi-person me-2"></i> Profil Saya</a>
        <a style="cursor: pointer;" onclick="window.location.href='../auth/signout'" class="dropdown-item border-bottom-0">
          <i class="bi bi-box-arrow-right me-2"></i> Keluar</a>
      </div>
    </div>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-top shadow">
    <ul class="navbar-nav">
      <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
        <h1 class="welcome-text">Selamat datang, <span class="text-black fw-bold"><?= $_SESSION["data-user"]["username"] ?></span></h1>
        <p class="">
          <i class="mdi mdi-subdirectory-arrow-right"></i>
          <a href="./" class="text-decoration-none text-dark">Dashboard</a>
          <?php if ($_SESSION["page-name"] != "Dashboard") {
            echo " / " . $_SESSION["page-name"];
          } ?>
        </p>
      </li>
    </ul>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown d-none d-lg-block user-dropdown">
        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <img class="img-xs rounded-circle" src="../assets/images/user.png" alt="Profile image">
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown p-0" style="width: 250px;" aria-labelledby="UserDropdown">
          <div class="dropdown-header text-center">
            <img class="img-md rounded-circle" src="../assets/images/user.png" style="width: 50px;" alt="Profile image">
            <p class="mb-1 mt-3 font-weight-semibold"><?= $_SESSION["data-user"]["username"] ?></p>
            <p class="mb-1 mt-3 font-weight-semibold" style="overflow-x: auto;"><?= $_SESSION["data-user"]["email"] ?></p>
          </div>
          <a style="cursor: pointer;" onclick="window.location.href='profil'" class="dropdown-item p-3">
            <i class="bi bi-person text-primary me-2"></i> Profil Saya</a>
          <a style="cursor: pointer;" onclick="window.location.href='../auth/signout'" class="dropdown-item border-bottom-0 p-3">
            <i class="bi bi-box-arrow-right text-primary me-2"></i> Keluar</a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>