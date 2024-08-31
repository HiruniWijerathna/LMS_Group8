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
    $user_id = $_POST['user_id'];
    $book_id = $_POST['book_id'];
    $stmt = $pdo->prepare("DELETE FROM user_books WHERE user_id = :user_id AND book_id = :book_id");
    $stmt->execute(['user_id' => $user_id, 'book_id' => $book_id]);
}

// Fetch users and their books
$stmt = $pdo->query("
    SELECT users.id AS user_id, users.name AS user_name, GROUP_CONCAT(books.title SEPARATOR ', ') AS books
    FROM users
    LEFT JOIN user_books ON users.id = user_books.user_id
    LEFT JOIN books ON user_books.book_id = books.id
    WHERE users.user_type = 'user'
    GROUP BY users.id
");
$usersBooks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Book List</title>
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

    <style>
         body {
        background-image: url('image/home.png'); /* Path to your background image */
            background-size: cover; /* Cover the entire viewport */
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #ecf0f1;
        }
        h2 {
    font-size: 24px; /* Adjust size as needed */
    color: #2c3e50; /* Dark color for contrast */
    margin-top: 0;
    text-align: center; /* Center the text horizontally */
    margin-bottom: 20px; /* Space below the heading */
    font-weight: bold; /* Make the heading bold */
    border-bottom: 2px solid #428d8d; /* Underline for emphasis */
    padding-bottom: 10px; /* Space between text and underline */
}

        table {
            width: 100%;
            border-collapse: collapse;
            padding-top: 10%;
            padding-left: 20%;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-button {
            background-color: #ff4d4d;
            color: white;
        }
        .delete-button:hover {
            background-color: #cc0000;
        }


        /* Main Container */
.content-container {
    width: 100%;
  
}

/* Headings */
h1 {
    font-size: 36px;
    color: #333;
    text-align: center;
    margin-bottom: 30px;
    font-family: 'Arial', sans-serif;
}

h2 {
    font-size: 24px; /* Adjust size as needed */
    color: #2c3e50; /* Dark color for contrast */
    margin-top: 0;
    text-align: center; /* Center the text horizontally */
    margin-bottom: 20px; /* Space below the heading */
    font-weight: bold; /* Make the heading bold */
    border-bottom: 2px solid #428d8d; /* Underline for emphasis */
    padding-bottom: 10px; /* Space between text and underline */
    
}

/* Logout Button */
form[method="POST"] {
    text-align: center;
    margin-bottom: 20px;
}

form[method="POST"] button {
    padding: 10px 20px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s ease;
}

form[method="POST"] button:hover {
    background-color: #c82333;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table th, table td {
    padding: 15px;
    text-align: left;
    font-size: 1.1em;
}

table th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f4f9;
}

table td {
    border-bottom: 1px solid #ddd;
}

/* Responsive Design */
@media (max-width: 768px) {
    table {
        width: 100%;
    }

    table th, table td {
        font-size: 0.9em;
        padding: 10px;
    }

    h1 {
        font-size: 28px;
    }

    h2 {
        font-size: 22px;
    }
}

.set{
    padding-left: 22%;
    padding-top: 10%;
    padding-right: 5%;
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
                <li >
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
                <li class="active">
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

<div class="set">
    <h1>User Book List</h1>
  
    <h2>Users and Their Books</h2>
    <table>
        <tr>
            <th>User Name</th>
            <th>Books</th>
         
        </tr>
        <?php foreach ($usersBooks as $entry): ?>
        <tr>
            <td><?php echo htmlspecialchars($entry['user_name']); ?></td>
            <td><?php echo htmlspecialchars($entry['books']); ?></td>
            
        </tr>
        <?php endforeach; ?>
    </table>

    </div>
</body>
</html>
