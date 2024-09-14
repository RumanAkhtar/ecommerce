<?php
// Include database connection
include 'db.php'; 

// Increment visit count
$stmt = $conn->prepare("INSERT INTO visits (visit_date) VALUES (NOW())");
$stmt->execute();

// Fetch total visit count
$result = $conn->query("SELECT COUNT(*) AS total_visits FROM visits");
$visit_count = $result->fetch_assoc()['total_visits'];

// Include header
include 'header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Our Clothing Store</title>
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8d7da; /* Light pink background */
        }

        main {
            padding: 20px;
        }

        .hero {
            position: relative;
            background: url('images/bg.jpg') no-repeat center center/cover;
            color: #fff;
            padding: 100px 20px;
            text-align: center;
            height: 400px;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Dark gradient overlay */
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #e94e77;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1em;
        }

        .btn-primary:hover {
            background-color: #d43f6c;
        }

        .categories {
            padding: 20px;
            text-align: center;
        }

        .categories h2 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .category-list {
            list-style: none;
            padding: 0;
        }

        .category-item {
            background: #fff;
            border-radius: 5px;
            margin-bottom: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .category-item a {
            display: block;
            padding: 15px;
            color: #333;
            text-decoration: none;
            font-size: 1.2em;
        }

        .category-item:hover {
            transform: scale(1.05);
        }

        .category-item a:hover {
            color: #e94e77;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        /* WhatsApp Button Styles */
        .whatsapp-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            z-index: 1000;
        }

        .whatsapp-button img {
            width: 40px;
            height: 40px;
        }

        .visit-count {
            text-align: left;
            margin-top: 5px;
            font-size: 1.2em;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>
    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Welcome to Our Clothing Store</h1>
                <p>Explore our wide range of clothing categories and find your perfect outfit!</p>
                <a href="shop.php" class="btn-primary">Shop Now</a>
            </div>
        </section>

        <section class="categories">
            <h2>Categories</h2>
            <ul class="category-list">
                <?php
                // Query to fetch categories
                $result = $conn->query("SELECT * FROM categories");

                if ($result === false) {
                    echo "<li class='category-item'>Error fetching categories: " . $conn->error . "</li>";
                } elseif ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<li class='category-item'><a href='category.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</a></li>";
                    }
                } else {
                    echo "<li class='category-item'>No categories available</li>";
                }
                ?>
            </ul>
        </section>

        <div class="visit-count">
            <p>Number of visits: <?php echo htmlspecialchars($visit_count); ?></p>
        </div>
    </main>

    <!-- WhatsApp Chat Button -->
    <a href="https://wa.me/1234567890" class="whatsapp-button" target="_blank" rel="noopener noreferrer">
        <img src="./images/WhatsApp_icon.png" alt="Chat with us on WhatsApp">
    </a>

    <?php include 'footer.php'; ?>
</body>
</html>
