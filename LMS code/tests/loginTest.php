<?php

use PHPUnit\Framework\TestCase;
use PDO;
use PDOException;

class LoginTest extends TestCase
{
    private $pdo;

    // Set up the PDO connection before each test
    protected function setUp(): void
    {
        // Set up an in-memory SQLite database for testing
        $dsn = 'sqlite::memory:';
        try {
            $this->pdo = new PDO($dsn);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create a mock users table
            $this->pdo->exec("CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT NOT NULL,
                password TEXT NOT NULL,
                user_type TEXT NOT NULL
            )");

            // Insert test user data (with hashed password)
            $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
            $this->pdo->exec("INSERT INTO users (email, password, user_type) VALUES ('testuser@example.com', '$hashedPassword', 'user')");

        } catch (PDOException $e) {
            $this->fail("Database connection failed: " . $e->getMessage());
        }
    }

    // Test for valid login credentials
    public function testValidLogin()
    {
        $email = 'testuser@example.com';
        $password = 'password123';

        // Fetch user data
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email AND user_type = 'user'");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        $this->assertNotFalse($user, "User should be found.");
        $this->assertTrue(password_verify($password, $user['password']), "Password should be verified.");
    }

    // Test for invalid email
    public function testInvalidEmail()
    {
        $email = 'nonexistent@example.com';
        $password = 'password123';

        // Fetch user data
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email AND user_type = 'user'");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        $this->assertFalse($user, "User should not be found with invalid email.");
    }

    // Test for invalid password
    public function testInvalidPassword()
    {
        $email = 'testuser@example.com';
        $password = 'wrongpassword';

        // Fetch user data
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email AND user_type = 'user'");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        $this->assertNotFalse($user, "User should be found.");
        $this->assertFalse(password_verify($password, $user['password']), "Password should not be verified with invalid password.");
    }

    // Test for empty email
    public function testEmptyEmail()
    {
        $email = '';
        $password = 'password123';

        // Ensure query returns false on empty email
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email AND user_type = 'user'");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        $this->assertFalse($user, "User should not be found with an empty email.");
    }

    // Test for empty password
    public function testEmptyPassword()
    {
        $email = 'testuser@example.com';
        $password = '';

        // Fetch user data
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email AND user_type = 'user'");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        // Empty password should fail verification
        $this->assertNotFalse($user, "User should be found.");
        $this->assertFalse(password_verify($password, $user['password']), "Password should not be verified with an empty password.");
    }

    // Tear down the PDO connection after each test
    protected function tearDown(): void
    {
        $this->pdo = null;
    }
}
