<?php include 'header2.php'; ?>
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
    body {
        background-image: url('image/home.png'); /* Path to your background image */
            background-size: cover; /* Cover the entire viewport */
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #ecf0f1;
        }

        /* Sidebar Container */
        .sidebar-container {
            width: 20%;
            height: 100vh;
            background-color: #428d8d;
            color: white;
            display: flex;
            flex-direction: column;
            padding-top: 10%;
            padding-right: 10px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        /* Brand Section */
        .brand {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        
            color: #ecf0f1;
            margin-top: 5px;
            text-align: center;
            margin-left: 10%;
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 24px; /* Smaller font size */
            font-weight: bold;
            color: red; /* Change color to red */
            -webkit-text-stroke: 1px black; /* Smaller text stroke */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Lighter shadow effect */
        }

        /* Navigation Menu */
        .nav-menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .nav-menu ul li {
            margin: 10px 0;
        }

        .nav-menu ul li a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 16px;
            display: flex;
            align-items: center;
            padding: 15px 5px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        /* Icon Styles */
        .icon {
            margin-right: 20px;
            font-size: 20px;
        }

        /* Hover Effects */
        .nav-menu ul li a:hover {
            background-color: #34495e;
        }

        /* Active State */
        .nav-menu ul li.active a {
            background-color: #2980b9;
        }

        .nav-menu ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

     

        .nav-menu .icon {
            margin-right: 10px;
        }

        .separator-line {
            height: 1px;
            background-color: #666;
            margin: 20px 0;
        }

        .content-container {
            flex-grow: 1;
            padding: 40px;
            background-color: #fff;
            padding-left: 22%;
            padding-top: 10%;
        }

        h2 {
    font-size: 24px; /* Adjust size as needed */
    color: #2c3e50; /* Dark color for contrast */
    margin-top: 0;
    text-align: center; /* Center the text horizontally */
    margin-bottom: 20px; /* Space below the heading */
    font-weight: bold; /* Make the heading bold */
    border-bottom: 2px solid #428d8d; /* Underline for emphasis */
    padding-bottom: 10px; /* Space between text and underline */
}

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
            transition: box-shadow 0.3s ease;
           
        }

        .book-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            color: #333;
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

        .book-card button, .book-card a {
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
        }

        .book-card button {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .book-card a {
            background-color: #007bff;
            color: white;
            text-decoration: none;
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
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-bar button {
            padding: 10px;
            font-size: 1em;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .search-bar button:hover {
            background-color: #0056b3;
        }

        @media screen and (max-width: 768px) {
            .book-card {
                width: calc(50% - 20px);
            }
        }

        @media screen and (max-width: 480px) {
            .book-card {
                width: 100%;
            }

            .sidebar-container {
                width: 200px;
            }
        }


        /* Content Container */
.content-container {
    flex-grow: 1;
    padding: 40px;
    background-color: #f1f4f9; /* Light gray background */
    padding-left: 22%;
    padding-top: 10%;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow for elevation */
}

/* Heading */
.content-container h2 {
    font-size: 28px;
    color: #333;
    margin-bottom: 30px;
    text-align: center; /* Center the heading */
    font-family: 'Arial', sans-serif;
}

/* Search Bar */
.search-bar {
    margin-bottom: 30px;
    display: flex;
    justify-content: center;
}

.search-bar input {
    padding: 12px 15px;
    font-size: 1.1em;
    width: 350px;
    margin-right: 15px;
    border: 2px solid #ccc;
    border-radius: 8px;
    transition: border-color 0.3s ease;
}

.search-bar input:focus {
    border-color: #007bff; /* Change border color on focus */
    outline: none;
}

.search-bar button {
    padding: 12px 18px;
    font-size: 1.1em;
    cursor: pointer;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.search-bar button:hover {
    background-color: #0056b3; /* Darker blue on hover */
}

/* Book Grid */
.book-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 15px; /* Increased gap for better spacing */
    justify-content: center; /* Center the book cards */
    text-align: center;
    
}

/* Book Card */
.book-card {
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 20px;
    width: calc(33.333% - 30px); /* Adjusted width */
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    
}

.book-card:hover {
    transform: translateY(-5px); /* Lift effect on hover */
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

.book-card h3 {
    margin: 0 0 15px;
    font-size: 1.4em;
    color: #333;
    font-family: 'Arial', sans-serif;
}

.book-card p {
    margin: 0 0 10px;
    color: #777;
}

.book-card img {
    max-width: 70%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 15px;
}

/* Actions (Delete and View buttons) */
.book-card .actions {
    display: flex;
    justify-content: space-between;
    margin-top: auto;
    gap: 10px;
}

.book-card button, 
.book-card a {
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
    text-align: center;
    font-size: 0.9em;
}

.book-card button {
    background-color: #dc3545;
    color: white;
    border: none;
    transition: background-color 0.3s ease;
}

.book-card button:hover {
    background-color: #c82333;
}

.book-card a {
    background-color: #007bff;
    color: white;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.book-card a:hover {
    background-color: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .book-card {
        width: calc(50% - 20px); /* Two cards per row on medium screens */
    }
}

@media (max-width: 480px) {
    .book-card {
        width: 100%; /* One card per row on small screens */
    }
}


    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar-container">
        <!-- Brand Section -->
       

        <!-- Navigation Menu -->
        <nav class="nav-menu">
            <ul>
                <li >
                    <a href="admin_home.php">
                        <span class="icon">🏠</span> Home
                    </a>
                </li>
            </ul>
            <ul>
                <li >
                    <a href="admin_upload_book.php">
                        <span class="icon">📚</span> Upload Book
                    </a>
                </li>
            </ul>
            <ul>
                <li class="active">
                    <a href="admin_view_book.php">
                        <span class="icon">📖</span> View Book
                    </a>
                </li>
            </ul>
            <ul>
                <li >
                    <a href="manage_users.php">
                        <span class="icon">👤</span> Manage Users
                    </a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="user_book_list.php">
                        <span class="icon">📋</span> User Book List
                    </a>
                </li>
            </ul>
            <!-- Separator Line -->
            <div class="separator-line"></div>
            <ul>
                <li>
                    <a href="logout.php">
                        <span class="icon">🚪</span> Logout
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Content Section -->
    <div class="content-container">
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
    </div>

</body>
</html>
