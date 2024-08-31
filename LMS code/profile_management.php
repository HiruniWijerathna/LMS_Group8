<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $mobile_number = $_POST['mobile_number'];

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = 'uploads/profile_pictures/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Update profile with new picture
                $stmt = $pdo->prepare("UPDATE users SET mobile_number = :mobile_number, profile_picture = :profile_picture WHERE id = :id");
                $stmt->execute([
                    'mobile_number' => $mobile_number,
                    'profile_picture' => $dest_path,
                    'id' => $user_id
                ]);
            } else {
                $error = 'Error uploading profile picture.';
            }
        } else {
            $error = 'Invalid file type. Only image files are allowed.';
        }
    } else {
        // Update profile without changing picture
        $stmt = $pdo->prepare("UPDATE users SET mobile_number = :mobile_number WHERE id = :id");
        $stmt->execute([
            'mobile_number' => $mobile_number,
            'id' => $user_id
        ]);
    }

    header('Location: user_home.php');
    exit;
}
?>
