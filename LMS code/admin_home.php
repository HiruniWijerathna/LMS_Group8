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

// Fetch total number of books
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM books");
$totalBooks = $stmt->fetchColumn();

// Fetch total number of users
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM users"); // Assuming your users table is named 'users'
$totalUsers = $stmt->fetchColumn();

// Fetch all books
$stmt = $pdo->query("SELECT * FROM books");
$totalBorrowed = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        
            color: #ecf0f1;
            margin-top: 5px;
            text-align: center;
            margin-left: 10%;
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 24px; /* Smaller font size */
            font-weight: bold;
            color: red; /* Change color to red */
            -webkit-text-stroke: 1px black; /* Smaller text stroke */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Lighter shadow effect */
        }

        /* Navigation Menu */
        .nav-menu ul,
        .settings-menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .nav-menu ul li,
        .settings-menu ul li {
            margin: 10px 0;
        }

        .nav-menu ul li a,
        .settings-menu ul li a {
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
        .nav-menu ul li a:hover,
        .settings-menu ul li a:hover {
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar-container {
                width: 100%;
                height: auto;
                position: relative;
            }

            .nav-menu ul li,
            .settings-menu ul li {
                margin: 10px 0;
            }
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

    </style>
</head>
<body>

<div class="sidebar-container">
    <!-- Brand Section -->


    <!-- Navigation Menu -->
    <nav class="nav-menu">
        <ul>
            <li class="active">
                <a href="admin_home.php">
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
        <h2>Overview</h2>
        <p>Get a quick summary of key statistics and recent activities.</p>
        <div class="statistics">
            <div class="stat-box">
                <h3><?php echo htmlspecialchars($totalBooks); ?></h3>
                <p>Total Books</p>
            </div>
            <div class="stat-box">
                <h3><?php echo htmlspecialchars($totalUsers); ?></h3>
                <p>Registered Users</p>
            </div>
           
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="section">
        <h2>Quick Actions</h2>
        <p>Perform common tasks quickly.</p>
        <div class="quick-actions">
            <div class="action-card" onclick="location.href='admin_upload_book.php';">
                <h3>Upload New Book</h3>
                <p>Upload new books to the library</p>
            </div>
            <div class="action-card" onclick="location.href='admin_view_book.php';">
                <h3>Manage Books</h3>
                <p>View and manage existing books</p>
            </div>
            <div class="action-card" onclick="location.href='manage_users.php';">
                <h3>Manage Users</h3>
                <p>Manage user accounts and roles</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
