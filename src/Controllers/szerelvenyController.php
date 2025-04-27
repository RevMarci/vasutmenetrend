<?php
    echo "Itt vagyok!";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'delete-l') {
                deleteSzerelveny();
            }
            if ($_POST['action'] === 'modify') {
                modifySzerelveny();
            }
        } else {
            createSzerelveny();
        }
    }

    function createSzerelveny() 
    {
        echo "Lefutok";
        include __DIR__ . '/../Database/connection.php';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lNum = intval($_POST['lnum']);
            $lCapacity = intval($_POST['lcapacity']);
        
            if (!$conn) {
                $e = oci_error();
                die("Csatlakozási hiba: " . htmlentities($e['message']));
            }
        
            $sql = "INSERT INTO SZERELVENY (MOZDONYSZAM, KAPACITAS)
                    VALUES (:ln, :lc)";
        
            $stid = oci_parse($conn, $sql);
        
            oci_bind_by_name($stid, ':ln', $lNum);
            oci_bind_by_name($stid, ':lc', $lCapacity);
        
            oci_execute($stid);
        
            oci_free_statement($stid);
            oci_close($conn);
        
            // Sikeres beszúrás után visszairányítás admin felületre
            header('Location: ../../pages/admin.php');
        }
    }

   


    function deleteSzerelveny() {
        include __DIR__ . '/../Database/connection.php';

        $azonosito = intval($_POST['lnum']);

        $stid = oci_parse($conn, 'DELETE FROM SZERELVENY WHERE MOZDONYSZAM = :azonosito');
        oci_bind_by_name($stid, ':azonosito', $azonosito);
        
        oci_execute($stid);

        oci_free_statement($stid);
        oci_close($conn);

        header('Location: ../../pages/admin.php');
    }

    function modifySzerelveny() 
    {
        echo "Lefutok";
        include __DIR__ . '/../Database/connection.php';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lNum = intval($_POST['lnum']);
            $lCapacity = intval($_POST['lcapacity']);
        
            if (!$conn) {
                $e = oci_error();
                die("Csatlakozási hiba: " . htmlentities($e['message']));
            }
        
            $sql = "UPDATE SZERELVENY SET KAPACITAS = :lc WHERE MOZDONYSZAM = :ln";
        
            $stid = oci_parse($conn, $sql);
        
            oci_bind_by_name($stid, ':ln', $lNum);
            oci_bind_by_name($stid, ':lc', $lCapacity);
        
            oci_execute($stid);
        
            oci_free_statement($stid);
            oci_close($conn);
        
            // Sikeres beszúrás után visszairányítás admin felületre
            header('Location: ../../pages/admin.php');
        }
    }
?>

