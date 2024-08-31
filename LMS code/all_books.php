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
</head>
<body>
    <h1>All Books</h1>
    
    <!-- Back to Home Page -->
    <form method="POST" action="user_home.php" style="display: inline;">
        <button type="submit">Back to Home</button>
    </form>

    <table>
        <tr>
            <th>Title</th>
            <th>Keywords</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($books as $book): ?>
        <tr>
            <td><?php echo htmlspecialchars($book['title']); ?></td>
            <td><?php echo htmlspecialchars($book['keywords']); ?></td>
            <td>
                <a href="view_book.php?id=<?php echo $book['id']; ?>" target="_blank">View</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
