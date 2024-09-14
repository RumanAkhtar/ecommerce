<?php
session_start();
include 'db.php'; // Ensure session is started and db connection is included

// Fetch the user’s name if logged in
$user_name = '';
if (isset($_SESSION['user_id'])) {
    $user_name = htmlspecialchars($_SESSION['user_name']); // Retrieve user name from session
}

// Fetch cart count from session or database
$cart_count = isset($_SESSION['cart_count']) ? intval($_SESSION['cart_count']) : 0; // Example cart count
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Your eCommerce site description here">
    <meta name="keywords" content="eCommerce, fashion, suits, shopping">
    <meta name="author" content="Your Name">
    <title>Your eCommerce Site</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lobster&display=swap"> <!-- Google Font -->
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        header {
            background-color: #d43f6c; /* Updated header background color */
            color: #fff;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .logo h2 {
            font-family: 'Lobster', cursive; /* Unique font style for logo */
            font-size: 2rem; /* Adjust size as needed */
            color: #fff; /* Ensure text color contrasts with background */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Add shadow for depth */
        }

        .logo img {
            height: 40px; /* Adjust based on your logo size */
            display: none; /* Hide the image if using text logo */
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 15px;
        }

        .nav-links li {
            display: inline;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px; /* Add border-radius for rounded corners */
            transition: background-color 0.3s ease; /* Smooth transition effect */
        }

        .nav-links a:hover {
            background-color: #c03a5c; /* Slightly darker shade for hover effect */
        }

        .search-bar form {
            display: flex;
        }

        .search-bar input {
            padding: 5px;
            border: none;
            border-radius: 4px 0 0 4px;
            outline: none;
            font-size: 1rem; /* Ensure font size is legible */
        }

        .search-bar button {
            padding: 5px 10px;
            border: none;
            background-color: #c03a5c; /* Button background color */
            color: #fff;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Smooth transition effect */
        }

        .search-bar button:hover {
            background-color: #a73253; /* Slightly darker shade for hover effect */
        }

        .user-actions a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            transition: color 0.3s ease; /* Smooth transition effect */
        }

        .user-actions a:hover {
            text-decoration: underline;
        }

        .user-info {
            display: flex;
            align-items: center;
            color: #fff;
        }

        .user-info span {
            margin-right: 20px;
        }

        .user-info .logout {
            background-color: #c03a5c; /* Button background color */
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .user-info .logout:hover {
            background-color: #a73253; /* Slightly darker shade for hover effect */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-bar form {
                flex-direction: column;
            }

            .search-bar input {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="container">
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <h2>Happy.in</h2> <!-- Replace with your logo text -->
                </a>

                <!-- Navigation Links -->
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="category.php?id=1">Ladies Suits</a></li>
                    <li><a href="category.php?id=2">Unstitched Suits</a></li>
                    <li><a href="category.php?id=3">Stitched Suits</a></li>
                </ul>

                <!-- Search Bar -->
                <div class="search-bar">
                    <form action="search.php" method="get">
                        <input type="text" name="query" placeholder="Search..." aria-label="Search">
                        <button type="submit">Search</button>
                    </form>
                </div>

                <!-- User Actions -->
                <div class="user-actions">
                    <?php if ($user_name): ?>
                        <div class="user-info">
                            <span><?php echo $user_name; ?>!</span>
                            <a href="cart.php">Cart (<?php echo $cart_count; ?>)</a> <!-- Dynamically update cart count -->
                            <a href="logout.php" class="logout">Logout</a> <!-- Logout link -->
                        </div>
                    <?php else: ?>
                        <a href="login.php">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    <!-- Content here -->
</body>
</html>
