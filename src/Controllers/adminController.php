<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete-a') {
            deleteAdmin();
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
?>