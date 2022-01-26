<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
  <title>Ini punya sapa</title>
</head>
<body onresize="shiftBarColumns()">

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<ul>
  <li>
    <label for="kabupaten">Kabupaten</label>
    <input type="text" id="kabupaten" name="kabupatenform">
  </li>
  <li>
    <label for="tahun">Tahun</label>
    <input type="text" id="tahun" name="tahunform">
  </li>
  <li>
    <button type="submit" name="submit">OK</button>
  </li>
</ul>
  
</form>

<?php 
if (isset($_POST['submit'])) {
    $kabupatenForm = $_POST['kabupatenform'];
    $tahunForm = $_POST['tahunform'];

    $con = new mysqli("108.136.175.182","root","sipi","sistem_imunisasi");

    $query = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          SUM(CASE WHEN data_individu.irl = 1 AND YEAR(data_individu.tanggal_irl) = $tahunForm THEN 1 ELSE 0 END) as irl
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY puskesmas.id_puskesmas
        ORDER BY puskesmas.id_puskesmas
    ");

    foreach ($query as $data) {
        $kabupaten[] = $data['kabupaten'];
        $puskesmas[] = $data['puskesmas'];
        $irl[] = $data['irl'];
    }

    $query1 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          SUM(CASE WHEN data_individu.irl = 1 AND (MONTH(data_individu.tanggal_irl) = 01 OR MONTH(data_individu.tanggal_irl) = 02 OR MONTH(data_individu.tanggal_irl) = 03) AND YEAR(data_individu.tanggal_irl) = $tahunForm THEN 1 ELSE 0 END) as irl
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY puskesmas.id_puskesmas
        ORDER BY puskesmas.id_puskesmas
    ");

    foreach ($query1 as $data1) {
      $kabupaten1[] = $data1['kabupaten'];
      $puskesmas1[] = $data1['puskesmas'];
      $irl1[] = $data1['irl'];
    }

    $query2 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          SUM(CASE WHEN data_individu.irl = 1 AND (MONTH(data_individu.tanggal_irl) = 01 OR MONTH(data_individu.tanggal_irl) = 02 OR MONTH(data_individu.tanggal_irl) = 03 OR MONTH(data_individu.tanggal_irl) = 04 OR MONTH(data_individu.tanggal_irl) = 05 OR MONTH(data_individu.tanggal_irl) = 06) AND YEAR(data_individu.tanggal_irl) = $tahunForm THEN 1 ELSE 0 END) as irl
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY puskesmas.id_puskesmas
        ORDER BY puskesmas.id_puskesmas
    ");

    foreach ($query2 as $data2) {
      $kabupaten2[] = $data2['kabupaten'];
      $puskesmas2[] = $data2['puskesmas'];
      $irl2[] = $data2['irl'];
    }

    $query3 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          SUM(CASE WHEN data_individu.irl = 1 AND (MONTH(data_individu.tanggal_irl) = 01 OR MONTH(data_individu.tanggal_irl) = 02 OR MONTH(data_individu.tanggal_irl) = 03 OR MONTH(data_individu.tanggal_irl) = 04 OR MONTH(data_individu.tanggal_irl) = 05 OR MONTH(data_individu.tanggal_irl) = 06 OR MONTH(data_individu.tanggal_irl) = 07 OR MONTH(data_individu.tanggal_irl) = 08 OR MONTH(data_individu.tanggal_irl) = 09) AND YEAR(data_individu.tanggal_irl) = $tahunForm THEN 1 ELSE 0 END) as irl
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY puskesmas.id_puskesmas
        ORDER BY puskesmas.id_puskesmas
    ");

    foreach ($query3 as $data3) {
      $kabupaten3[] = $data3['kabupaten'];
      $puskesmas3[] = $data3['puskesmas'];
      $irl3[] = $data3['irl'];
    }

    $query4 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          SUM(CASE WHEN data_individu.irl = 1 AND YEAR(data_individu.tanggal_irl) = $tahunForm THEN 1 ELSE 0 END) as irl
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY puskesmas.id_puskesmas
        ORDER BY puskesmas.id_puskesmas
    ");

    foreach ($query4 as $data4) {
        $kabupaten4[] = $data4['kabupaten'];
        $puskesmas4[] = $data4['puskesmas'];
        $irl4[] = $data4['irl'];
    }

}
?>



<!-- INI PAGE NYA--------------------------------------------------------------------------------------------------- -->

<div style="height: 500px;">
  <canvas id="myChart"></canvas>
</div>

<br>
<br>

<div id="myHTMLWrapper">
</div>


<!-- SAMPAI SINI PAGE NYA-------------------------------------------------------------------------------------------- -->

<script>
  var wrapper = document.getElementById("myHTMLWrapper");

  var myHTML = '';

  for (var i = 0; i < 4; i++) {
    myHTML += '<div style="height: 500px;"><canvas id="myChart' + (i + 1) + '"></canvas><br><br></div>';
  }

  wrapper.innerHTML = myHTML

</script>


<script>
      var data = {
        labels: <?php echo json_encode($puskesmas) ?>,
        datasets: [{
          label: "Imunisasi Rutin Lengkap (IRL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($irl) ?>,
        }]
      };

      var options = {
        scales: {
          xAxes: [{
            ticks: {
                      autoSkip: false,
                      maxRotation: 90,
                      minRotation: 90,
            }
          }],
          yAxes: [{
            stacked: false,
            ticks: {
              beginAtZero: true,
              userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
            },
          }]

        },
        title: {
            display: true,
            text: 'Total Sasaran dan IRL Tahunan Tiap Puskesmas',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
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


<script>
      var data = {
        labels: <?php echo json_encode($puskesmas1) ?>,
        datasets: [{
          label: "Imunisasi Rutin Lengkap (IRL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($irl1) ?>,
        }]
      };

      var options = {
        scales: {
          xAxes: [{
            ticks: {
                      autoSkip: false,
                      maxRotation: 90,
                      minRotation: 90,
            }
          }],
          yAxes: [{
            stacked: false,
            ticks: {
              beginAtZero: true,
              userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
            },
          }]

        },
        title: {
            display: true,
            text: 'Akumulasi IRL Quarter 1 Tiap Puskesmas',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
      };

      var ctx = document.getElementById("myChart1").getContext("2d");
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


<script>
      var data = {
        labels: <?php echo json_encode($puskesmas2) ?>,
        datasets: [{
          label: "Imunisasi Rutin Lengkap (IRL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($irl2) ?>,
        }]
      };

      var options = {
        scales: {
          xAxes: [{
            ticks: {
                      autoSkip: false,
                      maxRotation: 90,
                      minRotation: 90,
            }
          }],
          yAxes: [{
            stacked: false,
            ticks: {
              beginAtZero: true,
              userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
            },
          }]

        },
        title: {
            display: true,
            text: 'Akumulasi IRL Quarter 2 Tiap Puskesmas',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
      };

      var ctx = document.getElementById("myChart2").getContext("2d");
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


<script>
      var data = {
        labels: <?php echo json_encode($puskesmas3) ?>,
        datasets: [{
          label: "Imunisasi Rutin Lengkap (IRL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($irl3) ?>,
        }]
      };

      var options = {
        scales: {
          xAxes: [{
            ticks: {
                      autoSkip: false,
                      maxRotation: 90,
                      minRotation: 90,
            }
          }],
          yAxes: [{
            stacked: false,
            ticks: {
              beginAtZero: true,
              userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
            },
          }]

        },
        title: {
            display: true,
            text: 'Akumulasi IRL Quarter 3 Tiap Puskesmas',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
      };

      var ctx = document.getElementById("myChart3").getContext("2d");
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


<script>
      var data = {
        labels: <?php echo json_encode($puskesmas4) ?>,
        datasets: [{
          label: "Imunisasi Rutin Lengkap (IRL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($irl4) ?>,
        }]
      };

      var options = {
        scales: {
          xAxes: [{
            ticks: {
                      autoSkip: false,
                      maxRotation: 90,
                      minRotation: 90,
            }
          }],
          yAxes: [{
            stacked: false,
            ticks: {
              beginAtZero: true,
              userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
            },
          }]

        },
        title: {
            display: true,
            text: 'Akumulasi IRL Quarter 4 Tiap Puskesmas',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
      };

      var ctx = document.getElementById("myChart4").getContext("2d");
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