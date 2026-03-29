<!-- <?php
session_start();  // Start the session to check if the user is logged in
?> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centered Navbar</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <style>
        .navbar-nav {
            margin: 0 auto;
        }

        .nav-link {
            color: black !important;
        }

        .login {
            position: absolute;
            right: 20px;
        }

        .logout {
            position: absolute;
            right: 20px;
        }

        body {
            padding-top: 70px;
            font-family: "Fredoka", sans-serif;
        }
       
        .navbar{
            background-color: aqua !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="Dashboard.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="HeartRate.php">Health Monitor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Camera.php">Camera & Control</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Navigation.php">Navigation</a>
                    </li>

                    <!-- Check if user is logged in -->
                    <?php if (isset($_SESSION['userName'])): ?>
                        <li class="nav-item userName">
                            <a class="nav-link login" href="#">
                                <?php echo htmlspecialchars($_SESSION['userName']); ?>
                            </a>
                        </li>
                        <!-- <li class="nav-item logout">
                            <a class="nav-link login" href="Logout.php">Logout</a>
                        </li> -->
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link login" href="login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>