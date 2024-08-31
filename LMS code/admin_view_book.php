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

// Search functionality
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = trim($_GET['search']);
    $stmt = $pdo->prepare("SELECT * FROM books WHERE title LIKE :search_query");
    $stmt->execute(['search_query' => "%$search_query%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM books");
}

$books = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .book-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .book-card {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: calc(33.333% - 40px);
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .book-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .book-card h3 {
            margin: 0 0 10px;
            font-size: 1.25em;
        }

        .book-card p {
            margin: 0 0 10px;
            color: #666;
        }

        .book-card .actions {
            display: flex;
            justify-content: space-between;
            margin-top: auto;
        }

        .book-card button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .book-card a {
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .book-card button:hover, .book-card a:hover {
            opacity: 0.8;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            padding: 10px;
            font-size: 1em;
            width: 300px;
            margin-right: 10px;
        }

        .search-bar button {
            padding: 10px;
            font-size: 1em;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h2>View Books</h2>

    <!-- Search Form -->
    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by title..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="book-grid">
        <?php if (count($books) > 0): ?>
            <?php foreach ($books as $book): ?>
            <div class="book-card">
                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                <p><?php echo htmlspecialchars($book['keywords']); ?></p>
                <div>
                    <?php if (!empty($book['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($book['image_path']); ?>" alt="Book Image">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </div>
                <div class="actions">
                    <a href="view_book.php?id=<?php echo $book['id']; ?>">View</a>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                        <button type="submit" name="delete_book">Delete</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No books found.</p>
        <?php endif; ?>
    </div>

</body>
</html>
