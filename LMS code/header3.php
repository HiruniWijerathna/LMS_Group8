<?php
session_start();
require 'db.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$stmt = $pdo->prepare("
    SELECT name
    FROM users
    WHERE id = :user_id
");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch();

$username = $user['name']; // Assign username from the fetched user data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library Header</title>
    <style>
        /* General Styling */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Header Bar Styling */
        .header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #428d8d;
            color: white;
            padding: 10px 0px;
            border-bottom: 2px solid black;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .brand {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-top: 5px;
            text-align: center;
            margin-left: 5%;
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 24px; /* Smaller font size */
            font-weight: bold;
            color: red; 
            -webkit-text-stroke: 1px black; /* Smaller text stroke */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Lighter shadow effect */
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-right: 50px;
            font-size: 20px;
        }

        .user-info span {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <header class="header-bar">
        <div class="brand">EpicReads</div>
        <div class="user-info">
            <span role="img" aria-label="User Icon">👤</span>
            <span class="username"><?php echo htmlspecialchars($username); ?></span>
        </div>
    </header>
</body>
</html>
