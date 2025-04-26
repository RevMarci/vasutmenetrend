<?php
    echo "Itt vagyok!";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        createAllomas();
    }



    function createAllomas() 
    {
        echo "Lefutok";
        include __DIR__ . '/../Database/connection.php';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['sname'];
            $place = $_POST['splace'];
            $id = $_POST['sid'];

            //echo $name;
            //echo $hely;
            //echo $id;

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
?>

