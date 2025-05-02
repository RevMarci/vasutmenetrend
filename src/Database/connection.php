<?php

$tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
    )
    (CONNECT_DATA =
      (SID = oriana2)
    )
  )";

$conn = oci_connect(
    'C##ALONKX',    // Nev
    'Mandula135',   // Jelszo
    'localhost:1521/orania2.inf.u-szeged.hu', // Vagy ez vagy $tns, nekem valamiert ezzel mukodik, de az anyagban a tns van
    'AL32UTF8'  // UTF8 kodolas
);

if (!$conn) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
