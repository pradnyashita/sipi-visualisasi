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
    <label for="puskesmas">Puskesmas</label>
    <input type="text" id="puskesmas" name="puskesmasform">
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
    $puskesmasForm = $_POST['puskesmasform'];
    $tahunForm = $_POST['tahunform'];

    $con = new mysqli("108.136.175.182","root","sipi","sistem_imunisasi");

    $query = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung,
          ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kampung.wus_tidak_hamil+kampung.wus_hamil)*100) as t1_total,
          ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kampung.wus_hamil)*100) as t1_hamil,
          ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kampung.wus_tidak_hamil)*100) as t1_tidak_hamil
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
          AND puskesmas.id_puskesmas = $puskesmasForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
    ");

    foreach ($query as $data) {
        $kabupaten[] = $data['kabupaten'];
        $puskesmas[] = $data['puskesmas'];
        $kampung[] = $data['kampung'];
        $t1_total[] = $data['t1_total'];
        $t1_hamil[] = $data['t1_hamil'];
        $t1_tidak_hamil[] = $data['t1_tidak_hamil'];
    }

    $query1 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung,
          ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kampung.wus_tidak_hamil+kampung.wus_hamil)*100) as t1_total,
          ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kampung.wus_hamil)*100) as t1_hamil,
          ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kampung.wus_tidak_hamil)*100) as t1_tidak_hamil
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
          AND puskesmas.id_puskesmas = $puskesmasForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
    ");

    foreach ($query1 as $data1) {
        $kabupaten1[] = $data1['kabupaten'];
        $puskesmas1[] = $data1['puskesmas'];
        $kampung1[] = $data1['kampung'];
        $t1_total1[] = $data1['t1_total'];
        $t1_hamil1[] = $data1['t1_hamil'];
        $t1_tidak_hamil1[] = $data1['t1_tidak_hamil'];
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
        labels: <?php echo json_encode($kampung) ?>,
        datasets: [{
          label: "T1",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($t1_total) ?>,
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
              min: 0,
              max: 100,
              userCallback: function(label, index, labels) {
                    // when the floored value is the same as the value we have a whole number
                    if (Math.floor(label) === label) {
                        return label + '%';
                    }
              }
            }
          }]

        },
        title: {
            display: true,
            text: 'Ketercapaian T1 Tahunan Tiap Kampung',
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
        labels: <?php echo json_encode($kampung1) ?>,
        datasets: [{
          label: "WUS Hamil (%)",
          backgroundColor: 'rgba(196, 100, 59)',
          data: <?php echo json_encode($t1_hamil1) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "WUS Tidak Hamil (%)",
          backgroundColor: 'rgba(67, 48, 186)',
          data: <?php echo json_encode($t1_tidak_hamil1) ?>,
          xAxisID: "bar-x-axis2",
        }]
      };

      var options = {
        scales: {
          xAxes: [{
            stacked: false,
            id: "bar-x-axis1",
            ticks: {
                      autoSkip: false,
                      maxRotation: 90,
                      minRotation: 90,
            }
          }, {
            display: false,
            stacked: false,
            id: "bar-x-axis2",
            type: 'category',
            categoryPercentage: 0.9,
            barPercentage: 0.9,
            gridLines: {
              offsetGridLines: true
            },
            offset: true
          }],
          yAxes: [{
            stacked: false,
            ticks: {
              beginAtZero: true,
              min: 0,
              max: 100,
              userCallback: function(label, index, labels) {
                    // when the floored value is the same as the value we have a whole number
                    if (Math.floor(label) === label) {
                        return label + '%';
                    }
              }
            }
          }]
        },
        title: {
            display: true,
            text: 'Akumulasi Ketercapaian T1 WUS Hamil dan Tidak Hamil',
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
        labels: <?php echo json_encode($kampung2) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($idl2) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($sasaran2) ?>,
          xAxisID: "bar-x-axis2",
        }]
      };

      var options = {
        scales: {
          xAxes: [{
            stacked: true,
            id: "bar-x-axis1",
            barThickness: 20,
            ticks: {
                      autoSkip: false,
                      maxRotation: 90,
                      minRotation: 90,
            }
          }, {
            display: false,
            stacked: true,
            id: "bar-x-axis2",
            barThickness: 35,
            type: 'category',
            categoryPercentage: 0.8,
            barPercentage: 0.9,
            gridLines: {
              offsetGridLines: true
            },
            offset: true
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
            text: 'Target (40% Sasaran) dan IDL Quarter 2 Tiap Kampung',
            fontSize: 14,
        }
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
        labels: <?php echo json_encode($kampung3) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($idl3) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($sasaran3) ?>,
          xAxisID: "bar-x-axis2",
        }]
      };

      var options = {
        scales: {
          xAxes: [{
            stacked: true,
            id: "bar-x-axis1",
            barThickness: 20,
            ticks: {
                      autoSkip: false,
                      maxRotation: 90,
                      minRotation: 90,
            }
          }, {
            display: false,
            stacked: true,
            id: "bar-x-axis2",
            barThickness: 35,
            type: 'category',
            categoryPercentage: 0.8,
            barPercentage: 0.9,
            gridLines: {
              offsetGridLines: true
            },
            offset: true
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
            text: 'Target (60% Sasaran) dan IDL Quarter 3 Tiap Kampung',
            fontSize: 14,
        }
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
        labels: <?php echo json_encode($kampung4) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($idl4) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($sasaran4) ?>,
          xAxisID: "bar-x-axis2",
        }]
      };

      var options = {
        scales: {
          xAxes: [{
            stacked: true,
            id: "bar-x-axis1",
            barThickness: 20,
            ticks: {
                      autoSkip: false,
                      maxRotation: 90,
                      minRotation: 90,
            }
          }, {
            display: false,
            stacked: true,
            id: "bar-x-axis2",
            barThickness: 35,
            type: 'category',
            categoryPercentage: 0.8,
            barPercentage: 0.9,
            gridLines: {
              offsetGridLines: true
            },
            offset: true
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
            text: 'Target (80% Sasaran) dan IDL Quarter 4 Tiap Kampung',
            fontSize: 14,
        }
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