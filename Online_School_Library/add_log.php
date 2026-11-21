<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrow_id']) && isset($_POST['pages'])) {
    $borrow_id = $_POST['borrow_id'];
    $pages = (int)$_POST['pages'];

    if ($pages > 0) {
        // Reba niba hari log isanzweho kuri iyi borrow_id
        $check = $pdo->prepare("SELECT * FROM reading_logs WHERE borrow_id = ?");
        $check->execute([$borrow_id]);

        if ($check->rowCount() > 0) {
            // Niba ihari, yongereho amapaji
            $update = $pdo->prepare("UPDATE reading_logs SET pages_read = pages_read + ?, last_read_at = NOW() WHERE borrow_id = ?");
            $update->execute([$pages, $borrow_id]);
        } else {
            // Niba itayihari, kora nshya
            $insert = $pdo->prepare("INSERT INTO reading_logs (borrow_id, pages_read) VALUES (?, ?)");
            $insert->execute([$borrow_id, $pages]);
        }
    }
    header("Location: dashboard.php");
    exit;
}
?>