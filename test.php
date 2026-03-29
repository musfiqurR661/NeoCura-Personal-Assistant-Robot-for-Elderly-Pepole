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
                <!-- Change the src to point to your Raspberry Pi's IP address -->
                <img id="webcam" src="http://192.168.0.108:5000/video_feed" alt="Camera Feed" style="max-width:100%; height:auto;">
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
        function moveRobot(direction) {
            console.log("Moving robot " + direction); // Log the direction being sent

            // Send POST request to Flask server on Raspberry Pi
            fetch('http://192.168.0.108:5000/move', { // Ensure this is your Raspberry Pi's IP
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    direction: direction
                }) // Send the direction to Flask server
            })
            .then(response => {
                console.log('Response Status:', response.status); // Log the response status
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data); // Log success response from the server
            })
            .catch((error) => {
                console.error('Error:', error); // Handle any errors
            });
        }

        // Listen for arrow key presses and trigger button clicks
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
            }
        });
    </script>
</body>

</html>