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
        <form method="POST" action="/vasutmenetrend/src/Auth/registerController.php" accept-charset="utf-8">
            <h1>Regisztráció</h1>
            <div class="inpuBox">
                <label for="email">Email:</label>
                <input type="text" name="email">
            </div>
            <div class="inpuBox">
                <label for="name">Név:</label>
                <input type="text" name="name">
            </div>
            <div class="inpuBox">
                <label for="password1">Jelszó:</label>
                <input type="text" name="password1">
            </div>
            <div class="inpuBox">
                <label for="password2">Jelszó megint:</label>
                <input type="text" name="password2">
            </div>
            <?php
            if (isset($_SESSION["error"])) {
                echo "<p class='error'>" . $_SESSION["error"] . "</p>";
            }
            ?>
            <button class="purpleButton">Regisztráció</button>
        </form>
        <p>Van fiókod? <a href="login.php">Belépés!</a></p>
        
    </div>
</body>
</html>