<?php

function getTulajdonos($email) {
    include ROOT_PATH . 'src/Database/connection.php';

    $stid = oci_parse($conn, 'SELECT * FROM TULAJDONOS WHERE TAG_EMAIL = :email');
    oci_bind_by_name($stid, ':email', $email);
    oci_execute($stid);

    $rows = [];
    while ($row = oci_fetch_assoc($stid)) {
        $rows[] = $row;
    }

    if (count($rows) == 0) {
        oci_free_statement($stid);
        oci_close($conn);
        return null;
    }

    oci_free_statement($stid);
    oci_close($conn);
    return $rows;
}

function getJegy($azonosito) {
    include ROOT_PATH . 'src/Database/connection.php';

    $stid = oci_parse($conn, 'SELECT * FROM JEGY WHERE AZONOSITO = :azonosito');
    oci_bind_by_name($stid, ':azonosito', $azonosito);
    oci_execute($stid);

    $row = oci_fetch_assoc($stid);

    if (!$row) {
        oci_free_statement($stid);
        oci_close($conn);
        return null;
    }

    oci_free_statement($stid);
    oci_close($conn);
    return $row;
}
