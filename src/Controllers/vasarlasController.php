<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete-b') {
            deleteVasarlas();
        }
    } else {
        // Alapértelmezett, ha nincs megadva action
        
    }
}

function deleteVasarlas() {
    include __DIR__ . '/../Database/connection.php';

    $azonosito = $_POST['bnum'];

    $stid = oci_parse($conn, 'DELETE FROM VASARLAS WHERE ID = :azonosito');
    oci_bind_by_name($stid, ':azonosito', $azonosito);
    
    oci_execute($stid);

    oci_free_statement($stid);
    oci_close($conn);

    header('Location: ../../pages/admin.php');
}

function getVasarlas($azonosito) {
    include ROOT_PATH . 'src/Database/connection.php';

    $stid = oci_parse($conn, 'SELECT * FROM VASARLAS WHERE ID = :id');
    oci_bind_by_name($stid, ':id', $azonosito);
    oci_execute($stid);

    if (!oci_execute($stid)) {
        $e = oci_error($stid);
        return "SQL Hiba: " . $e['message'];
    }

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

function getVasarlasL() {
    include ROOT_PATH . 'src/Database/connection.php';

    $stid = oci_parse($conn, 'SELECT * FROM VASARLAS');
    oci_execute($stid);

    if (!oci_execute($stid)) {
        $e = oci_error($stid);
        return "SQL Hiba: " . $e['message'];
    }
    

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
?>