<nav class="sidebar sidebar-offcanvas shadow" style="background-color: #d9dadf;" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='./'">
        <i class="mdi mdi-view-dashboard menu-icon" style="color: #0C7DC4;"></i>
        <span class="menu-title" style="color: #0C7DC4;">Dashboard</span>
      </a>
    </li>
    <?php if ($role == 1) { ?>
      <li class="nav-item nav-category" style="color: #08507D;">Kelola Pengguna</li>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='pengguna'">
          <i class="mdi mdi-account-multiple-outline menu-icon" style="color: #0C7DC4;"></i>
          <span class="menu-title" style="color: #0C7DC4;">Pengguna</span>
        </a>
      </li>
    <?php }
    if ($role <= 2) { ?>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='penumpang'">
          <i class="mdi mdi-account-multiple-outline menu-icon" style="color: #0C7DC4;"></i>
          <span class="menu-title" style="color: #0C7DC4;">Penumpang</span>
        </a>
      </li>
      <li class="nav-item nav-category" style="color: #08507D;">Data ASDP</li>
      <?php if ($role == 1) { ?>
        <li class="nav-item">
          <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='account-bank'">
            <i class="mdi mdi-cash menu-icon" style="color: #0C7DC4;"></i>
            <span class="menu-title" style="color: #0C7DC4;">Account Bank</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='kelas'">
            <i class="mdi mdi-format-list-bulleted menu-icon" style="color: #0C7DC4;"></i>
            <span class="menu-title" style="color: #0C7DC4;">Kelas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='golongan'">
            <i class="mdi mdi-format-list-bulleted menu-icon" style="color: #0C7DC4;"></i>
            <span class="menu-title" style="color: #0C7DC4;">Golongan</span>
          </a>
        </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='kapal'">
          <i class="mdi mdi-ferry menu-icon" style="color: #0C7DC4;"></i>
          <span class="menu-title" style="color: #0C7DC4;">Kapal</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='pelabuhan'">
          <i class="mdi mdi-anchor menu-icon" style="color: #0C7DC4;"></i>
          <span class="menu-title" style="color: #0C7DC4;">Pelabuhan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='rute'">
          <i class="mdi mdi-map-marker-radius menu-icon" style="color: #0C7DC4;"></i>
          <span class="menu-title" style="color: #0C7DC4;">Rute</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='jadwal'">
          <i class="mdi mdi-format-list-bulleted menu-icon" style="color: #0C7DC4;"></i>
          <span class="menu-title" style="color: #0C7DC4;">Jadwal</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='informasi'">
          <i class="mdi mdi-information-outline menu-icon" style="color: #0C7DC4;"></i>
          <span class="menu-title" style="color: #0C7DC4;">Informasi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='galeri'">
          <i class="mdi mdi-image-album menu-icon" style="color: #0C7DC4;"></i>
          <span class="menu-title" style="color: #0C7DC4;">Galeri</span>
        </a>
      </li>
    <?php } ?>
    <li class="nav-item nav-category" style="color: #08507D;">Data Pemesanan</li>
    <?php if ($role == 3) { ?>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='../index#pemesanan'">
          <i class="mdi mdi-ferry menu-icon" style="color: #0C7DC4;"></i>
          <span class="menu-title" style="color: #0C7DC4;">Pelayaran</span>
        </a>
      </li>
    <?php } ?>
    <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='pemesanan'">
        <i class="mdi mdi-ferry menu-icon" style="color: #0C7DC4;"></i>
        <span class="menu-title" style="color: #0C7DC4;">Pemesanan</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='pembayaran'">
        <i class="mdi mdi-cash-multiple menu-icon" style="color: #0C7DC4;"></i>
        <span class="menu-title" style="color: #0C7DC4;">Pembayaran</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='tiket'">
        <i class="mdi mdi-ticket menu-icon" style="color: #0C7DC4;"></i>
        <span class="menu-title" style="color: #0C7DC4;">Tiket</span>
      </a>
    </li>
    <?php if ($role <= 2) { ?>
      <!-- <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='laporan'">
          <i class="mdi mdi-cash-multiple menu-icon" style="color: #0C7DC4;"></i>
          <span class="menu-title" style="color: #0C7DC4;">Laporan</span>
        </a>
      </li> -->
    <?php } ?>
    <li class="nav-item nav-category" style="color: #08507D;"></li>
    <!-- <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='icons'">
        <i class="mdi mdi-face-profile menu-icon" style="color: #0C7DC4;"></i>
        <span class="menu-title" style="color: #0C7DC4;">Icons</span>
      </a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='../auth/signout'">
        <i class="mdi mdi-logout-variant menu-icon" style="color: #0C7DC4;"></i>
        <span class="menu-title" style="color: #0C7DC4;">Keluar</span>
      </a>
    </li>
  </ul>
</nav>