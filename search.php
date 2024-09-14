<?php
session_start();
include 'db.php'; // Ensure database connection is included

// Initialize search query
$search_query = '';
$results = [];

// Check if search query is set and not empty
if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $search_query = trim($_GET['query']);
    
    // Sanitize input to prevent SQL injection
    $search_query = htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8');

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_name LIKE ?");
    $search_query_param = '%' . $search_query . '%';
    $stmt->bind_param('s', $search_query_param);

    // Execute the statement
    $stmt->execute();

    // Fetch results
    $result = $stmt->get_result();
    $results = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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
            background-color: #f8d7da;
            color: #333;
        }


        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        .product-list {
            /* list-style: none; */
            padding: 0;
        }

        .product-list li {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .product-list img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-list h2 {
            margin-top: 0;
            color: #d43f6c;
            font-size: 1.5rem;
        }

        .product-list p {
            margin: 10px 0;
        }

        .product-list a {
            display: inline-block;
            padding: 8px 15px;
            background-color: #d43f6c;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .product-list a:hover {
            background-color: #c03a5c;
        }

        footer {
            background-color: #d43f6c;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .product-list li {
                padding: 10px;
            }

            .product-list h2 {
                font-size: 1.2rem;
            }
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
    <header>
            <?php include 'header.php'; ?>
    </header>

    <main>
        <div class="container">
            <h1>Search Results</h1>
            
            <?php if ($search_query): ?>
                <p>Showing results for "<strong><?php echo htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8'); ?></strong>":</p>
                
                <?php if (count($results) > 0): ?>
                    <ul class="product-list">
                        <?php foreach ($results as $product): ?>
                            <li>
                                <?php if (!empty($product['image']) && file_exists($product['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php else: ?>
                                    <img src="images/products/yellow.webp" alt="Default Image">
                                <?php endif; ?>
                                <h2><?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                                <p><?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p>Price: $<?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <a href="product.php?id=<?php echo htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8'); ?>">View Product</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No results found for your search.</p>
                <?php endif; ?>
            <?php else: ?>
                <p>Please enter a search query.</p>
            <?php endif; ?>
        </div>
    </main>
    <a href="https://wa.me/1234567890" class="whatsapp-button" target="_blank" rel="noopener noreferrer">
        <img src="./images/WhatsApp_icon.png" alt="Chat with us on WhatsApp">
    </a>
    
    <footer>
        <?php include 'footer.php'; ?> <!-- Optional footer -->
    </footer>
</body>
</html>
