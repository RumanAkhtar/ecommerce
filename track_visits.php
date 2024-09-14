<?php
include 'db.php'; 

// Increment visit count
$stmt = $conn->prepare("INSERT INTO visits (visit_date) VALUES (NOW())");
$stmt->execute();

// Fetch total visit count
$result = $conn->query("SELECT COUNT(*) AS total_visits FROM visits");
$visit_count = $result->fetch_assoc()['total_visits'];

// Return the visit count
echo $visit_count;
?>
