<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>User Home</h1>
    
    <!-- Logout Form -->
    <form method="POST" action="index.php" style="display: inline;">
        <button type="submit" name="logout">Logout</button>
    </form>
    
    <!-- View All Books Button -->
    <form method="GET" action="all_books.php" style="display: inline;">
        <button type="submit">View All Books</button>
    </form>

    <!-- My Library Button -->
    <form method="GET" action="my_library.php" style="display: inline;">
        <button type="submit">My Library</button>
    </form>

    <!-- Manage Profile Button -->
    <form method="GET" action="profile_management.php" style="display: inline;">
        <button type="submit">Manage Profile</button>
    </form>

    <!-- Search Form -->
    <form method="POST" action="search_book.php">
        <label>Search Book Title: <input type="text" name="search_query" required></label>
        <button type="submit">Search</button>
    </form>

    <h2>Search Results</h2>
    <?php if (isset($books)): ?>
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
    <?php endif; ?>
</body>
</html>
