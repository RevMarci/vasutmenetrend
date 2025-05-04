<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['login'] == '' || $_SESSION['login'] == null || !isset($_SESSION['login']) || $_SESSION['login'] == 'tag') {
    header("Location: ../index.php");
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    <?php require_once '../config.php'; ?>
    <?php require_once ROOT_PATH . 'shared/header.php'; ?>
    <?php
        include '../src/ComplexQueries/statisztikaL.php';
    ?>

    <div class="container">
        <table>
            <thead>
                <tr>
                <td>Járat száma</td>
                <td>Járat típusa</td>
                <td>Eladott jegyek száma</td>
                </tr>
            </thead>
            <tbody>
            <?php
                $egesz = getEladasStat();
                if (is_array($egesz)) {
                    foreach ($egesz as $sor) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($sor['JARATSZAM']) . '</td>';
                        echo '<td>' . htmlspecialchars($sor['TIPUS']) . '</td>';
                        echo '<td>' . htmlspecialchars($sor['VASAROLT_JEGYEK_SZAMA']) . '</td>';
                        echo '</tr>';
                    }
                }
                
            ?>
            </tbody>
        </table>
    </div>

    <?php
    include '../src/ComplexQueries/getTag_JegyCount.php';
    $rows = getTag_JegyCount();
    
    echo '
    <div class="container">
    <table>
        <tr>
            <th>Tag email</th>
            <th>Vásárolt jegyek száma</th>
        </tr>';
        foreach ($rows as $row) {
            echo '<tr>
                <td>' . $row["EMAIL"] . '</td>
                <td>' . $row["JEGYEK_SZAMA"] . '</td>
            </tr>';
        }
    echo '
    </table>
    <div class="container">'
    ?>

    <div class="container">
        <table>
            <tr>
                <th>Járat legnagyobb kapacitással</th>
            </tr>
            <tr>
                <td>
                <?php
                    include '../src/ComplexQueries/getJaratKapacitas.php';
                    $row = getJaratKapacitas();
                    echo $row["KAPACITAS"];
                ?> fő
                </td>
            </tr>
        </table>
    </div>

    <div class="container">
        <table>
            <tr>
                <th>Fizetesi mód</th>
                <th>Darabszám</th>
                <th>Összes összeg</th>
            </tr>
            <?php
                include '../src/ComplexQueries/getSumJegyCostAmount.php';
                $rows = getSumJegyCostAmount();
                foreach ($rows as $row) {
                    echo '<tr>
                        <td>' . $row["FIZETESI_MOD"] . '</td>
                        <td>' . $row["DARABSZAM"] . '</td>
                        <td>' . $row["OSSZEG"] . '</td>
                    </tr>';
                }
            ?>
        </table>
    </div>
</body>
</html>