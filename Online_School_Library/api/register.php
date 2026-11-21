<?php
session_start();
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Kugenzura CSRF Token
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($email) && !empty($password)) {
        // Reba niba umukoresha cyangwa email isanzweho
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Username or Email already exists!";
        } else {
            // Hashing password (Umutekano)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role = 'student'; // Abiyandikisha ni abanyeshuri

            $sql = "INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute([$username, $email, $hashed_password, $role])) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Online School Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Create an Account</h2>
        <p>Join to start borrowing e-books</p>
        
        <?php if (!empty($error)) { echo "<p style='color: red; text-align: center; font-weight: bold;'>$error</p>"; } ?>
        <?php if (!empty($success)) { echo "<p style='color: green; text-align: center; font-weight: bold;'>$success</p>"; } ?>
        
        <form action="register.php" method="POST">
            <!-- CSRF Token (Umutekano) -->
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Choose a username" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password" required>
            </div>
            
            <button type="submit" class="btn">Register</button>
        </form>
        
        <p class="register-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>