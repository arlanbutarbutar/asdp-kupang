<?php require_once("../controller/script.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  .card-custom,
  .card-custom h4 {
    cursor: pointer;
    color: #000;
    transform: none;
    transition: 0.25s ease-in-out;
  }

  .card-custom:hover {
    transform: scale(1.1);
  }

  .card-custom h4:hover {
    color: #0C7DC4;
  }
</style>

<?php if ($role <= 2) { ?>
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-lg-3">
          <div class="card card-custom rounded-0 border-0 shadow mt-3">
            <div class="card-body">
              <h3>Pengguna</h3>
              <h4 class="mt-3 mb-1" onclick="window.location.href='pengguna'"><i class="mdi mdi-account-multiple-outline" style="font-size: 20px;"></i> Pengguna <?= $countPengelola ?></h4>
              <h4 class="mt-3 mb-1" onclick="window.location.href='penumpang'"><i class="mdi mdi-account-multiple-outline" style="font-size: 20px;"></i> Penumpang <?= $countPenumpang ?></h4>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card card-custom rounded-0 border-0 shadow mt-3" onclick="window.location.href='kapal'">
            <div class="card-body">
              <h3>Kapal</h3>
              <h1 class="mt-3 mb-3"><i class="mdi mdi-ferry" style="font-size: 35px;"></i> <?= $countKapal ?></h1>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card card-custom rounded-0 border-0 shadow mt-3" onclick="window.location.href='pemesanan'">
            <div class="card-body">
              <h3>Pemesanan</h3>
              <h1 class="mt-3 mb-3"><i class="mdi mdi-ferry" style="font-size: 35px;"></i> <?= $countPemesanan ?></h1>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card card-custom rounded-0 border-0 shadow mt-3" onclick="window.location.href='tiket'">
            <div class="card-body">
              <h3>Tiket</h3>
              <h1 class="mt-3 mb-3"><i class="mdi mdi-ticket" style="font-size: 35px;"></i> <?= $countTiket ?></h1>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="row flex-row-reverse">
        <div class="col-lg-8">
          <div class="card rounded-0 border-0 shadow mt-3">
            <div class="card-header">
              <div class="card-title">
                <h4 style="margin-top: 15px;">Grafik Penumpang</h4>
              </div>
            </div>
            <div class="card-body">
              <div style="width: 100%; margin: auto;">
                <canvas id="birthChart"></canvas>
              </div>

              <script>
                // Fungsi untuk mengambil data dari PHP menggunakan Fetch API
                function getData() {
                  return fetch('grafik-penumpang.php')
                    .then(response => response.json())
                    .then(data => {
                      return data;
                    });
                }

                // Fungsi untuk mengubah data menjadi format yang sesuai untuk Chart.js
                function prepareChartData(data) {
                  const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                  const genders = [...new Set(data.map(item => item.gender))];

                  const datasets = genders.map(gender => {
                    const values = months.map((month, index) => {
                      const found = data.find(item => item.gender === gender && item.bulan === index + 1);
                      return found ? found.total : 0;
                    });

                    return {
                      label: gender,
                      data: values,
                      backgroundColor: gender === 'Laki-Laki' ? 'rgba(54, 162, 235, 0.2)' : 'rgba(255, 99, 132, 0.2)',
                      borderColor: gender === 'Perempuan' ? 'rgba(54, 162, 235, 1)' : 'rgba(255, 99, 132, 1)',
                      borderWidth: 1,
                    };
                  });

                  return {
                    labels: months,
                    datasets: datasets,
                  };
                }

                // Fungsi untuk membuat chart dengan data yang diberikan
                function createChart(data) {
                  const ctx = document.getElementById('birthChart').getContext('2d');
                  const birthChart = new Chart(ctx, {
                    type: 'line',
                    data: prepareChartData(data),
                    options: {
                      scales: {
                        yAxes: [{
                          ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                              if (Math.floor(value) === value) {
                                return value;
                              }
                            }
                          }
                        }]
                      }
                    }
                  });
                }

                // Panggil fungsi getData untuk mengambil data dari PHP
                getData().then(data => {
                  createChart(data);
                });
              </script>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card rounded-0 border-0 shadow mt-3">
            <div class="card-body">
              <canvas id="pieChartPelayaran" width="400" height="400"></canvas>
              <?php

              // Fungsi untuk mengambil data jumlah penumpang dari database
              function getDataFromDB()
              {
                global $conn;
                $sql = 'SELECT kapal.nama_kapal, COUNT(*) AS total FROM pelayaran JOIN jadwal ON pelayaran.id_jadwal=jadwal.id_jadwal JOIN kapal ON jadwal.id_kapal=kapal.id_kapal JOIN tiket ON pelayaran.id_pelayaran=tiket.id_pelayaran JOIN penumpang ON tiket.id_penumpang=penumpang.id_penumpang GROUP BY kapal.nama_kapal';
                $result = mysqli_query($conn, $sql);

                $data = array();
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = array(
                      'nama_kapal' => $row['nama_kapal'],
                      'jumlah_penumpang' => (int)$row['total']
                    );
                  }
                }

                mysqli_close($conn);
                return $data;
              }

              $data = getDataFromDB();
              ?>

              <!-- <script>
                // Data jumlah penumpang dari PHP
                var data = <?php echo json_encode(array_column($data, 'jumlah_penumpang')); ?>;
                // Nama kapal dari PHP
                var labels = <?php echo json_encode(array_column($data, 'nama_kapal')); ?>;

                // Membuat chart pie
                var ctx = document.getElementById('pieChartPelayaran').getContext('2d');
                var pieChartPelayaran = new Chart(ctx, {
                  type: 'pie',
                  data: {
                    labels: labels,
                    datasets: [{
                      data: data,
                      backgroundColor: getDynamicColors(data.length), // Fungsi untuk warna dinamis
                      borderColor: 'rgba(255, 255, 255, 1)',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    title: {
                      display: true,
                      text: 'Jumlah Penumpang Berdasarkan Pelayaran Kapal'
                    }
                  }
                });

                // Fungsi untuk menghasilkan warna dinamis berdasarkan jumlah data kapal
                function getDynamicColors(length) {
                  var colors = [];
                  for (var i = 0; i < length; i++) {
                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);
                    colors.push('rgba(' + r + ', ' + g + ', ' + b + ', 0.8)');
                  }
                  return colors;
                }
              </script> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }
if ($role == 3) { ?>
  <div class="row">
    <div class="col-md-12">
      <?php if (mysqli_num_rows($view_overview) > 0) {
        while ($row_overview = mysqli_fetch_assoc($view_overview)) { ?>
          <div class="card mb-3 mt-3 rounded-0 border-0 shadow">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="../assets/images/qrcode/<?= $row_overview['qr_code'] ?>" style="width: 100%;height: 100%;" class="img-fluid rounded-start rounded-0" alt="...">
              </div>
              <div class="col-md-8 my-auto">
                <div class="card-body" style="text-align: left;">
                  <h1 class="card-title"><?= $row_overview['nama_kapal'] ?></h1>
                  <div class="row">
                    <div class="col-lg-6">
                      <p class="card-text">Kapal: <strong><?= $row_overview['nama_kapal'] . " " . $row_overview['jenis_kapal'] ?></strong></p>
                      <p class="card-text">Penumpang: <strong><?= $row_overview['nama'] ?></strong></p>
                      <p class="card-text">Kelas: <strong><?= $row_overview['nama_kelas'] ?></strong></p>
                      <p class="card-text">Golongan: <strong><?= $row_overview['nama_golongan'] ?></strong></p>
                    </div>
                    <div class="col-lg-6">
                      <p class="card-text">Cabang: <strong><?= $row_overview['cabang'] ?></strong></p>
                      <p class="card-text">Linsatan: <strong><?= $row_overview['pelabuhan_asal'] . ' - ' . $row_overview['pelabuhan_tujuan'] ?></strong></p>
                      <p class="card-text">Jarak: <strong><?= $row_overview['jarak'] ?> km</strong></p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-lg-12">
                      <p class="card-text mb-3">Tgl berangkat <strong><?php $tgl_berangkat = date_create($row_overview["tanggal_berangkat"]);
                                                                      echo date_format($tgl_berangkat, "d M Y") . " - " . $row_overview['jam_berangkat']; ?></strong></p>
                      <span class="badge bg-warning text-dark rounded-1 font-weight-bold">Perhatian!!</span>
                      <textarea class="form-control border-0 rounded-0 p-0 bg-transparent mt-2" style="height: 100px;line-height: 20px;" readonly>Mohon perhatikan tanggal keberangkatan dan tunjukan QR Code kepada petugas untuk bisa masuk ke kapal.</textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      <?php }
      } ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-lg-6">
          <div class="card card-custom rounded-0 border-0 shadow mt-3" onclick="window.location.href='tiket'">
            <div class="card-body">
              <h3>Tiket</h3>
              <h1 class="mt-3 mb-3"><i class="mdi mdi-ticket" style="font-size: 35px;"></i> <?= $countTiket ?></h1>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card card-custom rounded-0 border-0 shadow mt-3" onclick="window.location.href='pembayaran'">
            <div class="card-body">
              <h3>Pembayaran</h3>
              <h1 class="mt-3 mb-3"><i class="mdi mdi-cash-multiple" style="font-size: 35px;"></i> <?= $countPembayaran ?></h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<script src="../assets/datatable/datatables.js"></script>
<script>
  $(document).ready(function() {
    $("#datatable").DataTable();
  });
</script>
<script>
  (function() {
    function scrollH(e) {
      e.preventDefault();
      e = window.event || e;
      let delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));
      document.querySelector(".table-responsive").scrollLeft -= (delta * 40);
    }
    if (document.querySelector(".table-responsive").addEventListener) {
      document.querySelector(".table-responsive").addEventListener("mousewheel", scrollH, false);
      document.querySelector(".table-responsive").addEventListener("DOMMouseScroll", scrollH, false);
    }
  })();
</script>