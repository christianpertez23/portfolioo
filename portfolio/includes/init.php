<?php
// Shared bootstrap: session, MySQL database (auto-created), helpers.
session_start();
require_once __DIR__ . '/config.php';

function db(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;
    $opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
    $dsn  = 'mysql:host=' . DB_HOST . ';charset=utf8mb4';
    try {
        try {
            $pdo = new PDO($dsn . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $opts);
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), '1049') === false) throw $e;   // 1049 = database doesn't exist yet
            $tmp = new PDO($dsn, DB_USER, DB_PASS, $opts);
            $tmp->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
            $pdo = new PDO($dsn . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $opts);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        exit('<body style="font-family:sans-serif;background:#020617;color:#e2e8f0;padding:40px">
              <h2>Can\'t connect to the database</h2>
              <p>Open the XAMPP Control Panel and click <b>Start</b> next to <b>MySQL</b>, then refresh.</p>
              <p style="color:#94a3b8">Details: ' . htmlspecialchars($e->getMessage()) . '</p></body>');
    }
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin','user') NOT NULL DEFAULT 'user',
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(150) NOT NULL,
        email VARCHAR(150) NOT NULL,
        phone VARCHAR(50) NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    return $pdo;
}
function h($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_field(): string { return '<input type="hidden" name="csrf" value="' . csrf_token() . '">'; }
function csrf_ok(): bool { return isset($_POST['csrf']) && hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf']); }
function current_user(): ?array { return $_SESSION['user'] ?? null; }
function require_login(): void {
    if (!current_user()) { header('Location: login.php?next=' . urlencode(basename($_SERVER['PHP_SELF']))); exit; }
}
