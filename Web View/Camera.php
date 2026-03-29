<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robot Control</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Camera.css">
</head>

<body>
    <?php include("Navbar.php") ?>

    <div class="wrapper">
        <!-- Camera Section -->
        <div id="camera" class="content">
            <div class="section">
                <h2>Camera Feed</h2>
                <!-- Change the src to point to your ngrok URL -->
                <img id="webcam" src="https://f1d2-2401-1900-188-aba1-1c9a-1cb-c7d5-12cb.ngrok-free.app/video_feed" alt="Camera Feed" style="max-width:100%; height:auto;">
            </div>
        </div>

        <!-- Control Buttons -->
        <div class="content">
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
        </div>
    </div>

    <script>
        let intervalId = null; // To store the interval ID for continuous movement

        // Function to start moving the robot in a given direction
        function startMoveRobot(direction) {
            console.log("Started moving robot " + direction);
            // Keep sending the move request every 200ms while the button is held down
            intervalId = setInterval(() => {
                fetch('https://f1d2-2401-1900-188-aba1-1c9a-1cb-c7d5-12cb.ngrok-free.app/move', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            direction: direction
                        })
                    })
                    .then(response => {
                        console.log('Response Status:', response.status);
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success:', data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }, 200); // Adjust the delay for sending requests based on your need
        }

        // Function to stop moving the robot
        function stopMoveRobot() {
            if (intervalId) {
                clearInterval(intervalId); // Stop sending the move requests
                intervalId = null;
                console.log("Stopped moving robot");
            }
        }

        // Attach event listeners to buttons
        document.getElementById("upBtn").addEventListener('mousedown', () => startMoveRobot('up'));
        document.getElementById("upBtn").addEventListener('mouseup', stopMoveRobot);
        document.getElementById("upBtn").addEventListener('mouseleave', stopMoveRobot); // Stops movement if cursor leaves the button area
        document.getElementById("upBtn").addEventListener('touchstart', () => startMoveRobot('up')); // For touch devices
        document.getElementById("upBtn").addEventListener('touchend', stopMoveRobot);

        document.getElementById("downBtn").addEventListener('mousedown', () => startMoveRobot('down'));
        document.getElementById("downBtn").addEventListener('mouseup', stopMoveRobot);
        document.getElementById("downBtn").addEventListener('mouseleave', stopMoveRobot);
        document.getElementById("downBtn").addEventListener('touchstart', () => startMoveRobot('down'));
        document.getElementById("downBtn").addEventListener('touchend', stopMoveRobot);

        document.getElementById("leftBtn").addEventListener('mousedown', () => startMoveRobot('left'));
        document.getElementById("leftBtn").addEventListener('mouseup', stopMoveRobot);
        document.getElementById("leftBtn").addEventListener('mouseleave', stopMoveRobot);
        document.getElementById("leftBtn").addEventListener('touchstart', () => startMoveRobot('left'));
        document.getElementById("leftBtn").addEventListener('touchend', stopMoveRobot);

        document.getElementById("rightBtn").addEventListener('mousedown', () => startMoveRobot('right'));
        document.getElementById("rightBtn").addEventListener('mouseup', stopMoveRobot);
        document.getElementById("rightBtn").addEventListener('mouseleave', stopMoveRobot);
        document.getElementById("rightBtn").addEventListener('touchstart', () => startMoveRobot('right'));
        document.getElementById("rightBtn").addEventListener('touchend', stopMoveRobot);

        // Handle arrow key presses
        document.addEventListener('keydown', function(event) {
            let direction;
            if (event.key === "ArrowUp") {
                direction = "up";
            } else if (event.key === "ArrowDown") {
                direction = "down";
            } else if (event.key === "ArrowLeft") {
                direction = "left";
            } else if (event.key === "ArrowRight") {
                direction = "right";
            }

            if (direction && !intervalId) {
                startMoveRobot(direction); // Start moving
            }
        });

        document.addEventListener('keyup', function() {
            stopMoveRobot(); // Stop moving when the key is released
        });
    </script>

</body>

</html>