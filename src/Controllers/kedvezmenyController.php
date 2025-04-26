<?php
    echo "Itt vagyok!";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        createKedvezmeny();
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
?>

