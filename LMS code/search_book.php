<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_query = $_POST['search_query'];

    // Fetch books matching the search query
    $stmt = $pdo->prepare("SELECT * FROM books WHERE title LIKE :title");
    $stmt->execute(['title' => '%' . $search_query . '%']);
    $books = $stmt->fetchAll();
} else {
    // Redirect if not a POST request
    header('Location: user_home.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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
    <h1>Search Results</h1>
    <form method="POST" action="search_book.php">
        <label>Search Book Title: <input type="text" name="search_query" required value="<?php echo htmlspecialchars($search_query); ?>"></label>
        <button type="submit">Search</button>
    </form>

    <!-- Back to Home Page Link -->
    <a href="user_home.php" class="back-link">Back to Home</a>

    <div class="book-container">
        <?php if (isset($books) && count($books) > 0): ?>
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
            <div class="book-card">No books found.</div>
        <?php endif; ?>
    </div>
</body>
</html>
