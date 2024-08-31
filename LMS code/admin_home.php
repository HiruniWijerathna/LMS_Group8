<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

require 'db.php';

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

if (isset($_POST['delete_book'])) {
    $book_id = $_POST['book_id'];
    $stmt = $pdo->prepare("DELETE FROM books WHERE id = :book_id");
    $stmt->execute(['book_id' => $book_id]);
}

// Fetch books
$stmt = $pdo->query("SELECT * FROM books");
$books = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Admin Home</h1>
    <form method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
    <h2>Upload Book</h2>
    <form action="admin_upload_book.php" method="GET">
        <button type="submit">Upload Book</button>
    </form>

  
  
   
    <h2>Manage Users</h2>
    <form action="manage_users.php" method="GET">
        <button type="submit">Manage Users</button>
    </form>
    <h2>View Book Details</h2>
    <form action="admin_view_book.php" method="GET">
        <button type="submit">View Book</button>
    </form>
    <h2>User Book List</h2>
    <form action="user_book_list.php" method="GET">
        <button type="submit">View User Book List</button>
    </form>
</body>
</html>
