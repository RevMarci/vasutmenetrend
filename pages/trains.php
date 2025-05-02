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
        include '../src/ComplexQueries/vonatMenetrendjeL.php';
    ?>

    <div class="container">
        <label for="sid">Állomás:</label>
        <select id="sid" name="sid" class="js-example-basic-single">
        <option value="">Válassz állomást...</option>
        <?php
            $vonatok = getJaratL();
            foreach ($vonatok as $vonat) {
                echo '<option value="' . htmlspecialchars($vonat['JARATSZAM']) . '">'
                    . htmlspecialchars($vonat['TIPUS']) . ' (' . htmlspecialchars($vonat['JARATSZAM']) . ')</option>';
            }
        ?>
        </select>

        <table>
            <thead>
                <tr>
                <td>Állomás neve</td>
                <td>Érkezési idő</td>
                <td>Indulási idő</td>
                <td>Megálló járatok száma </td>
                </tr>
            </thead>
            <tbody id="menetrend-body">
                <!-- Ide kerül az AJAX-szel betöltött tartalom -->
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
<script>
$(document).ready(function() {
    $('#sid').change(function() {
        let sid = $(this).val();

        if (sid !== "") {
            $.ajax({
                url: '../src/ComplexQueries/vonatMenetrendjeL.php',
                type: 'POST',
                data: { sid: sid },
                success: function(response) {
                    $('#menetrend-body').html(response);
                },
                error: function() {
                    $('#menetrend-body').html('<tr><td colspan="3">Hiba történt.</td></tr>');
                }
            });
        } else {
            $('#menetrend-body').empty();
        }
    });
});
</script>
</html>