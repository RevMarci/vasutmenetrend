<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

        <form class="admin-del-form" action="../src/Controllers/adminController.php" method="POST">
            <h2>Admin törlése</h2>
            <label for="anum">Admin azonosítója:</label>
            <input type="number" id="anum" name="anum" required>
            
            <input type="hidden" name="action" value="delete-a">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="member-del-form" action="../src/Controllers/memberController.php" method="POST">
            <h2>Tag törlése</h2>
            <label for="temail">Tag email címe:</label>
            <input type="email" id="temail" name="temail" required>
            
            <input type="hidden" name="action" value="delete-t">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="buy-form" action="../src/Controllers/vasarlasController.php" method="POST">
            <h2>Jegyvásárlás törlése</h2>
            <label for="bnum">Vásárlás azonosítója:</label>
            <input type="number" id="bnum" name="bnum" required>
            
            <input type="hidden" name="action" value="delete-b">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="ticket-form" action="../src/Controllers/jegyController.php" method="POST">
            <h2>Jegy törlése</h2>
            <label for="tnum">Jegy azonosítója:</label>
            <input type="number" id="tnum" name="ticketnum" required>
            
            <input type="hidden" name="action" value="delete-t">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="locomotive-form" action="../src/Controllers/szerelvenyController.php" method="POST">
            <h2>Szerelvény törlése</h2>
            <label for="lnum">Mozdonyszám:</label>
            <input type="number" id="lnum" name="lnum" required>
            
            <input type="hidden" name="action" value="delete-l">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="station-form" action="../src/Controllers/allomasController.php" method="POST">
            <h2>Állomás törlése</h2>
            <label for="station-name">Állomás azonosítója:</label>
            <input type="text" id="sid" name="sid" required>

            <input type="hidden" name="action" value="delete-s">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="tour-form" action="../src/Controllers/jaratController.php" method="POST">
            <h2>Járat</h2>
            <label for="tnum">Járatszám:</label>
            <input type="number" id="tnum" name="tnum" required>

            <input type="hidden" name="action" value="delete-t">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="ticket-discount-form" action="../src/Controllers/kedvezmenyController.php" method="POST">
            <h2>Kezdvezmény eltörlése</h2>
            <label for="tdnum">kezdvezmény azonosítója:</label>
            <input type="number" id="tdnum" name="tdnum" required>

            <input type="hidden" name="action" value="delete-td">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="station-to-tour-form" action="../src/Controllers/megallController.php" method="POST">
            <h2>Állomás törlése útvonalról</h2>
            <label for="stopid">Megállás azonosítója:</label>
            <input type="number" id="stopid" name="stopid" required>

            <input type="hidden" name="action" value="delete-st">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="admin-form" action="../src/Controllers/adminController.php" method="POST">
            <h2>Admin adatának módosítása</h2>
            <label for="anum">Admin azonosítója (akin végezni szeretnéd a módosítást):</label>
            <input type="number" id="anum" name="anum" required>
            
            <label for="name">Admin új neve:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Admin új email címe:</label>
            <input type="email" id="email" name="email" required>
            
            <input type="hidden" name="action" value="modify">

            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="member-form" action="../src/Controllers/memberController.php" method="POST">
            <h2>TAG adatának módosítása</h2>
            <label for="anum">Tag email címe (akin végezni szeretnéd a módosítást):</label>
            <input type="number" id="anum" name="anum" required>
            
            <label for="name">Tag új neve:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Tag új email címe:</label>
            <input type="email" id="email" name="email" required>
            
            <input type="hidden" name="action" value="modify">

            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="locomotive-form" action="../src/Controllers/szerelvenyController.php" method="POST">
            <h2>Szerelvény módosítása</h2>
            <label for="lnum">Mozdonyszám:</label>
            <input type="number" id="lnum" name="lnum" required>
            
            <label for="lcapatity">Kapacitás:</label>
            <input type="number" id="lcapatity" name="lcapacity" required>
            
            <input type="hidden" name="action" value="modify">

            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="station-form" action="../src/Controllers/allomasController.php" method="POST">
            <h2>Állomás módosítása</h2>
            <label for="station-name">Állomás azonosítója:</label>
            <input type="text" id="station-name" name="sid" required>

            <label for="station-name">Állomás neve:</label>
            <input type="text" id="station-name" name="sname" required>
            
            <label for="station-location">Állomáshoz kapcsolódó település:</label>
            <input type="text" id="station-location" name="splace" required>

            <input type="hidden" name="action" value="modify">
            
            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="tour-form" action="../src/Controllers/jaratController.php" method="POST">
            <h2>Járat módosítása</h2>
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

            <input type="hidden" name="action" value="modify">
            
            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="ticket-discount-form" action="../src/Controllers/kedvezmenyController.php" method="POST">
            <h2>Kezdvezmény módosítása</h2>
            <label for="tdnum">kezdvezmény azonosítója:</label>
            <input type="number" id="tdnum" name="tdnum" required>
            
            <label for="tdtype">Kedvezmény típusa:</label>
            <input type="text" id="tdtype" name="tdtype" required>

            <label for="tdmetric">Kedvezmény mértéke (%):</label>
            <input type="number" id="tdmetric" name="tdmetric" required>

            <input type="hidden" name="action" value="modify">
            
            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="station-to-tour-form" action="../src/Controllers/megallController.php" method="POST">
            <h2>Állomás szerkesztése az útvonalon</h2>
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

            <input type="hidden" name="action" value="modify">
            
            <button class="felvitel" type="submit">Módosítás</button>
        </form>
    </div>
</body>
</html>