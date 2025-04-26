<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete-t') {
            deleteTag();
        }
    } else {
        // Alapértelmezett, ha nincs megadva action
        
    }
}

function deleteTag() {
    include __DIR__ . '/../Database/connection.php';

    $azonosito = $_POST['temail'];

    $stid = oci_parse($conn, 'DELETE FROM TAG WHERE EMAIL = :azonosito');
    oci_bind_by_name($stid, ':azonosito', $azonosito);
    
    oci_execute($stid);

    oci_free_statement($stid);
    oci_close($conn);

    header('Location: ../../pages/admin.php');
}
?>