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
    <link rel="stylesheet" href="/vasutmenetrend/css/allomasMenetrendje.css">
    <title>SnailRail</title>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery (Select2 függősége) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
        include '../src/ComplexQueries/allomasMenetrendjeL.php';
    ?>

    <div class="container">
    <label for="station-name">Állomás:</label>
            <select id="sid" name="sid" class="js-example-basic-single">
            <option value="">Válassz állomást...</option>
            <?php
                    $allomasok = getAllomasL();
                    if (!empty($allomasok)) {
                        foreach ($allomasok as $allomas) {
                            echo '<option value="' . htmlspecialchars($allomas['ID']) . '">'
                                . htmlspecialchars($allomas['NEV']) . ' (' . htmlspecialchars($allomas['HELY'] . ')')
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető állomás.</option>';
                    }
                ?>
            </select>
            <br>
            <table>
                <thead>
                    <tr>
                        <td>Járat száma</td>
                        <td>Érkezési idő</td>
                        <td>Indulási idő</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $minden = getAllomasMenetrenjeL();
                    
                            foreach ($minden as $sor) { 
                                echo '<tr><td>'. $sor['JARAT_JARATSZAM'].'</td><td>'.$sor['ERKEZES'].'</td><td>'.$sor['INDULAS'].'</td></tr>';
                            }
                ?>
                </tbody>
            </table>
    </div>
</body>
<script>
  $(document).ready(function() {
    $('.js-example-basic-single').select2({
      placeholder: "Keresés...",
      allowClear: true
    });
  });
</script>

</html>