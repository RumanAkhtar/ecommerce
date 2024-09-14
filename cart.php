<?php include 'db.php'; ?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            /* Ensure full height for sticky footer */
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8d7da;
            /* Light background color */
            color: #333;
            line-height: 1.6;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            text-align: center;
            color: #e94e77;
            /* Button color for consistency */
        }

        .cart-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            /* Allow content to grow */
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item p {
            font-size: 1.2em;
            margin: 0;
        }

        .checkout-button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #e94e77;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.2em;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .checkout-button:hover {
            background-color: #d43f6c;
        }

        .empty-cart {
            text-align: center;
            font-size: 1.2em;
            color: #888;
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
    <h1>Your Cart</h1>
    <div class="cart-container">
        <?php
        session_start();
        // Assuming cart items are stored in session
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            foreach ($cart as $item_id => $quantity) {
                $result = $conn->query("SELECT * FROM items WHERE id = $item_id");
                if ($result && $item = $result->fetch_assoc()) {
                    echo "<div class='cart-item'><p>" . htmlspecialchars($item['name']) . " x " . htmlspecialchars($quantity) . "</p></div>";
                } else {
                    echo "<div class='cart-item'><p>Item not found</p></div>";
                }
            }
        } else {
            echo "<div class='empty-cart'>Your cart is empty.</div>";
        }
        ?>
        <form action="checkout.php" method="post">
            <button type="submit" class="checkout-button">Proceed to Checkout</button>
        </form>
        <a href="https://wa.me/1234567890" class="whatsapp-button" target="_blank" rel="noopener noreferrer">
            <img src="./images/WhatsApp_icon.png" alt="Chat with us on WhatsApp">
        </a>
    </div>
    <?php include 'footer.php'; ?>

</body>

</html>