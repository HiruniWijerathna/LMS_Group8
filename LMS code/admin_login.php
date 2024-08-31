<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'db.php';
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check for admin credentials
    if ($email === 'admin@gmail.com' && $password === '123') {
        $_SESSION['admin_id'] = 1; // Assuming admin_id is 1
        header('Location: admin_home.php');
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
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/login.css"> <!-- Reuse the login.css -->
</head>
<body>
    <div class="login-container">
        <div class="image-container">
            <img src="image/book6.jpg" alt="Book Image" style="width: 100%; height: 100%;">
        </div>
        <div class="form-container">
            <h1 class="welcome">Admin Login</h1>
            <form method="POST">
                <label>Email: <input type="email" name="email" value="admin@gmail.com" required></label>
                <label>Password: <input type="password" name="password" value="123" required></label>
                <button type="submit" class="login-button">Login to Your Account</button>
            </form>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        </div>
    </div>
</body>
</html>
