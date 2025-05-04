<?php

function getLastVasarlas() {
    include ROOT_PATH . 'src/Database/connection.php';

    $stid = oci_parse($conn, '
    SELECT t.EMAIL, MAX(v.DATUM) AS utolso_vasarlas
    FROM TAG t
    JOIN JEGY j ON t.email = j.TAG_EMAIL
    JOIN VASARLAS v ON j.VASARLAS_ID = v.ID
    GROUP BY t.EMAIL
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