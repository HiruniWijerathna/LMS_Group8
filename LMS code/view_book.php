<?php
require 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $book_id = (int)$_GET['id'];

    // Fetch the book details from the database
    $stmt = $pdo->prepare("SELECT file_path FROM books WHERE id = :id");
    $stmt->execute(['id' => $book_id]);
    $book = $stmt->fetch();

    if ($book) {
        $file_path = $book['file_path'];

        // Check if the file exists
        if (file_exists($file_path)) {
            // Send headers to serve the PDF file
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        } else {
            echo 'File not found.';
        }
    } else {
        echo 'Invalid book ID.';
    }
} else {
    echo 'Invalid request.';
}
?>
