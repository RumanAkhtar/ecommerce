<?php include 'db.php'; ?>
<?php
session_start();
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$payment = $_POST['payment'];
$cart = $_SESSION['cart'];
$total_amount = 0;

// Insert order into database
$conn->query("INSERT INTO orders (user_id, total_amount, created_at) VALUES (1, 0, NOW())");
$order_id = $conn->insert_id;

foreach ($cart as $item_id => $quantity) {
    $result = $conn->query("SELECT price FROM items WHERE id = $item_id");
    $item = $result->fetch_assoc();
    $total_amount += $item['price'] * $quantity;
    $conn->query("INSERT INTO order_items (order_id, item_id, quantity) VALUES ($order_id, $item_id, $quantity)");
}

// Update order total
$conn->query("UPDATE orders SET total_amount = $total_amount WHERE id = $order_id");

// Clear cart
unset($_SESSION['cart']);

// Redirect to feedback page
header("Location: feedback.php?order_id=$order_id");
?>
