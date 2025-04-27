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
?>