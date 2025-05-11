<?php
session_start();

include __DIR__ . '/../src/Database/connection.php';   // $conn létrejön itt
include '../src/Controllers/keresesController.php';


// Dátum konverzió biztonságos kezelése
function formatDateTime($oracleDateTime) {
    if (empty($oracleDateTime)) return '-';
    // Oracle dátum kezelése
    if (is_string($oracleDateTime)) {
        return $oracleDateTime;
    }
    return $oracleDateTime;
}

$results = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 3a. INSERT új állomás (ha van új név/hely mező)
    if (!empty($_POST['new_name']) && !empty($_POST['new_place'])) {
        $insSql = "INSERT INTO ALLOMAS (NEV, HELY) VALUES (:n, :p)";
        $si = oci_parse($conn, $insSql);
        oci_bind_by_name($si, ":n", $_POST['new_name']);
        oci_bind_by_name($si, ":p", $_POST['new_place']);
        oci_execute($si);
        oci_free_statement($si);
    }

    $ind = $_POST['indulas'] ?? null;
    $cel = $_POST['cel'] ?? null;
    if ($ind && $cel) {
        // Debug információ
        echo "<!-- Keresés indítva: $ind → $cel -->";

        // Változtassuk meg az Oracle NLS_DATE_FORMAT beállítását
        $setNlsFormat = "ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'";
        $stmtFormat = oci_parse($conn, $setNlsFormat);
        oci_execute($stmtFormat);
        oci_free_statement($stmtFormat);

        $transferSql = "
WITH LEHETSEGES_UTAK AS (
    SELECT 
        m1.JARAT_JARATSZAM AS ELSO_JARAT,
        NULL AS MASODIK_JARAT,
        a1.NEV AS INDULASI_ALLOMAS,
        a2.NEV AS ERKEZESI_ALLOMAS,
        m1.INDULAS AS INDULASI_IDO,
        m2.ERKEZES AS ERKEZESI_IDO,
        NULL AS ATSZALLAS_ALLOMAS,
        NULL AS ATSZALLASI_IDO,
        NULL AS VARAKOZASI_IDO
    FROM 
        MEGALL m1
        JOIN MEGALL m2 ON m1.JARAT_JARATSZAM = m2.JARAT_JARATSZAM
        JOIN ALLOMAS a1 ON m1.ALLOMAS_ID = a1.ID
        JOIN ALLOMAS a2 ON m2.ALLOMAS_ID = a2.ID
    WHERE 
        m1.INDULAS < m2.ERKEZES
        AND a1.NEV = :p_indulasi_allomas
        AND a2.NEV = :p_erkezesi_allomas

    UNION ALL

    -- Egy átszállásos járatok
    SELECT 
        m1.JARAT_JARATSZAM AS ELSO_JARAT,
        m3.JARAT_JARATSZAM AS MASODIK_JARAT,
        a1.NEV AS INDULASI_ALLOMAS,
        a3.NEV AS ERKEZESI_ALLOMAS,
        m1.INDULAS AS INDULASI_IDO,
        m4.ERKEZES AS ERKEZESI_IDO,
        a2.NEV AS ATSZALLAS_ALLOMAS,
        m3.INDULAS AS ATSZALLASI_IDO,
        (m3.INDULAS - m2.ERKEZES) * 24 * 60 AS VARAKOZASI_IDO
    FROM 
        MEGALL m1
        JOIN MEGALL m2 ON m1.JARAT_JARATSZAM = m2.JARAT_JARATSZAM
        JOIN MEGALL m3 ON m2.ALLOMAS_ID = m3.ALLOMAS_ID
        JOIN MEGALL m4 ON m3.JARAT_JARATSZAM = m4.JARAT_JARATSZAM
        JOIN ALLOMAS a1 ON m1.ALLOMAS_ID = a1.ID
        JOIN ALLOMAS a2 ON m2.ALLOMAS_ID = a2.ID
        JOIN ALLOMAS a3 ON m4.ALLOMAS_ID = a3.ID
    WHERE 
        m1.INDULAS < m2.ERKEZES
        AND m2.ERKEZES < m3.INDULAS
        AND m3.INDULAS < m4.ERKEZES
        AND a1.NEV = :p_indulasi_allomas
        AND a3.NEV = :p_erkezesi_allomas
        AND m1.JARAT_JARATSZAM <> m3.JARAT_JARATSZAM
        AND (m3.INDULAS - m2.ERKEZES) * 24 * 60 >= 5 -- legalább 5 perc átszállási idő
)

SELECT 
    u.*,
    j1.TIPUS AS ELSO_JARAT_TIPUS,
    j2.TIPUS AS MASODIK_JARAT_TIPUS,
    CASE 
        WHEN u.MASODIK_JARAT IS NULL THEN 'Közvetlen járat'
        ELSE 'Átszállásos járat'
    END AS JARAT_TIPUS
FROM 
    LEHETSEGES_UTAK u
    LEFT JOIN JARAT j1 ON u.ELSO_JARAT = j1.JARATSZAM
    LEFT JOIN JARAT j2 ON u.MASODIK_JARAT = j2.JARATSZAM
WHERE
    u.MASODIK_JARAT IS NULL 
    OR (u.VARAKOZASI_IDO <= 60) 
ORDER BY 
    u.ERKEZESI_IDO - u.INDULASI_IDO, 
    u.VARAKOZASI_IDO 
";
        $st = oci_parse($conn, $transferSql);
        oci_bind_by_name($st, ":p_indulasi_allomas", $ind);
        oci_bind_by_name($st, ":p_erkezesi_allomas", $cel);

        // Debug információ
        echo "<!-- SQL paraméterek: $ind, $cel -->";

        $r = oci_execute($st);
        if (!$r) {
            $e = oci_error($st);
            echo "<!-- SQL hiba: " . htmlentities($e['message']) . " -->";
        }

        while ($row = oci_fetch_assoc($st)) {
            $results[] = $row;
        }
        echo "<!-- Találatok száma: " . count($results) . " -->";
        oci_free_statement($st);
    }
}

$allomasok = getKereses();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/vasutmenetrend/css/style.css">
    <link rel="stylesheet" href="/vasutmenetrend/css/header.css">
    <link rel="stylesheet" href="/vasutmenetrend/css/admin.css">
    <link rel="stylesheet" href="/vasutmenetrend/css/allomasMenetrendje.css">
    <title>SnailRail</title>


</head>
<body>
<?php require_once '../config.php'; ?>
<?php require_once ROOT_PATH . 'shared/header.php'; ?>
<div class="container">
    <form method="POST" action="">
        <label for="indulas">Indulási megálló:</label>
        <select name="indulas" class="js-example-basic-single" required>
            <option></option>
            <?php foreach($allomasok as $a): ?>
                <option><?=htmlspecialchars($a['NEV'])?></option>
            <?php endforeach?>
        </select>

        <label for="cel">Végállomás:</label>
        <select name="cel" class="js-example-basic-single" required>
            <option></option>
            <?php foreach($allomasok as $a): ?>
                <option><?=htmlspecialchars($a['NEV'])?></option>
            <?php endforeach?>
        </select>
        <button type="submit" class="felvitel">Keresés</button>
    </form>
</div>
<!-- Select2 init -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- EREDMÉNYTÁBLÁZAT -->
<?php if($_SERVER['REQUEST_METHOD']==='POST'): ?>

    <?php if(!empty($results)): ?>
        <table>
            <tr>
                <th>Járat típusa</th>
                <th>1. járat (típus)</th>
                <th>Indulási idő</th>
                <th>Átszálló állomás</th>
                <th>Várakozási idő</th>
                <th>2. járat (típus)</th>
                <th>Érkezési idő</th>
                <th>Teljes utazási idő</th>
            </tr>
            <?php foreach($results as $row):
                $rowClass = ($row['MASODIK_JARAT'] === null) ? 'journey-direct' : 'journey-transfer';

                $indulasIdo = formatDateTime($row['INDULASI_IDO']);
                $erkezesIdo = formatDateTime($row['ERKEZESI_IDO']);

                // Egyszerűsített időszámítás
                $teljesUtazasiIdo = 'Kb. ' . ((strtotime($erkezesIdo) - strtotime($indulasIdo)) > 0 ?
                        round(((strtotime($erkezesIdo) - strtotime($indulasIdo)) / 3600), 1) . ' óra' :
                        '-');

                $varakozasiIdoSzoveg = $row['VARAKOZASI_IDO'] !== null ? round((float)str_replace(',', '.', $row['VARAKOZASI_IDO'])) . ' perc' : '-';
                ?>
                <tr class="<?=$rowClass?>">
                    <td><?=$row['JARAT_TIPUS'] ?? ($row['MASODIK_JARAT'] === null ? 'Közvetlen járat' : 'Átszállásos járat')?></td>
                    <td><?=$row['ELSO_JARAT']?> <?=!empty($row['ELSO_JARAT_TIPUS']) ? '(' . $row['ELSO_JARAT_TIPUS'] . ')' : ''?></td>
                    <td><?=$indulasIdo?></td>
                    <td><?=$row['ATSZALLAS_ALLOMAS'] ?? '-'?></td>
                    <td><?=$varakozasiIdoSzoveg?></td>
                    <td><?=$row['MASODIK_JARAT'] ?? '-'?> <?=!empty($row['MASODIK_JARAT']) && !empty($row['MASODIK_JARAT_TIPUS']) ? '(' . $row['MASODIK_JARAT_TIPUS'] . ')' : ''?></td>
                    <td><?=$erkezesIdo?></td>
                    <td><?=$teljesUtazasiIdo?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <div style="margin-top: 20px; padding: 10px; background-color: #fff3cd; border: 1px solid #ffeeba; border-radius: 4px;">
            <strong>Nincs találat.</strong> Próbálj másik útvonalat keresni.
        </div>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>