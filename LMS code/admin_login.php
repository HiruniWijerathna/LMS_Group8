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
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Admin Login</h1>
    <form method="POST">
        <label>Email: <input type="email" name="email" value="admin@gmail.com" required></label>
        <label>Password: <input type="password" name="password" value="123" required></label>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
