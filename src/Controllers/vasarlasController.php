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
?>