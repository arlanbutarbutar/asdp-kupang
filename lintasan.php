<?php require_once("controller/script.php");
$_SESSION["page-name"] = "Lintasan";
$_SESSION["page-url"] = "lintasan";
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
      <h2>Kapal</h2>
      <h4 style="color: #e6b81d;">ASDP Cabang Kupang</h4>
    </div>
  </div>

  <!-- about section -->
  <section class="about_section layout_padding">
    <div class="container  ">
      <div class="row">
        <div class="col-lg-12">

          <div class="card rounded-0 mt-3">
            <div class="card-body table-responsive">
              <table class="table table-striped table-hover table-borderless table-sm display" id="datatable">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Cabang</th>
                    <th scope="col" class="text-center">Lintasan</th>
                    <th scope="col" class="text-center">Jarak</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (mysqli_num_rows($front_lintasan) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($front_lintasan)) { ?>
                      <tr>
                        <th scope="row" class="text-center"><?= $no; ?></th>
                        <td class="text-center"><?= $row["cabang"] ?></td>
                        <td class="text-center">
                          <?php
                          $cabang = $row['cabang'];
                          $rute_lintasan = "SELECT * FROM rute WHERE cabang='$cabang'";
                          $view_rute_lintasan = mysqli_query($conn, $rute_lintasan);
                          while ($row_rl = mysqli_fetch_assoc($view_rute_lintasan)) {
                            echo $row_rl["pelabuhan_asal"] . ' - ' . $row_rl["pelabuhan_tujuan"] . '<br>';
                          }
                          ?>
                        </td>
                        <td class="text-center"><?= $row["jarak"] ?> km</td>
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