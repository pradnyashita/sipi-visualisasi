<!-- QUARTER 1 -->

<?php

SELECT kabupaten.nama_kabupaten as kabupaten, 
	puskesmas.nama_puskesmas as puskesmas,
    kampung.nama_kampung as kampung,
    SUM(CASE WHEN data_individu.idl = 1 AND (MONTH(data_individu.tanggal_idl) = 01 OR MONTH(data_individu.tanggal_idl) = 02 OR MONTH(data_individu.tanggal_idl) = 03) AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl,
    ROUND((kampung.surviving_infant_L + kampung.surviving_infant_P)*0.2) as sasaran,
    ROUND((SUM(CASE WHEN data_individu.idl = 1 AND (MONTH(data_individu.tanggal_idl) = 01 OR MONTH(data_individu.tanggal_idl) = 02 OR MONTH(data_individu.tanggal_idl) = 03) AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END))/(ROUND((kampung.surviving_infant_L + kampung.surviving_infant_P)*0.2))*100) as ketercapaian,
    (CASE WHEN ((SUM(CASE WHEN data_individu.idl = 1 AND (MONTH(data_individu.tanggal_idl) = 01 OR MONTH(data_individu.tanggal_idl) = 02 OR MONTH(data_individu.tanggal_idl) = 03) AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END))/(ROUND((kampung.surviving_infant_L + kampung.surviving_infant_P)*0.2))*100) > 20 THEN 'UCI' ELSE 'Non-UCI' END) as uci
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
          AND puskesmas.id_puskesmas = $puskesmasForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        

?>


<!-- QUARTER 2 -->

<?php

SELECT kabupaten.nama_kabupaten as kabupaten, 
	puskesmas.nama_puskesmas as puskesmas,
    kampung.nama_kampung as kampung,
    SUM(CASE WHEN data_individu.idl = 1 AND (MONTH(data_individu.tanggal_idl) = 01 OR MONTH(data_individu.tanggal_idl) = 02 OR MONTH(data_individu.tanggal_idl) = 03 OR MONTH(data_individu.tanggal_idl) = 04 OR MONTH(data_individu.tanggal_idl) = 05 OR MONTH(data_individu.tanggal_idl) = 06) AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl,
    ROUND((kampung.surviving_infant_L + kampung.surviving_infant_P)*0.4) as sasaran,
    ROUND((SUM(CASE WHEN data_individu.idl = 1 AND (MONTH(data_individu.tanggal_idl) = 01 OR MONTH(data_individu.tanggal_idl) = 02 OR MONTH(data_individu.tanggal_idl) = 03 OR MONTH(data_individu.tanggal_idl) = 04 OR MONTH(data_individu.tanggal_idl) = 05 OR MONTH(data_individu.tanggal_idl) = 06) AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END))/(ROUND((kampung.surviving_infant_L + kampung.surviving_infant_P)*0.4))*100) as ketercapaian,
    (CASE WHEN ((SUM(CASE WHEN data_individu.idl = 1 AND (MONTH(data_individu.tanggal_idl) = 01 OR MONTH(data_individu.tanggal_idl) = 02 OR MONTH(data_individu.tanggal_idl) = 03 OR MONTH(data_individu.tanggal_idl) = 04 OR MONTH(data_individu.tanggal_idl) = 05 OR MONTH(data_individu.tanggal_idl) = 06) AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END))/(ROUND((kampung.surviving_infant_L + kampung.surviving_infant_P)*0.4))*100) > 40 THEN 'UCI' ELSE 'Non-UCI' END) as uci
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
          AND puskesmas.id_puskesmas = $puskesmasForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        

?>

<!-- QUARTER 3 -->

<?php

SELECT kabupaten.nama_kabupaten as kabupaten, 
	puskesmas.nama_puskesmas as puskesmas,
    kampung.nama_kampung as kampung,
    SUM(CASE WHEN data_individu.idl = 1 AND (MONTH(data_individu.tanggal_idl) = 01 OR MONTH(data_individu.tanggal_idl) = 02 OR MONTH(data_individu.tanggal_idl) = 03 OR MONTH(data_individu.tanggal_idl) = 04 OR MONTH(data_individu.tanggal_idl) = 05 OR MONTH(data_individu.tanggal_idl) = 06 OR MONTH(data_individu.tanggal_idl) = 07 OR MONTH(data_individu.tanggal_idl) = 08 OR MONTH(data_individu.tanggal_idl) = 09) AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl,
    ROUND((kampung.surviving_infant_L + kampung.surviving_infant_P)*0.6) as sasaran,
    ROUND((SUM(CASE WHEN data_individu.idl = 1 AND (MONTH(data_individu.tanggal_idl) = 01 OR MONTH(data_individu.tanggal_idl) = 02 OR MONTH(data_individu.tanggal_idl) = 03 OR MONTH(data_individu.tanggal_idl) = 04 OR MONTH(data_individu.tanggal_idl) = 05 OR MONTH(data_individu.tanggal_idl) = 06 OR MONTH(data_individu.tanggal_idl) = 07 OR MONTH(data_individu.tanggal_idl) = 08 OR MONTH(data_individu.tanggal_idl) = 09) AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END))/(ROUND((kampung.surviving_infant_L + kampung.surviving_infant_P)*0.6))*100) as ketercapaian,
    (CASE WHEN ((SUM(CASE WHEN data_individu.idl = 1 AND (MONTH(data_individu.tanggal_idl) = 01 OR MONTH(data_individu.tanggal_idl) = 02 OR MONTH(data_individu.tanggal_idl) = 03 OR MONTH(data_individu.tanggal_idl) = 04 OR MONTH(data_individu.tanggal_idl) = 05 OR MONTH(data_individu.tanggal_idl) = 06 OR MONTH(data_individu.tanggal_idl) = 07 OR MONTH(data_individu.tanggal_idl) = 08 OR MONTH(data_individu.tanggal_idl) = 09) AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END))/(ROUND((kampung.surviving_infant_L + kampung.surviving_infant_P)*0.6))*100) > 60 THEN 'UCI' ELSE 'Non-UCI' END) as uci
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
          AND puskesmas.id_puskesmas = $puskesmasForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        

?>

<!-- QUARTER 4 -->

<?php

SELECT kabupaten.nama_kabupaten as kabupaten, 
	puskesmas.nama_puskesmas as puskesmas,
    kampung.nama_kampung as kampung,
    SUM(CASE WHEN data_individu.idl = 1 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END) as idl,
    ROUND((kampung.surviving_infant_L + kampung.surviving_infant_P)*0.8) as sasaran,
    ROUND((SUM(CASE WHEN data_individu.idl = 1 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END))/(ROUND((kampung.surviving_infant_L + kampung.surviving_infant_P)*0.8))*100) as ketercapaian,
    (CASE WHEN ((SUM(CASE WHEN data_individu.idl = 1 AND YEAR(data_individu.tanggal_idl) = $tahunForm THEN 1 ELSE 0 END))/(ROUND((kampung.surviving_infant_L + kampung.surviving_infant_P)*0.8))*100) > 80 THEN 'UCI' ELSE 'Non-UCI' END) as uci
        FROM kampung 
          LEFT JOIN data_individu ON data_individu.id_kampung = kampung.id_kampung
          LEFT JOIN puskesmas ON puskesmas.id_puskesmas = kampung.id_puskesmas
          LEFT JOIN kabupaten ON kabupaten.id_kabupaten = puskesmas.id_kabupaten
        WHERE kabupaten.id_kabupaten = $kabupatenForm
          AND puskesmas.id_puskesmas = $puskesmasForm
        GROUP BY kampung.id_kampung
        ORDER BY kampung.id_kampung
        

?>