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
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>User Login</h1>
    <form method="POST">
        <label>Email: <input type="email" name="email" required></label>
        <label>Password: <input type="password" name="password" required></label>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
