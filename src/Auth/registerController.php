<?php

session_start();

include_once '../Database/connection.php';

$email = $_POST['email'];
$name = $_POST['name'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];

if (isExist($conn, $email)) {
    $_SESSION['error'] = "Az email-hez már tartozik felhasználó!";
    header("Location: ../../pages/register.php");
    exit();
}

if ($password1 !== $password2) {
    $_SESSION['error'] = "Nem egyezik a kettő jelszó!";
    header("Location: ../../pages/register.php");
    exit();
}

// TODO
// $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO TAG (EMAIL, JELSZO, NEV) VALUES (:email, :jelszo, :nev)";

$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':email', $email);
oci_bind_by_name($stid, ':jelszo', $password1);
oci_bind_by_name($stid, ':nev', $name);

$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

if (!$success) {
    $e = oci_error($stid);
    throw new Exception("Sikertelen regisztráció: " . $e['message']);
}

$_SESSION['login'] = 'tag';
$_SESSION['error'] = "";
header("Location: ../../pages/profile.php");
exit();


function isExist($conn, $email) {
    $stid = oci_parse($conn, 'SELECT JELSZO FROM TAG WHERE EMAIL = :email');
    oci_bind_by_name($stid, ':email', $email);
    oci_execute($stid);

    $row = oci_fetch_assoc($stid);

    if (!$row) {
        return false;
    }

    return true; // shit happened
}
