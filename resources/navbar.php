<!-- header section strats -->
<header class="header_section">
  <div class="header_top">
    <div class="container">
      <div class="contact_nav">
        <a href="">
          <i class="fa fa-phone" aria-hidden="true"></i>
          <span>
            Call Center : (0380) 890420
          </span>
        </a>
        <a href="">
          <i class="fa fa-envelope" aria-hidden="true"></i>
          <span>
            Email : cs@indonesiaferry.co.id
          </span>
        </a>
        <a href="https://www.google.com/maps/place/PT.+ASDP+Indonesia+Ferry+(Persero)+Cabang+Kupang/@-10.2199786,123.5153938,16z/data=!4m6!3m5!1s0x2c56997bcd1c7ad1:0xa1955cbf3fcd37d3!8m2!3d-10.2199781!4d123.5197239!16s%2Fg%2F11dxnq6wz_?authuser=0&entry=ttu" target="_blank">
          <i class="fa fa-map-marker" aria-hidden="true"></i>
          <span>
            Location
          </span>
        </a>
      </div>
    </div>
  </div>
  <div class="header_bottom">
    <div class="container-fluid shadow">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="" style="cursor: pointer;" onclick="window.location.href='<?= $baseURL ?>'">
          <img src="<?= $baseURL ?>assets/images/logo-asdp.png" alt="" style="width: 100px;">
        </a>


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""> </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="d-flex mr-auto flex-column flex-lg-row align-items-center">
            <ul class="navbar-nav  ">
              <li class="nav-item">
                <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='<?= $baseURL ?>'">Beranda</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='<?= $baseURL ?>tentang'">Tentang</a>
              </li>
              <div class="dropdown">
                <li class="nav-item">
                  <a class="nav-link dropdown-toggle" style="cursor: pointer;" data-toggle="dropdown" aria-expanded="false">Layanan</a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" style="cursor: pointer;" onclick="window.location.href='<?= $baseURL ?>lintasan'">Rute (Lintasan)</a>
                    <a class="dropdown-item" style="cursor: pointer;" onclick="window.location.href='<?= $baseURL ?>kapal'">Kapal</a>
                    <a class="dropdown-item" style="cursor: pointer;" onclick="window.location.href='<?= $baseURL ?>pelabuhan'">Pelabuhan</a>
                    <a class="dropdown-item" style="cursor: pointer;" onclick="window.location.href='<?= $baseURL ?>jadwal'">Jadwal</a>
                  </div>
                </li>
              </div>
              <li class="nav-item">
                <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='<?= $baseURL ?>galeri'">Galeri</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='<?= $baseURL ?>informasi'">Informasi</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='<?= $baseURL ?>kontak'">Kontak Kami</a>
              </li>
            </ul>
          </div>
          <div class="quote_btn-container">
            <?php if (!isset($_SESSION['data-user'])) { ?>
              <a class="text-white" style="cursor: pointer;" onclick="window.location.href='<?= $baseURL ?>auth/'">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>
                  Login
                </span>
              </a>
            <?php } else if (isset($_SESSION['data-user'])) { ?>
              <style>
                .dropdown-toggle::after {
                  display: none;
                }
              </style>
              <div class="dropdown">
                <button class="btn btn-link dropdown-toggle rounded-circle text-decoration-none" type="button" data-toggle="dropdown" aria-expanded="false">
                  <img src="assets/images/user.png" style="width: 40px;" alt="Icon Default User">
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item text-dark" style="cursor: pointer;font-size: 14px;" onclick="window.location.href='<?= $baseURL ?>views/profil'"><i class="fa fa-user" aria-hidden="true"></i> Profil saya</a>
                  <hr>
                  <a class="dropdown-item text-dark" style="cursor: pointer;font-size: 14px;" onclick="window.location.href='<?= $baseURL ?>views/'"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>
                  <a class="dropdown-item text-dark" style="cursor: pointer;font-size: 14px;" onclick="window.location.href='<?= $baseURL ?>views/tiket'"><i class="fa fa-ticket" aria-hidden="true"></i> Tiket</a>
                  <a class="dropdown-item text-dark" style="cursor: pointer;font-size: 14px;" onclick="window.location.href='<?= $baseURL ?>views/pembayaran'"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Pembayaran</a>
                  <hr>
                  <a class="dropdown-item text-dark" style="cursor: pointer;font-size: 14px;" onclick="window.location.href='<?= $baseURL ?>views/signout'"><i class="fa fa-sign-out" aria-hidden="true"></i> Keluar</a>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </nav>
    </div>
  </div>
</header>
<!-- end header section -->