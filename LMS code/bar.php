<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>side bar</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
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

        .nav-menu ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

     

        .nav-menu .icon {
            margin-right: 10px;
        }

        .separator-line {
            height: 1px;
            background-color: #666;
            margin: 20px 0;
        }

        .content-container {
            flex-grow: 1;
            padding: 40px;
            background-color: #fff;
            padding-left: 22%;
            padding-top: 10%;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .book-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        



    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar-container">
        <!-- Brand Section -->
       

        <!-- Navigation Menu -->
        <nav class="nav-menu">
            <ul>
                <li >
                    <a href="admin_home.php">
                        <span class="icon">🏠</span> Home
                    </a>
                </li>
            </ul>
            <ul>
                <li >
                    <a href="admin_upload_book.php">
                        <span class="icon">📚</span> Upload Book
                    </a>
                </li>
            </ul>
            <ul>
                <li class="active">
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

    </body>
</html>
