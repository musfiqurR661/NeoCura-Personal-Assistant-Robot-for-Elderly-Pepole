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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Get the username and password from the form
   $userName = $_POST['userName'];
   $password = $_POST['password'];

   // Prepare a SQL statement to prevent SQL injection
   $stmt = $conn->prepare("SELECT * FROM user_info WHERE userName = ? AND password = ?");
   $stmt->bind_param("ss", $userName, $password);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
      // Set session variables and redirect to the dashboard
      $_SESSION['userName'] = $userName;
      header("Location: ../Dashboard.php");
      exit();
   } else {
      // If login fails, set the error message
      $error_message = "Invalid username or password.";
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
   <title>Login Page</title>
   <link rel="stylesheet" href="login.css">
</head>

<body>
   <div class="wrapper">
      <form action="login.php" method="POST">
         <h1>Login</h1>
         <div class="input-box">
            <input type="text" name="userName" placeholder="Username" required />
            <i class="bx bxs-user"></i>
         </div>
         <div class="input-box">
            <input type="password" name="password" placeholder="Password" required />
            <i class="bx bxs-lock-alt"></i>
         </div>

         <!-- Display error message if it exists -->
         <?php if (!empty($error_message)): ?>
            <div class="error" style="color: red; margin-bottom: 10px;">
               <?php echo $error_message; ?>
            </div>
         <?php endif; ?>

         <div>
            <button class="btn" type="submit">Login</button>
         </div>
      </form>

      <div class="reg-link">
         <p>Don't have an account? <a href="SignUp.php">Sign up</a></p>
      </div>
   </div>
</body>

</html>