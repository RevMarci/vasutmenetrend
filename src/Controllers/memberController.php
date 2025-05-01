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

    //header('Location: ../../pages/admin.php');
}

function getTagL() {
    include ROOT_PATH . 'src/Database/connection.php';

    $stid = oci_parse($conn, 'SELECT * FROM TAG');
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