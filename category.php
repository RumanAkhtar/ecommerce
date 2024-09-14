<?php include 'db.php'; ?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <style>
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
            position: relative;
            background: url('images/bg2.jpg') no-repeat center center/cover;
            color: #fff;
            padding: 100px 20px;
            text-align: center;
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: calc(33.333% - 20px);
            text-align: center;
            transition: transform 0.3s;
        }

        .product-card img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
            transition: transform 0.3s ease; /* Add transition for smooth scaling */
        }

        .product-card:hover img {
            transform: scale(1.1); /* Scale up the image to 110% on hover */
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

        .product-card button {
            background-color: #e94e77;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            margin: 15px;
        }

        .product-card button:hover {
            background-color: #d43f6c;
            transform: scale(1.05);
        }

        .product-card:hover {
            transform: scale(1.05);
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
            <h1>Products in Category</h1>
            <p>Browse our collection of products in this category</p>
        </div>
    </header>

    <main>
        <!-- Products List -->
        <section class="product-cards">
            <?php
            $category_id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM products WHERE category_id = $category_id");

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
                            <button onclick=\"addToCart(" . $row['id'] . ")\">Add to Cart</button>
                        </div>";
                }
            } else {
                echo "<p>No products found in this category.</p>";
            }
            ?>
        </section>
    </main>

    <script>
        function addToCart(itemId) {
            // Logic to add item to cart
            alert('Added item with ID ' + itemId + ' to cart.');
        }
    </script>
    <a href="https://wa.me/1234567890" class="whatsapp-button" target="_blank" rel="noopener noreferrer">
        <img src="./images/WhatsApp_icon.png" alt="Chat with us on WhatsApp">
    </a>
    <?php include 'footer.php'; ?>
</body>

</html>
