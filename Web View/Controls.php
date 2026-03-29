<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robot Controller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .controller-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 85vh;
        }

        .btn-group-vertical {
            display: flex;
            flex-direction: column;
        }

        .btn-group-horizontal {
            display: flex;
            justify-content: center;
            gap: 100px;
        }

        .btn {
            width: 80px;
            height: 80px;
            font-size: 24px;
        }

        /* Add styles for the pressed effect */
        .pressed {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            background-color: #007bff;
            transform: scale(0.95);
        }
    </style>
</head>

<body>
    <?php include("Navbar.php") ?>

    <div class="container controller-container">
        <div class="d-flex flex-column align-items-center">
            <button id="upBtn" class="btn btn-primary mb-3" onclick="moveRobot('up')">
                <i class="fa-solid fa-arrow-up"></i>
            </button>
            <div class="btn-group-horizontal mb-3">
                <button id="leftBtn" class="btn btn-primary me-3" onclick="moveRobot('left')">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <button id="rightBtn" class="btn btn-primary" onclick="moveRobot('right')">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
            <button id="downBtn" class="btn btn-primary" onclick="moveRobot('down')">
                <i class="fa-solid fa-arrow-down"></i>
            </button>
        </div>
    </div>

    <script>
        function moveRobot(direction) {
            console.log("Moving robot " + direction);
            // Add your control logic here
            // You can use AJAX, fetch, or WebSocket to communicate with the robot
        }

        // Function to apply the pressed effect
        function applyPressedEffect(button) {
            button.classList.add("pressed");
            setTimeout(() => {
                button.classList.remove("pressed");
            }, 200); // Remove the effect after 200ms
        }

        // Listen for arrow key presses and trigger button clicks with effect
        document.addEventListener('keydown', function(event) {
            let button;
            if (event.key === "ArrowUp") {
                button = document.getElementById("upBtn");
            } else if (event.key === "ArrowDown") {
                button = document.getElementById("downBtn");
            } else if (event.key === "ArrowLeft") {
                button = document.getElementById("leftBtn");
            } else if (event.key === "ArrowRight") {
                button = document.getElementById("rightBtn");
            }

            if (button) {
                button.click(); // Trigger the click
                applyPressedEffect(button); // Apply the pressed effect
            }
        });
    </script>
</body>

</html>