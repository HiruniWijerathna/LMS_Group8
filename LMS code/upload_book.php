<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $keywords = $_POST['keywords'];

    // Handle file upload
    if (isset($_FILES['file']) && isset($_FILES['image'])) {
        $file = $_FILES['file'];
        $image = $_FILES['image'];

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
        } else {
            echo "Failed to upload files.";
        }
    } else {
        echo "No files uploaded.";
    }
}
?>
