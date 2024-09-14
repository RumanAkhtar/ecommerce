<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from POST request
    $user_id = intval($_POST['user_id']);
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($user_id && $product_id && $quantity) {
        // Check if the item already exists in the cart
        $checkQuery = "SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // If item exists, update quantity
            $updateQuery = "UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("iii", $quantity, $user_id, $product_id);
            $stmt->execute();
        } else {
            // If item does not exist, insert new record
            $insertQuery = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("iii", $user_id, $product_id, $quantity);
            $stmt->execute();
        }

        // Check if the query was successful
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Item added to cart successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add item to cart.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
    }
}
?>
