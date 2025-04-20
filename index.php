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
    <?php require_once 'config.php'; ?>
    <?php require_once ROOT_PATH . 'shared/header.php'; ?>

    <p>alma</p>
    <button class="blackButton">Bejelnetkezés</button>
    <button class="purpleButton">Keresés</button>
    <div class="inpuBox">
        <label for="">Honnan:</label>
        <input type="text">
    </div>
    <div class="inpuBox">
        <label for="">Mikor</label>
        <input type="date" name="" id="">
    </div>

    <?php


##############################################################################################
#######                  --- EZT A PHP-T TELJESEN KI LEHET HAGYNI ---                  #######
#######   --- AZÉRT HAGYTAM ITT, HOGY LETUDD TESZTELNI, HOGY TUDSZ E CSATLAKOZNI ---   #######
##############################################################################################


$conn = oci_connect('C##NEPTUN', 'Jelszo123', 'localhost:1521/orania2.inf.u-szeged.hu'); // Ha ez SID

if (!$conn) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, 'SELECT * FROM ADMIN');
if (!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

print "<table border='1'>\n";

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    print "<tr>\n";
    foreach ($row as $item) {
        print "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    print "</tr>\n";
}
print "</table>\n";

oci_free_statement($stid);

oci_close($conn);

?>

</body>
</html>