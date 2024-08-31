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
        table {
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>
<body>
    <h1>User Book List</h1>
    <form method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
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
</body>
</html>
