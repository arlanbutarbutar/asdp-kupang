<?php require_once("controller/script.php");
$_SESSION["page-name"] = "Kontak";
$_SESSION["page-url"] = "kontak";
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
      <h2>Kontak Kami</h2>
      <h4 style="color: #e6b81d;">ASDP Cabang Kupang</h4>
    </div>
  </div>

  <!-- about section -->
  <section class="about_section layout_padding">
    <div class="container  ">
      <div class="row">
        <div class="col-lg-6 mt-4">
          <div class="card border-0 rounded-0 shadow">
            <div class="card-header">
              <div class="card-title">
                <h4>Kontak Kami</h4>
              </div>
            </div>
            <div class="card-body">
              <a href="mailto:cs@indonesiaferry.co.id" target="_blank">
                <i class="fa fa-envelope-o" aria-hidden="true"></i> cs@indonesiaferry.co.id
              </a><br>
              <a href="tel:082340958883" target="_blank">
                <i class="fa fa-whatsapp" aria-hidden="true"></i> 082340958883
              </a><br>
              <a href="https://maps.google.com/?q=Kantor Pusat : Jl. Jend. Ahmad Yani Kav. 52 A, Cempaka Putih Timur,Kota Jakarta Pusat,10510, Indonesia" target="_blank">
                <i class="fa fa-map" aria-hidden="true"></i> Kantor Pusat : Jl. Jend. Ahmad Yani Kav. 52 A, Cempaka Putih Timur,Kota Jakarta Pusat,10510, Indonesia
              </a><br>
              <a href="https://www.google.com/maps/place/PT.+ASDP+Indonesia+Ferry+(Persero)+Cabang+Kupang/@-10.2190785,123.5157243,16z/data=!4m6!3m5!1s0x2c56997bcd1c7ad1:0xa1955cbf3fcd37d3!8m2!3d-10.2199781!4d123.5197239!16s%2Fg%2F11dxnq6wz_?authuser=0&entry=ttu" target="_blank">
                <i class="fa fa-map" aria-hidden="true"></i> Kantor Cabang Kupang : Bolok, Kec. Kupang Barat, Kabupaten Kupang, Nusa Tenggara Timur
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mt-4">
          <div class="card border-0 rounded-0 shadow">
            <div class="card-body">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1959.8972805111694!2d123.51850365380827!3d-10.219592398865618!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c56997bcd1c7ad1%3A0xa1955cbf3fcd37d3!2sPT.%20ASDP%20Indonesia%20Ferry%20(Persero)%20Cabang%20Kupang!5e0!3m2!1sid!2sid!4v1691261313581!5m2!1sid!2sid" width="520" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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