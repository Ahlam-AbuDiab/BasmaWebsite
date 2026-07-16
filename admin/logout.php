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
$_SESSION = array();
session_destroy();

header("Location: login.html");
exit();
?>