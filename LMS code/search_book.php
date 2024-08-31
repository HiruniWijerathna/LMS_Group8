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
</head>
<body>
    <h1>Search Results</h1>
    <form method="POST" action="search_book.php">
        <label>Search Book Title: <input type="text" name="search_query" required value="<?php echo htmlspecialchars($search_query); ?>"></label>
        <button type="submit">Search</button>
    </form>

    <h2>Results</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Keywords</th>
            <th>Actions</th>
        </tr>
        <?php if (isset($books) && count($books) > 0): ?>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?php echo htmlspecialchars($book['title']); ?></td>
                <td><?php echo htmlspecialchars($book['keywords']); ?></td>
                <td>
                    <a href="view_book.php?id=<?php echo $book['id']; ?>" target="_blank">View</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No books found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
