<?php 
include 'header3.php'; 
require 'db.php';

// Fetch all books from the database
try {
    $stmt = $pdo->query("SELECT * FROM books");
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $books = []; // Default to an empty array on error
    error_log($e->getMessage()); // Log the error for debugging
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Books</title>
    <link rel="stylesheet" href="css/user_home.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
        }
        
        .book-container {
            margin-top: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            flex-grow: 1;
            padding: 40px;
            background-color: #fff;
            padding-left: 22%;
            padding-top: 10%;
        }
        .book-card {
            border: 1px solid #ddd;
            background-color: #fff;
            border-radius: 10px;
            width: 200px;
            height:400px;
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
            <li class="active">
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

<div class="book-container">
    <?php if (is_array($books) && count($books) > 0): ?>
        <?php foreach ($books as $book): ?>
        <div class="book-card">
            <?php if (!empty($book['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($book['image_path']); ?>" alt="Book Image">
            <?php endif; ?>
            <h2><?php echo htmlspecialchars($book['title']); ?></h2>
            <p><strong>Keywords:</strong> <?php echo htmlspecialchars($book['keywords']); ?></p>
            <div class="buttons">
                <a href="view_book.php?id=<?php echo $book['id']; ?>" target="_blank">View</a>
                <form action="add_to_library.php" method="POST" style="display:inline;">
                    <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                    <button type="submit">Add to Library</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="book-card">No books available.</div>
    <?php endif; ?>
</div>
</body>
</html>
