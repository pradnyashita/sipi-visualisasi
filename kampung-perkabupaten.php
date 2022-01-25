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
    <label for="antigen">Antigen</label>
    <input type="text" id="antigen" name="antigenform">
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
    $antigenForm = $_POST['antigenform'];

    $con = new mysqli("108.136.175.182","root","sipi","sistem_imunisasi");

    if ($antigenForm==1 || $antigenForm==2 || $antigenForm==3) {
        $query = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        ");

        foreach ($query as $data) {
            $kabupaten[] = $data['kabupaten'];
            $puskesmas[] = $data['puskesmas'];
            $kampung[] = $data['kampung'];
            $jumlah[] = $data['jumlah'];
            $jumlahP[] = $data['jumlahP'];
            $jumlahL[] = $data['jumlahL'];
            $target[] = $data['target'];
        }

        $query1 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung

        ");

        foreach ($query1 as $data1) {
            $kabupaten1[] = $data1['kabupaten'];
            $puskesmas1[] = $data1['puskesmas'];
            $kampung1[] = $data1['kampung'];
            $jumlah1[] = $data1['jumlah'];
            $jumlahP1[] = $data1['jumlahP'];
            $jumlahL1[] = $data1['jumlahL'];
            $target1[] = $data1['target'];
        }

        $query2 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        
        ");

        foreach ($query2 as $data2) {
            $kabupaten2[] = $data2['kabupaten'];
            $puskesmas2[] = $data2['puskesmas'];
            $kampung2[] = $data2['kampung'];
            $jumlah2[] = $data2['jumlah'];
            $jumlahP2[] = $data2['jumlahP'];
            $jumlahL2[] = $data2['jumlahL'];
            $target2[] = $data2['target'];
        }
      
        $query3 = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
        ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
      FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
        LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
      WHERE kabupaten.id_kabupaten = $kabupatenForm
      GROUP BY kampung.id_kampung
      ORDER BY kampung.id_kampung
      
      ");

        foreach ($query3 as $data3) {
            $kabupaten3[] = $data3['kabupaten'];
            $puskesmas3[] = $data3['puskesmas'];
            $kampung3[] = $data3['kampung'];
            $jumlah3[] = $data3['jumlah'];
            $jumlahP3[] = $data3['jumlahP'];
            $jumlahL3[] = $data3['jumlahL'];
            $target3[] = $data3['target'];
        }
    
        $query4 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        
        ");

        foreach ($query4 as $data4) {
            $kabupaten4[] = $data4['kabupaten'];
            $puskesmas4[] = $data4['puskesmas'];
            $kampung4[] = $data4['kampung'];
            $jumlah4[] = $data4['jumlah'];
            $jumlahP4[] = $data4['jumlahP'];
            $jumlahL4[] = $data4['jumlahL'];
            $target4[] = $data4['target'];
        }
      
        $query5 = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
        ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
      FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
        LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
      WHERE kabupaten.id_kabupaten = $kabupatenForm
      GROUP BY kampung.id_kampung
      ORDER BY kampung.id_kampung
      
      ");

        foreach ($query5 as $data5) {
            $kabupaten5[] = $data5['kabupaten'];
            $puskesmas5[] = $data5['puskesmas'];
            $kampung5[] = $data5['kampung'];
            $jumlah5[] = $data5['jumlah'];
            $jumlahP5[] = $data5['jumlahP'];
            $jumlahL5[] = $data5['jumlahL'];
            $target5[] = $data5['target'];
        }
    
        $query6 = $con->query("
      SELECT kabupaten.nama_kabupaten as kabupaten, 
      puskesmas.nama_puskesmas as puskesmas, 
      kampung.nama_kampung as kampung, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
      ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
    FROM kampung 
      LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
      LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
      LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
      LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
      LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    
    ");

        foreach ($query6 as $data6) {
            $kabupaten6[] = $data6['kabupaten'];
            $puskesmas6[] = $data6['puskesmas'];
            $kampung6[] = $data6['kampung'];
            $jumlah6[] = $data6['jumlah'];
            $jumlahP6[] = $data6['jumlahP'];
            $jumlahL6[] = $data6['jumlahL'];
            $target6[] = $data6['target'];
        }

        $query7 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
    puskesmas.nama_puskesmas as puskesmas, 
    kampung.nama_kampung as kampung, 
    SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
    SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
    SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
    ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
  FROM kampung 
    LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
    LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
    LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
    LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
    LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
  WHERE kabupaten.id_kabupaten = $kabupatenForm
  GROUP BY kampung.id_kampung
  ORDER BY kampung.id_kampung

  ");

        foreach ($query7 as $data7) {
            $kabupaten7[] = $data7['kabupaten'];
            $puskesmas7[] = $data7['puskesmas'];
            $kampung7[] = $data7['kampung'];
            $jumlah7[] = $data7['jumlah'];
            $jumlahP7[] = $data7['jumlahP'];
            $jumlahL7[] = $data7['jumlahL'];
            $target7[] = $data7['target'];
        }

        $query8 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        
        ");

        foreach ($query8 as $data8) {
            $kabupaten8[] = $data8['kabupaten'];
            $puskesmas8[] = $data8['puskesmas'];
            $kampung8[] = $data8['kampung'];
            $jumlah8[] = $data8['jumlah'];
            $jumlahP8[] = $data8['jumlahP'];
            $jumlahL8[] = $data8['jumlahL'];
            $target8[] = $data8['target'];
        }

        $query9 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        
        ");

        foreach ($query9 as $data9) {
            $kabupaten9[] = $data9['kabupaten'];
            $puskesmas9[] = $data9['puskesmas'];
            $kampung9[] = $data9['kampung'];
            $jumlah9[] = $data9['jumlah'];
            $jumlahP9[] = $data9['jumlahP'];
            $jumlahL9[] = $data9['jumlahL'];
            $target9[] = $data9['target'];
        }
      
      
        $query10 = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
        ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
      FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
        LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
      WHERE kabupaten.id_kabupaten = $kabupatenForm
      GROUP BY kampung.id_kampung
      ORDER BY kampung.id_kampung
      
      ");

        foreach ($query10 as $data10) {
            $kabupaten10[] = $data10['kabupaten'];
            $puskesmas10[] = $data10['puskesmas'];
            $kampung10[] = $data10['kampung'];
            $jumlah10[] = $data10['jumlah'];
            $jumlahP10[] = $data10['jumlahP'];
            $jumlahL10[] = $data10['jumlahL'];
            $target10[] = $data10['target'];
        }
      
      
        $query11 = $con->query("
      SELECT kabupaten.nama_kabupaten as kabupaten, 
      puskesmas.nama_puskesmas as puskesmas, 
      kampung.nama_kampung as kampung, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
      ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
    FROM kampung 
      LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
      LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
      LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
      LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
      LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    
    ");

        foreach ($query11 as $data11) {
            $kabupaten11[] = $data11['kabupaten'];
            $puskesmas11[] = $data11['puskesmas'];
            $kampung11[] = $data11['kampung'];
            $jumlah11[] = $data11['jumlah'];
            $jumlahP11[] = $data11['jumlahP'];
            $jumlahL11[] = $data11['jumlahL'];
            $target11[] = $data11['target'];
        }

        $query12 = $con->query("
      SELECT kabupaten.nama_kabupaten as kabupaten, 
      puskesmas.nama_puskesmas as puskesmas, 
      kampung.nama_kampung as kampung, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
      ROUND((ROUND(AVG(kampung.bayi_lahir_L + kampung.bayi_lahir_P),0))*0.95) as target
    FROM kampung 
      LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
      LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
      LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
      LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
      LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    
    ");

        foreach ($query12 as $data12) {
            $kabupaten12[] = $data12['kabupaten'];
            $puskesmas12[] = $data12['puskesmas'];
            $kampung12[] = $data12['kampung'];
            $jumlah12[] = $data12['jumlah'];
            $jumlahP12[] = $data12['jumlahP'];
            $jumlahL12[] = $data12['jumlahL'];
            $target12[] = $data12['target'];
        }


    } elseif ($antigenForm==12 || $antigenForm==13) {
      $query = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        ");

        foreach ($query as $data) {
            $kabupaten[] = $data['kabupaten'];
            $puskesmas[] = $data['puskesmas'];
            $kampung[] = $data['kampung'];
            $jumlah[] = $data['jumlah'];
            $jumlahP[] = $data['jumlahP'];
            $jumlahL[] = $data['jumlahL'];
            $target[] = $data['target'];
        }

        $query1 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung

        ");

        foreach ($query1 as $data1) {
            $kabupaten1[] = $data1['kabupaten'];
            $puskesmas1[] = $data1['puskesmas'];
            $kampung1[] = $data1['kampung'];
            $jumlah1[] = $data1['jumlah'];
            $jumlahP1[] = $data1['jumlahP'];
            $jumlahL1[] = $data1['jumlahL'];
            $target1[] = $data1['target'];
        }

        $query2 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        
        ");

        foreach ($query2 as $data2) {
            $kabupaten2[] = $data2['kabupaten'];
            $puskesmas2[] = $data2['puskesmas'];
            $kampung2[] = $data2['kampung'];
            $jumlah2[] = $data2['jumlah'];
            $jumlahP2[] = $data2['jumlahP'];
            $jumlahL2[] = $data2['jumlahL'];
            $target2[] = $data2['target'];
        }
      
        $query3 = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
        ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
      FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
        LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
      WHERE kabupaten.id_kabupaten = $kabupatenForm
      GROUP BY kampung.id_kampung
      ORDER BY kampung.id_kampung
      
      ");

        foreach ($query3 as $data3) {
            $kabupaten3[] = $data3['kabupaten'];
            $puskesmas3[] = $data3['puskesmas'];
            $kampung3[] = $data3['kampung'];
            $jumlah3[] = $data3['jumlah'];
            $jumlahP3[] = $data3['jumlahP'];
            $jumlahL3[] = $data3['jumlahL'];
            $target3[] = $data3['target'];
        }
    
        $query4 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        
        ");

        foreach ($query4 as $data4) {
            $kabupaten4[] = $data4['kabupaten'];
            $puskesmas4[] = $data4['puskesmas'];
            $kampung4[] = $data4['kampung'];
            $jumlah4[] = $data4['jumlah'];
            $jumlahP4[] = $data4['jumlahP'];
            $jumlahL4[] = $data4['jumlahL'];
            $target4[] = $data4['target'];
        }
      
        $query5 = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
        ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
      FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
        LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
      WHERE kabupaten.id_kabupaten = $kabupatenForm
      GROUP BY kampung.id_kampung
      ORDER BY kampung.id_kampung
      
      ");

        foreach ($query5 as $data5) {
            $kabupaten5[] = $data5['kabupaten'];
            $puskesmas5[] = $data5['puskesmas'];
            $kampung5[] = $data5['kampung'];
            $jumlah5[] = $data5['jumlah'];
            $jumlahP5[] = $data5['jumlahP'];
            $jumlahL5[] = $data5['jumlahL'];
            $target5[] = $data5['target'];
        }
    
        $query6 = $con->query("
      SELECT kabupaten.nama_kabupaten as kabupaten, 
      puskesmas.nama_puskesmas as puskesmas, 
      kampung.nama_kampung as kampung, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
      ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
    FROM kampung 
      LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
      LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
      LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
      LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
      LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    
    ");

        foreach ($query6 as $data6) {
            $kabupaten6[] = $data6['kabupaten'];
            $puskesmas6[] = $data6['puskesmas'];
            $kampung6[] = $data6['kampung'];
            $jumlah6[] = $data6['jumlah'];
            $jumlahP6[] = $data6['jumlahP'];
            $jumlahL6[] = $data6['jumlahL'];
            $target6[] = $data6['target'];
        }

        $query7 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
    puskesmas.nama_puskesmas as puskesmas, 
    kampung.nama_kampung as kampung, 
    SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
    SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
    SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
    ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
  FROM kampung 
    LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
    LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
    LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
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
            $jumlah7[] = $data7['jumlah'];
            $jumlahP7[] = $data7['jumlahP'];
            $jumlahL7[] = $data7['jumlahL'];
            $target7[] = $data7['target'];
        }

        $query8 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        
        ");

        foreach ($query8 as $data8) {
            $kabupaten8[] = $data8['kabupaten'];
            $puskesmas8[] = $data8['puskesmas'];
            $kampung8[] = $data8['kampung'];
            $jumlah8[] = $data8['jumlah'];
            $jumlahP8[] = $data8['jumlahP'];
            $jumlahL8[] = $data8['jumlahL'];
            $target8[] = $data8['target'];
        }

        $query9 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        
        ");

        foreach ($query9 as $data9) {
            $kabupaten9[] = $data9['kabupaten'];
            $puskesmas9[] = $data9['puskesmas'];
            $kampung9[] = $data9['kampung'];
            $jumlah9[] = $data9['jumlah'];
            $jumlahP9[] = $data9['jumlahP'];
            $jumlahL9[] = $data9['jumlahL'];
            $target9[] = $data9['target'];
        }
      
      
        $query10 = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
        ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
      FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
        LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
      WHERE kabupaten.id_kabupaten = $kabupatenForm
      GROUP BY kampung.id_kampung
      ORDER BY kampung.id_kampung
      
      ");

        foreach ($query10 as $data10) {
            $kabupaten10[] = $data10['kabupaten'];
            $puskesmas10[] = $data10['puskesmas'];
            $kampung10[] = $data10['kampung'];
            $jumlah10[] = $data10['jumlah'];
            $jumlahP10[] = $data10['jumlahP'];
            $jumlahL10[] = $data10['jumlahL'];
            $target10[] = $data10['target'];
        }
      
      
        $query11 = $con->query("
      SELECT kabupaten.nama_kabupaten as kabupaten, 
      puskesmas.nama_puskesmas as puskesmas, 
      kampung.nama_kampung as kampung, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
      ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
    FROM kampung 
      LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
      LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
      LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
      LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
      LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    
    ");

        foreach ($query11 as $data11) {
            $kabupaten11[] = $data11['kabupaten'];
            $puskesmas11[] = $data11['puskesmas'];
            $kampung11[] = $data11['kampung'];
            $jumlah11[] = $data11['jumlah'];
            $jumlahP11[] = $data11['jumlahP'];
            $jumlahL11[] = $data11['jumlahL'];
            $target11[] = $data11['target'];
        }

        $query12 = $con->query("
      SELECT kabupaten.nama_kabupaten as kabupaten, 
      puskesmas.nama_puskesmas as puskesmas, 
      kampung.nama_kampung as kampung, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
      ROUND((ROUND(AVG(kampung.baduta_L + kampung.baduta_P),0))*0.95) as target
    FROM kampung 
      LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
      LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
      LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
      LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
      LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    
    ");

        foreach ($query12 as $data12) {
            $kabupaten12[] = $data12['kabupaten'];
            $puskesmas12[] = $data12['puskesmas'];
            $kampung12[] = $data12['kampung'];
            $jumlah12[] = $data12['jumlah'];
            $jumlahP12[] = $data12['jumlahP'];
            $jumlahL12[] = $data12['jumlahL'];
            $target12[] = $data12['target'];
        }
    

    } else {
      $query = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        ");

        foreach ($query as $data) {
            $kabupaten[] = $data['kabupaten'];
            $puskesmas[] = $data['puskesmas'];
            $kampung[] = $data['kampung'];
            $jumlah[] = $data['jumlah'];
            $jumlahP[] = $data['jumlahP'];
            $jumlahL[] = $data['jumlahL'];
            $target[] = $data['target'];
        }

        $query1 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung

        ");

        foreach ($query1 as $data1) {
            $kabupaten1[] = $data1['kabupaten'];
            $puskesmas1[] = $data1['puskesmas'];
            $kampung1[] = $data1['kampung'];
            $jumlah1[] = $data1['jumlah'];
            $jumlahP1[] = $data1['jumlahP'];
            $jumlahL1[] = $data1['jumlahL'];
            $target1[] = $data1['target'];
        }

        $query2 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        
        ");

        foreach ($query2 as $data2) {
            $kabupaten2[] = $data2['kabupaten'];
            $puskesmas2[] = $data2['puskesmas'];
            $kampung2[] = $data2['kampung'];
            $jumlah2[] = $data2['jumlah'];
            $jumlahP2[] = $data2['jumlahP'];
            $jumlahL2[] = $data2['jumlahL'];
            $target2[] = $data2['target'];
        }
      
        $query3 = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
        ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
      FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
        LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
      WHERE kabupaten.id_kabupaten = $kabupatenForm
      GROUP BY kampung.id_kampung
      ORDER BY kampung.id_kampung
      
      ");

        foreach ($query3 as $data3) {
            $kabupaten3[] = $data3['kabupaten'];
            $puskesmas3[] = $data3['puskesmas'];
            $kampung3[] = $data3['kampung'];
            $jumlah3[] = $data3['jumlah'];
            $jumlahP3[] = $data3['jumlahP'];
            $jumlahL3[] = $data3['jumlahL'];
            $target3[] = $data3['target'];
        }
    
        $query4 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        
        ");

        foreach ($query4 as $data4) {
            $kabupaten4[] = $data4['kabupaten'];
            $puskesmas4[] = $data4['puskesmas'];
            $kampung4[] = $data4['kampung'];
            $jumlah4[] = $data4['jumlah'];
            $jumlahP4[] = $data4['jumlahP'];
            $jumlahL4[] = $data4['jumlahL'];
            $target4[] = $data4['target'];
        }
      
        $query5 = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
        ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
      FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
        LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
      WHERE kabupaten.id_kabupaten = $kabupatenForm
      GROUP BY kampung.id_kampung
      ORDER BY kampung.id_kampung
      
      ");

        foreach ($query5 as $data5) {
            $kabupaten5[] = $data5['kabupaten'];
            $puskesmas5[] = $data5['puskesmas'];
            $kampung5[] = $data5['kampung'];
            $jumlah5[] = $data5['jumlah'];
            $jumlahP5[] = $data5['jumlahP'];
            $jumlahL5[] = $data5['jumlahL'];
            $target5[] = $data5['target'];
        }
    
        $query6 = $con->query("
      SELECT kabupaten.nama_kabupaten as kabupaten, 
      puskesmas.nama_puskesmas as puskesmas, 
      kampung.nama_kampung as kampung, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
      ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
    FROM kampung 
      LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
      LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
      LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
      LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
      LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    
    ");

        foreach ($query6 as $data6) {
            $kabupaten6[] = $data6['kabupaten'];
            $puskesmas6[] = $data6['puskesmas'];
            $kampung6[] = $data6['kampung'];
            $jumlah6[] = $data6['jumlah'];
            $jumlahP6[] = $data6['jumlahP'];
            $jumlahL6[] = $data6['jumlahL'];
            $target6[] = $data6['target'];
        }

        $query7 = $con->query("
    SELECT kabupaten.nama_kabupaten as kabupaten, 
    puskesmas.nama_puskesmas as puskesmas, 
    kampung.nama_kampung as kampung, 
    SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
    SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
    SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
    ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
  FROM kampung 
    LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
    LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
    LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
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
            $jumlah7[] = $data7['jumlah'];
            $jumlahP7[] = $data7['jumlahP'];
            $jumlahL7[] = $data7['jumlahL'];
            $target7[] = $data7['target'];
        }

        $query8 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        
        ");

        foreach ($query8 as $data8) {
            $kabupaten8[] = $data8['kabupaten'];
            $puskesmas8[] = $data8['puskesmas'];
            $kampung8[] = $data8['kampung'];
            $jumlah8[] = $data8['jumlah'];
            $jumlahP8[] = $data8['jumlahP'];
            $jumlahL8[] = $data8['jumlahL'];
            $target8[] = $data8['target'];
        }

        $query9 = $con->query("
          SELECT kabupaten.nama_kabupaten as kabupaten, 
          puskesmas.nama_puskesmas as puskesmas, 
          kampung.nama_kampung as kampung, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        
        ");

        foreach ($query9 as $data9) {
            $kabupaten9[] = $data9['kabupaten'];
            $puskesmas9[] = $data9['puskesmas'];
            $kampung9[] = $data9['kampung'];
            $jumlah9[] = $data9['jumlah'];
            $jumlahP9[] = $data9['jumlahP'];
            $jumlahL9[] = $data9['jumlahL'];
            $target9[] = $data9['target'];
        }
      
      
        $query10 = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
        puskesmas.nama_puskesmas as puskesmas, 
        kampung.nama_kampung as kampung, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
        SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
        ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
      FROM kampung 
        LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
        LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
        LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
        LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
        LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
      WHERE kabupaten.id_kabupaten = $kabupatenForm
      GROUP BY kampung.id_kampung
      ORDER BY kampung.id_kampung
      
      ");

        foreach ($query10 as $data10) {
            $kabupaten10[] = $data10['kabupaten'];
            $puskesmas10[] = $data10['puskesmas'];
            $kampung10[] = $data10['kampung'];
            $jumlah10[] = $data10['jumlah'];
            $jumlahP10[] = $data10['jumlahP'];
            $jumlahL10[] = $data10['jumlahL'];
            $target10[] = $data10['target'];
        }
      
      
        $query11 = $con->query("
      SELECT kabupaten.nama_kabupaten as kabupaten, 
      puskesmas.nama_puskesmas as puskesmas, 
      kampung.nama_kampung as kampung, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
      ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
    FROM kampung 
      LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
      LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
      LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
      LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
      LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    
    ");

        foreach ($query11 as $data11) {
            $kabupaten11[] = $data11['kabupaten'];
            $puskesmas11[] = $data11['puskesmas'];
            $kampung11[] = $data11['kampung'];
            $jumlah11[] = $data11['jumlah'];
            $jumlahP11[] = $data11['jumlahP'];
            $jumlahL11[] = $data11['jumlahL'];
            $target11[] = $data11['target'];
        }

        $query12 = $con->query("
      SELECT kabupaten.nama_kabupaten as kabupaten, 
      puskesmas.nama_puskesmas as puskesmas, 
      kampung.nama_kampung as kampung, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
      SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
      ROUND((ROUND(AVG(kampung.surviving_infant_L + kampung.surviving_infant_P),0))*0.95) as target
    FROM kampung 
      LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
      LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
      LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
      LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
      LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
    WHERE kabupaten.id_kabupaten = $kabupatenForm
    GROUP BY kampung.id_kampung
    ORDER BY kampung.id_kampung
    
    ");

        foreach ($query12 as $data12) {
            $kabupaten12[] = $data12['kabupaten'];
            $puskesmas12[] = $data12['puskesmas'];
            $kampung12[] = $data12['kampung'];
            $jumlah12[] = $data12['jumlah'];
            $jumlahP12[] = $data12['jumlahP'];
            $jumlahL12[] = $data12['jumlahL'];
            $target12[] = $data12['target'];
        }
    }
}
?>



<!-- INI PAGE NYA--------------------------------------------------------------------------------------------------- -->

<div style="width: 2500px;">
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
          label: "Sudah Imunisasi",
          backgroundColor: 'rgba(240, 168, 36)',
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
            text: 'Target dan Realisasi Tahunan',
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
        labels: <?php echo json_encode($kampung1) ?>,
        datasets: [{
          label: "Perempuan",
          backgroundColor: 'rgba(215, 160, 159)',
          data: <?php echo json_encode($jumlahP1) ?>,
        }, {
          label: "Laki-Laki",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($jumlahL1) ?>,
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
                      userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Imunisasi Bulan Januari',
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
        labels: <?php echo json_encode($kampung2) ?>,
        datasets: [{
          label: "Perempuan",
          backgroundColor: 'rgba(215, 160, 159)',
          data: <?php echo json_encode($jumlahP2) ?>,
        }, {
          label: "Laki-Laki",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($jumlahL2) ?>,
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
                      userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Imunisasi Bulan Februari',
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
          label: "Perempuan",
          backgroundColor: 'rgba(215, 160, 159)',
          data: <?php echo json_encode($jumlahP3) ?>,
        }, {
          label: "Laki-Laki",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($jumlahL3) ?>,
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
                      userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Imunisasi Bulan Maret',
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
          label: "Perempuan",
          backgroundColor: 'rgba(215, 160, 159)',
          data: <?php echo json_encode($jumlahP4) ?>,
        }, {
          label: "Laki-Laki",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($jumlahL4) ?>,
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
                      userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Imunisasi Bulan April',
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


<script>
      var data = {
        labels: <?php echo json_encode($kampung5) ?>,
        datasets: [{
          label: "Perempuan",
          backgroundColor: 'rgba(215, 160, 159)',
          data: <?php echo json_encode($jumlahP5) ?>,
        }, {
          label: "Laki-Laki",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($jumlahL5) ?>,
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
                      userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Imunisasi Bulan Mei',
            fontSize: 14,
        }
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
        labels: <?php echo json_encode($kampung6) ?>,
        datasets: [{
          label: "Perempuan",
          backgroundColor: 'rgba(215, 160, 159)',
          data: <?php echo json_encode($jumlahP6) ?>,
        }, {
          label: "Laki-Laki",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($jumlahL6) ?>,
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
                      userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Imunisasi Bulan Juni',
            fontSize: 14,
        }
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
        labels: <?php echo json_encode($kampung7) ?>,
        datasets: [{
          label: "Perempuan",
          backgroundColor: 'rgba(215, 160, 159)',
          data: <?php echo json_encode($jumlahP7) ?>,
        }, {
          label: "Laki-Laki",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($jumlahL7) ?>,
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
                      userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Imunisasi Bulan Juli',
            fontSize: 14,
        }
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
        labels: <?php echo json_encode($kampung8) ?>,
        datasets: [{
          label: "Perempuan",
          backgroundColor: 'rgba(215, 160, 159)',
          data: <?php echo json_encode($jumlahP8) ?>,
        }, {
          label: "Laki-Laki",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($jumlahL8) ?>,
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
                      userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Imunisasi Bulan Agustus',
            fontSize: 14,
        }
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
        labels: <?php echo json_encode($kampung9) ?>,
        datasets: [{
          label: "Perempuan",
          backgroundColor: 'rgba(215, 160, 159)',
          data: <?php echo json_encode($jumlahP9) ?>,
        }, {
          label: "Laki-Laki",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($jumlahL9) ?>,
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
                      userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Imunisasi Bulan September',
            fontSize: 14,
        }
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
        labels: <?php echo json_encode($kampung10) ?>,
        datasets: [{
          label: "Perempuan",
          backgroundColor: 'rgba(215, 160, 159)',
          data: <?php echo json_encode($jumlahP10) ?>,
        }, {
          label: "Laki-Laki",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($jumlahL10) ?>,
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
                      userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Imunisasi Bulan Oktober',
            fontSize: 14,
        }
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
        labels: <?php echo json_encode($kampung11) ?>,
        datasets: [{
          label: "Perempuan",
          backgroundColor: 'rgba(215, 160, 159)',
          data: <?php echo json_encode($jumlahP11) ?>,
        }, {
          label: "Laki-Laki",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($jumlahL11) ?>,
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
                      userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Imunisasi Bulan November',
            fontSize: 14,
        }
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
        labels: <?php echo json_encode($kampung12) ?>,
        datasets: [{
          label: "Perempuan",
          backgroundColor: 'rgba(215, 160, 159)',
          data: <?php echo json_encode($jumlahP12) ?>,
        }, {
          label: "Laki-Laki",
          backgroundColor: 'rgba(162, 193, 224)',
          data: <?php echo json_encode($jumlahL12) ?>,
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
                      userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }
                 },
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Imunisasi Bulan Desember',
            fontSize: 14,
        }
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