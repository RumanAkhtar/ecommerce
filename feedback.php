<?php include 'db.php'; ?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%; /* Ensure full height for sticky footer */
            display: flex;
            flex-direction: column; /* Stack content vertically */
            font-family: Arial, sans-serif;
            background-color: #f8d7da;
            text-align: center;
        }

        body {
            color: #333;
        }

        .container {
            flex: 1; /* Allow the container to grow and fill available space */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .feedback-form-container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .feedback-form-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .feedback-form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            resize: vertical;
        }

        .feedback-form-container button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            background-color: #e94e77;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }

        .feedback-form-container button:hover {
            background-color: #d43f6c;
        }

        .feedback-form-container input[type="hidden"] {
            display: none;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <section class="feedback-form-container">
            <h1>Feedback</h1>
            <form action="submit_feedback.php" method="post">
                <textarea name="feedback_text" placeholder="Your feedback" required></textarea>
                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($_GET['order_id']); ?>">
                <button type="submit">Submit Feedback</button>
            </form>
        </section>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
