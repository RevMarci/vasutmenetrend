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
    <title>SnailRail</title>
</head>
<body>
    <?php require_once '../config.php'; ?>
    <?php require_once ROOT_PATH . 'shared/header.php'; ?>

    <div class="centerDiv">
        <form method="POST" action="/vasutmenetrend/src/Auth/loginController.php" accept-charset="utf-8">
            <h1>Bejelentkezés</h1>
            <div class="inpuBox">
                <label for="email">Email:</label>
                <input type="text" name="email">
            </div>
            <div class="inpuBox">
                <label for="password">Jelszó:</label>
                <input type="text" name="password">
            </div>
            <?php
            if (isset($_SESSION["error"])) {
                echo "<p class='error'>" . $_SESSION["error"] . "</p>";
            }
            ?>
            <button class="purpleButton">Belépés</button>
        </form>
        <p>Nincs fiókod?<a href="register.php">Regisztráció!</a></p>
    </div>
</body>
</html>