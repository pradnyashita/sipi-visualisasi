<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <title>Document</title>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <label for="">Kabupaten</label>
  <input type="text" name="kabupaten">
  <button type="submit" name="submit">Ok</button>
</form>

<?php 
if (isset($_POST['submit'])) {
    $kabupaten = $_POST['kabupaten'];
    echo $kabupaten;
    
    $con = new mysqli('localhost', 'root', '', 'sistem_imunisasi');
    $query = $con->query("
  SELECT kampung.nama_kampung as kampung, COUNT(imunisasi.status) as jumlah, SUM(data_individu.jenis_kelamin = 'P') as jumlahP, SUM(data_individu.jenis_kelamin = 'L') as jumlahL, ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0) as target
  FROM imunisasi
        JOIN data_individu ON imunisasi.id_anak = data_individu.id_anak 
        JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
        JOIN posyandu ON posyandu.id_posyandu = data_individu.id_posyandu
        JOIN kampung ON kampung.id_kampung = data_individu.id_kampung
        JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
      WHERE imunisasi.status = 'sudah' 
          AND kabupaten.nama_kabupaten = '$kabupaten'
          AND antigen.id_antigen = 2
          AND MONTH(imunisasi.tanggal_pemberian) = 06
          AND YEAR(imunisasi.tanggal_pemberian) = 2012
      GROUP BY kampung.nama_kampung


  ");

    foreach ($query as $data) {
        $kampung[] = $data['kampung'];
        $jumlah[] = $data['jumlah'];
        $jumlahP[] = $data['jumlahP'];
        $jumlahL[] = $data['jumlahL'];
        $target[] = $data['target'];
    }
}
?>



<div>
    <canvas id="chart" width="500" height="300"></canvas>
</div>
<br>
<div>
    <canvas id="chart" width="500" height="300"></canvas>
</div>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

<script>
const actualData = <?php echo json_encode($jumlahL) ?>;
const targetData = <?php echo json_encode($target) ?>;

new Chart("chart", {
  type: "bar",
  data: {
    labels: <?php echo json_encode($kampung) ?>,
    datasets: [{
        label: "Actual",
        backgroundColor: 'rgba(0, 0, 255, 0.2)',
        data: actualData,
        xAxisID: "x-axis-actual"
      },
      {
        label: "Target",
        backgroundColor: 'rgba(255, 0, 128, 1)',
        data: targetData.map(v => [v - 1, v + 1]),
        xAxisID: "x-axis-target"
      }
    ]
  },
  options: {
    tooltips: {
      callbacks: {
        label: (tooltipItem, data) => {
          const v = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
          return Array.isArray(v) ? (v[1] + v[0]) / 2 : v;
        }
      }
    },
    scales: {
      xAxes: [{
          id: "x-axis-target",
          stacked: true
        },
        {
          display: false,
          offset: true,
          stacked: true,
          id: "x-axis-actual",
          gridLines: {
            offsetGridLines: true
          }
        }
      ],
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});
</script>

</body>
</html>
