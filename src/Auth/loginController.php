<?php

session_start();

include_once '../Database/connection.php';

$email = $_POST['email'];
$password = $_POST['password'];

if ( isset($email) && isset($password) ) {

    // lekérdezés
    if (login($conn, $email, $password)) {
        $_SESSION['login'] = 'tag';
        $_SESSION['error'] = "";
        $_SESSION['success'] = "Sikeres bejelentkezés!";
        header("Location: ../../pages/success.php");
    } elseif (loginAdmin($conn, $email, $password)) {
        $_SESSION['login'] = 'admin';
        $_SESSION['error'] = "";
        $_SESSION['success'] = "Sikeres admin bejelentkezés!";
        header("Location: ../../pages/success.php");
    } else {
        $_SESSION['error'] = "Helytelen azonosító vagy jelszó.";
        header("Location: ../../pages/login.php");
        exit();
    }

} else {
    $_SESSION['error'] = "Nincs beállítva valamely érték.";
    header("Location: ../../pages/login.php");
    exit();
}

function login($conn, $email, $password) {
    $stid = oci_parse($conn, 'SELECT JELSZO FROM TAG WHERE EMAIL = :email');
    oci_bind_by_name($stid, ':email', $email);
    oci_execute($stid);

    $row = oci_fetch_assoc($stid);

    if (!$row) {
        return false;
    }

    if (password_verify($password, $row['JELSZO'])) {
        return true;
    }

    return false; // shit happened
}

// valamiert nem enged tablat bindolni, ideiglenes megoldas :c
function loginAdmin($conn, $email, $password) {
    $stid = oci_parse($conn, 'SELECT JELSZO FROM ADMIN WHERE EMAIL = :email');
    oci_bind_by_name($stid, ':email', $email);
    oci_execute($stid);

    $row = oci_fetch_assoc($stid);

    if (!$row) {
        return false;
    }

    if (password_verify($password, $row['JELSZO'])) {
        return true;
    }

    return false; // shit happened
}
