<?php

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <!-- favicon -->
    <link rel="icon" href="#" />

    <!-- CSS -->
    <link rel="stylesheet" href="Dashboard.css">


</head>

<body>
    <?php include("Navbar.php") ?>

    <div class="container ">
        <div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center">

            <div class="col" href="index.html">
                <a href="HeartRate.php" class="text-decoration-none text-dark">

                    <div class="card mx-auto custom-card-height">
                        <div class="card-body">
                            <h5 class="card-title">Health Monitor</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col">
                <a href="Camera.php" class="text-decoration-none text-dark">
                    <div class="card mx-auto custom-card-height">
                        <div class="card-body">
                            <h5 class="card-title">Camera & Control</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="Navigation.php" class="text-decoration-none text-dark">

                    <div class="card mx-auto custom-card-height">
                        <div class="card-body">
                            <h5 class="card-title">Navigation</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="#" class="text-decoration-none text-dark">

                    <div class="card mx-auto custom-card-height">
                        <div class="card-body">
                            <h5 class="card-title">Control</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <script>
        // List of 8 colors to pick from
        // const colors = ['#FF5733', '#33FF57', '#3357FF', '#F3FF33', '#FF33A8', '#33FFF3', '#A833FF', '#FF8C33'];

        let colors = ["#FFEBB7", "#B5EAD7", "#FFDAC1", "#C7CEEA", "#FFDFD3", "#FFC4C4", "#E0BBE4", "#A0E7E5"];


        // Add event listeners to each card
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                // Pick a random color from the list
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                // Apply the random color as the background
                card.style.backgroundColor = randomColor;
            });

            card.addEventListener('mouseleave', function() {
                // Reset the background color when hover ends
                card.style.backgroundColor = '';
            });
        });
    </script>
</body>

</html>