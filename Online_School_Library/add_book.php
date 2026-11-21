<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $file_url = trim($_POST['file_url']); // Ingaruka: kuri Version 1, turakoresha izina ry'ifoto gusa.

    if (!empty($title) && !empty($author) && !empty($category)) {
        $sql = "INSERT INTO ebooks (title, author, category, file_url) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$title, $author, $category, $file_url])) {
            $success = "Igitabo cyongeweho neza!";
        } else {
            $error = "Habaye ikibazo.";
        }
    } else {
        $error = "Uzuza ibice byose by'ingenzi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book - Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container" style="margin-top: 50px;">
        <h2>Add New E-Book</h2>
        
        <?php if (!empty($error)) { echo "<p style='color: red; text-align: center;'>$error</p>"; } ?>
        <?php if (!empty($success)) { echo "<p style='color: green; text-align: center;'>$success</p>"; } ?>

        <form action="add_book.php" method="POST">
            <div class="input-group">
                <label>Title</label>
                <input type="text" name="title" required>
            </div>
            <div class="input-group">
                <label>Author</label>
                <input type="text" name="author" required>
            </div>
            <div class="input-group">
                <label>Category</label>
                <input type="text" name="category" required>
            </div>
            <div class="input-group">
                <label>Image Filename (e.g., book1.jpg)</label>
                <input type="text" name="file_url" placeholder="book1.jpg">
            </div>
            <button type="submit" class="btn">Add Book</button>
        </form>
        <p class="register-link"><a href="admin_dashboard.php">Back to Admin Panel</a></p>
    </div>
</body>
</html>