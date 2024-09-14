<?php include 'db.php'; ?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%; /* Ensure full height for sticky footer */
            display: flex;
            flex-direction: column;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8d7da;
            margin: 0;
            padding: 0;
            flex: 1;
        }

        .main-content {
            flex: 1; /* Allow main content to expand */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .checkout-container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 20px; /* Increased space between form groups */
        }

        .form-group label {
            display: block; /* Ensures label takes full width */
            margin-bottom: 5px;
            font-size: 16px;
            color: #333;
        }

        .form-group input {
            width: 100%; /* Full width input field */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box; /* Ensure padding is included in width */
        }

        .form-group input:focus {
            border-color: #333;
            outline: none;
        }

        .place-order-button {
            padding: 12px;
            border: none;
            background-color: #e94e77; /* Distinct color for the order button */
            color: #fff;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 20px; /* Space above the button */
            width: 40%; /* Full width button */
        }

        .place-order-button:hover {
            background-color: #d43f6c;
            transform: scale(1.02); /* Slightly enlarge on hover */
        }

        .place-order-button:active {
            transform: scale(0.98); /* Slightly shrink on click */
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
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
    <div class="main-content">
        <div class="checkout-container">
            <h1>Checkout</h1>
            <form action="process_order.php" method="post">
                <div class="form-group">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <label for="email">Your Email:</label>
                    <input type="email" id="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="form-group">
                    <label for="address">Your Address:</label>
                    <input type="text" id="address" name="address" placeholder="Your Address" required>
                </div>
                <div class="form-group">
                    <label for="payment">Payment Details:</label>
                    <input type="text" id="payment" name="payment" placeholder="Payment Details" required>
                </div>
                <button type="submit" class="place-order-button">Place Order</button>
            </form>
        </div>
    </div>
    <a href="https://wa.me/1234567890" class="whatsapp-button" target="_blank" rel="noopener noreferrer">
        <img src="./images/WhatsApp_icon.png" alt="Chat with us on WhatsApp">
    </a>
    <?php include 'footer.php'; ?>
</body>
</html>
