<?php
session_start();
include 'db.php'; // Include the database connection file
include 'header.php'; // Include the header file

// Initialize variables to hold error messages
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Sanitize input
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = trim($password);
    $confirm_password = trim($confirm_password);

    // Validate input
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email format.';
    } elseif ($password !== $confirm_password) {
        $error_message = 'Passwords do not match.';
    } else {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = 'Email is already registered.';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $name, $email, $hashed_password);

            if ($stmt->execute()) {
                $success_message = 'Registration successful! You can now <a href="login.php">login</a>.';
            } else {
                $error_message = 'An error occurred. Please try again.';
            }
        }
        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8d7da;
            margin: 0;
            padding: 0;
        }

        .center-container {
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full viewport height */
        }

        .signup-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px; /* Ensure proper width for the form */
            text-align: left; /* Align text to the left */
        }

        h2 {
            margin-bottom: 20px;
            font-size: 26px; /* Slightly larger font size */
            text-align: center; /* Center align heading */
        }

        .form-group {
            display: flex;
            flex-direction: column; /* Stack label and input vertically */
            margin-bottom: 20px; /* Increase space between form groups */
        }

        .form-group label {
            margin-bottom: 8px; /* Add space between label and input */
            font-size: 16px; /* Adjust font size */
            color: #333; /* Darker color for better contrast */
        }

        .form-group input {
            width: 100%; /* Make input take the full width of its container */
            padding: 12px; /* Increase padding for better usability */
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px; /* Adjust font size */
            box-sizing: border-box; /* Ensure padding is included in width */
        }

        .form-group input:focus {
            border-color: #333;
            outline: none;
        }

        .form-group button {
            width: 100%; /* Make button take the full width of its container */
            padding: 12px; /* Increase padding for better usability */
            border: none;
            background-color: #e94e77;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px; /* Adjust font size */
        }

        .form-group button:hover {
            background-color: #555;
        }

        .error-message, .success-message {
            text-align: center;
            margin-bottom: 20px; /* Increase space for better visibility */
            font-size: 16px; /* Adjust font size */
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }

        .additional-links {
            margin-top: 20px;
            text-align: center; /* Center align additional links */
        }

        .additional-links a {
            color: #333;
            text-decoration: none;
            font-size: 16px;
        }

        .additional-links a:hover {
            text-decoration: underline;
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
    <div class="center-container">
        <div class="signup-container">
            <h2>Signup</h2>

            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <form action="signup.php" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="form-group">
                    <button type="submit">Signup</button>
                </div>
            </form>

            <div class="additional-links">
                <a href="login.php">Already have an account? Login here</a>
            </div>
        </div>
    </div>
    <a href="https://wa.me/1234567890" class="whatsapp-button" target="_blank" rel="noopener noreferrer">
        <img src="./images/WhatsApp_icon.png" alt="Chat with us on WhatsApp">
    </a>
    <?php include 'footer.php'; ?> <!-- Optional footer -->
</body>
</html>
