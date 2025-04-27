<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete-t') {
            deleteTag();
        }
        if ($_POST['action'] === 'modify') {
            modifyTag();
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

function modifyTag() {
    include __DIR__ . '/../Database/connection.php';

    
    $email = $_POST['email'];
    $newemail = $_POST['newmail'];
    $nev = $_POST['name'];

    $stid = oci_parse($conn, 'UPDATE TAG SET EMAIL = :email, NEV = :nev WHERE EMAIL = :azonosito');
    oci_bind_by_name($stid, ':azonosito', $email);
    oci_bind_by_name($stid, ':nev', $nev);
    oci_bind_by_name($stid, ':email', $newemail);
    
    oci_execute($stid);

    oci_free_statement($stid);
    oci_close($conn);

    header('Location: ../../pages/admin.php');
}
?>