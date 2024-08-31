<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $re_password = $_POST['re_password'];

    if ($password !== $re_password) {
        $error = "Passwords do not match.";
    } else {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $error = "Email is already registered.";
        } else {
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
            if ($conn->query($sql)) {
                $success = "Registration successful!";
                header("Location: user_login.php");
            } else {
                $error = "Error: " . $conn->error;
            }
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
    <link rel="stylesheet" href="css/register.css"> <!-- Link to the CSS file -->
</head>
<body>
    <div class="login-container">
        <div class="image-container">
            <img src="image/book6.jpg" alt="Book Image" style="width: 100%; height: 100%;">
        </div>
        <div class="form-container">
            <div class="tabs">
                <a href="user_login.php" class="tab ">Login</a>
                <a href="user_register.php" class="tab active">Register</a>
            </div>
            <h1 class="welcome">REGISTER ACCOUNT</h1>
            <form method="POST">
                <label>Your Email: <input type="email" name="email" required></label>
                <label>Your Password: <input type="password" name="password" required></label>
                <label>Re-enter Password: <input type="password" name="re_password" id="re_password" required></label>
                <div class="terms-conditions">
                    <label><input type="checkbox" name="terms and conditions" required> I accept the Terms and Conditions</label>
                </div>
                <button type="submit" class="register-button">Create Account</button>
            </form>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <p class="login-text">Already have an Account? <a href="user_login.php" class="login-link">Login here</a></p>
        </div>
    </div>
</body>
</html>