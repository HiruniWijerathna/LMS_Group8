<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];

    // Check if the book is already in the library
    $stmt = $pdo->prepare("SELECT * FROM user_books WHERE user_id = :user_id AND book_id = :book_id");
    $stmt->execute(['user_id' => $user_id, 'book_id' => $book_id]);
    $existing = $stmt->fetch();

    if (!$existing) {
        // Add book to the user's library
        $stmt = $pdo->prepare("INSERT INTO user_books (user_id, book_id) VALUES (:user_id, :book_id)");
        $stmt->execute(['user_id' => $user_id, 'book_id' => $book_id]);
    }
}

// Redirect to My Library page
header('Location: my_library.php');
exit;
