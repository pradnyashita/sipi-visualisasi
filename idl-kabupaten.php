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
    $tahunForm = $_POST['tahunform'];

    $con = new mysqli("108.136.175.182","root","sipi","sistem_imunisasi");

    $query = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          SUM(CASE WHEN data_individu.idl = 1 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl,
          (kabupaten.surviving_infant_L + kabupaten.surviving_infant_P) as sasaran
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query as $data) {
        $kabupaten[] = $data['kabupaten'];
        $idl[] = $data['idl'];
        $sasaran[] = $data['sasaran'];
    }

    $query1 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        SUM(CASE WHEN data_individu.idl = 1 AND (MONTH(data_individu.tanggal_idl) = 01 OR MONTH(data_individu.tanggal_idl) = 02 OR MONTH(data_individu.tanggal_idl) = 03) AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl,
        ROUND((kabupaten.surviving_infant_L + kabupaten.surviving_infant_P)*0.2) as sasaran
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query1 as $data1) {
      $kabupaten1[] = $data1['kabupaten'];
      $idl1[] = $data1['idl'];
      $sasaran1[] = $data1['sasaran'];
    }

    $query2 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        SUM(CASE WHEN data_individu.idl = 1 AND (MONTH(data_individu.tanggal_idl) = 01 OR MONTH(data_individu.tanggal_idl) = 02 OR MONTH(data_individu.tanggal_idl) = 03 OR MONTH(data_individu.tanggal_idl) = 04 OR MONTH(data_individu.tanggal_idl) = 05 OR MONTH(data_individu.tanggal_idl) = 06) AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl,
        ROUND((kabupaten.surviving_infant_L + kabupaten.surviving_infant_P)*0.4) as sasaran
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query2 as $data2) {
      $kabupaten2[] = $data2['kabupaten'];
      $idl2[] = $data2['idl'];
      $sasaran2[] = $data2['sasaran'];
    }

    $query3 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        SUM(CASE WHEN data_individu.idl = 1 AND (MONTH(data_individu.tanggal_idl) = 01 OR MONTH(data_individu.tanggal_idl) = 02 OR MONTH(data_individu.tanggal_idl) = 03 OR MONTH(data_individu.tanggal_idl) = 04 OR MONTH(data_individu.tanggal_idl) = 05 OR MONTH(data_individu.tanggal_idl) = 06 OR MONTH(data_individu.tanggal_idl) = 07 OR MONTH(data_individu.tanggal_idl) = 08 OR MONTH(data_individu.tanggal_idl) = 09) AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl,
        ROUND((kabupaten.surviving_infant_L + kabupaten.surviving_infant_P)*0.6) as sasaran
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query3 as $data3) {
      $kabupaten3[] = $data3['kabupaten'];
      $idl3[] = $data3['idl'];
      $sasaran3[] = $data3['sasaran'];
    }

    $query4 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        SUM(CASE WHEN data_individu.idl = 1 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl,
        ROUND((kabupaten.surviving_infant_L + kabupaten.surviving_infant_P)*0.8) as sasaran
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query4 as $data4) {
        $kabupaten4[] = $data4['kabupaten'];
        $idl4[] = $data4['idl'];
        $sasaran4[] = $data4['sasaran'];
    }

}
?>



<!-- INI PAGE NYA--------------------------------------------------------------------------------------------------- -->

<div style="width: 1000px;">
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
    myHTML += '<div style="width: 1000px;"><canvas id="myChart' + (i + 1) + '"></canvas><br><br></div>';
  }

  wrapper.innerHTML = myHTML

</script>


<script>
      var data = {
        labels: <?php echo json_encode($kabupaten) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($idl) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($sasaran) ?>,
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
            text: 'Total Sasaran dan IDL Tahunan Tiap Kabupaten',
            fontSize: 14,
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


<script>
      var data = {
        labels: <?php echo json_encode($kabupaten1) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($idl1) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($sasaran1) ?>,
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
            text: 'Target (20% Sasaran) dan IDL Quarter 1 Tiap Kabupaten',
            fontSize: 14,
        }
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
        labels: <?php echo json_encode($kabupaten2) ?>,
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
            text: 'Target (40% Sasaran) dan IDL Quarter 2 Tiap Kabupaten',
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
        labels: <?php echo json_encode($kabupaten3) ?>,
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
            text: 'Target (60% Sasaran) dan IDL Quarter 3 Tiap Kabupaten',
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
        labels: <?php echo json_encode($kabupaten4) ?>,
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
            text: 'Target (80% Sasaran) dan IDL Quarter 4 Tiap Kabupaten',
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