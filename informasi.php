<?php require_once("controller/script.php");
$_SESSION["page-name"] = "Informasi";
$_SESSION["page-url"] = "informasi";
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

    .card {
      transform: none;
      transition: 0.25s ease-in-out;
    }

    .card img {
      height: 200px;
      object-fit: cover;
    }

    .card:hover {
      transform: scale(1.1);
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
      <h2>Informasi</h2>
      <h4 style="color: #e6b81d;">ASDP Cabang Kupang</h4>
    </div>
  </div>

  <!-- about section -->
  <section class="about_section layout_padding">
    <div class="container  ">
      <div class="row">
        <?php if (mysqli_num_rows($front_informasi) > 0) {
          while ($row = mysqli_fetch_assoc($front_informasi)) { ?>
            <div class="col-lg-10 mt-4">
              <div class="card border-0 rounded-0 shadow">
                <div class="card-body">
                  <blockquote class="blockquote mb-0">
                    <?= $row['informasi'] ?>
                    <footer class="blockquote-footer">Informasi tanggal <cite title="Source Title"><?php $tgl = date_create($row["tgl_informasi"]);
                                                                                                    echo date_format($tgl, "l, d M Y h:i a"); ?></cite></footer>
                  </blockquote>
                </div>
              </div>
            </div>
        <?php }
        } ?>
      </div>
    </div>
  </section>
  <!-- end about section -->

  <?php require_once("resources/footer.php"); ?>

</body>

</html>