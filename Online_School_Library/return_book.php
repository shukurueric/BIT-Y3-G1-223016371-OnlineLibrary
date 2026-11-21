<?php
session_start();
require_once 'db.php';

// Reba niba umukoresha yinjiye
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $borrow_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Reba niba iki gitabo ari icy'uyu mukoresha
    $stmt = $pdo->prepare("SELECT * FROM borrowings WHERE borrow_id = ? AND user_id = ? AND returned_at IS NULL");
    $stmt->execute([$borrow_id, $user_id]);
    
    if ($stmt->rowCount() > 0) {
        // Hindura returned_at (Gusubiza igitabo)
        $update = $pdo->prepare("UPDATE borrowings SET returned_at = NOW() WHERE borrow_id = ?");
        if ($update->execute([$borrow_id])) {
            echo "<script>alert('Igitabo cyasubijwe neza! Murakoze.'); window.location.href='dashboard.php';</script>";
            exit;
        } else {
            echo "<script>alert('Habaye ikibazo mu gusubiza igitabo.'); window.location.href='dashboard.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Iki gitabo nticyabonetse cyangwa ntabwo ari icyawe.'); window.location.href='dashboard.php';</script>";
        exit;
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>