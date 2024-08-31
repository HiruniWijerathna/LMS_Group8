<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_book'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];

    // Remove book from the user's library
    $stmt = $pdo->prepare("DELETE FROM user_books WHERE user_id = :user_id AND book_id = :book_id");
    $stmt->execute(['user_id' => $user_id, 'book_id' => $book_id]);
}

// Fetch books in the user's library
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("
    SELECT b.* FROM books b
    JOIN user_books ub ON b.id = ub.book_id
    WHERE ub.user_id = :user_id
");
$stmt->execute(['user_id' => $user_id]);
$books = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Library</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: #f5f5f5;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        .sidebar button {
            width: 150px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            background-color: rgba(45, 172, 143, 1);
        }

        .book-container {
            margin-left: 240px;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .book-card {
            border: 1px solid #ddd;
            background-color: #fff;
            border-radius: 10px;
            width: 200px;
            height: 400px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 10px;
        }
        .book-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
        }
        .book-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .book-card h2 {
            margin: 0 0 10px;
            font-size: 18px;
            color: #2c3e50;
            flex-grow: 1;
        }
        .book-card p {
            margin: 10px 0;
            color: #555;
            font-size: 14px;
            flex-grow: 1;
        }
        .book-card .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: auto;
        }
        .book-card a,
        .book-card button {
            color: rgba(45, 172, 143, 1);
            text-decoration: none;
            font-weight: bold;
            background-color: transparent;
            border: none;
            cursor: pointer;
            transition: color 0.3s ease;
            padding: 5px 10px;
        }
        .book-card a:hover,
        .book-card button:hover {
            color: #2980b9;
            text-decoration: none;
        }
        .book-card button {
            background-color: rgba(206, 95, 96, 0.92);
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .book-card button:hover {
            background-color: rgba(45, 172, 143, 1);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <!-- Back to Home Page Button -->
        <a href="user_home.php" class="back-link">
            <button>Back to Home</button>
        </a>
    </div>

    <div class="book-container">
        <?php if (count($books) > 0): ?>
            <?php foreach ($books as $book): ?>
            <div class="book-card">
                <?php if (!empty($book['image_path'])): ?>
                    <img src="<?php echo htmlspecialchars($book['image_path']); ?>" alt="Book Image">
                <?php endif; ?>
                <h2><?php echo htmlspecialchars($book['title']); ?></h2>
                <p><strong>Keywords:</strong> <?php echo htmlspecialchars($book['keywords']); ?></p>
                <div class="buttons">
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                        <button type="submit" name="remove_book">Remove</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="book-card">No books in your library.</div>
        <?php endif; ?>
    </div>
</body>
</html>
