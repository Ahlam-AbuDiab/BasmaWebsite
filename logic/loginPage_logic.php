<?php

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['passward'] ?? '';

if ($username === '' || $password === '') {
    header('Location: ../login.php?error=1');
    exit;
}

$stmt = mysqli_prepare(
    $conn,
    "SELECT username, passward
     FROM admin
     WHERE username = ?
     LIMIT 1"
);

if (!$stmt) {
    header('Location: ../login.php?error=2');
    exit;
}

mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $dbUsername, $dbPassword);

$admin = null;

if (mysqli_stmt_fetch($stmt)) {
    $admin = [
        'username' => $dbUsername,
        'passward' => $dbPassword,
    ];
}

mysqli_stmt_close($stmt);

if (
    $admin &&
    password_verify($password, $admin['passward'])
) {
    session_regenerate_id(true);

    $_SESSION['admin'] = true;
    $_SESSION['username'] = $admin['username'];

    header('Location: ../admin/adminDash.php');
    exit;
}

header('Location: ../login.php?error=1');
exit;
