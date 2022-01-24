<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
  <title>Document</title>
</head>
<body onresize="shiftBarColumns()">

<?php 
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
                AND kabupaten.nama_kabupaten = 'fakfak'
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
?>



<div style="width: 500px;">
  <canvas id="myChart"></canvas>
</div>


<script>
var data = {
  labels: <?php echo json_encode($kampung) ?>,
  datasets: [{
    label: "Perempuan",
    backgroundColor: 'rgba(217, 108, 159)',
    borderWidth: 1,
    data: <?php echo json_encode($jumlahP) ?>,
    xAxisID: "bar-x-axis1",
    yAxisID: "bar-y-axis1",
  }, {
    label: "Laki-Laki",
    backgroundColor: 'rgba(96, 163, 214)',
    borderWidth: 1,
    data: <?php echo json_encode($jumlahL) ?>,
    xAxisID: "bar-x-axis1", 
    yAxisID: "bar-y-axis1",
}, {  
    label: "Target",
    backgroundColor: 'rgba(255, 206, 86, 0.2)',
    borderWidth: 1,
    data: <?php echo json_encode($target) ?>,
    xAxisID: "bar-x-axis2",
    yAxisID: "bar-y-axis2",
  }]
};

var options = {
    indexAxis: 'y',
  scales: {
    xAxes: [{
        categoryPercentage: 1,
        barPercentage: 1,
        offset: true,
        stacked: true,
        id: "bar-x-axis1",
        barThickness: 20,
    }, { 
      display: false,
      stacked: true,
      id: "bar-x-axis2",
      barThickness: 35,
      // these are needed because the bar controller defaults set only the first x axis properties
      type: 'category',
      categoryPercentage: 0.8,
      barPercentage: 0.9,
      gridLines: {
        offsetGridLines: true
      },
      offset: true
    }],
    yAxes: [{
      id: "bar-y-axis1",
      stacked: true,
      ticks: {
        beginAtZero: true
      }
    },{
      id: "bar-y-axis2",
      stacked: false,
      ticks: {
        beginAtZero: true


      }
    }]

  }
};

var ctx = document.getElementById("myChart").getContext("2d");
var myBarChart = new Chart(ctx, {
  type: 'bar',
  data: data,
  options: options
});

function shiftBarColumns(){
    console.log(window.innerWidth);
    console.log(window.outerWidth)
}
</script>

</body>
</html>
