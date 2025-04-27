<?php
    echo "Itt vagyok!";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'delete-s') {
                deleteAllomas();
            }
            if ($_POST['action'] === 'modify') {
                modifyAllomas();
            }
        } else {
            createAllomas();
        }
    }


    function createAllomas() 
    {
        echo "Lefutok";
        include __DIR__ . '/../Database/connection.php';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['sname'];
            $place = $_POST['splace'];
            $id = $_POST['sid'];

            if (!$conn) {
                $e = oci_error();
                die("Csatlakozási hiba: " . htmlentities($e['message']));
            }

            $sql = "INSERT INTO ALLOMAS (ID, NEV, HELY)
                    VALUES (:id, :nev, :hely)";

            $stid = oci_parse($conn, $sql);

            oci_bind_by_name($stid, ':id', $id);
            oci_bind_by_name($stid, ':nev', $name);
            oci_bind_by_name($stid, ':hely', $place);
            oci_execute($stid);

            

            oci_free_statement($stid);
            oci_close($conn);

            echo "✅ Állomás sikeresen rögzítve!";
            header('Location: ../../pages/admin.php');
        }
    }

    function deleteAllomas() {
        include __DIR__ . '/../Database/connection.php';

        $azonosito = intval($_POST['sid']);

        $stid = oci_parse($conn, 'DELETE FROM ALLOMAS WHERE ID = :azonosito');
        oci_bind_by_name($stid, ':azonosito', $azonosito);
        
        oci_execute($stid);

        oci_free_statement($stid);
        oci_close($conn);

        header('Location: ../../pages/admin.php');
    }

    function modifyAllomas() 
    {
        echo "Lefutok";
        include __DIR__ . '/../Database/connection.php';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['sname'];
            $place = $_POST['splace'];
            $id = $_POST['sid'];

            if (!$conn) {
                $e = oci_error();
                die("Csatlakozási hiba: " . htmlentities($e['message']));
            }

            $sql = "UPDATE ALLOMAS 
            SET NEV = :nev, HELY = :hely 
            WHERE ID = :id";


            $stid = oci_parse($conn, $sql);

            oci_bind_by_name($stid, ':id', $id);
            oci_bind_by_name($stid, ':nev', $name);
            oci_bind_by_name($stid, ':hely', $place);
            oci_execute($stid);

            

            oci_free_statement($stid);
            oci_close($conn);

            echo "✅ Állomás sikeresen rögzítve!";
            header('Location: ../../pages/admin.php');
        }
    }
?>

