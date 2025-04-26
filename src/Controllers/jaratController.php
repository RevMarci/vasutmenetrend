<?php
    echo "Itt vagyok!";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        createJarat();
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
?>

