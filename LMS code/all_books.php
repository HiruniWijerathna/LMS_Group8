<?php
require 'db.php';

// Fetch all books from the database
$stmt = $pdo->query("SELECT * FROM books");
$books = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Books</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .book-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .book-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .book-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .book-card h2 {
            margin: 0 0 10px;
            font-size: 20px;
        }
        .book-card p {
            margin: 10px 0;
        }
        .book-card a,
        .book-card button {
            display: block;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }
        .book-card a:hover,
        .book-card button:hover {
            text-decoration: underline;
        }
        .back-link {
            display: inline-block;
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>All Books</h1>
    
    <!-- Back to Home Page Link -->
    <a href="user_home.php" class="back-link">Back to Home</a>

    <!-- Add Book Button -->
    <a href="my_library.php" class="back-link">My Library</a>

    <div class="book-container">
        <?php if (count($books) > 0): ?>
            <?php foreach ($books as $book): ?>
            <div class="book-card">
                <?php if (!empty($book['image_path'])): ?>
                    <img src="<?php echo htmlspecialchars($book['image_path']); ?>" alt="Book Image">
                <?php endif; ?>
                <h2><?php echo htmlspecialchars($book['title']); ?></h2>
                <p><strong>Keywords:</strong> <?php echo htmlspecialchars($book['keywords']); ?></p>
                <a href="view_book.php?id=<?php echo $book['id']; ?>" target="_blank">View</a>
                <form action="add_to_library.php" method="POST" style="display:inline;">
                    <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                    <button type="submit">Add to Library</button>
                </form>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="book-card">No books available.</div>
        <?php endif; ?>
    </div>
</body>
</html>
