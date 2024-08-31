<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $keywords = htmlspecialchars($_POST['keywords']);

    // Handle file upload
    if (isset($_FILES['file']) && isset($_FILES['image'])) {
        $file = $_FILES['file'];
        $image = $_FILES['image'];

        // Validate file type (e.g., PDF for book, JPEG/PNG for image)
        $allowedFileTypes = ['application/pdf'];
        $allowedImageTypes = ['image/jpeg', 'image/png'];

        if (in_array($file['type'], $allowedFileTypes) && in_array($image['type'], $allowedImageTypes)) {
            // Validate and move uploaded files
            $filePath = 'uploads/files/' . basename($file['name']);
            $imagePath = 'uploads/images/' . basename($image['name']);

            // Create directories if they don't exist
            if (!is_dir('uploads/files')) {
                mkdir('uploads/files', 0777, true);
            }
            if (!is_dir('uploads/images')) {
                mkdir('uploads/images', 0777, true);
            }

            // Move uploaded files to the server
            if (move_uploaded_file($file['tmp_name'], $filePath) && move_uploaded_file($image['tmp_name'], $imagePath)) {
                // Insert book details into the database
                $stmt = $pdo->prepare("INSERT INTO books (title, keywords, file_path, image_path) VALUES (:title, :keywords, :file_path, :image_path)");
                $stmt->execute([
                    'title' => $title,
                    'keywords' => $keywords,
                    'file_path' => $filePath,
                    'image_path' => $imagePath
                ]);
                echo "Book uploaded successfully.";
                header('Location: admin_view_book.php');
                exit;
            } else {
                echo "Failed to upload files.";
            }
        } else {
            echo "Invalid file types. Please upload a PDF file for the book and a JPEG/PNG image.";
        }
    } else {
        echo "No files uploaded.";
    }
}
?>
