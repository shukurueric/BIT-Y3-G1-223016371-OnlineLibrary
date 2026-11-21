<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// --- Imibare (Statistics) ---
// 1. Ibitabo byatijwe (Borrowed)
$stmt_b = $pdo->prepare("SELECT COUNT(*) FROM borrowings WHERE user_id = ? AND returned_at IS NULL");
$stmt_b->execute([$user_id]);
$total_borrowed = $stmt_b->fetchColumn();

// 2. Amapaji yasomwe (Pages Read)
$stmt_p = $pdo->prepare("
    SELECT SUM(rl.pages_read) 
    FROM reading_logs rl 
    JOIN borrowings b ON rl.borrow_id = b.borrow_id 
    WHERE b.user_id = ?
");
$stmt_p->execute([$user_id]);
$total_pages = $stmt_p->fetchColumn() ?: 0;

// 3. Kubara iminsi isigaye (Days Remaining)
$stmt_d = $pdo->prepare("SELECT MIN(due_date) as next_due FROM borrowings WHERE user_id = ? AND returned_at IS NULL");
$stmt_d->execute([$user_id]);
$next_due = $stmt_d->fetchColumn();

$days_remaining = 0;
if ($next_due) {
    $today = new DateTime();
    $due = new DateTime($next_due);
    $interval = $today->diff($due);
    $days_remaining = $interval->format('%r%a');
    if ($days_remaining < 0) $days_remaining = "Overdue";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Online School Library</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .dashboard-container { padding: 40px; }
        .stats-grid { display: flex; gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); flex: 1; text-align: center; }
        .stat-card h3 { color: #007bff; font-size: 30px; margin-bottom: 5px; }
    </style>
</head>
<body class="landing-page">
    <header class="navbar">
        <div class="logo">📚 Online Library</div>
        <nav>
            <a href="index.php">Home</a>
            <span style="color: #fff; margin-left: 20px; font-size: 16px;">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <a href="logout.php" class="btn-login" style="background-color: #dc3545; margin-left: 15px; text-decoration: none;">Logout</a>
        </nav>
    </header>

    <div class="dashboard-container">
        <h1>Welcome to your Dashboard, <?php echo htmlspecialchars($username); ?>!</h1>
        <p>Role: <strong><?php echo htmlspecialchars($role); ?></strong></p>

        <div class="stats-grid">
            <div class="stat-card">
                <h3><?php echo $total_borrowed; ?></h3>
                <p>Books Borrowed</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $total_pages; ?></h3>
                <p>Pages Read</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $days_remaining; ?></h3>
                <p>Days Remaining</p>
            </div>
        </div>

        <h2>My Borrowed Books</h2>
        
        <div class="book-grid" style="margin-top: 20px;">
            <?php
            $stmt = $pdo->prepare("
                SELECT b.borrow_id, e.title, e.author, b.borrowed_at, b.due_date, b.returned_at 
                FROM borrowings b 
                JOIN ebooks e ON b.ebook_id = e.ebook_id 
                WHERE b.user_id = ? AND b.returned_at IS NULL
            ");
            $stmt->execute([$user_id]);
            $borrowed_books = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($borrowed_books)) {
                echo "<p style='color: #888; width: 100%;'>Nta bitabo uratanga ubu. <a href='index.php' style='color: #007bff;'>Jya gushakisha ibitabo</a></p>";
            } else {
                foreach ($borrowed_books as $b) {
                    echo '<div class="book-card">';
                    echo '<h3>' . htmlspecialchars($b['title']) . '</h3>';
                    echo '<p>Author: ' . htmlspecialchars($b['author']) . '</p>';
                    echo '<p style="color: #007bff; font-size: 14px; margin-bottom: 15px;">Due: ' . htmlspecialchars($b['due_date']) . '</p>';
                    
                    // Ifishi yo kwandika amapaji (Reading Logs)
                    echo '<form action="add_log.php" method="POST" style="margin-top: 10px; display: flex; gap: 5px; justify-content: center;">';
                    echo '<input type="hidden" name="borrow_id" value="' . $b['borrow_id'] . '">';
                    echo '<input type="number" name="pages" placeholder="Pages read" style="width: 100px; padding: 8px; border: 1px solid #ccc; border-radius: 5px;" required>';
                    echo '<button type="submit" class="btn" style="padding: 8px 15px; background-color: #007bff; font-size: 14px; width: auto;">Log</button>';
                    echo '</form>';

                    // Buto ya Return
                    echo '<form action="return_book.php?id=' . $b['borrow_id'] . '" method="GET" style="margin-top: 10px;">';
                    echo '<button type="submit" class="btn" style="background-color: #28a745;">Return Book</button>';
                    echo '</form>';
                    
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>