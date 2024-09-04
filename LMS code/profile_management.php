<?php 

include 'header3.php'; 
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

    // Check if profile already exists
    $stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $profileExists = $stmt->fetch();

    if ($profileExists) {
        // Update existing profile
        $stmt = $pdo->prepare("
            UPDATE profiles
            SET mobile_number = :mobile_number, profile_picture = :profile_picture
            WHERE user_id = :user_id
        ");
    } else {
        // Insert new profile
        $stmt = $pdo->prepare("
            INSERT INTO profiles (user_id, mobile_number, profile_picture)
            VALUES (:user_id, :mobile_number, :profile_picture)
        ");
    }

    // Execute the query
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
    <link rel="stylesheet" href="css/user_home.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-size: cover;
            background-image: url('image/book12.jpg');
            background-position: center;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .profile-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 600px;
            margin-top: 300px;
            margin-left: 300px;
        }
        .profile-form label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
            font-weight: bold;
        }
        .profile-form input[type="text"],
        .profile-form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .profile-form button {
            width: 100%;
            padding: 10px;
            background-color: rgba(45, 172, 143, 1);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .profile-form button:hover {
            background-color: #2980b9;
        }
        .profile-picture img {
            max-width: 150px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 24px;
        }
    </style>
</head>
<body>
<div class="sidebar-container">

    <!-- Navigation Menu -->
    <nav class="nav-menu">
        <ul>
            <li>
                <a href="user_home.php">
                    <span class="icon">🏠</span> Home
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="all_books.php">
                    <span class="icon">📚</span> View All Books
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="my_library.php">
                    <span class="icon">📖</span> My Library
                </a>
            </li>
        </ul>
        <ul>
            <li  class="active">
                <a href="profile_management.php">
                    <span class="icon">👤</span> Manage Profile
                </a>
            </li>
        </ul>
        <!-- Separator Line -->
        <div class="separator-line"></div>
        <ul>
            <li>
                <a href="logout.php">
                    <span class="icon">🚪</span> Logout
                </a>
            </li>
        </ul>
    </nav>
</div>
    <div class="profile-container">
        <h1>Manage Profile</h1>
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
