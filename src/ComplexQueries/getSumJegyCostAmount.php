<?php

function getSumJegyCostAmount() {
    include ROOT_PATH . 'src/Database/connection.php';

    $stid = oci_parse($conn, '
    SELECT v.FIZETESI_MOD, COUNT(j.azonosito) AS darabszam, SUM(j.jegyar) AS osszeg
    FROM vasarlas v
    JOIN JEGY j ON v.id = j.vasarlas_id
    GROUP BY v.fizetesi_mod
    ');

    if (!oci_execute($stid)) {
        $e = oci_error($stid);
        return "SQL Hiba: " . $e['message'];
    }

    $rows = [];
    while ($row = oci_fetch_assoc($stid)) {
        $rows[] = $row;
    }

    return $rows;
}