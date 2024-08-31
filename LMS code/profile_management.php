<?php
session_start();
require 'db.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user profile data
$stmt = $pdo->prepare("
    SELECT users.*, profiles.mobile_number, profiles.profile_picture
    FROM users
    LEFT JOIN profiles ON users.id = profiles.user_id
    WHERE users.id = :user_id
");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $mobile_number = $_POST['mobile_number'];
    $file_path = '';

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_name = basename($_FILES['profile_picture']['name']);
        $upload_dir = 'uploads/profile_pictures/';
        $file_path = $upload_dir . $file_name;

        // Ensure upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move uploaded file
        move_uploaded_file($file_tmp, $file_path);
    } else {
        // Keep existing picture if no new one uploaded
        $file_path = !empty($user['profile_picture']) ? $user['profile_picture'] : '';
    }

    // Update user name
    $stmt = $pdo->prepare("
        UPDATE users
        SET name = :name
        WHERE id = :user_id
    ");
    $stmt->execute([
        'name' => $name,
        'user_id' => $user_id
    ]);

    // Update or insert profile data
    $stmt = $pdo->prepare("
        INSERT INTO profiles (user_id, mobile_number, profile_picture)
        VALUES (:user_id, :mobile_number, :profile_picture)
        ON DUPLICATE KEY UPDATE
            mobile_number = VALUES(mobile_number),
            profile_picture = VALUES(profile_picture)
    ");
    $stmt->execute([
        'user_id' => $user_id,
        'mobile_number' => $mobile_number,
        'profile_picture' => $file_path
    ]);

    // Refresh the page to show updated data
    header('Location: profile_management.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .profile-form label {
            display: block;
            margin: 10px 0 5px;
        }
        .profile-form input[type="text"],
        .profile-form input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        .profile-form button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .profile-form button:hover {
            background-color: #0056b3;
        }
        .profile-picture img {
            max-width: 150px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <h1>Manage Profile</h1>

    <div class="profile-container">
        <form method="POST" enctype="multipart/form-data" class="profile-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            
            <label for="mobile_number">Mobile Number:</label>
            <input type="text" id="mobile_number" name="mobile_number" value="<?php echo htmlspecialchars($user['mobile_number']); ?>">

            <label for="profile_picture">Profile Picture:</label>
            <?php if (!empty($user['profile_picture'])): ?>
                <div class="profile-picture">
                    <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture">
                </div>
            <?php endif; ?>
            <input type="file" id="profile_picture" name="profile_picture">

            <button type="submit" name="update_profile">Update Profile</button>
        </form>
    </div>
</body>
</html>
