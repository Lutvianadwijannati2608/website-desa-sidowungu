<?php

session_start();


// =====================================================
// CEK METHOD
// =====================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header('Location: login.php');
    exit;

}


// =====================================================
// AMBIL INPUT
// =====================================================

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';


// =====================================================
// AKUN ADMIN SEMENTARA
// =====================================================

$username_admin = 'admin';
$password_admin = 'admin123';


// =====================================================
// VALIDASI LOGIN
// =====================================================

if (
    $username === $username_admin &&
    $password === $password_admin
) {

    // Buat session login
    $_SESSION['admin_login'] = true;
    $_SESSION['admin_username'] = $username_admin;

    // Masuk ke dashboard
    header('Location: /admin/');
    exit;

}


// =====================================================
// LOGIN GAGAL
// =====================================================

header('Location: login.php?error=1');
exit;