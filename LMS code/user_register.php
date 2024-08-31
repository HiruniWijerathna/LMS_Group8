<?php
include './db.php'; // Ensure this path is correct relative to the location of your file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password

    // Check if the email already exists
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    if ($stmt->rowCount() > 0) {
        echo "Email is already registered.";
    } else {
        // Insert user details into the database
        $sql = "INSERT INTO users (name, email, password, user_type) VALUES (:name, :email, :password, 'user')";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ])) {
            echo "Registration successful!";
            header("Location: user_login.php");  // Redirect to login page
            exit;
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
