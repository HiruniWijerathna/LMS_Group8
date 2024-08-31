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

// Fetch books
$stmt = $pdo->query("SELECT * FROM books");
$books = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Admin Home</h1>
    <form method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
    <h2>Upload Book</h2>
    <form action="upload_book.php" method="POST" enctype="multipart/form-data">
        <label>Book Title: <input type="text" name="title" required></label>
        <label>Keywords: <input type="text" name="keywords"></label>
        <label>File: <input type="file" name="file" required></label>
        <label>Image: <input type="file" name="image" required></label>
        <button type="submit">Upload</button>
    </form>
    <h2>View Books</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Keywords</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php foreach ($books as $book): ?>
        <tr>
            <td><?php echo htmlspecialchars($book['title']); ?></td>
            <td><?php echo htmlspecialchars($book['keywords']); ?></td>
            <td>
                <?php if (!empty($book['image_path'])): ?>
                    <img src="<?php echo htmlspecialchars($book['image_path']); ?>" alt="Book Image" style="max-width: 100px;">
                <?php else: ?>
                    No Image
                <?php endif; ?>
            </td>
            <td>
                <a href="view_book.php?id=<?php echo $book['id']; ?>">View</a>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                    <button type="submit" name="delete_book">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h2>Manage Users</h2>
    <form action="manage_users.php" method="GET">
        <button type="submit">Manage Users</button>
    </form>
    <h2>User Book List</h2>
    <form action="user_book_list.php" method="GET">
        <button type="submit">View User Book List</button>
    </form>
</body>
</html>
