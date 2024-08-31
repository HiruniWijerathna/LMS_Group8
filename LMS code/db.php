<?php
$host = 'localhost';
$db = 'library_system';
$user = 'root';
$pass = '';

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db");
    echo "Database '$db' created or already exists.<br>";

    // Select the database
    $pdo->exec("USE $db");

    // Table creation queries
    $tables = [
        'users' => "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                user_type ENUM('admin', 'user') NOT NULL
            );
        ",
        'books' => "
        CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    keywords TEXT,
    file_path VARCHAR(255) NOT NULL,
    image_path VARCHAR(255) NOT NULL
);

        ",
        'profiles' => "
            CREATE TABLE IF NOT EXISTS profiles (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                mobile_number VARCHAR(20),
                profile_picture VARCHAR(255),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );
        "
    ];

    // Create tables
    foreach ($tables as $table => $sql) {
        $pdo->exec($sql);
        echo "Table '$table' has been created or already exists.<br>";
    }

} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
