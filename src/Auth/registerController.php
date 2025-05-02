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

$hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
//$_SESSION['error'] = "Hashed pasw: " . $hashedPassword;

/*
$sql = "INSERT INTO TAG (EMAIL, JELSZO, NEV) VALUES (:email, :jelszo, :nev)";

$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':email', $email);
oci_bind_by_name($stid, ':jelszo', $hashedPassword);
oci_bind_by_name($stid, ':nev', $name);

$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
*/

$sql = 'BEGIN add_tag(:email, :pswrd, :name); END;';
$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':email', $email);
oci_bind_by_name($stid, ':pswrd', $hashedPassword);
oci_bind_by_name($stid, ':name', $name);

$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

if (!$success) {
    $e = oci_error($stid);
    $errorMsg = $e['message'];

    if (strpos($errorMsg, 'ORA-20001') !== false) {
        $_SESSION['error'] = "Ez az e-mail cím már foglalt egy admin felhasználónál.";
    } else {
        $_SESSION['error'] = "Adatbázis hiba történt: " . htmlentities($errorMsg);
    }

    header("Location: ../../pages/register.php");
    exit();
}

$_SESSION['login'] = 'tag';
$_SESSION['userName'] = $name;
$_SESSION['userEmail'] = $email;
$_SESSION['error'] = "";
$_SESSION['success'] = "Sikeres regisztráció!";

oci_free_statement($stid);
oci_close($conn);

header("Location: ../../pages/success.php");
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
