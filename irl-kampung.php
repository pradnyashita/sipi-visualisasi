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
          SUM(CASE WHEN data_individu.idl = 1 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
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
        $idl[] = $data['idl'];
    }

    $query1 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung,
        SUM(CASE WHEN data_individu.idl = 1 AND MONTH(data_individu.tanggal_idl) = 01 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
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
        $idl1[] = $data1['idl'];
    }

    $query2 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung,
        SUM(CASE WHEN data_individu.idl = 1 AND MONTH(data_individu.tanggal_idl) = 01 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
    FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
        AND puskesmas.id_puskesmas = $puskesmasForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    ");

    foreach ($query2 as $data2) {
        $kabupaten2[] = $data2['kabupaten'];
        $puskesmas2[] = $data2['puskesmas'];
        $kampung2[] = $data2['kampung'];
        $idl2[] = $data2['idl'];
    }
    
    $query3 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung,
        SUM(CASE WHEN data_individu.idl = 1 AND MONTH(data_individu.tanggal_idl) = 01 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
    FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
        AND puskesmas.id_puskesmas = $puskesmasForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    ");

    foreach ($query3 as $data3) {
        $kabupaten3[] = $data3['kabupaten'];
        $puskesmas3[] = $data3['puskesmas'];
        $kampung3[] = $data3['kampung'];
        $idl3[] = $data3['idl'];
    }

    $query4 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung,
        SUM(CASE WHEN data_individu.idl = 1 AND MONTH(data_individu.tanggal_idl) = 01 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
    FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
        AND puskesmas.id_puskesmas = $puskesmasForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    ");

    foreach ($query4 as $data4) {
        $kabupaten4[] = $data4['kabupaten'];
        $puskesmas4[] = $data4['puskesmas'];
        $kampung4[] = $data4['kampung'];
        $idl4[] = $data4['idl'];
    }
    
    $query5 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung,
        SUM(CASE WHEN data_individu.idl = 1 AND MONTH(data_individu.tanggal_idl) = 01 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
    FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
        AND puskesmas.id_puskesmas = $puskesmasForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    ");

    foreach ($query5 as $data5) {
        $kabupaten5[] = $data5['kabupaten'];
        $puskesmas5[] = $data5['puskesmas'];
        $kampung5[] = $data5['kampung'];
        $idl5[] = $data5['idl'];
    }

    $query6 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung,
        SUM(CASE WHEN data_individu.idl = 1 AND MONTH(data_individu.tanggal_idl) = 01 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
    FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
        AND puskesmas.id_puskesmas = $puskesmasForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    ");

    foreach ($query6 as $data6) {
        $kabupaten6[] = $data6['kabupaten'];
        $puskesmas6[] = $data6['puskesmas'];
        $kampung6[] = $data6['kampung'];
        $idl6[] = $data6['idl'];
    }

    $query7 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung,
        SUM(CASE WHEN data_individu.idl = 1 AND MONTH(data_individu.tanggal_idl) = 01 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
    FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
        AND puskesmas.id_puskesmas = $puskesmasForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    ");

    foreach ($query7 as $data7) {
        $kabupaten7[] = $data7['kabupaten'];
        $puskesmas7[] = $data7['puskesmas'];
        $kampung7[] = $data7['kampung'];
        $idl7[] = $data7['idl'];
    }

    $query8 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung,
        SUM(CASE WHEN data_individu.idl = 1 AND MONTH(data_individu.tanggal_idl) = 01 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
    FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
        AND puskesmas.id_puskesmas = $puskesmasForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    ");

    foreach ($query8 as $data8) {
        $kabupaten8[] = $data8['kabupaten'];
        $puskesmas8[] = $data8['puskesmas'];
        $kampung8[] = $data8['kampung'];
        $idl8[] = $data8['idl'];
    }

    $query9 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung,
        SUM(CASE WHEN data_individu.idl = 1 AND MONTH(data_individu.tanggal_idl) = 01 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
    FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
        AND puskesmas.id_puskesmas = $puskesmasForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    ");

    foreach ($query9 as $data9) {
        $kabupaten9[] = $data9['kabupaten'];
        $puskesmas9[] = $data9['puskesmas'];
        $kampung9[] = $data9['kampung'];
        $idl9[] = $data9['idl'];
    }
    
    
    $query10 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung,
        SUM(CASE WHEN data_individu.idl = 1 AND MONTH(data_individu.tanggal_idl) = 01 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
    FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
        AND puskesmas.id_puskesmas = $puskesmasForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    ");

    foreach ($query10 as $data10) {
        $kabupaten10[] = $data10['kabupaten'];
        $puskesmas10[] = $data10['puskesmas'];
        $kampung10[] = $data10['kampung'];
        $idl10[] = $data10['idl'];
    }
    
    
    $query11 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung,
        SUM(CASE WHEN data_individu.idl = 1 AND MONTH(data_individu.tanggal_idl) = 01 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
    FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
        AND puskesmas.id_puskesmas = $puskesmasForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    ");

    foreach ($query11 as $data11) {
        $kabupaten11[] = $data11['kabupaten'];
        $puskesmas11[] = $data11['puskesmas'];
        $kampung11[] = $data11['kampung'];
        $idl11[] = $data11['idl'];
    }

    $query12 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung,
        SUM(CASE WHEN data_individu.idl = 1 AND MONTH(data_individu.tanggal_idl) = 01 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl
    FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
        AND puskesmas.id_puskesmas = $puskesmasForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    ");

    foreach ($query12 as $data12) {
        $kabupaten12[] = $data12['kabupaten'];
        $puskesmas12[] = $data12['puskesmas'];
        $kampung12[] = $data12['kampung'];
        $idl12[] = $data12['idl'];
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

  for (var i = 0; i < 12; i++) {
    myHTML += '<div style="width: 1000px;"><canvas id="myChart' + (i + 1) + '"></canvas><br><br></div>';
  }

  wrapper.innerHTML = myHTML

</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(242, 198, 109)',
          data: <?php echo json_encode($idl) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Tahunan',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung1) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($idl1) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Bulan Januari',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart1").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung2) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($idl2) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Bulan Februari',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart2").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung3) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($idl3) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Bulan Maret',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart3").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung4) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($idl4) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Bulan April',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart4").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung5) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($idl5) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Bulan Mei',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart5").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung6) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($idl6) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Bulan Juni',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart6").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung7) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($idl7) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Bulan Juli',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart7").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung8) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($idl8) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Bulan Agustus',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart8").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung9) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($idl9) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Bulan September',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart9").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung10) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($idl10) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Bulan Oktober',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart10").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung11) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($idl11) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Bulan November',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart11").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


<script>
      var data = {
        labels: <?php echo json_encode($kampung12) ?>,
        datasets: [{
          label: "Total IDL",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($idl12) ?>,
        }]
      };

      var options = {
        scales: {
            xAxes: [{
                ticks: {
                stepSize: 1,
                beginAtZero: true,
                },
            }],
            },
        title: {
            display: true,
            text: 'Jumlah IDL Bulan Desember',
            fontSize: 14,
        }
      };

      var ctx = document.getElementById("myChart12").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
      });
</script>


</body>
</html>