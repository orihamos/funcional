<?php
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'produtos_crud');

$pdo = null;
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Error connecting to database: " . $e->getMessage(), 3, __DIR__ . '/error.log');
    echo "Erro ao conectar, por favor, tente mais tarde.";
    exit();
}

if (!$pdo) {
    error_log("Failed to connect to database.", 3, __DIR__ . '/error.log');
    echo "Erro ao conectar, por favor, tente mais tarde.";
    exit();
}
