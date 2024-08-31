<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

require 'db.php';

if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
}

// Fetch users
$stmt = $pdo->query("SELECT * FROM users WHERE user_type = 'user'");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Manage Users</h1>
    <form method="POST" action="admin_home.php">
        <button type="submit" name="logout">Logout</button>
    </form>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['name']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <button type="submit" name="delete_user">Remove</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
