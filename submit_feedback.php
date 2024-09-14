<?php include 'db.php'; ?>
<?php
$feedback_text = $_POST['feedback_text'];
$order_id = $_POST['order_id'];

// Save feedback in database
$conn->query("INSERT INTO feedback (order_id, feedback_text) VALUES ($order_id, '$feedback_text')");

// Call OpenAI API to classify feedback
$api_key = 'YOUR_OPENAI_API_KEY';
$response = file_get_contents("https://api.openai.com/v1/engines/text-davinci-003/completions", false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Authorization: Bearer $api_key\r\nContent-Type: application/json\r\n",
        'content' => json_encode([
            'prompt' => "Classify the following feedback as Positive, Neutral, or Negative:\n$feedback_text",
            'max_tokens' => 60
        ])
    ]
]));

$response_data = json_decode($response, true);
$classification = trim($response_data['choices'][0]['text']);

// Update feedback with classification
$conn->query("UPDATE feedback SET classification = '$classification' WHERE order_id = $order_id");

echo "Feedback submitted and classified as: " . $classification;
?>
