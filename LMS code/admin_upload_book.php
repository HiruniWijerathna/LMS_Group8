<?php include 'header2.php'; ?>
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
    <style>
        /* General Styling */
        body {
            background-image: url('image/home.png'); /* Path to your background image */
            background-size: cover; /* Cover the entire viewport */
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #ecf0f1;
        }

        /* Sidebar Container */
        .sidebar-container {
            width: 20%;
            height: 100vh;
            background-color: #428d8d;
            color: white;
            display: flex;
            flex-direction: column;
            padding-top: 10%;
            padding-right: 10px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        /* Brand Section */
        .brand {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 50px;
            color: #ecf0f1;
        }

        /* Navigation Menu */
        .nav-menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .nav-menu ul li {
            margin: 10px 0;
        }

        .nav-menu ul li a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 16px;
            display: flex;
            align-items: center;
            padding: 15px 5px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        /* Icon Styles */
        .icon {
            margin-right: 20px;
            font-size: 20px;
        }

        /* Hover Effects */
        .nav-menu ul li a:hover {
            background-color: #34495e;
        }

        /* Active State */
        .nav-menu ul li.active a {
            background-color: #2980b9;
        }

        /* Separator Line */
        .separator-line {
            height: 1px;
            background-color: #bdc3c7;
            margin: 15px 0;
        }

        /* Content Styling */
        .content-container {
            margin-left: 25%;
            padding: 20px;
            padding-top: 10%;
        }

        .section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }

        .section h2 {
            margin-top: 0;
            font-size: 22px;
        }

        .statistics {
            display: flex;
            justify-content: space-between;
        }

        .statistics .stat-box {
            flex: 1;
            background-color:rgba(128, 234, 202, 1);
            border-radius: 8px;
            padding: 20px;
            margin: 0 10px;
            text-align: center;
        }

        .statistics .stat-box h3 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }

        .statistics .stat-box p {
            margin: 5px 0 0;
            color: black;
        }

        .quick-actions {
            display: flex;
            justify-content: space-between;
        }

        .quick-actions .action-card {
            flex: 1;
            background-color:rgba(110, 220, 165, 1);
            border-radius: 8px;
            padding: 20px;
            margin: 0 10px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .quick-actions .action-card:hover {
            background-color: rgba(163, 220, 110, 1);
        }

        .action-card h3 {
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar-container {
                width: 100%;
                height: auto;
                position: relative;
            }

            .nav-menu ul li {
                margin: 10px 0;
            }

            .content-container {
                margin-left: 0;
                padding-top: 5%;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar-container">
        <!-- Brand Section -->
        <div class="brand">EpicReads</div>

        <!-- Navigation Menu -->
        <nav class="nav-menu">
            <ul>
                <li class="active">
                    <a href="home.php">
                        <span class="icon">🏠</span> Home
                    </a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="admin_upload_book.php">
                        <span class="icon">📚</span> Upload Book
                    </a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="admin_view_book.php">
                        <span class="icon">📖</span> View Book
                    </a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="manage_users.php">
                        <span class="icon">👤</span> Manage Users
                    </a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="user_book_list.php">
                        <span class="icon">📋</span> User Book List
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

    <!-- Content Section -->
    <div class="content-container">
        <!-- Overview Section -->
        <div class="section">
            <h2>Upload Book</h2>
            <form action="upload_book.php" method="POST" enctype="multipart/form-data">
               <ul> 
                <li></li><label>Book Title: <input type="text" name="title" required></label></li>
                <li><label>Keywords: <input type="text" name="keywords"></label></li>
                <li><label>File: <input type="file" name="file" required></label></li>
                <li><label>Image: <input type="file" name="image" required></label></li>
                <li><button type="submit">Upload</button>
                </ul>
            </form>
        </div>

        <!-- Other Sections -->
        <!-- Add additional sections as needed -->
    </div>
</body>
</html>
