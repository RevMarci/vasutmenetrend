<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete-a') {
            deleteAdmin();
        }
        if ($_POST['action'] === 'modify') {
            modifyAdmin();
        }
    } else {
        // Alapértelmezett, ha nincs megadva action
        
    }
}

function deleteAdmin() {
    include __DIR__ . '/../Database/connection.php';

    $azonosito = intval($_POST['anum']);

    $stid = oci_parse($conn, 'DELETE FROM ADMIN WHERE ADMIN_ID = :azonosito');
    oci_bind_by_name($stid, ':azonosito', $azonosito);
    
    oci_execute($stid);

    oci_free_statement($stid);
    oci_close($conn);

    header('Location: ../../pages/admin.php');
}

function modifyAdmin() {
    include __DIR__ . '/../Database/connection.php';

    $azonosito = intval($_POST['anum']);
    $email = $_POST['email'];
    $nev = $_POST['name'];

    $stid = oci_parse($conn, 'UPDATE ADMIN SET EMAIL = :email, NEV = :nev WHERE ADMIN_ID = :azonosito');
    oci_bind_by_name($stid, ':azonosito', $azonosito);
    oci_bind_by_name($stid, ':nev', $nev);
    oci_bind_by_name($stid, ':email', $email);
    
    oci_execute($stid);

    oci_free_statement($stid);
    oci_close($conn);

    header('Location: ../../pages/admin.php');
}

function getAdminL() {
    include ROOT_PATH . 'src/Database/connection.php';

    $stid = oci_parse($conn, 'SELECT * FROM ADMIN');
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