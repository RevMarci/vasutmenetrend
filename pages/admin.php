<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['login'] == '' || $_SESSION['login'] == null || !isset($_SESSION['login']) || $_SESSION['login'] == 'tag') {
    header("Location: ../index.php");
    exit();
}?>

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
    ?>

    <?php require_once ROOT_PATH . 'shared/header.php'; ?>

    <div class="container">
        <a href="../src/Auth/logout.php">
            <button class="purpleButton">Kilépés</button>
        </a>
        <form class="locomotive-form" action="../src/Controllers/szerelvenyController.php" method="POST">
            <h2>Szerelvény felvétele</h2>
            <label for="lnum">Mozdonyszám:</label>
            <input type="number" id="lnum" name="lnum" required>
            
            <label for="lcapatity">Kapacitás:</label>
            <input type="number" id="lcapatity" name="lcapacity" required>
            
            <button class="felvitel" type="submit">Létrehozás</button>
        </form>

        <form class="station-form" action="../src/Controllers/allomasController.php" method="POST">
            <h2>Állomás felvétel</h2>
            <label for="station-name">Állomás azonosítója:</label>
            <input type="text" id="station-name" name="sid" required>

            <label for="station-name">Állomás neve:</label>
            <input type="text" id="station-name" name="sname" required>
            
            <label for="station-location">Állomáshoz kapcsolódó település:</label>
            <input type="text" id="station-location" name="splace" required>
            
            <button class="felvitel" type="submit">Hozzáadás</button>
        </form>

        <form class="tour-form" action="../src/Controllers/jaratController.php" method="POST">
            <h2>Járat létrehozása</h2>
            <label for="tnum">Járatszám:</label>
            <input type="number" id="tnum" name="tnum" required>
            
            <label for="ttype">Szerelvény típusa:</label>
            <select id="ttype" name="ttype" required>
                <option value="Szemely">Személy</option>
                <option value="IC">IC</option>
                <option value="Gyors">Gyors</option>
                <option value="Expressz">Expressz</option>
                <option value="Zonazo">Zónázó</option>
                <option value="Gyorsszemely">Gyorsított személy</option>
                <option value="Interregio">IR</option>
                <option value="Sebes">Sebes</option>
                <option value="Teher">Teher</option>
            </select>

            <label for="lnum">Mozdonyszám:</label>
            <!--input type="number" id="lnum" name="lnum" required-->
            <select id="lnum" name="lnum">
                <?php
                $szerelvenyek = getSzerelvenyL();
                if (!empty($szerelvenyek)) {
                    foreach ($szerelvenyek as $szerelveny) {
                        echo '<option value="' . htmlspecialchars($szerelveny['MOZDONYSZAM']) . '">'
                            . 'Mozdony: ' . htmlspecialchars($szerelveny['MOZDONYSZAM']) . ', Kapacitás: ' . htmlspecialchars($szerelveny['KAPACITAS'])
                            . '</option>';
                    }
                } else {
                    echo '<option value="">Nincs elérhető szerelvény.</option>';
                }
                
                ?>
            </select>
            
            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="ticket-discount-form" action="../src/Controllers/kedvezmenyController.php" method="POST">
            <h2>Új kezdvezmény</h2>
            <label for="tdnum">kezdvezmény azonosítója:</label>
            <input type="number" id="tdnum" name="tdnum" required>
            
            <label for="tdtype">Kedvezmény típusa:</label>
            <input type="text" id="tdtype" name="tdtype" required>

            <label for="tdmetric">Kedvezmény mértéke (%):</label>
            <input type="number" id="tdmetric" name="tdmetric" required>
            
            <button class="felvitel" type="submit">Létrehozás</button>
        </form>

        <form class="station-to-tour-form" action="../src/Controllers/megallController.php" method="POST">
            <h2>Állomás hozzárendelése útvonalhoz</h2>
            <label for="stopid">Megállás azonosítója:</label>
            <input type="number" id="stopid" name="stopid" required>

            <label for="sid">Állomás:</label>
            <!--input type="number" id="sid" name="sid" required-->
            <select id="sid" name="sid">
            <?php
                    $allomasok = getAllomasL();
                    if (!empty($allomasok)) {
                        foreach ($allomasok as $allomas) {
                            echo '<option value="' . htmlspecialchars($allomas['ID']) . '">'
                                . htmlspecialchars($allomas['NEV']) . ' - ' . htmlspecialchars($allomas['HELY'])
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető állomás.</option>';
                    }
                ?>
            </select>
            
            <label for="tnum">Járat:</label>
            <!--input type="number" id="tnum" name="tnum" required-->
            <select id="tnum" name="tnum">
                <?php
                    $jaratok = getJaratL();
                    if (!empty($jaratok)) {
                        foreach ($jaratok as $jarat) {
                            echo '<option value="' . htmlspecialchars($jarat['JARATSZAM']) . '">'
                                . 'Járatszám: ' . htmlspecialchars($jarat['JARATSZAM']) 
                                . ', Típus: ' . htmlspecialchars($jarat['TIPUS']) 
                                . ', Mozdony: ' . htmlspecialchars($jarat['SZERELVENY_MOZDONYSZAM'])
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető járat.</option>';
                    }
        
                ?>
            </select>

            <label for="arrive-time">Érkezési idő (Nem kezdőállomás esetén):</label>
            <input type="datetime-local" id="arrive-time" name="arrive-time">

            <label for="start-time">Indulási idő (Nem végállomás esetén):</label>
            <input type="datetime-local" id="start-time" name="start-time">
            
            <button class="felvitel" type="submit">Létrehozás</button>
        </form>

        <form class="admin-del-form" action="../src/Controllers/adminController.php" method="POST">
            <h2>Admin törlése</h2>
            <label for="anum">Admin:</label>
            <!--input type="number" id="anum" name="anum" required-->
            <select id="anum" name="anum">
                <?php
                    $tagok = getAdminL();
                    if (!empty($tagok)) {
                        foreach ($tagok as $tag) {
                            echo '<option value="' . htmlspecialchars($tag['ADMIN_ID']) . '">'
                                . htmlspecialchars($tag['NEV']) . ' (' . htmlspecialchars($tag['EMAIL']) . ')'
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető felhasználó.</option>';
                    }
                    
                ?>
            </select>
            
            <input type="hidden" name="action" value="delete-a">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="member-del-form" action="../src/Controllers/memberController.php" method="POST">
            <h2>Tag törlése</h2>
            <label for="temail">Tag:</label>
            <!--input type="email" id="temail" name="temail" required-->
            <select id="temail" name="temail">
            <?php
                    $tagok = getTagL();
                    if (!empty($tagok)) {
                        foreach ($tagok as $tag) {
                            echo '<option value="' . htmlspecialchars($tag['EMAIL']) . '">'
                                . htmlspecialchars($tag['NEV']) . ' (' . htmlspecialchars($tag['EMAIL']) . ')'
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető felhasználó.</option>';
                    }
                    
                ?>
            </select>
            
            <input type="hidden" name="action" value="delete-t">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="buy-form" action="../src/Controllers/vasarlasController.php" method="POST">
            <h2>Jegyvásárlás törlése</h2>
            <label for="bnum">Vásárlás:</label>
            <!--input type="number" id="bnum" name="bnum" required-->
            <select id="bnum" name="bnum">
                <?php
                $vasarlasok = getVasarlasL();
                if (!empty($vasarlasok)) {
                    foreach ($vasarlasok as $vasarlas) {
                        echo '<option value="' . htmlspecialchars($vasarlas['ID']) . '">'
                            . 'ID: ' . htmlspecialchars($vasarlas['ID']) . ', Dátum: ' . htmlspecialchars($vasarlas['DATUM'])
                            . ', Fizetési mód: ' . htmlspecialchars($vasarlas['FIZETESI_MOD'])
                            . '</option>';
                    }
                } else {
                    echo '<option value="">Nincs elérhető vásárlás.</option>';
                }
                ?>
            </select>
            
            <input type="hidden" name="action" value="delete-b">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="ticket-form" action="../src/Controllers/jegyController.php" method="POST">
            <h2>Jegy törlése</h2>
            <label for="tnum">Jegy:</label>
            <!--input type="number" id="tnum" name="ticketnum" required-->
            <select name="tnum" id="ticketnum">
            <?php
                $jegyek = getJegyL();
                if (!empty($jegyek)) {
                    foreach ($jegyek as $jegy) {
                        echo '<option value="' . htmlspecialchars($jegy['AZONOSITO']) . '">'
                            . 'Jegy ID: ' . htmlspecialchars($jegy['AZONOSITO']) 
                            . ', Járatszám: ' . htmlspecialchars($jegy['JARAT_JARATSZAM']) 
                            . ', Ár: ' . htmlspecialchars($jegy['JEGYAR']) . ' Ft'
                            . '</option>';
                    }
                } else {
                    echo '<option value="">Nincs elérhető jegy.</option>';
                }
            ?>
            </select>
            <input type="hidden" name="action" value="delete-t">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="locomotive-form" action="../src/Controllers/szerelvenyController.php" method="POST">
            <h2>Szerelvény törlése</h2>
            <label for="lnum">Szerelvény:</label>
            <!--input type="number" id="lnum" name="lnum" required-->
            <select id="lnum" name="lnum">
            <?php
                $szerelvenyek = getSzerelvenyL();
                if (!empty($szerelvenyek)) {
                    foreach ($szerelvenyek as $szerelveny) {
                        echo '<option value="' . htmlspecialchars($szerelveny['MOZDONYSZAM']) . '">'
                            . 'Mozdony: ' . htmlspecialchars($szerelveny['MOZDONYSZAM']) . ', Kapacitás: ' . htmlspecialchars($szerelveny['KAPACITAS'])
                            . '</option>';
                    }
                } else {
                    echo '<option value="">Nincs elérhető szerelvény.</option>';
                }
            ?>
            </select>
            <input type="hidden" name="action" value="delete-l">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="station-form" action="../src/Controllers/allomasController.php" method="POST">
            <h2>Állomás törlése</h2>
            <label for="station-name">Állomás:</label>
            <!--input type="text" id="sid" name="sid" required-->
            <select id="sid" name="sid">
            <?php
                    $allomasok = getAllomasL();
                    if (!empty($allomasok)) {
                        foreach ($allomasok as $allomas) {
                            echo '<option value="' . htmlspecialchars($allomas['ID']) . '">'
                                . htmlspecialchars($allomas['NEV']) . ' - ' . htmlspecialchars($allomas['HELY'])
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető állomás.</option>';
                    }
                ?>
            </select>
            <input type="hidden" name="action" value="delete-s">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="tour-form" action="../src/Controllers/jaratController.php" method="POST">
            <h2>Járat törlése</h2>
            <label for="tnum">Járat:</label>
            <!--input type="number" id="tnum" name="tnum" required-->
            <select id="tnum" name="tnum">
                <?php
                    $jaratok = getJaratL();
                    if (!empty($jaratok)) {
                        foreach ($jaratok as $jarat) {
                            echo '<option value="' . htmlspecialchars($jarat['JARATSZAM']) . '">'
                                . 'Járatszám: ' . htmlspecialchars($jarat['JARATSZAM']) 
                                . ', Típus: ' . htmlspecialchars($jarat['TIPUS']) 
                                . ', Mozdony: ' . htmlspecialchars($jarat['SZERELVENY_MOZDONYSZAM'])
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető járat.</option>';
                    }
                    
                ?>
            </select>

            <input type="hidden" name="action" value="delete-t">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="ticket-discount-form" action="../src/Controllers/kedvezmenyController.php" method="POST">
            <h2>Kezdvezmény eltörlése</h2>
            <label for="tdnum">Kezdvezmény:</label>
            <!--input type="number" id="tdnum" name="tdnum" required-->
            <select id="tdnum" name="tdnum">
                <?php
                $kedvezmenyek = getKedvezmenyL();
                if (!empty($kedvezmenyek)) {
                    foreach ($kedvezmenyek as $kedvezmeny) {
                        echo '<option value="' . htmlspecialchars($kedvezmeny['ID']) . '">'
                            . htmlspecialchars($kedvezmeny['TIPUS']) . ' (' . htmlspecialchars($kedvezmeny['MERTEKE']) . '%)'
                            . '</option>';
                    }
                } else {
                    echo '<option value="">Nincs elérhető kedvezmény.</option>';
                }
                
                ?>
            </select>

            <input type="hidden" name="action" value="delete-td">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="station-to-tour-form" action="../src/Controllers/megallController.php" method="POST">
            <h2>Állomás törlése útvonalról</h2>
            <label for="stopid">Megállás:</label>
            <!--input type="number" id="stopid" name="stopid" required-->
            <select id="stopid" name="stopid">
                <?php
                $megallok = getMegallL();
                if (!empty($megallok)) {
                    foreach ($megallok as $megall) {
                        echo '<option value="' . htmlspecialchars($megall['ID']) . '">'
                            . 'Állomás ID: ' . htmlspecialchars($megall['ALLOMAS_ID']) 
                            . ', Járatszám: ' . htmlspecialchars($megall['JARAT_JARATSZAM'])
                            . '</option>';
                    }
                } else {
                    echo '<option value="">Nincs elérhető megálló.</option>';
                }
                
                ?>
            </select>

            <input type="hidden" name="action" value="delete-st">
            
            <button class="felvitel" type="submit">Törlés</button>
        </form>

        <form class="admin-form" action="../src/Controllers/adminController.php" method="POST">
            <h2>Admin adatának módosítása</h2>
            <label for="anum">Admin:</label>
            <!--input type="number" id="anum" name="anum" required-->
            <select id="anum" name="anum">
                <?php
                    $tagok = getAdminL();
                    if (!empty($tagok)) {
                        foreach ($tagok as $tag) {
                            echo '<option value="' . htmlspecialchars($tag['ADMIN_ID']) . '">'
                                . htmlspecialchars($tag['NEV']) . ' (' . htmlspecialchars($tag['EMAIL']) . ')'
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető felhasználó.</option>';
                    }
                    
                ?>
            </select>
            
            <label for="name">Admin új neve:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Admin új email címe:</label>
            <input type="email" id="email" name="email" required>
            
            <input type="hidden" name="action" value="modify">

            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="member-form" action="../src/Controllers/memberController.php" method="POST">
            <h2>Tag adatának módosítása</h2>
            <label for="email">Tag:</label>
            <!--input type="email" id="email" name="email" required-->
            <select id="temail" name="email">
            <?php
                    $tagok = getTagL();
                    if (!empty($tagok)) {
                        foreach ($tagok as $tag) {
                            echo '<option value="' . htmlspecialchars($tag['EMAIL']) . '">'
                                . htmlspecialchars($tag['NEV']) . ' (' . htmlspecialchars($tag['EMAIL']) . ')'
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető felhasználó.</option>';
                    }
                    
                ?>
            </select>
            
            <label for="name">Tag új neve:</label>
            <input type="text" id="name" name="name" required>

            <label for="newmail">Tag új email címe:</label>
            <input type="email" id="newmail" name="newmail" required>
            
            <input type="hidden" name="action" value="modify">

            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="locomotive-form" action="../src/Controllers/szerelvenyController.php" method="POST">
            <h2>Szerelvény módosítása</h2>
            <label for="lnum">Mozdony:</label>
            <!--input type="number" id="lnum" name="lnum" required-->
            <select id="lnum" name="lnum">
            <?php
                $szerelvenyek = getSzerelvenyL();
                if (!empty($szerelvenyek)) {
                    foreach ($szerelvenyek as $szerelveny) {
                        echo '<option value="' . htmlspecialchars($szerelveny['MOZDONYSZAM']) . '">'
                            . 'Mozdony: ' . htmlspecialchars($szerelveny['MOZDONYSZAM']) . ', Kapacitás: ' . htmlspecialchars($szerelveny['KAPACITAS'])
                            . '</option>';
                    }
                } else {
                    echo '<option value="">Nincs elérhető szerelvény.</option>';
                }
            ?>
            </select>
            
            <label for="lcapatity">Kapacitás:</label>
            <input type="number" id="lcapatity" name="lcapacity" required>
            
            <input type="hidden" name="action" value="modify">

            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="station-form" action="../src/Controllers/allomasController.php" method="POST">
            <h2>Állomás módosítása</h2>
            <label for="sid">Állomás:</label>
            <!--input type="text" id="station-name" name="sid" required-->
            <select id="sid" name="sid">
            <?php
                    $allomasok = getAllomasL();
                    if (!empty($allomasok)) {
                        foreach ($allomasok as $allomas) {
                            echo '<option value="' . htmlspecialchars($allomas['ID']) . '">'
                                . htmlspecialchars($allomas['NEV']) . ' - ' . htmlspecialchars($allomas['HELY'])
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető állomás.</option>';
                    }
                ?>
            </select>

            <label for="station-name">Állomás neve:</label>
            <input type="text" id="station-name" name="sname" required>
            
            <label for="station-location">Állomáshoz kapcsolódó település:</label>
            <input type="text" id="station-location" name="splace" required>

            <input type="hidden" name="action" value="modify">
            
            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="tour-form" action="../src/Controllers/jaratController.php" method="POST">
            <h2>Járat módosítása</h2>
            <label for="tnum">Járat:</label>
            <!--input type="number" id="tnum" name="tnum" required-->
            <select id="tnum" name="tnum">
                <?php
                    $jaratok = getJaratL();
                    if (!empty($jaratok)) {
                        foreach ($jaratok as $jarat) {
                            echo '<option value="' . htmlspecialchars($jarat['JARATSZAM']) . '">'
                                . 'Járatszám: ' . htmlspecialchars($jarat['JARATSZAM']) 
                                . ', Típus: ' . htmlspecialchars($jarat['TIPUS']) 
                                . ', Mozdony: ' . htmlspecialchars($jarat['SZERELVENY_MOZDONYSZAM'])
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető járat.</option>';
                    }
                    
                ?>
            </select>
            
            <label for="ttype">Járat új típusa:</label>
            <select id="ttype" name="ttype" required>
                <option value="Szemely">Személy</option>
                <option value="IC">IC</option>
                <option value="Gyors">Gyors</option>
                <option value="Expressz">Expressz</option>
                <option value="Zonazo">Zónázó</option>
                <option value="Gyorsszemely">Gyorsított személy</option>
                <option value="Interregio">IR</option>
                <option value="Sebes">Sebes</option>
                <option value="Teher">Teher</option>
            </select>

            <label for="lnum">Új mozdony:</label>
            <!--input type="number" id="lnum" name="lnum" required-->
            <select id="lnum" name="lnum">
            <?php
                $szerelvenyek = getSzerelvenyL();
                if (!empty($szerelvenyek)) {
                    foreach ($szerelvenyek as $szerelveny) {
                        echo '<option value="' . htmlspecialchars($szerelveny['MOZDONYSZAM']) . '">'
                            . 'Mozdony: ' . htmlspecialchars($szerelveny['MOZDONYSZAM']) . ', Kapacitás: ' . htmlspecialchars($szerelveny['KAPACITAS'])
                            . '</option>';
                    }
                } else {
                    echo '<option value="">Nincs elérhető szerelvény.</option>';
                }
            ?>

            <input type="hidden" name="action" value="modify">
            
            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="ticket-discount-form" action="../src/Controllers/kedvezmenyController.php" method="POST">
            <h2>Kezdvezmény módosítása</h2>
            <label for="tdnum">kezdvezmény:</label>
            <!--input type="number" id="tdnum" name="tdnum" required-->
            <select id="tdnum" name="tdnum">
                <?php
                $kedvezmenyek = getKedvezmenyL();
                if (!empty($kedvezmenyek)) {
                    foreach ($kedvezmenyek as $kedvezmeny) {
                        echo '<option value="' . htmlspecialchars($kedvezmeny['ID']) . '">'
                            . htmlspecialchars($kedvezmeny['TIPUS']) . ' (' . htmlspecialchars($kedvezmeny['MERTEKE']) . '%)'
                            . '</option>';
                    }
                } else {
                    echo '<option value="">Nincs elérhető kedvezmény.</option>';
                }
                
                ?>
            </select>
            
            <label for="tdtype">Kedvezmény új típusa:</label>
            <input type="text" id="tdtype" name="tdtype" required>

            <label for="tdmetric">Kedvezmény új mértéke (%):</label>
            <input type="number" id="tdmetric" name="tdmetric" required>

            <input type="hidden" name="action" value="modify">
            
            <button class="felvitel" type="submit">Módosítás</button>
        </form>

        <form class="station-to-tour-form" action="../src/Controllers/megallController.php" method="POST">
            <h2>Állomás szerkesztése az útvonalon</h2>
            <label for="stopid">Megállás:</label>
            <!--input type="number" id="stopid" name="stopid" required-->
            <select id="stopid" name="stopid">
                <?php
                $megallok = getMegallL();
                if (!empty($megallok)) {
                    foreach ($megallok as $megall) {
                        echo '<option value="' . htmlspecialchars($megall['ID']) . '">'
                            . 'Állomás ID: ' . htmlspecialchars($megall['ALLOMAS_ID']) 
                            . ', Járatszám: ' . htmlspecialchars($megall['JARAT_JARATSZAM'])
                            . '</option>';
                    }
                } else {
                    echo '<option value="">Nincs elérhető megálló.</option>';
                }
                
                ?>
            </select>

            <label for="sid">Állomás</label>
            <!--input type="number" id="sid" name="sid" required-->
            <select id="sid" name="sid">
            <?php
                    $allomasok = getAllomasL();
                    if (!empty($allomasok)) {
                        foreach ($allomasok as $allomas) {
                            echo '<option value="' . htmlspecialchars($allomas['ID']) . '">'
                                . htmlspecialchars($allomas['NEV']) . ' - ' . htmlspecialchars($allomas['HELY'])
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető állomás.</option>';
                    }
                ?>
            </select>
            
            <label for="tnum">Járat:</label>
            <!--input type="number" id="tnum" name="tnum" required-->
            <select id="tnum" name="tnum">
                <?php
                    $jaratok = getJaratL();
                    if (!empty($jaratok)) {
                        foreach ($jaratok as $jarat) {
                            echo '<option value="' . htmlspecialchars($jarat['JARATSZAM']) . '">'
                                . 'Járatszám: ' . htmlspecialchars($jarat['JARATSZAM']) 
                                . ', Típus: ' . htmlspecialchars($jarat['TIPUS']) 
                                . ', Mozdony: ' . htmlspecialchars($jarat['SZERELVENY_MOZDONYSZAM'])
                                . '</option>';
                        }
                    } else {
                        echo '<option value="">Nincs elérhető járat.</option>';
                    }
                    
                ?>
            </select>

            <label for="arrive-time">Érkezési idő (Nem kezdőállomás esetén):</label>
            <input type="datetime-local" id="arrive-time" name="arrive-time">

            <label for="start-time">Indulási idő (Nem végállomás esetén):</label>
            <input type="datetime-local" id="start-time" name="start-time">

            <input type="hidden" name="action" value="modify">
            
            <button class="felvitel" type="submit">Módosítás</button>
        </form>
    </div>
</body>
</html>