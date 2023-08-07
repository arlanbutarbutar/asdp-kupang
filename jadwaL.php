<?php require_once("controller/script.php");
$_SESSION["page-name"] = "Jadwal";
$_SESSION["page-url"] = "jadwal";
?>

<!DOCTYPE html>
<html>

<head>

  <?php require_once("resources/header.php"); ?>
  <style>
    .col-custom {
      position: relative;
    }

    .col-custom img {
      max-height: 300px;
      -webkit-filter: brightness(50%);
      width: 100%;
      object-fit: cover;
    }

    .container-custom {
      position: absolute;
      top: 60%;
      left: 15%;
      transform: translate(-50%, -50%);
      text-align: left;
      color: white;
      background-color: rgba(0, 0, 0, 0.7);
      padding: 20px;
      border-radius: 5px;
    }

    .container-custom h2 {
      font-size: 35px;
      margin-bottom: 10px;
    }

    .container-custom h4 {
      font-size: 30px;
      margin: 0;
    }

    @media screen and (max-width: 991px) {
      .col-custom img {
        height: 200px;
      }

      .container-custom {
        top: 50%;
        left: 50%;
        text-align: center;
      }

      .container-custom h2 {
        font-size: 24px;
      }

      .container-custom h4 {
        font-size: 18px;
      }
    }
  </style>

</head>

<body>

  <div class="hero_area">
    <?php require_once("resources/navbar.php"); ?>
  </div>

  <div class="col-lg-12 p-0 m-0 col-custom">
    <img src="assets/images/wb-merak.png" alt="...">
    <div class="container-custom">
      <h2>Jadwal</h2>
      <h4 style="color: #e6b81d;">ASDP Cabang Kupang</h4>
    </div>
  </div>

  <!-- about section -->
  <section class="about_section layout_padding">
    <div class="container  ">
      <div class="row">
        <div class="col-lg-12">
          <div class="card rounded-0 border-0 shadow">
            <div class="card-body table-responsive">
              <table class="table table-striped table-hover table-borderless table-sm display" id="datatable">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Nama Kapal</th>
                    <th scope="col" class="text-center">Pelabuhan Asal</th>
                    <th scope="col" class="text-center">Pelabuhan Tujuan</th>
                    <th scope="col" class="text-center">Tgl Berangkat</th>
                    <th scope="col" class="text-center">Jam Berangkat</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (mysqli_num_rows($front_jadwal) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($front_jadwal)) { ?>
                      <tr>
                        <th scope="row" class="text-center"><?= $no; ?></th>
                        <td><?= $row["nama_kapal"] ?></td>
                        <td><?= $row["pelabuhan_asal"] ?></td>
                        <td><?= $row["pelabuhan_tujuan"] ?></td>
                        <td class="text-center"><?php $tgl_berangkat = date_create($row["tanggal_berangkat"]);
                            echo date_format($tgl_berangkat, "d M Y"); ?></td>
                        <td class="text-center"><?= $row["jam_berangkat"] ?></td>
                      </tr>
                  <?php $no++;
                    }
                  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end about section -->

  <?php require_once("resources/footer.php"); ?>

</body>

</html>