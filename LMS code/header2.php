<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library Header</title>
    <link rel="stylesheet" href="css/header.css">
    <style>
        /* General Styling */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        

        /* Header Bar Styling */
        .header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #428d8d;
            color: white;
            padding: 20px 20px;
            border-bottom: 2px solid black;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        
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
        .logo img {
            height: 40px; /* Adjust logo size */
        }

        .nav-links {
            display: flex;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .nav-links li {
            margin: 0 15px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .nav-links a:hover {
            background-color: #34495e;
        }

        .search-bar {
            display: flex;
            align-items: center;
        }

        .search-bar input {
            padding: 5px;
            border-radius: 20px;
            border: none;
            font-size: 14px;
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-right: 50px;
            font-size: 20px;
        }

        .user-info span {
            margin-left: 10px;
        }

        .hamburger {
            display: none; /* Hide hamburger menu for desktop */
            flex-direction: column;
            cursor: pointer;
        }

        .hamburger .bar {
            width: 25px;
            height: 3px;
            background-color: white;
            margin: 3px 0;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 60px;
                right: 0;
                background-color: #428d8d;
                width: 100%;
            }

            .nav-links.open {
                display: flex;
            }

            .hamburger {
                display: flex;
            }
        }
    </style>
</head>
<body>
    <header class="header-bar">
        <div class="logo">
        <div class="brand">EpicReads</div>
        </div>
        <nav>
           
            
            <div class="user-info">
                <span role="img" aria-label="User Icon">👤 Admin</span>
                
            </div>
            <div class="hamburger" onclick="toggleMenu()">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>

    <script>
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('open');
        }
    </script>
</body>
</html>
