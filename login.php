<?php
session_start();
include 'db.php'; // Include the database connection file
include 'header.php'; // Include the header file

// Initialize error message
$error_message = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize input
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = trim($password);

    // Query to check if the email exists
    $stmt = $conn->prepare("SELECT id, password, name FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password, $name);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['user_name'] = $name; // Store user name in session

            // Redirect to the homepage or a logged-in user page
            header("Location: category.php");
            exit();
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "Invalid email or password.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8d7da;
        }

        .center-container {
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full viewport height */
        }

        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px; /* Restrict width for better alignment on larger screens */
            text-align: left; /* Align text to the left */
        }

        h2 {
            margin-bottom: 20px;
            font-size: 26px; /* Slightly larger font size */
            text-align: center; /* Center align heading */
        }

        .form-group {
            margin-bottom: 20px; /* Increase space between form groups */
            display: flex;
            flex-direction: column; /* Stack label and input vertically */
        }

        .form-group label {
            margin-bottom: 8px; /* Add space between label and input */
            font-size: 16px; /* Adjust font size for better readability */
            color: #333; /* Darker color for better contrast */
        }

        .form-group input {
            width: 100%; /* Make input take the full width of its container */
            padding: 12px; /* Increase padding for better usability */
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px; /* Adjust font size for better readability */
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
            font-size: 16px; /* Adjust font size for better readability */
        }

        .form-group button:hover {
            background-color: #c03a5c;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px; /* Increase space for better visibility */
            font-size: 16px; /* Adjust font size for better readability */
        }

        .signup-link {
            display: block;
            margin-top: 15px;
            color: #333;
            text-decoration: none;
            font-size: 16px; /* Adjust font size for better readability */
            text-align: center; /* Center align the link */
        }

        .signup-link:hover {
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
        <div class="login-container">
            <h2>Login</h2>

            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit">Login</button>
                </div>
            </form>

            <!-- Signup Link -->
            <a href="signup.php" class="signup-link">Don't have an account? Sign up here</a>
        </div>
    </div>
    <a href="https://wa.me/1234567890" class="whatsapp-button" target="_blank" rel="noopener noreferrer">
        <img src="./images/WhatsApp_icon.png" alt="Chat with us on WhatsApp">
    </a>
    <?php include 'footer.php'; ?> <!-- Optional footer -->
</body>
</html>
