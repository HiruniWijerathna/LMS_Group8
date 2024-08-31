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
    
    <h2>Upload Book</h2>
    <form action="upload_book.php" method="POST" enctype="multipart/form-data">
        <label>Book Title: <input type="text" name="title" required></label>
        <label>Keywords: <input type="text" name="keywords"></label>
        <label>File: <input type="file" name="file" required></label>
        <label>Image: <input type="file" name="image" required></label>
        <button type="submit">Upload</button>
    </form>
  
   
 
</body>
</html>
