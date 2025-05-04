<?php

function getTag_JegyCount() {
    include ROOT_PATH . 'src/Database/connection.php';

    $stid = oci_parse($conn, '
    SELECT t.email, COUNT(j.AZONOSITO) AS jegyek_szama
    FROM TAG t
    JOIN JEGY j ON t.EMAIL = j.TAG_EMAIL
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