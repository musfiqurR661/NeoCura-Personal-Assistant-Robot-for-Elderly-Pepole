<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robot Control Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="HeartRate.css">
</head>

<body>
    <?php include("Navbar.php") ?>

    <!-- Health Monitor Section -->
    <div id="health-monitor" class="content">
        <div class="section">
            <h2>Health Monitoring</h2>
            <div class="card">
                <span class="icon"><i class="fa-solid fa-heart"></i></span>
                <p>Heart Rate: <span class="data" id="heart-rate">Loading...</span> bpm</p>
            </div>
            <div class="card">
                <span class="icon"><i class="fa-solid fa-droplet"></i></span>
                <p>Oxygen Level: <span class="data" id="oxygen-level">Loading...</span> %</p>
            </div>
            <div class="pdf-btn">
                <button onclick="downloadPDF()">Download PDF</button>
            </div>
        </div>
    </div>

    <script src="HeartRate.js"></script>
</body>

</html>