<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $keywords = $_POST['keywords'];
    
    // Ensure the uploads/books directory exists
    $uploadFileDir = 'uploads/books/';
    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true); // Create directory if it doesn't exist
    }

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        $fileNameCmps = explode('.', $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Check if the file is a PDF
        if ($fileExtension === 'pdf') {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Save book information to the database
                $stmt = $pdo->prepare("INSERT INTO books (title, keywords, file_path) VALUES (:title, :keywords, :file_path)");
                $stmt->execute([
                    'title' => $title,
                    'keywords' => $keywords,
                    'file_path' => $dest_path
                ]);

                header('Location: admin_home.php');
                exit;
            } else {
                $error = 'Error moving uploaded PDF file. Check directory permissions.';
            }
        } else {
            $error = 'Invalid file type. Only PDF files are allowed.';
        }
    } else {
        $error = 'Error uploading file.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Book</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Upload Book</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Book Title: <input type="text" name="title" required></label>
        <label>Keywords: <input type="text" name="keywords"></label>
        <label>Upload PDF: <input type="file" name="file" accept=".pdf" required></label>
        <button type="submit">Upload Book</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
