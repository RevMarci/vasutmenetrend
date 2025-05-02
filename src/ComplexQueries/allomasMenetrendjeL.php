<?php
require_once __DIR__ . '/../../config.php';

include ROOT_PATH . 'src/Database/connection.php';

if (isset($_POST['sid'])) {
    $sid = intval($_POST['sid']);

    $sql = "SELECT JARAT.JARATSZAM, MEGALL.ERKEZES, MEGALL.INDULAS
            FROM JARAT
            JOIN MEGALL ON JARAT.JARATSZAM = MEGALL.JARAT_JARATSZAM
            WHERE MEGALL.ALLOMAS_ID = :sid";

    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':sid', $sid);
    oci_execute($stid);

    while ($row = oci_fetch_assoc($stid)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['JARATSZAM']) . '</td>';
        echo '<td>' . htmlspecialchars($row['ERKEZES']) . '</td>';
        echo '<td>' . htmlspecialchars($row['INDULAS']) . '</td>';
        echo '</tr>';
    }

    oci_free_statement($stid);
    oci_close($conn);
}
?>
