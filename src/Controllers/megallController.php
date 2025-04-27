<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'delete-st') {
                deleteMegall();
            }
            if ($_POST['action'] === 'modify') {
                modifyAllomas();
            }
        } else {
            createMegall();
        }
    }



    function createMegall() 
    {
        echo "Lefutok";
        include __DIR__ . '/../Database/connection.php';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stopid = intval($_POST['stopid']);
            $sid = intval($_POST['sid']);
            $tnum = intval($_POST['tnum']);

            $arriveTimeRaw = $_POST['arrive-time'];
            $startTimeRaw = $_POST['start-time'];

            $arriveTime = !empty($arriveTimeRaw) ? date('d-m-Y H:i:s', strtotime($arriveTimeRaw)) : null;
            $startTime = !empty($startTimeRaw) ? date('d-m-Y H:i:s', strtotime($startTimeRaw)) : null;

            // Oracle kapcsolat ellenőrzés
            if (!$conn) {
                $e = oci_error();
                die("Csatlakozási hiba: " . htmlentities($e['message']));
            }

            // Az SQL így nézne ki:
            $sql = "INSERT INTO MEGALL (ID, ALLOMAS_ID, JARAT_JARATSZAM, ERKEZES, INDULAS)
                    VALUES (:id ,:stationid, :tnum, " .
                    (is_null($arriveTime) ? "NULL" : "TO_DATE(:arriveTime, 'DD-MM-YYYY HH24:MI:SS')") . ", " .
                    (is_null($startTime) ? "NULL" : "TO_DATE(:startTime, 'DD-MM-YYYY HH24:MI:SS')") .
                    ")";

            $stid = oci_parse($conn, $sql);

            oci_bind_by_name($stid, ':id', $stopid);
            oci_bind_by_name($stid, ':stationid', $sid);
            oci_bind_by_name($stid, ':tnum', $tnum);

            if (!is_null($arriveTime)) {
                oci_bind_by_name($stid, ':arriveTime', $arriveTime);
            }
            if (!is_null($startTime)) {
                oci_bind_by_name($stid, ':startTime', $startTime);
            }

            oci_execute($stid);

            oci_free_statement($stid);
            oci_close($conn);

            echo "✅ Állomás és járat kapcsolata rögzítve!";
            header('Location: ../../pages/admin.php');
            exit();

        }
    }

    function deleteMegall() {
        include __DIR__ . '/../Database/connection.php';

        $azonosito = intval($_POST['stopid']);

        $stid = oci_parse($conn, 'DELETE FROM MEGALL WHERE ID = :azonosito');
        oci_bind_by_name($stid, ':azonosito', $azonosito);
        
        oci_execute($stid);

        oci_free_statement($stid);
        oci_close($conn);

        header('Location: ../../pages/admin.php');
    }

    function modifyMegall() 
    {
        echo "Lefutok";
        include __DIR__ . '/../Database/connection.php';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stopid = intval($_POST['stopid']);
            $sid = intval($_POST['sid']);
            $tnum = intval($_POST['tnum']);

            $arriveTimeRaw = $_POST['arrive-time'];
            $startTimeRaw = $_POST['start-time'];

            $arriveTime = !empty($arriveTimeRaw) ? date('d-m-Y H:i:s', strtotime($arriveTimeRaw)) : null;
            $startTime = !empty($startTimeRaw) ? date('d-m-Y H:i:s', strtotime($startTimeRaw)) : null;

            // Oracle kapcsolat ellenőrzés
            if (!$conn) {
                $e = oci_error();
                die("Csatlakozási hiba: " . htmlentities($e['message']));
            }

            // Az SQL így nézne ki:
            $sql = "UPDATE MEGALL 
            SET ALLOMAS_ID = :stationid, 
                JARAT_JARATSZAM = :tnum, 
                ERKEZES = " . (is_null($arriveTime) ? "NULL" : "TO_DATE(:arriveTime, 'DD-MM-YYYY HH24:MI:SS')") . ", 
                INDULAS = " . (is_null($startTime) ? "NULL" : "TO_DATE(:startTime, 'DD-MM-YYYY HH24:MI:SS')") . "
            WHERE ID = :id";
    

            $stid = oci_parse($conn, $sql);

            oci_bind_by_name($stid, ':id', $stopid);
            oci_bind_by_name($stid, ':stationid', $sid);
            oci_bind_by_name($stid, ':tnum', $tnum);

            if (!is_null($arriveTime)) {
                oci_bind_by_name($stid, ':arriveTime', $arriveTime);
            }
            if (!is_null($startTime)) {
                oci_bind_by_name($stid, ':startTime', $startTime);
            }

            oci_execute($stid);

            oci_free_statement($stid);
            oci_close($conn);

            echo "✅ Állomás és járat kapcsolata rögzítve!";
            header('Location: ../../pages/admin.php');
            exit();

        }
    }

    function getMegallL() {
        include ROOT_PATH . 'src/Database/connection.php';
    
        $stid = oci_parse($conn, 'SELECT * FROM MEGALL');
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

