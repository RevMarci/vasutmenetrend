<?php
// Ezek abszolút útvonalak
// Kellettek a header-höz, mert azt több helyen használjuk és így mindenhova belehet húzni
// Használhatod máshol is, de a relatív is megteszi
// Ha ezt akarod használni, akkor oda először be kell húzni ezt is (ezt a config.php-t)

// Webes abszolút útvonal (HTML-ben használható pl. href, src, a)
define('BASE_URL', '/vasutmenetrend/');

// Fájlrendszerbeli abszolút útvonal (require, include)
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . BASE_URL);
