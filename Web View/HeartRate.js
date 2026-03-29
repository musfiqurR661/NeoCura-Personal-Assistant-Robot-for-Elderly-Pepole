// Fetch Blynk Data and Update UI
const BLYNK_AUTH = "77nL81ME672wr7iW-Zypihl5QJVb6Ku1"; // Your Blynk Auth Token
const heartRateElement = document.getElementById('heart-rate');
const oxygenLevelElement = document.getElementById('oxygen-level');

// Array to store health data
let healthData = [];

// Load existing data from local storage
function loadHealthData() {
    const storedData = localStorage.getItem('healthData');
    if (storedData) {
        healthData = JSON.parse(storedData);
    }
}

// Save health data to local storage
function saveHealthData() {
    localStorage.setItem('healthData', JSON.stringify(healthData));
}

// Function to fetch data
async function fetchData() {
    try {
        const heartRateResponse = await fetch(`https://blynk.cloud/external/api/get?token=${BLYNK_AUTH}&V3`);
        const oxygenLevelResponse = await fetch(`https://blynk.cloud/external/api/get?token=${BLYNK_AUTH}&V4`);

        const heartRate = await heartRateResponse.text();
        const oxygenLevel = await oxygenLevelResponse.text();

        // Update UI
        heartRateElement.textContent = heartRate || 'N/A';
        oxygenLevelElement.textContent = oxygenLevel || 'N/A';

        // Store the data with a timestamp
        const timestamp = new Date().toLocaleString();
        healthData.push({
            time: timestamp,
            heartRate: heartRate || 'N/A',
            oxygenLevel: oxygenLevel || 'N/A'
        });

        // Save updated health data to local storage
        saveHealthData();

    } catch (error) {
        console.error('Error fetching data:', error);
        heartRateElement.textContent = 'Error';
        oxygenLevelElement.textContent = 'Error';
    }
}

// Fetch data every 1 second
setInterval(fetchData, 1000);

// Function to download PDF
function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFont('Poppins', 'bold');
    doc.setFontSize(20);
    doc.text('Health Monitoring Report', 10, 10);

    doc.setFontSize(12);
    let y = 30; // Starting Y position
    const lineHeight = 10; // Height for each line
    const maxLinesPerPage = 20; // Maximum number of lines per page
    let currentPageLines = 0; // Counter for the current page's lines

    healthData.forEach((entry, index) => {
        // Add a new page if the maximum lines per page is exceeded
        if (currentPageLines >= maxLinesPerPage) {
            doc.addPage(); // Create a new page
            doc.setFontSize(20);
            doc.text('Health Monitoring Report', 10, 10);
            doc.setFontSize(12);
            y = 30; // Reset Y position for the new page
            currentPageLines = 0; // Reset line counter for the new page
        }

        // Print all details in one line
        const entryText = `Time: ${entry.time}, Heart Rate: ${entry.heartRate} bpm, Oxygen Level: ${entry.oxygenLevel} %`;
        doc.text(entryText, 10, y);

        // Increment Y position for the next entry
        y += lineHeight; // Increment Y position for the next entry
        currentPageLines++; // Increment line counter for each entry
    });


    // Save the PDF
    doc.save('Health_Monitoring_Report.pdf');
}

// Load existing health data when the page loads
loadHealthData();
