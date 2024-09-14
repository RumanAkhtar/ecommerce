<?php include 'db.php'; ?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Our Clothing Store</title>
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
            color: #333;
            background-color: #f8d7da;
        }

        .header {
            background: url('images/bg2.jpg') no-repeat center center/cover;
            color: #fff;
            padding: 100px 20px;
            text-align: center;
            position: relative;
            height: 300px;
        }

        .header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .header>* {
            position: relative;
            z-index: 2;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .header h1 {
            font-size: 3em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        .category-filter {
            padding: 20px;
            background-color: #fff;
            margin: 20px 0;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .category-filter label {
            font-size: 1em;
            margin-right: 10px;
        }

        .category-filter select {
            width: 200px;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .category-filter button {
            padding: 10px 15px;
            font-size: 1em;
            color: #fff;
            background-color: #e94e77;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        .category-filter button:hover {
            background-color: #d43f6c;
        }

        .product-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
            width: calc(33.333% - 20px);
            text-align: center;
            transition: transform 0.4s ease, box-shadow 0.5s ease, opacity 1s ease; /* Added box-shadow and opacity transitions */
            position: relative;
            opacity: 0; /* Initial state for animation */
            transform: translateY(20px); /* Initial position for animation */
        }

        .product-card.visible {
            opacity: 1;
            transform: translateY(0); /* Final position for animation */
        }

        .product-card img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
            transition: transform 0.3s ease; /* Added transition for scaling effect */
        }

        .product-card:hover {
            transform: translateY(-10px); /* Move the card up by 10px on hover */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Add shadow for emphasis */
        }

        .product-card:hover img {
            transform: scale(1.1); /* Scale image to 110% on hover */
        }

        .product-card h3 {
            padding: 15px;
            font-size: 1.2em;
            color: #333;
        }

        .product-card p {
            padding: 0 15px 15px;
            font-size: 1em;
            color: #666;
        }

        .product-card .price {
            font-size: 1.2em;
            color: #e94e77;
            margin: 10px 0;
        }

        .product-card .add-to-cart {
            background-color: #e94e77;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 1em;
            cursor: pointer;
            margin: 15px;
            transition: background-color 0.3s;
        }

        .product-card .add-to-cart:hover {
            background-color: #d43f6c;
        }

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
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <h1>Our Clothing Collection</h1>
            <p>Find the best deals on trendy clothing</p>
        </div>
    </header>

    <main>
        <!-- Category Filter -->
        <div class="category-filter">
            <form action="shop.php" method="get">
                <label for="category">Filter by Category:</label>
                <select id="category" name="category">
                    <option value="">All Categories</option>
                    <?php
                    $result = $conn->query("SELECT * FROM categories");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $selected = (isset($_GET['category']) && $_GET['category'] == $row['id']) ? 'selected' : '';
                            echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit">Apply Filter</button>
            </form>
        </div>

        <!-- Product Cards -->
        <section class="product-cards">
            <?php
            $category_filter = isset($_GET['category']) ? intval($_GET['category']) : 0;
            $query = "SELECT * FROM products" . ($category_filter ? " WHERE category_id = $category_filter" : "");
            $result = $conn->query($query);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Construct the image path
                    $imagePath = 'images/products/' . htmlspecialchars($row['image']);
                    
                    // Output the product card
                    echo "<div class='product-card'>
                            <img src='" . $imagePath . "' alt='" . htmlspecialchars($row['name']) . "'>
                            <h3>" . htmlspecialchars($row['name']) . "</h3>
                            <p class='price'>₹" . number_format($row['price'], 2) . "</p>
                            <p>" . htmlspecialchars($row['description']) . "</p>
                            <button class='add-to-cart' onclick=\"addToCart(" . $row['id'] . ")\">Add to Cart</button>
                        </div>";
                }
            } else {
                echo "<p>No products found.</p>";
            }
            ?>
        </section>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Create an instance of IntersectionObserver
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add the 'visible' class when the element comes into view
                    entry.target.classList.add('visible');
                    // Stop observing the element after it becomes visible
                    observer.unobserve(entry.target);
                }
            });
        }, {
            // Options for the observer (e.g., root margin)
            root: null, // Use the viewport as the root
            rootMargin: '0px',
            threshold: 0.1 // Trigger when 10% of the element is visible
        });

        // Target all product cards
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            observer.observe(card);
        });
    });

    function addToCart(itemId) {
        // Logic to add item to cart
        alert('Added item with ID ' + itemId + ' to cart.');
        // Implement actual cart logic here
    }
    </script>
    
    <a href="https://wa.me/1234567890" class="whatsapp-button" target="_blank" rel="noopener noreferrer">
        <img src="./images/WhatsApp_icon.png" alt="Chat with us on WhatsApp">
    </a>
    
    <?php include 'footer.php'; ?>
</body>
</html>
