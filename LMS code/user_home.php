<?php include 'header2.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
            background-color: rgba(255, 255, 255, 0.7); /* Slightly faded white background */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            margin-bottom: 20px;
            padding: 40px;
            max-width: 600px;
            margin: 20px auto;
           
        }

        .section h2 {
            margin-top: 0;
            font-size: 28px;
            color: #2c3e50;
            text-align: center;
        }

        .section p {
            font-size: 18px;
            color: #34495e;
            line-height: 1.6;
            text-align: center;
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
            <li>
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

<!-- Content Section -->
<div class="content-container">
    <!-- Welcome Section -->
    <div class="section">
        <h2>The Art of Digital Library Mastery</h2>
        <p>Welcome to EpicReads, your gateway to mastering the digital library experience. Our platform empowers you to explore, manage, and enjoy an extensive collection of books with ease. Discover a user-friendly interface designed to enhance your reading journey, whether you're seeking new titles, managing your personal library, or diving into insightful literary content. Join us in transforming the way you engage with books and elevate your digital library experience!</p>
    </div>
</div>

</body>
</html>
