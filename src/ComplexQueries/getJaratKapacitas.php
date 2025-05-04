<?php

function getJaratKapacitas() {
    include ROOT_PATH . 'src/Database/connection.php';

    $stid = oci_parse($conn, '
    SELECT j.jaratszam, s.kapacitas
    FROM jarat j
    JOIN szerelveny s ON j.szerelveny_mozdonyszam = s.mozdonyszam
    ORDER BY s.kapacitas DESC
    FETCH FIRST 1 ROWS ONLY
    ');

    if (!oci_execute($stid)) {
        $e = oci_error($stid);
        return "SQL Hiba: " . $e['message'];
    }

    $row = oci_fetch_assoc($stid);

    return $row;
}