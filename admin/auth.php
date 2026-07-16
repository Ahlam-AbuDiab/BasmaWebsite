<?php

require_once __DIR__ . '/../includes/session.php';

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

if (empty($_SESSION['admin'])) {
    header('Location: ../login.php?error=session');
    exit();
}
