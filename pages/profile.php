<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['login'] == '' || $_SESSION['login'] == null || !isset($_SESSION['login'])) {
    header("Location: ../../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/vasutmenetrend/css/style.css">
    <link rel="stylesheet" href="/vasutmenetrend/css/header.css">
    <link rel="stylesheet" href="/vasutmenetrend/css/profile.css">
    <title>SnailRail</title>
</head>
<body>
    <?php require_once '../config.php'; ?>
    <?php require_once ROOT_PATH . 'shared/header.php'; ?>

    <div class="centerDiv">
        <h1>Profil</h1>
        <p>Név: <?php echo $_SESSION['userName'] ?></p>
        <p>Email: <?php echo $_SESSION['userEmail'] ?></p>
        <h2>Profilhoz tartozó jegyek:</h2>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        

        require_once '../src/Controllers/jegyController.php';
        
        $rows = getJegy($_SESSION['userEmail']);
        /*
        echo '<pre>';
        print_r($rows);
        echo '</pre>';
        */
        
        if ($rows === null || count($rows) === 0) {
            echo "Nincs találat.";
        } else {
            foreach ($rows as $row) {
                echo
                '<details>
                    <summary>Jegy azonosítója: ' . $row['AZONOSITO'] . '</summary>
                    <hr>
                    <ul>
                        <li>Járat szám: ' . $row['JARAT_JARATSZAM'] . '</li>
                        <li>Vásárlás szám: ' . $row['VASARLAS_ID'] . '</li>
                        <li>Érvényesség: ' . $row['ERVENYESSEG'] . '</li>
                        <li>Jegyár: ' . $row['JEGYAR'] . '</li>
                        <li>Kedvezmény szám: ' . $row['KEDVEZMENYEK_ID'] . '</li>
                    </ul>
                </details>'
                ;
            }
        }
        ?>

        <h2>Vásárlások:</h2>
        <?php
        require_once '../src/Controllers/jegyController.php';
        require_once '../src/Controllers/vasarlasController.php';

        $jegyRows = getJegy($_SESSION['userEmail']);
        if ($jegyRows === null || count($rows) === 0) {
            echo "Nincs találat.";
        } else {
            foreach ($jegyRows as $jegy) {
                $vasarlasRow = getVasarlas($jegy['VASARLAS_ID']);
                foreach ($vasarlasRow as $vasarlas) {
                    echo
                    '<details>
                        <summary>Vasarlas azonosítója: ' . $vasarlas['ID'] . '</summary>
                        <hr>
                        <ul>
                            <li>Vásárlás dátuma: ' . $vasarlas['DATUM'] . '</li>
                            <li>Fizetési mód: ' . $vasarlas['FIZETESI_MOD'] . '</li>
                        </ul>
                    </details>'
                    ;
                }
            }
        }
        ?>

        <a href="../src/Auth/logout.php">
            <button class="purpleButton">Kilépés</button>
        </a>
    </div>
</body>
</html>