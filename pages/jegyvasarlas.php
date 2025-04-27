<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

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
    <?php
        include '../src/Controllers/adminController.php';
        include '../src/Controllers/allomasController.php';
        include '../src/Controllers/jaratController.php';
        include '../src/Controllers/jegyController.php';
        include '../src/Controllers/kedvezmenyController.php';
        include '../src/Controllers/megallController.php';
        include '../src/Controllers/memberController.php';
        include '../src/Controllers/szerelvenyController.php';
        include '../src/Controllers/vasarlasController.php';
    ?>

    <div class="container">
        <!--?php print_r($_SESSION) ?-->
        <form class="buy-ticket-form" action="../src/Controllers/jegyController.php" method="POST">
            <h2>Jegyvásárlás</h2>
            <label for="ticketnum">Jegy azonosítója:</label>
            <input type="number" id="ticketnum" name="ticketnum" required>
            
            <label for="tnum">Erre a járatra:</label>
            <!--input type="number" id="tnum" name="tnum" required-->
            <select id="tnum" name="tnum">
                <?php
                    $jaratok = getJaratL();
                    if (!empty($jaratok)) {
                        foreach ($jaratok as $jarat) {
                            echo '<option value="' . htmlspecialchars($jarat['JARATSZAM']) . '">'
                                . 'Járatszám: ' . htmlspecialchars($jarat['JARATSZAM']) 
                                . ', Típus: ' . htmlspecialchars($jarat['TIPUS']) 
                                . ', Mozdony: ' . htmlspecialchars($jarat['SZERELVENY_MOZDONYSZAM'])
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető járat.</option>';
                    }
        
                ?>
            </select>

            <label for="bnum">Jegyvásárlás azonosítója:</label>
            <input type="number" id="bnum" name="bnum" required>

            <label for="until-time">Érvényesség:</label>
            <input type="datetime-local" id="until-time" name="until-time" required>

            <label for="tcost">Jegy ára:</label>
            <input type="number" id="tcost" name="tcost" value="600" required readonly>

            <label for="dnum">Kedvezmény:</label>
            <!--input type="number" id="dnum" name="dnum" required-->
            <select id="dnum" name="dnum">
                <?php
                $kedvezmenyek = getKedvezmenyL();
                if (!empty($kedvezmenyek)) {
                    foreach ($kedvezmenyek as $kedvezmeny) {
                        echo '<option value="' . htmlspecialchars($kedvezmeny['ID']) . '">'
                            . htmlspecialchars($kedvezmeny['TIPUS']) . ' (' . htmlspecialchars($kedvezmeny['MERTEKE']) . '%)'
                            . '</option>';
                    }
                } else {
                    echo '<option value="">Nincs elérhető kedvezmény.</option>';
                }
                
                ?>
            </select>

            <label for="uemail">Email cím:</label>
            <?php echo 
            "<input type='email' id='uemail' name='uemail' value='".$_SESSION['userEmail']."' required readonly>"
            ?>
            
            <button class="felvitel" type="submit">Jegyvásárlás</button>
        </form>
    </div>
</body>
</html>