<?php

session_start();

$_SESSION['login'] = false;
$_SESSION['userName'] = null;
$_SESSION['userEmail'] = null;

header('Location: ../../index.php');

?>