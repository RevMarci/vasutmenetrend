<?php
function getKereses() {
    global $conn;
    $sql = "SELECT ID, NEV, HELY FROM ALLOMAS ORDER BY NEV";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    $rows = [];
    while ($r = oci_fetch_assoc($stmt)) {
        $rows[] = $r;
    }
    oci_free_statement($stmt);
    return $rows;
}