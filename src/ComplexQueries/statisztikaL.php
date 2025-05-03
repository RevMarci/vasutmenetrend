<?php

function getEladasStat() {
    

//include __DIR__ . '/../../config.php';
include ROOT_PATH . 'src/Database/connection.php';

$sql = "
    SELECT 
        JARAT.JARATSZAM,
        JARAT.TIPUS,
        COUNT(JEGY.AZONOSITO) AS VASAROLT_JEGYEK_SZAMA
    FROM 
        JARAT
    LEFT JOIN 
        JEGY ON JEGY.JARAT_JARATSZAM = JARAT.JARATSZAM
    GROUP BY 
        JARAT.JARATSZAM, JARAT.TIPUS
    ORDER BY 
        VASAROLT_JEGYEK_SZAMA DESC
";

$stid = oci_parse($conn, $sql);

if (oci_execute($stid)) {
    while ($row = oci_fetch_assoc($stid)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['JARATSZAM']) . '</td>';
        echo '<td>' . htmlspecialchars($row['TIPUS']) . '</td>';
        echo '<td>' . htmlspecialchars($row['VASAROLT_JEGYEK_SZAMA']) . '</td>';
        echo '</tr>';
    }
} else {
    $error = oci_error($stid);
    echo '<tr><td colspan="3">Hiba a lekérdezés során: ' . htmlspecialchars($error['message']) . '</td></tr>';
}

oci_free_statement($stid);
oci_close($conn);
}
?>
