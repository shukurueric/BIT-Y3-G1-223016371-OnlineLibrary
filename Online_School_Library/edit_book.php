<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Reba niba ID yoherejwe
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$id = $_GET['id'];
$error = '';
$success = '';

// Gushaka igitabo gisanzweho
$stmt = $pdo->prepare("SELECT * FROM ebooks WHERE ebook_id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    die("Igitabo nticyabonetse.");
}

// Niba ifishi yoherejwe (Update)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $file_url = trim($_POST['file_url']);

    if (!empty($title) && !empty($author) && !empty($category)) {
        $sql = "UPDATE ebooks SET title = ?, author = ?, category = ?, file_url = ? WHERE ebook_id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$title, $author, $category, $file_url, $id])) {
            $success = "Igitabo cyahinduwe neza!";
            // Subiza amakuru mashya
            $book['title'] = $title;
            $book['author'] = $author;
            $book['category'] = $category;
            $book['file_url'] = $file_url;
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
    <title>Edit Book - Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container" style="margin-top: 50px;">
        <h2>Edit E-Book</h2>
        
        <?php if (!empty($error)) { echo "<p style='color: red; text-align: center;'>$error</p>"; } ?>
        <?php if (!empty($success)) { echo "<p style='color: green; text-align: center;'>$success</p>"; } ?>

        <form action="edit_book.php?id=<?php echo $id; ?>" method="POST">
            <div class="input-group">
                <label>Title</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
            </div>
            <div class="input-group">
                <label>Author</label>
                <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
            </div>
            <div class="input-group">
                <label>Category</label>
                <input type="text" name="category" value="<?php echo htmlspecialchars($book['category']); ?>" required>
            </div>
            <div class="input-group">
                <label>Image Filename</label>
                <input type="text" name="file_url" value="<?php echo htmlspecialchars($book['file_url']); ?>">
            </div>
            <button type="submit" class="btn">Update Book</button>
        </form>
        <p class="register-link"><a href="admin_dashboard.php">Back to Admin Panel</a></p>
    </div>
</body>
</html>