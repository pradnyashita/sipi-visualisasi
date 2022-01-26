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
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query as $data) {
        $kabupaten[] = $data['kabupaten'];
        $antigen[] = $data['antigen'];
        $jumlah[] = $data['jumlah'];
        $target[] = $data['target'];
    }

    $query1 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95/12) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query1 as $data1) {
      $kabupate1[] = $data1['kabupaten'];
      $antigen1[] = $data1['antigen'];
      $jumlah1[] = $data1['jumlah'];
      $target1[] = $data1['target'];
    }

    $query2 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95/12) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query2 as $data2) {
      $kabupate2[] = $data2['kabupaten'];
      $antigen2[] = $data2['antigen'];
      $jumlah2[] = $data2['jumlah'];
      $target2[] = $data2['target'];
    }
    
    
    $query3 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95/12) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query3 as $data3) {
      $kabupate3[] = $data3['kabupaten'];
      $antigen3[] = $data3['antigen'];
      $jumlah3[] = $data3['jumlah'];
      $target3[] = $data3['target'];
    }
    
    
    $query4 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95/12) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query4 as $data4) {
      $kabupate4[] = $data4['kabupaten'];
      $antigen4[] = $data4['antigen'];
      $jumlah4[] = $data4['jumlah'];
      $target4[] = $data4['target'];
    }
    
    
    $query5 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95/12) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query5 as $data5) {
      $kabupate5[] = $data5['kabupaten'];
      $antigen5[] = $data5['antigen'];
      $jumlah5[] = $data5['jumlah'];
      $target5[] = $data5['target'];
    }
    
    
    $query6 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95/12) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query6 as $data6) {
      $kabupate6[] = $data6['kabupaten'];
      $antigen6[] = $data6['antigen'];
      $jumlah6[] = $data6['jumlah'];
      $target6[] = $data6['target'];
    }
    
    
    $query7 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95/12) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query7 as $data7) {
      $kabupate7[] = $data7['kabupaten'];
      $antigen7[] = $data7['antigen'];
      $jumlah7[] = $data7['jumlah'];
      $target7[] = $data7['target'];
    }
    
    
    $query8 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95/12) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query8 as $data8) {
      $kabupate8[] = $data8['kabupaten'];
      $antigen8[] = $data8['antigen'];
      $jumlah8[] = $data8['jumlah'];
      $target8[] = $data8['target'];
    }
    
    
    $query9 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 9 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95/12) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query9 as $data9) {
      $kabupate9[] = $data9['kabupaten'];
      $antigen9[] = $data9['antigen'];
      $jumlah9[] = $data9['jumlah'];
      $target9[] = $data9['target'];
    }
    
    
    $query10 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95/12) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query10 as $data10) {
      $kabupate10[] = $data10['kabupaten'];
      $antigen10[] = $data10['antigen'];
      $jumlah10[] = $data10['jumlah'];
      $target10[] = $data10['target'];
    }
    
    
    $query11 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95/12) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query11 as $data11) {
      $kabupate11[] = $data11['kabupaten'];
      $antigen11[] = $data11['antigen'];
      $jumlah11[] = $data11['jumlah'];
      $target11[] = $data11['target'];
    }
    
    
    $query12 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
          antigen.nama_antigen as antigen,
          SUM(CASE WHEN imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah,  
          ROUND(AVG(CASE WHEN antigen.id_antigen=1 OR antigen.id_antigen=2 OR antigen.id_antigen=3 THEN (kabupaten.bayi_lahir_L+kabupaten.bayi_lahir_P) 
              WHEN antigen.id_antigen=12 OR antigen.id_antigen=13 THEN (kabupaten.baduta_L+kabupaten.baduta_P)
              WHEN antigen.id_antigen=14 OR antigen.id_antigen=15 THEN (kabupaten.sd_1_L+kabupaten.sd_1_P)
              WHEN antigen.id_antigen=16 THEN (kabupaten.sd_2_L+kabupaten.sd_2_P)
              WHEN antigen.id_antigen=17 OR antigen.id_antigen=18 THEN (kabupaten.sd_5_L+kabupaten.sd_5_P)
              WHEN antigen.id_antigen=19 THEN (kabupaten.sd_6_L+kabupaten.sd_6_P)
              ELSE (kabupaten.surviving_infant_L+kabupaten.surviving_infant_P) END)*0.95/12) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY antigen.id_antigen
        ORDER BY kabupaten.id_kabupaten
    ");

    foreach ($query12 as $data12) {
      $kabupate12[] = $data12['kabupaten'];
      $antigen12[] = $data12['antigen'];
      $jumlah12[] = $data12['jumlah'];
      $target12[] = $data12['target'];
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

  for (var i = 0; i < 12; i++) {
    myHTML += '<div style="height: 500px;"><canvas id="myChart' + (i + 1) + '"></canvas><br><br></div>';
  }

  wrapper.innerHTML = myHTML

</script>


<script>
      var data = {
        labels: <?php echo json_encode($antigen) ?>,
        datasets: [{
          label: "Jumlah Imunisasi",
          backgroundColor: 'rgba(73, 110, 196)',
          data: <?php echo json_encode($jumlah) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Target",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target) ?>,
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
            text: 'Target dan Realisasi Imunisasi Tahunan Tiap Antigen',
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
        labels: <?php echo json_encode($antigen1) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($jumlah1) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target1) ?>,
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
            text: 'Target dan Realisasi Bulan Januari Tiap antigen',
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
        labels: <?php echo json_encode($antigen2) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($jumlah2) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target2) ?>,
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
            text: 'Target dan Realisasi Bulan Februari Tiap antigen',
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
        labels: <?php echo json_encode($antigen3) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($jumlah3) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target3) ?>,
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
            text: 'Target dan Realisasi Bulan Maret Tiap antigen',
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
        labels: <?php echo json_encode($antigen4) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($jumlah4) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target4) ?>,
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
            text: 'Target dan Realisasi Bulan April Tiap antigen',
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


<script>
      var data = {
        labels: <?php echo json_encode($antigen5) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($jumlah5) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target5) ?>,
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
            text: 'Target dan Realisasi Bulan Mei Tiap antigen',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
      };

      var ctx = document.getElementById("myChart5").getContext("2d");
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
        labels: <?php echo json_encode($antigen6) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($jumlah6) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target6) ?>,
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
            text: 'Target dan Realisasi Bulan Juni Tiap antigen',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
      };

      var ctx = document.getElementById("myChart6").getContext("2d");
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
        labels: <?php echo json_encode($antigen7) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($jumlah7) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target7) ?>,
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
            text: 'Target dan Realisasi Bulan Juli Tiap antigen',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
      };

      var ctx = document.getElementById("myChart7").getContext("2d");
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
        labels: <?php echo json_encode($antigen8) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($jumlah8) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target8) ?>,
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
            text: 'Target dan Realisasi Bulan Agustus Tiap antigen',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
      };

      var ctx = document.getElementById("myChart8").getContext("2d");
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
        labels: <?php echo json_encode($antigen9) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($jumlah9) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target9) ?>,
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
            text: 'Target dan Realisasi Bulan September Tiap antigen',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
      };

      var ctx = document.getElementById("myChart9").getContext("2d");
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
        labels: <?php echo json_encode($antigen10) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($jumlah10) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target10) ?>,
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
            text: 'Target dan Realisasi Bulan Oktober Tiap antigen',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
      };

      var ctx = document.getElementById("myChart10").getContext("2d");
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
        labels: <?php echo json_encode($antigen11) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($jumlah11) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target11) ?>,
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
            text: 'Target dan Realisasi Bulan November Tiap antigen',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
      };

      var ctx = document.getElementById("myChart11").getContext("2d");
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
        labels: <?php echo json_encode($antigen12) ?>,
        datasets: [{
          label: "Imunisasi Lengkap (IDL)",
          backgroundColor: 'rgba(240, 168, 36)',
          data: <?php echo json_encode($jumlah12) ?>,
          xAxisID: "bar-x-axis1",
        }, {
          label: "Sasaran",
          backgroundColor: 'rgba(156, 153, 145, 0.4)',
          data: <?php echo json_encode($target12) ?>,
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
            text: 'Target dan Realisasi Bulan Desember Tiap antigen',
            fontSize: 14,
        },
        responsive: true,
        maintainAspectRatio: false
      };

      var ctx = document.getElementById("myChart12").getContext("2d");
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