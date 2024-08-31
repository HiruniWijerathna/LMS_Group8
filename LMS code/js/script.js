<?php
include '../db.php';
session_start();

$user_id = isset($_SESSION['admin']) ? $_SESSION['admin'] : (isset($_SESSION['user']) ? $_SESSION['user'] : null);

if (!$user_id) {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $sql = "SELECT password FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (password_verify($old_password, $row['password'])) {
        $sql = "UPDATE users SET password='$new_password' WHERE id='$user_id'";
        if ($conn->query($sql)) {
            echo "Password changed successfully!";
        } else {
            echo "Error updating password.";
        }
    } else {
        echo "Old password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    <h2>Change Password</h2>
    <form method="POST">
        <label>Old Password:</label>
        <input type="password" name="old_password" required>
        <label>New Password:</label>
        <input type="password" name="new_password" required>
        <button type="submit">Change Password</button>
    </form>
</body>
</html>