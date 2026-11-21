<?php
session_start();
require_once 'db.php';

// Reba niba umukoresha yinjiye KANDI ari admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Gushaka ibitabo byose muri database
$stmt = $pdo->query("SELECT * FROM ebooks ORDER BY ebook_id DESC");
$books = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Online School Library</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .admin-container { padding: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #1a252f; color: white; }
        .btn-small { padding: 6px 12px; font-size: 14px; text-decoration: none; border-radius: 5px; color: white; display: inline-block; }
        .btn-edit { background-color: #ffc107; color: #000; }
        .btn-delete { background-color: #dc3545; }
        .btn-add { background-color: #28a745; margin-bottom: 20px; display: inline-block; padding: 10px 20px; text-decoration: none; border-radius: 5px; color: white; font-weight: bold;}
    </style>
</head>
<body class="landing-page">
    <header class="navbar">
        <div class="logo">📚 Admin Panel</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="dashboard.php">My Dashboard</a>
            <span style="color: #fff; margin-left: 20px; font-size: 16px;">Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
            <a href="logout.php" class="btn-login" style="background-color: #dc3545; margin-left: 15px; text-decoration: none;">Logout</a>
        </nav>
    </header>

    <div class="admin-container">
        <h1>Manage E-Books</h1>
        
        <a href="add_book.php" class="btn-add">+ Add New Book</a>

        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?php echo $book['ebook_id']; ?></td>
                <td><?php echo htmlspecialchars($book['title']); ?></td>
                <td><?php echo htmlspecialchars($book['author']); ?></td>
                <td><?php echo htmlspecialchars($book['category']); ?></td>
                <td>
                    <a href="edit_book.php?id=<?php echo $book['ebook_id']; ?>" class="btn-small btn-edit">Edit</a>
                    <a href="delete_book.php?id=<?php echo $book['ebook_id']; ?>" class="btn-small btn-delete" onclick="return confirm('Urabyizeye? Ugisiba iki gitabo?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>