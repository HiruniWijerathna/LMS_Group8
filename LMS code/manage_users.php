<?php include 'header2.php'; ?>

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

require 'db.php';

if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
}

// Fetch users
$stmt = $pdo->query("SELECT * FROM users WHERE user_type = 'user'");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
    font-family: 'Arial', sans-serif;
    background-color: #f5f7fa;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    min-height: 100vh;
    padding-left: 20%;
    padding-top: 10%;
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
    margin-bottom: 20px;
    text-align: center;
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
    width: 80%;
    border-collapse: collapse;
    margin-bottom: 50px;
    background-color: white;
    border-radius: 12px;
    overflow: hidden;
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

/* Remove Button */
table form button {
    padding: 8px 12px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

table form button:hover {
    background-color: #c82333;
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
                <li class="active">
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

    
    <h2>Manage Users</h2>
    
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['name']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <button type="submit" name="delete_user">Remove</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
