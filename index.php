<?php
// index.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/configuracion/config.php';
require_once __DIR__ . '/core/App.php';

$app = new App();