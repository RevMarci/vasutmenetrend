<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete-t') {
            deleteJegy();
        }
        /*if ($_POST['action'] === 'delete-b') {
            deleteJegy();
        }*/
    } else {
        // Alapértelmezett, ha nincs megadva action
        jegyVasarlas();
    }
}


function getJegy($email) {
    include ROOT_PATH . 'src/Database/connection.php';

    $stid = oci_parse($conn, 'SELECT * FROM JEGY WHERE TAG_EMAIL = :email');
    oci_bind_by_name($stid, ':email', $email);
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

function getJegyL() {
    include ROOT_PATH . 'src/Database/connection.php';

    $stid = oci_parse($conn, 'SELECT * FROM JEGY');
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

function jegyVasarlas(){
    include __DIR__ . '/../Database/connection.php';
    $ticketnum = intval($_POST['ticketnum']);
    $tnum = intval($_POST['tnum']);
    //$bnum = intval($_POST['bnum']);
    $untilTimeRaw = $_POST['until-time'];
    $tcost = intval($_POST['tcost']);
    $dnum = intval($_POST['dnum']);
    $uemail = $_POST['uemail'];
    $mode = "Bankkártya";


    // Oracle kapcsolat ellenőrzés
    if (!$conn) {
        $e = oci_error();
        die("Csatlakozási hiba: " . htmlentities($e['message']));
    }

    // Idők átalakítása
    $untilTime = date('d-m-Y H:i:s', strtotime($_POST['until-time']));
    //$dateNow = date('d-m-Y H:i:s');

    // Get vasarlas next ID - $bnum
    $sql = 'BEGIN get_next_vasarlas_id(:next_id); END;';
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':next_id', $bnum, 10);
    oci_execute($stid);

    
    // Először a VASARLAS INSERT
    $sql1 = "INSERT INTO VASARLAS (ID, FIZETESI_MOD) 
    VALUES (:bnum, :paymode)";

    $stid1 = oci_parse($conn, $sql1);

    // Bind-olás a VASARLAS paraméterekhez
    oci_bind_by_name($stid1, ':bnum', $bnum);
    //oci_bind_by_name($stid1, ':datenow', $dateNow);
    oci_bind_by_name($stid1, ':paymode', $mode);

    // Végrehajtás
    oci_execute($stid1);

    // Most a JEGY INSERT
    $sql2 = "INSERT INTO JEGY (AZONOSITO, JARAT_JARATSZAM, VASARLAS_ID, ERVENYESSEG, JEGYAR, KEDVEZMENYEK_ID, TAG_EMAIL)
    VALUES (:ticketnum, :tnum, :bnum, TO_DATE(:untilTime, 'DD-MM-YYYY HH24:MI:SS'), :tcost, :dnum, :uemail)";

    $stid2 = oci_parse($conn, $sql2);

    // Bind-olás a JEGY paraméterekhez
    oci_bind_by_name($stid2, ':ticketnum', $ticketnum);
    oci_bind_by_name($stid2, ':tnum', $tnum);
    oci_bind_by_name($stid2, ':bnum', $bnum);
    oci_bind_by_name($stid2, ':untilTime', $untilTime);
    oci_bind_by_name($stid2, ':tcost', $tcost);
    oci_bind_by_name($stid2, ':dnum', $dnum);
    oci_bind_by_name($stid2, ':uemail', $uemail);

    // Végrehajtás
    oci_execute($stid2);

    // Mindig zárd le a statementeket
    oci_free_statement($stid1);
    oci_free_statement($stid2);

    // Zárd le a kapcsolatot
    oci_close($conn);

   
    echo "✅ Jegy sikeresen rögzítve!";
    header('Location: ../../pages/jegyvasarlas.php');
    exit();

}

function deleteJegy() {
    include __DIR__ . '/../Database/connection.php';

    $azonosito = intval($_POST['ticketnum']);

    $stid = oci_parse($conn, 'DELETE FROM JEGY WHERE AZONOSITO = :azonosito');
    oci_bind_by_name($stid, ':azonosito', $azonosito);
    
    oci_execute($stid);

    /*if ($success) {
        oci_commit($conn);
    } else {
        oci_rollback($conn);
    }*/

    oci_free_statement($stid);
    oci_close($conn);

    //return $success;
    header('Location: ../../pages/admin.php');
}