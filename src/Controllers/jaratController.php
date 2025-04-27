<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'delete-t') {
                deleteJarat();
            }
            if ($_POST['action'] === 'modify') {
                modifyJarat();
            }
        } else {
            createJarat();
        }
    }



    function createJarat() 
    {
        echo "Lefutok";
        include __DIR__ . '/../Database/connection.php';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tnum = intval($_POST['tnum']);
            $ttype = $_POST['ttype'];
            $lnum = intval($_POST['lnum']);

            if (!$conn) {
                $e = oci_error();
                die("Csatlakozási hiba: " . htmlentities($e['message']));
            }

            $sql = "INSERT INTO JARAT (JARATSZAM, TIPUS, SZERELVENY_MOZDONYSZAM)
                    VALUES (:jszam, :tipus, :mszam)";

            $stid = oci_parse($conn, $sql);

            
            oci_bind_by_name($stid, ':jszam', $tnum);
            oci_bind_by_name($stid, ':tipus', $ttype);
            oci_bind_by_name($stid, ':mszam', $lnum);
            oci_execute($stid);

            

            oci_free_statement($stid);
            oci_close($conn);

            echo "✅ Járat sikeresen rögzítve!";
            header('Location: ../../pages/admin.php');
        }
    }

    function deleteJarat() {
        include __DIR__ . '/../Database/connection.php';

        $azonosito = intval($_POST['tnum']);

        $stid = oci_parse($conn, 'DELETE FROM JARAT WHERE JARATSZAM = :azonosito');
        oci_bind_by_name($stid, ':azonosito', $azonosito);
        
        oci_execute($stid);

        oci_free_statement($stid);
        oci_close($conn);

        header('Location: ../../pages/admin.php');
    }

    function modifyJarat() 
    {
        echo "Lefutok";
        include __DIR__ . '/../Database/connection.php';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tnum = intval($_POST['tnum']);
            $ttype = $_POST['ttype'];
            $lnum = intval($_POST['lnum']);

            if (!$conn) {
                $e = oci_error();
                die("Csatlakozási hiba: " . htmlentities($e['message']));
            }

            $sql = "UPDATE JARAT 
            SET TIPUS = :tipus, SZERELVENY_MOZDONYSZAM = :mszam 
            WHERE JARATSZAM = :jszam";


            $stid = oci_parse($conn, $sql);

            
            oci_bind_by_name($stid, ':jszam', $tnum);
            oci_bind_by_name($stid, ':tipus', $ttype);
            oci_bind_by_name($stid, ':mszam', $lnum);
            oci_execute($stid);

            

            oci_free_statement($stid);
            oci_close($conn);

            echo "✅ Járat sikeresen rögzítve!";
            header('Location: ../../pages/admin.php');
        }
    }

    function getJaratL() {
        include ROOT_PATH . 'src/Database/connection.php';
    
        $stid = oci_parse($conn, 'SELECT * FROM JARAT');
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

