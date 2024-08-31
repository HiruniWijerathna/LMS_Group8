<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <style>
        /* General Styles */
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif; /* Use a clean font */
            color: #333; /* Text color */
        }

        /* Background Image */
        body {
            background-image: url('image/index.jpg'); /* Path to your background image */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent repeating the image */
        }

        /* Main Heading */
        h1 {
            text-align: center;
            margin-top: 50px; /* Adjust top margin as needed */
            font-size: 3rem; /* Adjust font size */
            color: #ffffff; /* White text color for contrast */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Subtle shadow for readability */
        }

        /* Links */
        .bu{
            display: block;
            text-align: center;
            margin: 20px auto;
            padding: 25px;
            font-size: 1.5rem;
            color: #ffffff;
            text-decoration: none;
            background-color: black; /* Button color */
            border-radius: 5px; /* Rounded corners */
            width: 200px; /* Fixed width for buttons */
        }

        /* Link Hover State */
        .bu:hover {
            background-color: red; /* Darker shade on hover */
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>
    <h1>Welcome to the Library System</h1>
    <a class="bu" href="admin_login.php">Admin Login</a>
    <a class="bu" href="user_login.php">User Login</a>
    <a class="bu" href="user_register.php">User Register</a>
</body>
</html>
