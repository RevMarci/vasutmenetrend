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
    'C##Y7BRWS',    // Nev
    'C2s0i0k3iS7ud',   // Jelszo
    'localhost:1521/orania2.inf.u-szeged.hu', // Vagy ez vagy $tns, nekem valamiert ezzel mukodik, de az anyagban a tns van
    'AL32UTF8'  // UTF8 kodolas
);

if (!$conn) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
?>
