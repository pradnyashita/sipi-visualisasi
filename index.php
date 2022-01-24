<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Document</title>
</head>
<body>

<?php 
  $con = new mysqli('localhost','root','','sistem_imunisasi');
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
          AND kabupaten.nama_kabupaten = 'Fakfak'
          AND antigen.id_antigen = 2
          AND MONTH(imunisasi.tanggal_pemberian) = 06
          AND YEAR(imunisasi.tanggal_pemberian) = 2012
      GROUP BY kampung.nama_kampung


  ");

  foreach($query as $data)
    {
      $kampung[] = $data['kampung'];
      $jumlah[] = $data['jumlah'];
      $jumlahP[] = $data['jumlahP'];
      $jumlahL[] = $data['jumlahL'];
      $target[] = $data['target'];
    }

?>



<div style="width: 500px;">
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  // === include 'setup' then 'config' above ===
  const labels = <?php echo json_encode($kampung) ?>;
  const data = {
    labels: labels,
    datasets: [{
      label: 'Laki-Laki',
      data: <?php echo json_encode($jumlahL) ?>,
      backgroundColor: 'rgba(68, 40, 181)',
      xAxisID: "bar-x-axis2",
      stack: "background"
    },{
      label: 'Perempuan',
      data: <?php echo json_encode($jumlahP) ?>,
      backgroundColor: 'rgba(181, 40, 71)',
      xAxisID: "bar-x-axis2",
      stack: "background"
    },{
      label: 'Target',
      data: <?php echo json_encode($target) ?>,
      backgroundColor: 'rgba(0,0,0,0.5)',
      xAxisID: "bar-x-axis1",
      fill: false
    }]
  };

  const config = {
    type: 'bar',
    data: data,
    options: {
      indexAxis: 'y',
      scales: {
        x: [{
          id: "bar-x-axis2",
          stacked: true,  
          categoryPercentage: 1,
          barPercentage: 1,
          offset: true
        },{
          id: "bar-x-axis1",
          display: false,
          stacked: true,
          type: 'category',
          categoryPercentage: 1,
          barPercentage: 1,
          gridLines: {
          offsetGridLines: true
        },
        // stacked: true,
        }],
        y: [{
            max: 100,
            min: 0,
            stacked: true
        }]
      }
      // ,
      // plugins: {
      //   datalabels: {
      //     anchor: 'center',
      //     align: 'end',
      //     offset: 10,
      //     color: '#ffff'
      //   }
      // },
      
    }
    // ,
    // plugins: [ChartDataLabels]
  };
  
  var myChart = new Chart(
    document.getElementById('myChart').getContext("2d"),
    config
  );
</script>

</body>
</html>