<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow-x: hidden; /* Prevents horizontal scrolling */
        }

        .hero {
            background-image: url('image/home.png'); /* Update the path to match your PHP file structure */
            background-size: cover;
            background-position: center;
            min-height: 100vh; /* Ensures hero section takes up full height of the viewport */
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            color: red;
            text-align: left;
            width: 100%; /* Ensure full width */
        }

        .hero-content {
            display: flex;
        }

        .hero-title-side {
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

        .hero-text-side {
            margin-top: 5px;
            background: rgba(255, 255, 255, 0.5); /* Overlay effect */
            padding: 40px;
            border-radius: 10px;
            flex-direction: row;
            margin-left: 30px;
            margin-right: 10%;
            text-align: center;
        }

        .hero-title {
            padding: 20px;
            border-radius: 20px;
            flex-direction: row;
            background: rgba(255, 255, 255, 0.5); /* Overlay effect */
            color: red;
        }

        .hero-subtitle {
            font-size: 1.8rem;
            color: #480404;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 40px;
            font-weight: bold;
        }

        .hero-description {
            font-size: 1.3rem;
            color: #340217;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 30px;
        }

        .hero-button {
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #fff;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .hero-button:hover {
            background-color: #e67575;
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="hero-content">
            <div class="hero-title-side"><br><br><br>
                <h1 class="hero-title">EpicReads</h1>
            </div>
            <div class="hero-text-side">
                <p class="hero-subtitle">Every Book You Love and Ones You Haven’t Met Yet!</p>
                <p class="hero-description">
                    Explore a collection where familiar favorites meet undiscovered gems.
                    Start your next chapter with us today!
                </p>
                <form method="GET" action="index.php" style="display: inline;">
                    <button class="hero-button" type="submit">Start Reading</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
