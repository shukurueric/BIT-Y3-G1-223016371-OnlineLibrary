<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Gusiba igitabo muri database
    $stmt = $pdo->prepare("DELETE FROM ebooks WHERE ebook_id = ?");
    if ($stmt->execute([$id])) {
        echo "<script>alert('Igitabo cyasibwe neza!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Habaye ikibazo mu gusiba.'); window.location.href='admin_dashboard.php';</script>";
    }
} else {
    header("Location: admin_dashboard.php");
    exit;
}
?>