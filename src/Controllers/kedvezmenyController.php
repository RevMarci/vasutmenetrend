<?php
    echo "Itt vagyok!";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'delete-td') {
                deleteKedvezmeny();
            }
            if ($_POST['action'] === 'modify') {
                modifyKedvezmeny();
            }
        } else {
            createKedvezmeny();
        }
    }



    function createKedvezmeny() 
    {
        echo "Lefutok";
        include __DIR__ . '/../Database/connection.php';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tdNum = intval($_POST['tdnum']);
            $tdType = $_POST['tdtype'];
            $tdMetric = intval($_POST['tdmetric']);

        
            if (!$conn) {
                $e = oci_error();
                die("Csatlakozási hiba: " . htmlentities($e['message']));
            }
        
            $sql = "INSERT INTO KEDVEZMENY (ID, TIPUS, MERTEKE)
                    VALUES (:id, :typ, :metric)";
        
            $stid = oci_parse($conn, $sql);
        
            oci_bind_by_name($stid, ':id', $tdNum);
            oci_bind_by_name($stid, ':typ', $tdType);
            oci_bind_by_name($stid, ':metric', $tdMetric);
        
            oci_execute($stid);
        
            oci_free_statement($stid);
            oci_close($conn);
        
            // Sikeres beszúrás után visszairányítás admin felületre
            header('Location: ../../pages/admin.php');
        }
    }

    function deleteKedvezmeny() {
        include __DIR__ . '/../Database/connection.php';

        $azonosito = intval($_POST['tdnum']);

        $stid = oci_parse($conn, 'DELETE FROM KEDVEZMENY WHERE ID = :azonosito');
        oci_bind_by_name($stid, ':azonosito', $azonosito);
        
        oci_execute($stid);

        oci_free_statement($stid);
        oci_close($conn);

        header('Location: ../../pages/admin.php');
    }

    function modifyKedvezmeny() 
    {
        echo "Lefutok";
        include __DIR__ . '/../Database/connection.php';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tdNum = intval($_POST['tdnum']);
            $tdType = $_POST['tdtype'];
            $tdMetric = intval($_POST['tdmetric']);

        
            if (!$conn) {
                $e = oci_error();
                die("Csatlakozási hiba: " . htmlentities($e['message']));
            }
        
            $sql = "UPDATE KEDVEZMENY 
            SET TIPUS = :typ, MERTEKE = :metric 
            WHERE ID = :id";

        
            $stid = oci_parse($conn, $sql);
        
            oci_bind_by_name($stid, ':id', $tdNum);
            oci_bind_by_name($stid, ':typ', $tdType);
            oci_bind_by_name($stid, ':metric', $tdMetric);
        
            oci_execute($stid);
        
            oci_free_statement($stid);
            oci_close($conn);
        
            // Sikeres beszúrás után visszairányítás admin felületre
            header('Location: ../../pages/admin.php');
        }
    }
?>

