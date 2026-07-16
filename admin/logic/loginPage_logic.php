<?php

session_name('BASMASESSID');

$secureCookie = (
    !empty($_SERVER['HTTPS']) &&
    $_SERVER['HTTPS'] !== 'off'
);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $secureCookie,
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

require_once __DIR__ . '/../dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.html');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['passward'] ?? '';

$stmt = mysqli_prepare(
    $conn,
    "SELECT username, passward
     FROM admin
     WHERE username = ?
     LIMIT 1"
);

mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);

if (
    $admin &&
    password_verify($password, $admin['passward'])
) {
    session_regenerate_id(true);

    $_SESSION['admin'] = true;
    $_SESSION['username'] = $admin['username'];

    session_write_close();

    header('Location: ../admin/adminDash.php');
    exit;
}

header('Location: ../login.html?error=1');
exit;