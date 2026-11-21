<?php
session_start();
require_once 'db.php';

// Reba niba umukoresha yinjiye
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Reba niba ifishi yoherejwe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ebook_id'])) {
    $ebook_id = $_POST['ebook_id'];
    $user_id = $_SESSION['user_id'];
    
    // Guhita utanga igitabo (Borrow logic)
    try {
        // Reba niba umukoresha ataratanga iki gitabo
        $check = $pdo->prepare("SELECT * FROM borrowings WHERE ebook_id = ? AND user_id = ? AND returned_at IS NULL");
        $check->execute([$ebook_id, $user_id]);
        
        if ($check->rowCount() > 0) {
            echo "<script>alert('Uyu mukoresha yamaze gutanga iki gitabo!'); window.location.href='index.php';</script>";
            exit;
        } else {
            // Bika ko yatse igitabo
            $sql = "INSERT INTO borrowings (ebook_id, user_id, due_date) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 7 DAY))";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute([$ebook_id, $user_id])) {
                echo "<script>alert('Byagenze neza! Watse igitabo. Ufite iminsi 7 yo kugisoma.'); window.location.href='dashboard.php';</script>";
                exit;
            } else {
                echo "<script>alert('Habaye ikibazo. Ongera ugerageze.'); window.location.href='index.php';</script>";
            }
        }
    } catch(PDOException $e) {
        echo "Ikibazo: " . $e->getMessage();
    }
} else {
    // Niba nta ebook_id yoherejwe
    header("Location: index.php");
    exit;
}
?>