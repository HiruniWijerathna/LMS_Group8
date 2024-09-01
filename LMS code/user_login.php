
<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'db.php';  // Ensure this path is correct

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND user_type = 'user'");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // User credentials are correct
        $_SESSION['user_id'] = $user['id'];
        header('Location: user_home.php');
        exit;
    } else {
        // Invalid credentials
        $error = 'Invalid email or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="image-container">
            <img src="image/book6.jpg" alt="Book Image" style="width: 100%; height: 100%;">
        </div>
        <div class="form-container">
            <div class="tabs">
                <a href="user_login.php" class="tab active">Login</a>
                <a href="user_register.php" class="tab">Register</a>
            </div>
            <h1 class="welcome">WELCOME BACK!!</h1>
            <form method="POST">
                <label>Your Email: <input type="email" name="email" required></label>
                <label>Your Password: <input type="password" name="password" required></label>
                <div class="remember-me">
                    <label><input type="checkbox" name="remember"> Remember Me</label>
                    <a href="#" class="forgot-password">Forgot your password? Click here</a>
                </div>
                <button type="submit" class="login-button">Login to Your Account</button>
            </form>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <p class="register-text">Don't have an account? <a href="user_register.php" class="register-link">Register</a></p>
        </div>
    </div>
</body>
</html>