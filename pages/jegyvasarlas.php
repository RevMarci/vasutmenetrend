<?php

session_start();

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

    <div class="container">
        <!--?php print_r($_SESSION) ?-->
        <form class="buy-ticket-form" action="../src/Controllers/jegyController.php" method="POST">
            <h2>Jegyvásárlás</h2>
            <label for="ticketnum">Jegy azonosítója:</label>
            <input type="number" id="ticketnum" name="ticketnum" required>
            
            <label for="tnum">Létező járat száma:</label>
            <input type="number" id="tnum" name="tnum" required>

            <label for="bnum">Jegyvásárlás azonosítója:</label>
            <input type="number" id="bnum" name="bnum" required>

            <label for="until-time">Érvényesség:</label>
            <input type="datetime-local" id="until-time" name="until-time" required>

            <label for="tcost">Jegy ára:</label>
            <input type="number" id="tcost" name="tcost" value="600" required readonly>

            <label for="dnum">Kedvezmény azonosítója:</label>
            <input type="number" id="dnum" name="dnum" required>

            <label for="uemail">Email cím:</label>
            <?php echo 
            "<input type='email' id='uemail' name='uemail' value='".$_SESSION['userEmail']."' required readonly>"
            ?>
            
            <button class="felvitel" type="submit">Jegyvásárlás</button>
        </form>
    </div>
</body>
</html>