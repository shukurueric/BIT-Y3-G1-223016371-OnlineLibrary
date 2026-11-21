<?php
session_start();
require_once 'db.php';

// Reba niba umukoresha yinjiye
$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? $_SESSION['username'] : '';

// Gushaka ibitabo byose muri database (Default view)
$stmt = $pdo->query("SELECT * FROM ebooks");
$books = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online School Library - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="landing-page">

    <!-- Umutwe w'urubuga (Navigation Bar) -->
    <header class="navbar">
        <div class="logo">📚 Online Library</div>
        <nav>
            <a href="index.php">Home</a>
            
            <?php if ($is_logged_in): ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="admin_dashboard.php" style="color: #ffc107; margin-left: 10px;">Admin Panel</a>
                <?php endif; ?>
                <span style="color: #fff; margin-left: 20px; font-size: 16px;">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
                <a href="logout.php" class="btn-login" style="background-color: #dc3545; margin-left: 15px; text-decoration: none;">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn-login" style="text-decoration: none;">Login</a>
            <?php endif; ?>
            
        </nav>
    </header>

    <!-- Igice cy'ibanze (Hero Section) -->
    <section class="hero">
        <h1>Welcome to the Online School Library</h1>
        <p>Discover, borrow, and read thousands of e-books from the comfort of your home.</p>
        
        <?php if ($is_logged_in): ?>
            <a href="dashboard.php" class="btn" style="text-decoration: none; display: inline-block; width: auto; padding: 12px 30px;">Go to Dashboard</a>
        <?php else: ?>
            <a href="login.php" class="btn" style="text-decoration: none; display: inline-block; width: auto; padding: 12px 30px;">Start Borrowing</a>
        <?php endif; ?>
    </section>

    <!-- Igice cy'Ibitabo (Featured E-books) -->
    <section class="featured-books">
        <h2>Featured E-Books</h2>
        
        <!-- Search Input (Kuri Day 9 - Async) -->
        <div style="text-align: center; margin-bottom: 30px;">
            <input type="text" id="searchInput" placeholder="Search for a book or author..." 
                   style="width: 50%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
        </div>

        <div class="book-grid" id="bookGrid">
            <?php
            // Niba nta bitabo birimo
            if (count($books) == 0) {
                echo "<p style='text-align:center; width:100%; color:#666;'>Nta bitabo birimo muri bubiko ubu.</p>";
            } else {
                // Kwerekana buri gitabo
                foreach ($books as $book) {
                    echo '<div class="book-card">';
                    echo '<img src="images/' . htmlspecialchars($book['file_url']) . '" alt="Book Cover">';
                    echo '<h3>' . htmlspecialchars($book['title']) . '</h3>';
                    echo '<p>Author: ' . htmlspecialchars($book['author']) . '</p>';
                    
                    // Ifishi yo kohereza kuri borrow.php
                    echo '<form action="borrow.php" method="POST" style="margin-top: 10px;">';
                    echo '<input type="hidden" name="ebook_id" value="' . $book['ebook_id'] . '">';
                    echo '<button type="submit" class="btn">Borrow</button>';
                    echo '</form>';
                    
                    echo '</div>';
                }
            }
            ?>
        </div>
    </section>

    <!-- JavaScript: Async Live Search (Day 9) -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const bookGrid = document.getElementById('bookGrid');
        let timer;

        searchInput.addEventListener('input', () => {
            clearTimeout(timer); // Debounce
            
            timer = setTimeout(async () => {
                const query = searchInput.value;
                
                // Niba nta kintu cyanditswe, subiza ibitabo byose (Reload page)
                if (query.trim() === '') {
                    window.location.reload(); 
                    return;
                }

                try {
                    // Koresha Fetch kubaza API
                    const response = await fetch('api/search_books.php?search=' + encodeURIComponent(query));
                    const result = await response.json();
                    
                    // Sukura grid
                    bookGrid.innerHTML = '';
                    
                    if (result.data.length === 0) {
                        bookGrid.innerHTML = '<p style="text-align:center; width:100%;">Nta gitabo kibonetse.</p>';
                        return;
                    }

                    // Ongeramo ibitabo bishya muri DOM
                    result.data.forEach(book => {
                        const card = document.createElement('div');
                        card.className = 'book-card';
                        card.innerHTML = `
                            <img src="images/${book.file_url}" alt="Book Cover">
                            <h3>${book.title}</h3>
                            <p>Author: ${book.author}</p>
                            <form action="borrow.php" method="POST" style="margin-top: 10px;">
                                <input type="hidden" name="ebook_id" value="${book.ebook_id}">
                                <button type="submit" class="btn">Borrow</button>
                            </form>
                        `;
                        bookGrid.appendChild(card);
                    });

                } catch (error) {
                    console.error('Error fetching data:', error);
                }
            }, 300); // Tegereza 300ms (Debounce)
        });
    </script>

</body>
</html>