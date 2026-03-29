<?php
// Start session to manage user login state
session_start();

// Database connection
$host = 'localhost'; // Your database host
$db = 'youngboys'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

// Create a new MySQLi connection
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = ''; // Variable to store the error message
$success_message = ''; // Variable to store success message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username, password, and confirm password from the form
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if the passwords match
    if ($password !== $confirmPassword) {
        $error_message = "Passwords do not match.";
    } else {
        // Check if the username already exists
        $stmt = $conn->prepare("SELECT * FROM user_info WHERE userName = ?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Username already exists.";
        } else {
            // Insert the new user into the database
            $stmt = $conn->prepare("INSERT INTO user_info (userName, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $userName, $password);

            if ($stmt->execute()) {
                $success_message = "Account created successfully. You can now <a href='login.php'>login</a>.";
            } else {
                $error_message = "Error creating account. Please try again.";
            }
        }

        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="wrapper">
        <form action="signup.php" method="POST">
            <h1>Sign Up</h1>
            <div class="input-box">
                <input type="text" name="userName" placeholder="Username" required />
                <i class="bx bxs-user"></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required />
                <i class="bx bxs-lock-alt"></i>
            </div>
            <div class="input-box">
                <input type="password" name="confirmPassword" placeholder="Confirm Password" required />
                <i class="bx bxs-lock-alt"></i>
            </div>

            <!-- Display error or success message if it exists -->
            <?php if (!empty($error_message)): ?>
                <div class="error" style="color: red; margin-bottom: 10px;">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($success_message)): ?>
                <div class="success" style="color: green; margin-bottom: 10px;">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <div>
                <button class="btn" type="submit">Sign Up</button>
            </div>

            <div class="reg-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>

</html>