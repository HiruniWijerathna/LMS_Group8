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
    <link rel="stylesheet" href="css/login.css"> <!-- Ensure this path is correct -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
</head>
<body>
       <!-- Home Button with Icon -->
       <div style="position: absolute; top: 10px; left: 10px;" class="home-button">
        <a href="index.php" class="home-button">
            <img src="image/home_icon.png" alt="Home Icon" class="home-icon">
            
        </a>
    </div>
    
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
