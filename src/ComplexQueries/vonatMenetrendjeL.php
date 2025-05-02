<?php
require_once __DIR__ . '/../../config.php';
require_once ROOT_PATH . 'src/Database/connection.php';

if (isset($_POST['sid'])) {
    $allomasId = intval($_POST['sid']);

    $sql = "
        SELECT 
    ALLOMAS.NEV AS ALLOMAS_NEV,
    MEGALL.ERKEZES,
    MEGALL.INDULAS,
    (
        SELECT COUNT(DISTINCT MEGALL_SUB.JARAT_JARATSZAM)
        FROM MEGALL MEGALL_SUB
        WHERE MEGALL_SUB.ALLOMAS_ID = MEGALL.ALLOMAS_ID
    ) AS JARATOK_SZAMA,
    (MEGALL.INDULAS - MEGALL.ERKEZES) * 24 * 60 AS TARTOZKODASI_IDO_PERCBEN
FROM 
    MEGALL
JOIN 
    JARAT ON MEGALL.JARAT_JARATSZAM = JARAT.JARATSZAM
JOIN 
    ALLOMAS ON MEGALL.ALLOMAS_ID = ALLOMAS.ID
ORDER BY 
    ERKEZES ASC, INDULAS ASC
    ";

    $stid = oci_parse($conn, $sql);
    //oci_bind_by_name($stid, ':allomasId', $allomasId);

    if (oci_execute($stid)) {
        while ($row = oci_fetch_assoc($stid)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['ALLOMAS_NEV']) . '</td>';
            echo '<td>' . htmlspecialchars($row['ERKEZES']) . '</td>';
            echo '<td>' . htmlspecialchars($row['INDULAS']) . '</td>';
            echo '<td>' . htmlspecialchars($row['JARATOK_SZAMA']) . '</td>';
            echo '</tr>';
        }
    } else {
        $error = oci_error($stid);
        echo '<tr><td colspan="4">Hiba a lekérdezés során: ' . htmlspecialchars($error['message']) . '</td></tr>';
    }

    oci_free_statement($stid);
    oci_close($conn);
}
?>
