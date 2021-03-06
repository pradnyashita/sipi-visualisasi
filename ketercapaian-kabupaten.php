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
    $tahunForm = $_POST['tahunform'];
    $antigenForm = $_POST['antigenform'];

    $con = new mysqli("108.136.175.182","root","sipi","sistem_imunisasi");

    if ($antigenForm==1 || $antigenForm==2 || $antigenForm==3) {
        $query = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query as $data) {
            $kabupaten[] = $data['kabupaten'];
            $jumlah[] = $data['jumlah'];
            $jumlahP[] = $data['jumlahP'];
            $jumlahL[] = $data['jumlahL'];
            $target[] = $data['target'];
        }

        $query1 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
            WHERE kabupaten.id_kabupaten != 0
            GROUP BY kabupaten.id_kabupaten
            ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query1 as $data1) {
            $kabupaten1[] = $data1['kabupaten'];
            $jumlah1[] = $data1['jumlah'];
            $jumlahP1[] = $data1['jumlahP'];
            $jumlahL1[] = $data1['jumlahL'];
            $target1[] = $data1['target'];
        }

        
        
        $query2 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query2 as $data2) {
            $kabupaten2[] = $data2['kabupaten'];
            $jumlah2[] = $data2['jumlah'];
            $jumlahP2[] = $data2['jumlahP'];
            $jumlahL2[] = $data2['jumlahL'];
            $target2[] = $data2['target'];
        }

        
        $query3 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query3 as $data3) {
            $kabupaten3[] = $data3['kabupaten'];
            $jumlah3[] = $data3['jumlah'];
            $jumlahP3[] = $data3['jumlahP'];
            $jumlahL3[] = $data3['jumlahL'];
            $target3[] = $data3['target'];
        }

        
        $query4 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query4 as $data4) {
            $kabupaten4[] = $data4['kabupaten'];
            $jumlah4[] = $data4['jumlah'];
            $jumlahP4[] = $data4['jumlahP'];
            $jumlahL4[] = $data4['jumlahL'];
            $target4[] = $data4['target'];
        }

        
        $query5 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query5 as $data5) {
            $kabupaten5[] = $data5['kabupaten'];
            $jumlah5[] = $data5['jumlah'];
            $jumlahP5[] = $data5['jumlahP'];
            $jumlahL5[] = $data5['jumlahL'];
            $target5[] = $data5['target'];
        }

        
        $query6 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query6 as $data6) {
            $kabupaten6[] = $data6['kabupaten'];
            $jumlah6[] = $data6['jumlah'];
            $jumlahP6[] = $data6['jumlahP'];
            $jumlahL6[] = $data6['jumlahL'];
            $target6[] = $data6['target'];
        }

        
        $query7 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query7 as $data7) {
            $kabupaten7[] = $data7['kabupaten'];
            $jumlah7[] = $data7['jumlah'];
            $jumlahP7[] = $data7['jumlahP'];
            $jumlahL7[] = $data7['jumlahL'];
            $target7[] = $data7['target'];
        }

        
        $query8 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query8 as $data8) {
            $kabupaten8[] = $data8['kabupaten'];
            $jumlah8[] = $data8['jumlah'];
            $jumlahP8[] = $data8['jumlahP'];
            $jumlahL8[] = $data8['jumlahL'];
            $target8[] = $data8['target'];
        }

        
        $query9 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query9 as $data9) {
            $kabupaten9[] = $data9['kabupaten'];
            $jumlah9[] = $data9['jumlah'];
            $jumlahP9[] = $data9['jumlahP'];
            $jumlahL9[] = $data9['jumlahL'];
            $target9[] = $data9['target'];
        }

        
        $query10 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query10 as $data10) {
            $kabupaten10[] = $data10['kabupaten'];
            $jumlah10[] = $data10['jumlah'];
            $jumlahP10[] = $data10['jumlahP'];
            $jumlahL10[] = $data10['jumlahL'];
            $target10[] = $data10['target'];
        }

        
        $query11 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query11 as $data11) {
            $kabupaten11[] = $data11['kabupaten'];
            $jumlah11[] = $data11['jumlah'];
            $jumlahP11[] = $data11['jumlahP'];
            $jumlahL11[] = $data11['jumlahL'];
            $target11[] = $data11['target'];
        }

        
        $query12 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.bayi_lahir_L+ kabupaten.bayi_lahir_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query12 as $data12) {
            $kabupaten12[] = $data12['kabupaten'];
            $jumlah12[] = $data12['jumlah'];
            $jumlahP12[] = $data12['jumlahP'];
            $jumlahL12[] = $data12['jumlahL'];
            $target12[] = $data12['target'];
        }




    } elseif ($antigenForm==12 || $antigenForm==13) {
        $query = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query as $data) {
            $kabupaten[] = $data['kabupaten'];
            $jumlah[] = $data['jumlah'];
            $jumlahP[] = $data['jumlahP'];
            $jumlahL[] = $data['jumlahL'];
            $target[] = $data['target'];
        }

        $query1 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query1 as $data1) {
            $kabupaten1[] = $data1['kabupaten'];
            $jumlah1[] = $data1['jumlah'];
            $jumlahP1[] = $data1['jumlahP'];
            $jumlahL1[] = $data1['jumlahL'];
            $target1[] = $data1['target'];
        }

        
        
        $query2 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query2 as $data2) {
            $kabupaten2[] = $data2['kabupaten'];
            $jumlah2[] = $data2['jumlah'];
            $jumlahP2[] = $data2['jumlahP'];
            $jumlahL2[] = $data2['jumlahL'];
            $target2[] = $data2['target'];
        }

        
        $query3 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query3 as $data3) {
            $kabupaten3[] = $data3['kabupaten'];
            $jumlah3[] = $data3['jumlah'];
            $jumlahP3[] = $data3['jumlahP'];
            $jumlahL3[] = $data3['jumlahL'];
            $target3[] = $data3['target'];
        }

        
        $query4 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query4 as $data4) {
            $kabupaten4[] = $data4['kabupaten'];
            $jumlah4[] = $data4['jumlah'];
            $jumlahP4[] = $data4['jumlahP'];
            $jumlahL4[] = $data4['jumlahL'];
            $target4[] = $data4['target'];
        }

        
        $query5 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query5 as $data5) {
            $kabupaten5[] = $data5['kabupaten'];
            $jumlah5[] = $data5['jumlah'];
            $jumlahP5[] = $data5['jumlahP'];
            $jumlahL5[] = $data5['jumlahL'];
            $target5[] = $data5['target'];
        }

        
        $query6 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query6 as $data6) {
            $kabupaten6[] = $data6['kabupaten'];
            $jumlah6[] = $data6['jumlah'];
            $jumlahP6[] = $data6['jumlahP'];
            $jumlahL6[] = $data6['jumlahL'];
            $target6[] = $data6['target'];
        }

        
        $query7 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query7 as $data7) {
            $kabupaten7[] = $data7['kabupaten'];
            $jumlah7[] = $data7['jumlah'];
            $jumlahP7[] = $data7['jumlahP'];
            $jumlahL7[] = $data7['jumlahL'];
            $target7[] = $data7['target'];
        }

        
        $query8 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query8 as $data8) {
            $kabupaten8[] = $data8['kabupaten'];
            $jumlah8[] = $data8['jumlah'];
            $jumlahP8[] = $data8['jumlahP'];
            $jumlahL8[] = $data8['jumlahL'];
            $target8[] = $data8['target'];
        }

        
        $query9 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query9 as $data9) {
            $kabupaten9[] = $data9['kabupaten'];
            $jumlah9[] = $data9['jumlah'];
            $jumlahP9[] = $data9['jumlahP'];
            $jumlahL9[] = $data9['jumlahL'];
            $target9[] = $data9['target'];
        }

        
        $query10 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query10 as $data10) {
            $kabupaten10[] = $data10['kabupaten'];
            $jumlah10[] = $data10['jumlah'];
            $jumlahP10[] = $data10['jumlahP'];
            $jumlahL10[] = $data10['jumlahL'];
            $target10[] = $data10['target'];
        }

        
        $query11 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query11 as $data11) {
            $kabupaten11[] = $data11['kabupaten'];
            $jumlah11[] = $data11['jumlah'];
            $jumlahP11[] = $data11['jumlahP'];
            $jumlahL11[] = $data11['jumlahL'];
            $target11[] = $data11['target'];
        }

        
        $query12 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.baduta_L + kabupaten.baduta_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query12 as $data12) {
            $kabupaten12[] = $data12['kabupaten'];
            $jumlah12[] = $data12['jumlah'];
            $jumlahP12[] = $data12['jumlahP'];
            $jumlahL12[] = $data12['jumlahL'];
            $target12[] = $data12['target'];
        }
    

    } elseif ($antigenForm==14 || $antigenForm==15) {
        $query = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query as $data) {
            $kabupaten[] = $data['kabupaten'];
            $jumlah[] = $data['jumlah'];
            $jumlahP[] = $data['jumlahP'];
            $jumlahL[] = $data['jumlahL'];
            $target[] = $data['target'];
        }

        $query1 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query1 as $data1) {
            $kabupaten1[] = $data1['kabupaten'];
            $jumlah1[] = $data1['jumlah'];
            $jumlahP1[] = $data1['jumlahP'];
            $jumlahL1[] = $data1['jumlahL'];
            $target1[] = $data1['target'];
        }

        
        
        $query2 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query2 as $data2) {
            $kabupaten2[] = $data2['kabupaten'];
            $jumlah2[] = $data2['jumlah'];
            $jumlahP2[] = $data2['jumlahP'];
            $jumlahL2[] = $data2['jumlahL'];
            $target2[] = $data2['target'];
        }

        
        $query3 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query3 as $data3) {
            $kabupaten3[] = $data3['kabupaten'];
            $jumlah3[] = $data3['jumlah'];
            $jumlahP3[] = $data3['jumlahP'];
            $jumlahL3[] = $data3['jumlahL'];
            $target3[] = $data3['target'];
        }

        
        $query4 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query4 as $data4) {
            $kabupaten4[] = $data4['kabupaten'];
            $jumlah4[] = $data4['jumlah'];
            $jumlahP4[] = $data4['jumlahP'];
            $jumlahL4[] = $data4['jumlahL'];
            $target4[] = $data4['target'];
        }

        
        $query5 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query5 as $data5) {
            $kabupaten5[] = $data5['kabupaten'];
            $jumlah5[] = $data5['jumlah'];
            $jumlahP5[] = $data5['jumlahP'];
            $jumlahL5[] = $data5['jumlahL'];
            $target5[] = $data5['target'];
        }

        
        $query6 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query6 as $data6) {
            $kabupaten6[] = $data6['kabupaten'];
            $jumlah6[] = $data6['jumlah'];
            $jumlahP6[] = $data6['jumlahP'];
            $jumlahL6[] = $data6['jumlahL'];
            $target6[] = $data6['target'];
        }

        
        $query7 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query7 as $data7) {
            $kabupaten7[] = $data7['kabupaten'];
            $jumlah7[] = $data7['jumlah'];
            $jumlahP7[] = $data7['jumlahP'];
            $jumlahL7[] = $data7['jumlahL'];
            $target7[] = $data7['target'];
        }

        
        $query8 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query8 as $data8) {
            $kabupaten8[] = $data8['kabupaten'];
            $jumlah8[] = $data8['jumlah'];
            $jumlahP8[] = $data8['jumlahP'];
            $jumlahL8[] = $data8['jumlahL'];
            $target8[] = $data8['target'];
        }

        
        $query9 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query9 as $data9) {
            $kabupaten9[] = $data9['kabupaten'];
            $jumlah9[] = $data9['jumlah'];
            $jumlahP9[] = $data9['jumlahP'];
            $jumlahL9[] = $data9['jumlahL'];
            $target9[] = $data9['target'];
        }

        
        $query10 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query10 as $data10) {
            $kabupaten10[] = $data10['kabupaten'];
            $jumlah10[] = $data10['jumlah'];
            $jumlahP10[] = $data10['jumlahP'];
            $jumlahL10[] = $data10['jumlahL'];
            $target10[] = $data10['target'];
        }

        
        $query11 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query11 as $data11) {
            $kabupaten11[] = $data11['kabupaten'];
            $jumlah11[] = $data11['jumlah'];
            $jumlahP11[] = $data11['jumlahP'];
            $jumlahL11[] = $data11['jumlahL'];
            $target11[] = $data11['target'];
        }

        
        $query12 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_1_L + kabupaten.sd_1_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query12 as $data12) {
            $kabupaten12[] = $data12['kabupaten'];
            $jumlah12[] = $data12['jumlah'];
            $jumlahP12[] = $data12['jumlahP'];
            $jumlahL12[] = $data12['jumlahL'];
            $target12[] = $data12['target'];
        }
    

    } elseif ($antigenForm==16) {
        $query = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query as $data) {
            $kabupaten[] = $data['kabupaten'];
            $jumlah[] = $data['jumlah'];
            $jumlahP[] = $data['jumlahP'];
            $jumlahL[] = $data['jumlahL'];
            $target[] = $data['target'];
        }

        $query1 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query1 as $data1) {
            $kabupaten1[] = $data1['kabupaten'];
            $jumlah1[] = $data1['jumlah'];
            $jumlahP1[] = $data1['jumlahP'];
            $jumlahL1[] = $data1['jumlahL'];
            $target1[] = $data1['target'];
        }

        
        
        $query2 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query2 as $data2) {
            $kabupaten2[] = $data2['kabupaten'];
            $jumlah2[] = $data2['jumlah'];
            $jumlahP2[] = $data2['jumlahP'];
            $jumlahL2[] = $data2['jumlahL'];
            $target2[] = $data2['target'];
        }

        
        $query3 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query3 as $data3) {
            $kabupaten3[] = $data3['kabupaten'];
            $jumlah3[] = $data3['jumlah'];
            $jumlahP3[] = $data3['jumlahP'];
            $jumlahL3[] = $data3['jumlahL'];
            $target3[] = $data3['target'];
        }

        
        $query4 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query4 as $data4) {
            $kabupaten4[] = $data4['kabupaten'];
            $jumlah4[] = $data4['jumlah'];
            $jumlahP4[] = $data4['jumlahP'];
            $jumlahL4[] = $data4['jumlahL'];
            $target4[] = $data4['target'];
        }

        
        $query5 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query5 as $data5) {
            $kabupaten5[] = $data5['kabupaten'];
            $jumlah5[] = $data5['jumlah'];
            $jumlahP5[] = $data5['jumlahP'];
            $jumlahL5[] = $data5['jumlahL'];
            $target5[] = $data5['target'];
        }

        
        $query6 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query6 as $data6) {
            $kabupaten6[] = $data6['kabupaten'];
            $jumlah6[] = $data6['jumlah'];
            $jumlahP6[] = $data6['jumlahP'];
            $jumlahL6[] = $data6['jumlahL'];
            $target6[] = $data6['target'];
        }

        
        $query7 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query7 as $data7) {
            $kabupaten7[] = $data7['kabupaten'];
            $jumlah7[] = $data7['jumlah'];
            $jumlahP7[] = $data7['jumlahP'];
            $jumlahL7[] = $data7['jumlahL'];
            $target7[] = $data7['target'];
        }

        
        $query8 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query8 as $data8) {
            $kabupaten8[] = $data8['kabupaten'];
            $jumlah8[] = $data8['jumlah'];
            $jumlahP8[] = $data8['jumlahP'];
            $jumlahL8[] = $data8['jumlahL'];
            $target8[] = $data8['target'];
        }

        
        $query9 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query9 as $data9) {
            $kabupaten9[] = $data9['kabupaten'];
            $jumlah9[] = $data9['jumlah'];
            $jumlahP9[] = $data9['jumlahP'];
            $jumlahL9[] = $data9['jumlahL'];
            $target9[] = $data9['target'];
        }

        
        $query10 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query10 as $data10) {
            $kabupaten10[] = $data10['kabupaten'];
            $jumlah10[] = $data10['jumlah'];
            $jumlahP10[] = $data10['jumlahP'];
            $jumlahL10[] = $data10['jumlahL'];
            $target10[] = $data10['target'];
        }

        
        $query11 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query11 as $data11) {
            $kabupaten11[] = $data11['kabupaten'];
            $jumlah11[] = $data11['jumlah'];
            $jumlahP11[] = $data11['jumlahP'];
            $jumlahL11[] = $data11['jumlahL'];
            $target11[] = $data11['target'];
        }

        
        $query12 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_2_L + kabupaten.sd_2_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query12 as $data12) {
            $kabupaten12[] = $data12['kabupaten'];
            $jumlah12[] = $data12['jumlah'];
            $jumlahP12[] = $data12['jumlahP'];
            $jumlahL12[] = $data12['jumlahL'];
            $target12[] = $data12['target'];
        }
    

    } elseif ($antigenForm==17 || $antigenForm==18) {
        $query = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query as $data) {
            $kabupaten[] = $data['kabupaten'];
            $jumlah[] = $data['jumlah'];
            $jumlahP[] = $data['jumlahP'];
            $jumlahL[] = $data['jumlahL'];
            $target[] = $data['target'];
        }

        $query1 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query1 as $data1) {
            $kabupaten1[] = $data1['kabupaten'];
            $jumlah1[] = $data1['jumlah'];
            $jumlahP1[] = $data1['jumlahP'];
            $jumlahL1[] = $data1['jumlahL'];
            $target1[] = $data1['target'];
        }

        
        
        $query2 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query2 as $data2) {
            $kabupaten2[] = $data2['kabupaten'];
            $jumlah2[] = $data2['jumlah'];
            $jumlahP2[] = $data2['jumlahP'];
            $jumlahL2[] = $data2['jumlahL'];
            $target2[] = $data2['target'];
        }

        
        $query3 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query3 as $data3) {
            $kabupaten3[] = $data3['kabupaten'];
            $jumlah3[] = $data3['jumlah'];
            $jumlahP3[] = $data3['jumlahP'];
            $jumlahL3[] = $data3['jumlahL'];
            $target3[] = $data3['target'];
        }

        
        $query4 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query4 as $data4) {
            $kabupaten4[] = $data4['kabupaten'];
            $jumlah4[] = $data4['jumlah'];
            $jumlahP4[] = $data4['jumlahP'];
            $jumlahL4[] = $data4['jumlahL'];
            $target4[] = $data4['target'];
        }

        
        $query5 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query5 as $data5) {
            $kabupaten5[] = $data5['kabupaten'];
            $jumlah5[] = $data5['jumlah'];
            $jumlahP5[] = $data5['jumlahP'];
            $jumlahL5[] = $data5['jumlahL'];
            $target5[] = $data5['target'];
        }

        
        $query6 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query6 as $data6) {
            $kabupaten6[] = $data6['kabupaten'];
            $jumlah6[] = $data6['jumlah'];
            $jumlahP6[] = $data6['jumlahP'];
            $jumlahL6[] = $data6['jumlahL'];
            $target6[] = $data6['target'];
        }

        
        $query7 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query7 as $data7) {
            $kabupaten7[] = $data7['kabupaten'];
            $jumlah7[] = $data7['jumlah'];
            $jumlahP7[] = $data7['jumlahP'];
            $jumlahL7[] = $data7['jumlahL'];
            $target7[] = $data7['target'];
        }

        
        $query8 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query8 as $data8) {
            $kabupaten8[] = $data8['kabupaten'];
            $jumlah8[] = $data8['jumlah'];
            $jumlahP8[] = $data8['jumlahP'];
            $jumlahL8[] = $data8['jumlahL'];
            $target8[] = $data8['target'];
        }

        
        $query9 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query9 as $data9) {
            $kabupaten9[] = $data9['kabupaten'];
            $jumlah9[] = $data9['jumlah'];
            $jumlahP9[] = $data9['jumlahP'];
            $jumlahL9[] = $data9['jumlahL'];
            $target9[] = $data9['target'];
        }

        
        $query10 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query10 as $data10) {
            $kabupaten10[] = $data10['kabupaten'];
            $jumlah10[] = $data10['jumlah'];
            $jumlahP10[] = $data10['jumlahP'];
            $jumlahL10[] = $data10['jumlahL'];
            $target10[] = $data10['target'];
        }

        
        $query11 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query11 as $data11) {
            $kabupaten11[] = $data11['kabupaten'];
            $jumlah11[] = $data11['jumlah'];
            $jumlahP11[] = $data11['jumlahP'];
            $jumlahL11[] = $data11['jumlahL'];
            $target11[] = $data11['target'];
        }

        
        $query12 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_5_L + kabupaten.sd_5_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query12 as $data12) {
            $kabupaten12[] = $data12['kabupaten'];
            $jumlah12[] = $data12['jumlah'];
            $jumlahP12[] = $data12['jumlahP'];
            $jumlahL12[] = $data12['jumlahL'];
            $target12[] = $data12['target'];
        }
    

    } elseif ($antigenForm==19) {
        $query = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query as $data) {
            $kabupaten[] = $data['kabupaten'];
            $jumlah[] = $data['jumlah'];
            $jumlahP[] = $data['jumlahP'];
            $jumlahL[] = $data['jumlahL'];
            $target[] = $data['target'];
        }

        $query1 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query1 as $data1) {
            $kabupaten1[] = $data1['kabupaten'];
            $jumlah1[] = $data1['jumlah'];
            $jumlahP1[] = $data1['jumlahP'];
            $jumlahL1[] = $data1['jumlahL'];
            $target1[] = $data1['target'];
        }

        
        
        $query2 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query2 as $data2) {
            $kabupaten2[] = $data2['kabupaten'];
            $jumlah2[] = $data2['jumlah'];
            $jumlahP2[] = $data2['jumlahP'];
            $jumlahL2[] = $data2['jumlahL'];
            $target2[] = $data2['target'];
        }

        
        $query3 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query3 as $data3) {
            $kabupaten3[] = $data3['kabupaten'];
            $jumlah3[] = $data3['jumlah'];
            $jumlahP3[] = $data3['jumlahP'];
            $jumlahL3[] = $data3['jumlahL'];
            $target3[] = $data3['target'];
        }

        
        $query4 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query4 as $data4) {
            $kabupaten4[] = $data4['kabupaten'];
            $jumlah4[] = $data4['jumlah'];
            $jumlahP4[] = $data4['jumlahP'];
            $jumlahL4[] = $data4['jumlahL'];
            $target4[] = $data4['target'];
        }

        
        $query5 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query5 as $data5) {
            $kabupaten5[] = $data5['kabupaten'];
            $jumlah5[] = $data5['jumlah'];
            $jumlahP5[] = $data5['jumlahP'];
            $jumlahL5[] = $data5['jumlahL'];
            $target5[] = $data5['target'];
        }

        
        $query6 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query6 as $data6) {
            $kabupaten6[] = $data6['kabupaten'];
            $jumlah6[] = $data6['jumlah'];
            $jumlahP6[] = $data6['jumlahP'];
            $jumlahL6[] = $data6['jumlahL'];
            $target6[] = $data6['target'];
        }

        
        $query7 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query7 as $data7) {
            $kabupaten7[] = $data7['kabupaten'];
            $jumlah7[] = $data7['jumlah'];
            $jumlahP7[] = $data7['jumlahP'];
            $jumlahL7[] = $data7['jumlahL'];
            $target7[] = $data7['target'];
        }

        
        $query8 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query8 as $data8) {
            $kabupaten8[] = $data8['kabupaten'];
            $jumlah8[] = $data8['jumlah'];
            $jumlahP8[] = $data8['jumlahP'];
            $jumlahL8[] = $data8['jumlahL'];
            $target8[] = $data8['target'];
        }

        
        $query9 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query9 as $data9) {
            $kabupaten9[] = $data9['kabupaten'];
            $jumlah9[] = $data9['jumlah'];
            $jumlahP9[] = $data9['jumlahP'];
            $jumlahL9[] = $data9['jumlahL'];
            $target9[] = $data9['target'];
        }

        
        $query10 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query10 as $data10) {
            $kabupaten10[] = $data10['kabupaten'];
            $jumlah10[] = $data10['jumlah'];
            $jumlahP10[] = $data10['jumlahP'];
            $jumlahL10[] = $data10['jumlahL'];
            $target10[] = $data10['target'];
        }

        
        $query11 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query11 as $data11) {
            $kabupaten11[] = $data11['kabupaten'];
            $jumlah11[] = $data11['jumlah'];
            $jumlahP11[] = $data11['jumlahP'];
            $jumlahL11[] = $data11['jumlahL'];
            $target11[] = $data11['target'];
        }

        
        $query12 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.sd_6_L + kabupaten.sd_6_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query12 as $data12) {
            $kabupaten12[] = $data12['kabupaten'];
            $jumlah12[] = $data12['jumlah'];
            $jumlahP12[] = $data12['jumlahP'];
            $jumlahL12[] = $data12['jumlahL'];
            $target12[] = $data12['target'];
        }
    

    } else {
        $query = $con->query("
        SELECT kabupaten.nama_kabupaten as kabupaten, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
          SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
          ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
          LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query as $data) {
            $kabupaten[] = $data['kabupaten'];
            $jumlah[] = $data['jumlah'];
            $jumlahP[] = $data['jumlahP'];
            $jumlahL[] = $data['jumlahL'];
            $target[] = $data['target'];
        }

        $query1 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 01 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query1 as $data1) {
            $kabupaten1[] = $data1['kabupaten'];
            $jumlah1[] = $data1['jumlah'];
            $jumlahP1[] = $data1['jumlahP'];
            $jumlahL1[] = $data1['jumlahL'];
            $target1[] = $data1['target'];
        }

        
        
        $query2 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 02 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query2 as $data2) {
            $kabupaten2[] = $data2['kabupaten'];
            $jumlah2[] = $data2['jumlah'];
            $jumlahP2[] = $data2['jumlahP'];
            $jumlahL2[] = $data2['jumlahL'];
            $target2[] = $data2['target'];
        }

        
        $query3 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 03 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query3 as $data3) {
            $kabupaten3[] = $data3['kabupaten'];
            $jumlah3[] = $data3['jumlah'];
            $jumlahP3[] = $data3['jumlahP'];
            $jumlahL3[] = $data3['jumlahL'];
            $target3[] = $data3['target'];
        }

        
        $query4 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 04 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query4 as $data4) {
            $kabupaten4[] = $data4['kabupaten'];
            $jumlah4[] = $data4['jumlah'];
            $jumlahP4[] = $data4['jumlahP'];
            $jumlahL4[] = $data4['jumlahL'];
            $target4[] = $data4['target'];
        }

        
        $query5 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 05 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query5 as $data5) {
            $kabupaten5[] = $data5['kabupaten'];
            $jumlah5[] = $data5['jumlah'];
            $jumlahP5[] = $data5['jumlahP'];
            $jumlahL5[] = $data5['jumlahL'];
            $target5[] = $data5['target'];
        }

        
        $query6 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 06 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query6 as $data6) {
            $kabupaten6[] = $data6['kabupaten'];
            $jumlah6[] = $data6['jumlah'];
            $jumlahP6[] = $data6['jumlahP'];
            $jumlahL6[] = $data6['jumlahL'];
            $target6[] = $data6['target'];
        }

        
        $query7 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 07 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query7 as $data7) {
            $kabupaten7[] = $data7['kabupaten'];
            $jumlah7[] = $data7['jumlah'];
            $jumlahP7[] = $data7['jumlahP'];
            $jumlahL7[] = $data7['jumlahL'];
            $target7[] = $data7['target'];
        }

        
        $query8 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 08 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query8 as $data8) {
            $kabupaten8[] = $data8['kabupaten'];
            $jumlah8[] = $data8['jumlah'];
            $jumlahP8[] = $data8['jumlahP'];
            $jumlahL8[] = $data8['jumlahL'];
            $target8[] = $data8['target'];
        }

        
        $query9 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 09 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query9 as $data9) {
            $kabupaten9[] = $data9['kabupaten'];
            $jumlah9[] = $data9['jumlah'];
            $jumlahP9[] = $data9['jumlahP'];
            $jumlahL9[] = $data9['jumlahL'];
            $target9[] = $data9['target'];
        }

        
        $query10 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 10 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query10 as $data10) {
            $kabupaten10[] = $data10['kabupaten'];
            $jumlah10[] = $data10['jumlah'];
            $jumlahP10[] = $data10['jumlahP'];
            $jumlahL10[] = $data10['jumlahL'];
            $target10[] = $data10['target'];
        }

        
        $query11 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 11 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query11 as $data11) {
            $kabupaten11[] = $data11['kabupaten'];
            $jumlah11[] = $data11['jumlah'];
            $jumlahP11[] = $data11['jumlahP'];
            $jumlahL11[] = $data11['jumlahL'];
            $target11[] = $data11['target'];
        }

        
        $query12 = $con->query("
            SELECT kabupaten.nama_kabupaten as kabupaten, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm THEN 1 ELSE 0 END) as jumlah, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND data_individu.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlahP, 
            SUM(CASE WHEN antigen.id_antigen=$antigenForm AND imunisasi.status='sudah' AND MONTH(imunisasi.tanggal_pemberian) = 12 AND YEAR(imunisasi.tanggal_pemberian) = $tahunForm AND  data_individu.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlahL, 
            ROUND((ROUND(AVG(kabupaten.surviving_infant_L + kabupaten.surviving_infant_P),0))*(SELECT (antigen.target_tahunan/100) FROM antigen WHERE antigen.id_antigen=$antigenForm)) as target
        FROM kampung 
            LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
            LEFT JOIN imunisasi ON imunisasi.id_anak = data_individu.id_anak
            LEFT JOIN antigen ON imunisasi.id_antigen = antigen.id_antigen
            LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
            LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
                WHERE kabupaten.id_kabupaten != 0
        GROUP BY kabupaten.id_kabupaten
        ORDER BY kabupaten.id_kabupaten
        ");

        foreach ($query12 as $data12) {
            $kabupaten12[] = $data12['kabupaten'];
            $jumlah12[] = $data12['jumlah'];
            $jumlahP12[] = $data12['jumlahP'];
            $jumlahL12[] = $data12['jumlahL'];
            $target12[] = $data12['target'];
        }
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
        labels: <?php echo json_encode($kabupaten) ?>,
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
            },
          }]

        },
        title: {
            display: true,
            text: 'Target dan Realisasi Tahunan Tiap Kabupaten',
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
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Realisasi Imunisasi Tiap Kabupaten Bulan Januari',
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
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Realisasi Imunisasi Tiap Kabupaten Bulan Februari',
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
        labels: <?php echo json_encode($kabupaten3) ?>,
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
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Realisasi Imunisasi Tiap Kabupaten Bulan Maret',
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
        labels: <?php echo json_encode($kabupaten4) ?>,
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
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Realisasi Imunisasi Tiap Kabupaten Bulan April',
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
        labels: <?php echo json_encode($kabupaten5) ?>,
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
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Realisasi Imunisasi Tiap Kabupaten Bulan Mei',
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
        labels: <?php echo json_encode($kabupaten6) ?>,
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
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Realisasi Imunisasi Tiap Kabupaten Bulan Juni',
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
        labels: <?php echo json_encode($kabupaten7) ?>,
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
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Realisasi Imunisasi Tiap Kabupaten Bulan Juli',
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
        labels: <?php echo json_encode($kabupaten8) ?>,
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
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Realisasi Imunisasi Tiap Kabupaten Bulan Agustus',
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
        labels: <?php echo json_encode($kabupaten9) ?>,
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
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Realisasi Imunisasi Tiap Kabupaten Bulan September',
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
        labels: <?php echo json_encode($kabupaten10) ?>,
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
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Realisasi Imunisasi Tiap Kabupaten Bulan Oktober',
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
        labels: <?php echo json_encode($kabupaten11) ?>,
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
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Realisasi Imunisasi Tiap Kabupaten Bulan November',
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
        labels: <?php echo json_encode($kabupaten12) ?>,
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
                      }
                  }]
                },
        title: {
            display: true,
            text: 'Realisasi Imunisasi Tiap Kabupaten Bulan Desember',
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