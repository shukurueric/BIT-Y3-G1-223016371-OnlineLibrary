<?php
// db.php - Database Connection & Security Functions

// --- CSRF Token Functions ---
// Iyi function ikora token niba itayihari
function generate_csrf_token() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Iyi function igenzura niba token ari yo
function verify_csrf_token($token) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die("<h3 style='color: red; text-align: center; margin-top: 50px;'>CSRF token validation failed! (Umutekano)</h3>");
    }
}

// --- Database Connection ---
$host = 'localhost';
$dbname = 'online_library';
$username = 'root';
$password = ''; // Muri WAMP, password isanzwe iri ubusa

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Kwereka PHP ko dukoresha amakosa (Error handling)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>