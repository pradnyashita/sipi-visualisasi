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
        ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t1_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t1_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t1_tidak_hamil,

        ROUND(SUM(CASE WHEN data_individu.status_t='t2' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t2_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t2' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t2_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t2' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t2_tidak_hamil,

        ROUND(SUM(CASE WHEN data_individu.status_t='t3' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t3_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t3' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t3_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t3' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t3_tidak_hamil,

        ROUND(SUM(CASE WHEN data_individu.status_t='t4' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t4_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t4' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t4_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t4' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t4_tidak_hamil,
                
        ROUND(SUM(CASE WHEN data_individu.status_t='t5' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t5_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t5' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t5_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t5' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t5_tidak_hamil
                
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
        $t1_total[] = $data['t1_total'];
        $t1_hamil[] = $data['t1_hamil'];
        $t1_tidak_hamil[] = $data['t1_tidak_hamil'];
        $t2_total[] = $data['t2_total'];
        $t2_hamil[] = $data['t2_hamil'];
        $t2_tidak_hamil[] = $data['t2_tidak_hamil'];
        $t3_total[] = $data['t3_total'];
        $t3_hamil[] = $data['t3_hamil'];
        $t3_tidak_hamil[] = $data['t3_tidak_hamil'];
        $t4_total[] = $data['t4_total'];
        $t4_hamil[] = $data['t4_hamil'];
        $t4_tidak_hamil[] = $data['t4_tidak_hamil'];
        $t5_total[] = $data['t5_total'];
        $t5_hamil[] = $data['t5_hamil'];
        $t5_tidak_hamil[] = $data['t5_tidak_hamil'];
    }

    $query1 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t1_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t1_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t1_tidak_hamil,

        ROUND(SUM(CASE WHEN data_individu.status_t='t2' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t2_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t2' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t2_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t2' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t2_tidak_hamil,

        ROUND(SUM(CASE WHEN data_individu.status_t='t3' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t3_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t3' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t3_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t3' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t3_tidak_hamil,

        ROUND(SUM(CASE WHEN data_individu.status_t='t4' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t4_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t4' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t4_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t4' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t4_tidak_hamil,
                
        ROUND(SUM(CASE WHEN data_individu.status_t='t5' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t5_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t5' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t5_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t5' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t5_tidak_hamil
                
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
        $t1_total1[] = $data1['t1_total'];
        $t1_hamil1[] = $data1['t1_hamil'];
        $t1_tidak_hamil1[] = $data1['t1_tidak_hamil'];
        $t2_total1[] = $data1['t2_total'];
        $t2_hamil1[] = $data1['t2_hamil'];
        $t2_tidak_hamil1[] = $data1['t2_tidak_hamil'];
        $t3_total1[] = $data1['t3_total'];
        $t3_hamil1[] = $data1['t3_hamil'];
        $t3_tidak_hamil1[] = $data1['t3_tidak_hamil'];
        $t4_total1[] = $data1['t4_total'];
        $t4_hamil1[] = $data1['t4_hamil'];
        $t4_tidak_hamil1[] = $data1['t4_tidak_hamil'];
        $t5_total1[] = $data1['t5_total'];
        $t5_hamil1[] = $data1['t5_hamil'];
        $t5_tidak_hamil1[] = $data1['t5_tidak_hamil'];
    }

    $query2 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
        ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t1_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t1_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t1' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t1_tidak_hamil,

        ROUND(SUM(CASE WHEN data_individu.status_t='t2' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t2_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t2' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t2_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t2' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t2_tidak_hamil,

        ROUND(SUM(CASE WHEN data_individu.status_t='t3' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t3_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t3' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t3_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t3' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t3_tidak_hamil,

        ROUND(SUM(CASE WHEN data_individu.status_t='t4' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t4_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t4' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t4_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t4' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t4_tidak_hamil,
                
        ROUND(SUM(CASE WHEN data_individu.status_t='t5' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil+kabupaten.wus_hamil)*100) as t5_total,
        ROUND(SUM(CASE WHEN data_individu.status_t='t5' AND data_individu.status_hamil='hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_hamil)*100) as t5_hamil,
        ROUND(SUM(CASE WHEN data_individu.status_t='t5' AND data_individu.status_hamil='tidak hamil' AND data_individu.jenis_kelamin='p' AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END)/(kabupaten.wus_tidak_hamil)*100) as t5_tidak_hamil
                
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
        $t1_total2[] = $data2['t1_total'];
        $t1_hamil2[] = $data2['t1_hamil'];
        $t1_tidak_hamil2[] = $data2['t1_tidak_hamil'];
        $t2_total2[] = $data2['t2_total'];
        $t2_hamil2[] = $data2['t2_hamil'];
        $t2_tidak_hamil2[] = $data2['t2_tidak_hamil'];
        $t3_total2[] = $data2['t3_total'];
        $t3_hamil2[] = $data2['t3_hamil'];
        $t3_tidak_hamil2[] = $data2['t3_tidak_hamil'];
        $t4_total2[] = $data2['t4_total'];
        $t4_hamil2[] = $data2['t4_hamil'];
        $t4_tidak_hamil2[] = $data2['t4_tidak_hamil'];
        $t5_total2[] = $data2['t5_total'];
        $t5_hamil2[] = $data2['t5_hamil'];
        $t5_tidak_hamil2[] = $data2['t5_tidak_hamil'];
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
        labels: <?php echo json_encode($kabupaten) ?>,
        datasets: [{
          label: "T1 (%)",
          backgroundColor: 'rgba(196, 59, 59)',
          data: <?php echo json_encode($t1_total) ?>,
        }, {
          label: "T2 (%)",
          backgroundColor: 'rgba(222, 182, 40)',
          data: <?php echo json_encode($t2_total) ?>,
        }, {
          label: "T3 (%)",
          backgroundColor: 'rgba(17, 133, 19)',
          data: <?php echo json_encode($t3_total) ?>,
        }, {
          label: "T4 (%)",
          backgroundColor: 'rgba(17, 90, 133)',
          data: <?php echo json_encode($t4_total) ?>,
        }, {
          label: "T5 (%)",
          backgroundColor: 'rgba(186, 75, 219)',
          data: <?php echo json_encode($t5_total) ?>,
      }]
      };

      var options = {
        scales: {
                  xAxes: [{
                      stacked: true,
                      ticks: {
                      autoSkip: false,
                      maxRotation: 90,
                      minRotation: 90,
                      }
                  }],
                  yAxes: [{
                    stacked: true,
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
            text: 'Ketercapaian TT pada WUS Hamil & Tidak Hamil Tiap Kabupaten',
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
        labels: <?php echo json_encode($kabupaten1) ?>,
        datasets: [{
          label: "T1 (%)",
          backgroundColor: 'rgba(196, 59, 59)',
          data: <?php echo json_encode($t1_hamil1) ?>,
        }, {
          label: "T2 (%)",
          backgroundColor: 'rgba(222, 182, 40)',
          data: <?php echo json_encode($t2_hamil1) ?>,
        }, {
          label: "T3 (%)",
          backgroundColor: 'rgba(17, 133, 19)',
          data: <?php echo json_encode($t3_hamil1) ?>,
        }, {
          label: "T4 (%)",
          backgroundColor: 'rgba(17, 90, 133)',
          data: <?php echo json_encode($t4_hamil1) ?>,
        }, {
          label: "T5 (%)",
          backgroundColor: 'rgba(186, 75, 219)',
          data: <?php echo json_encode($t5_hamil1) ?>,
      }]
      };

      var options = {
        scales: {
                  xAxes: [{
                      stacked: true,
                      ticks: {
                      autoSkip: false,
                      maxRotation: 90,
                      minRotation: 90,
                      }
                  }],
                  yAxes: [{
                    stacked: true,
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
            text: 'Ketercapaian TT pada WUS Hamil Tiap Kabupaten',
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
        labels: <?php echo json_encode($kabupaten2) ?>,
        datasets: [{
          label: "T1 (%)",
          backgroundColor: 'rgba(196, 59, 59)',
          data: <?php echo json_encode($t1_tidak_hamil2) ?>,
        }, {
          label: "T2 (%)",
          backgroundColor: 'rgba(222, 182, 40)',
          data: <?php echo json_encode($t2_tidak_hamil2) ?>,
        }, {
          label: "T3 (%)",
          backgroundColor: 'rgba(17, 133, 19)',
          data: <?php echo json_encode($t3_tidak_hamil2) ?>,
        }, {
          label: "T4 (%)",
          backgroundColor: 'rgba(17, 90, 133)',
          data: <?php echo json_encode($t4_tidak_hamil2) ?>,
        }, {
          label: "T5 (%)",
          backgroundColor: 'rgba(186, 75, 219)',
          data: <?php echo json_encode($t5_tidak_hamil2) ?>,
      }]
      };

      var options = {
        scales: {
                  xAxes: [{
                      stacked: true,
                      ticks: {
                      autoSkip: false,
                      maxRotation: 90,
                      minRotation: 90,
                      }
                  }],
                  yAxes: [{
                    stacked: true,
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
            text: 'Ketercapaian TT pada WUS Tidak Hamil Tiap Kabupaten',
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


</body>
</html>