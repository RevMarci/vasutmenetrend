<!--?php


?-->
<?php
session_start();

if ($_SESSION['login'] == '' || $_SESSION['login'] == null || !isset($_SESSION['login'])) {
    header("Location: ../../index.php");
    exit();
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/vasutmenetrend/css/style.css">
    <link rel="stylesheet" href="/vasutmenetrend/css/header.css">
    <link rel="stylesheet" href="/vasutmenetrend/css/admin.css">
    <title>SnailRail</title>
</head>
<body>
    <?php require_once '../config.php'; ?>
    <?php require_once ROOT_PATH . 'shared/header.php'; ?>

    <p>Profil</p>
    <?php
    echo $_SESSION['login'];
    ?>
    <a href="../src/Auth/logout.php">
        <button class="purpleButton">Kilépés</button>
    </a>

    <div class="container">
        <form class="locomotive-form" action="../src/Controllers/szerelvenyController.php" method="POST">
            <h2>Szerelvény felvétele</h2>
            <label for="lnum">Mozdonyszám:</label>
            <input type="number" id="lnum" name="lnum" required>
            
            <label for="lcapatity">Kapacitás:</label>
            <input type="number" id="lcapatity" name="lcapacity" required>
            
            <button class="felvitel" type="submit">Létrehozás</button>
        </form>

        <form class="station-form" action="../src/Controllers/allomasController.php" method="POST">
            <h2>Állomás felvétel</h2>
            <label for="station-name">Állomás azonosítója:</label>
            <input type="text" id="station-name" name="sid" required>

            <label for="station-name">Állomás neve:</label>
            <input type="text" id="station-name" name="sname" required>
            
            <label for="station-location">Állomáshoz kapcsolódó település:</label>
            <input type="text" id="station-location" name="splace" required>
            
            <button class="felvitel" type="submit">Hozzáadás</button>
        </form>

        <form class="tour-form" action="../src/Controllers/jaratController.php" method="POST">
            <h2>Járat</h2>
            <label for="tnum">Járatszám:</label>
            <input type="number" id="tnum" name="tnum" required>
            
            <label for="ttype">Szerelvény típusa:</label>
            <select id="ttype" name="ttype" required>
                <option value="Szemely">Személy</option>
                <option value="IC">IC</option>
                <option value="Gyors">Gyors</option>
                <option value="Expressz">Expressz</option>
                <option value="Zonazo">Zónázó</option>
                <option value="Gyorsszemely">Gyorsított személy</option>
                <option value="Interregio">IR</option>
                <option value="Sebes">Sebes</option>
                <option value="Teher">Teher</option>
            </select>

            <label for="lnum">Mozdonyszám:</label>
            <input type="number" id="lnum" name="lnum" required>
            
            <button class="felvitel" type="submit">Létrehozás</button>
        </form>

        <form class="ticket-discount-form" action="../src/Controllers/kedvezmenyController.php" method="POST">
            <h2>Új kezdvezmény</h2>
            <label for="tdnum">kezdvezmény azonosítója:</label>
            <input type="number" id="tdnum" name="tdnum" required>
            
            <label for="tdtype">Kedvezmény típusa:</label>
            <input type="text" id="tdtype" name="tdtype" required>

            <label for="tdmetric">Kedvezmény mértéke (%):</label>
            <input type="number" id="tdmetric" name="tdmetric" required>
            
            <button class="felvitel" type="submit">Létrehozás</button>
        </form>

        <form class="station-to-tour-form" action="../src/Controllers/megallController.php" method="POST">
            <h2>Állomás hozzárendelése útvonalhoz</h2>
            <label for="stopid">Megállás azonosítója:</label>
            <input type="number" id="stopid" name="stopid" required>

            <label for="sid">Létező állomás azonosítója:</label>
            <input type="number" id="sid" name="sid" required>
            
            <label for="tnum">Létező járat száma:</label>
            <input type="number" id="tnum" name="tnum" required>

            <label for="arrive-time">Érkezési idő (Nem kezdőállomás esetén):</label>
            <input type="datetime-local" id="arrive-time" name="arrive-time">

            <label for="start-time">Indulási idő (Nem végállomás esetén):</label>
            <input type="datetime-local" id="start-time" name="start-time">
            
            <button class="felvitel" type="submit">Létrehozás</button>
        </form>
    </div>
</body>
</html>