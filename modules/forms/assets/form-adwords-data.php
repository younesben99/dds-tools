<?php
ob_start(); // Start output buffering
// Send headers to prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// Capture GCLID from URL
$gclid = isset($_GET['gclid']) ? $_GET['gclid'] : null;
$campaign = isset($_GET['campaign']) ? $_GET['campaign'] : null;

// Database credentials - REPLACE with your actual database credentials
$servername = "35.214.174.30"; // Server IP
$username = "ubxdekdgeto3z";     // Database username
$password = "t0e4xbypqgdu";     // Database password
$dbname = "dbmirth08tqnsl";     // Database name
$port = 3306;                   // Port number

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check if 'download' is the only parameter in the URL
if (isset($_GET['download']) && count($_GET) == 1) {
    $campaignName = trim($_GET['download'], '()');

    // Prepare SQL query to select data
    $sql = "SELECT GCLID, ConversionName, ConversionTime, ConversionValue, ConversionCurrency FROM OfflineConversions WHERE Campaign = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $campaignName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Set headers to download file rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $campaignName . '.csv"');

    // Create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // Write the header row to the CSV file
    fputcsv($output, ['GCLID', 'ConversionName', 'ConversionTime', 'ConversionValue', 'ConversionCurrency']);

    // Fetch the data and write it to the CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    fclose($output);
    $stmt->close();
    exit; // Ensure no further output is sent
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
<html> 
    <head><link href='https://fonts.googleapis.com/css?family=Noto Sans' rel='stylesheet'><title>Lead rating Succesvol</title><meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
    <body>
        <style>
            body{
                margin: 0;
                font-family:"Noto Sans", "Sans serif";
            }nav img {
    width: 40%;max-width: 207px;
}
nav{
    background: #111920;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 80Px;
}
p {
    font-size: 30px;
    margin: 10px;
    text-align: center;
}
input[type="submit"] {
    width: 280px;
    height: 60px;
    font-size: 19px;
    border-radius: 9px;
    border: 0px;
    background: #167ee1;
    color: white;
    box-shadow: 0px 3px 10px #2969a6a1;
    cursor:pointer;
}

            .wrapper{
                display: flex;
    justify-content: center;
    align-items: center;
    height: 75%;
    flex-direction: column;
            }
            .later_arrived {
    opacity: 0;
    transform: translateY(20px);
    animation-name: fadeInUp;
    animation-duration: 2s;
    animation-delay: 3s;
    animation-fill-mode: forwards;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.delete {
    text-decoration: none;
    color: #882c2c;
    background: #f0cfd957;
    padding: 10px;
    margin-top: 20px;
    border-radius: 10px;
    font-size: 13px;
    box-shadow: 0px 4px 4px #b15c742b;
    border: 1px solid #edd6d6;
    cursor:pointer;
}
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

        </style>
       <nav>
        <img src="https://digiflow.be/wp-content/uploads/2020/09/Digiflowsvgwhite2.png" alt="Digiflow">
       </nav>
    <div class="Wrapper">

<?php
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateDeleteLink($gclid, $campaign) {
    return "<a class='delete' href='?action=delete&campaign=" . urlencode($campaign) . "&gclid=" . urlencode($gclid) . "' onclick='return confirm(\"Wil je deze lead niet aangeven als winstgevend?\");'>Verwijder deze Lead</a>";

}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && $gclid && $campaign) {
    // Delete the GCLID record
    $deleteSql = "DELETE FROM OfflineConversions WHERE GCLID = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("s", $gclid);
    $deleteStmt->execute();
    $deleteStmt->close();

    // Redirect to re-add page
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?') . "?action=readd&campaign=".$campaign."&gclid=" . urlencode($gclid));
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'readd' && $gclid && $campaign) {
    // Display the re-add button
    echo "<form style='display:flex;flex-direction:column;' action='' method='get'>";
    echo "<input type='hidden' name='gclid' value='" . htmlspecialchars($gclid) . "'>";
    echo "<input type='hidden' name='campaign' value='" . htmlspecialchars($campaign) . "'>";
    echo "<p>Vergissing?</p>";
    echo "<input style='font-size: 15px;' type='submit' value='Lead terug ingeven in het systeem'>";
    echo "</form>";
    exit;
}

$conversionName = "Thumbs_Up_Conversion";
$conversionValue = 2.01;
$conversionCurrency = "EUR";
$currentDateTime = date('Y-m-d H:i:s');

// Check if a record with the same GCLID already exists
$checkSql = "SELECT * FROM OfflineConversions WHERE GCLID = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $gclid);
$checkStmt->execute();
$result = $checkStmt->get_result();
$checkStmt->close();

if ($result->num_rows > 0) {
    echo "<p>Deze lead bestaat al in het systeem.</p>";
    echo generateDeleteLink($gclid, $campaign);
} else {
    // Prepare the INSERT statement
    $insertSql = "INSERT INTO OfflineConversions (GCLID, ConversionName, ConversionTime, ConversionValue, ConversionCurrency, Campaign) VALUES (?, ?, ?, ?, ?, ?)";

    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("sssdss", $gclid, $conversionName, $currentDateTime, $conversionValue, $conversionCurrency, $campaign);








    if ($insertStmt->execute()) {

        echo "<div><img src='/wp-content/plugins/dds-tools/modules/forms/assets/loading-adwords.gif' /></div>";
        echo "<div class='later_arrived'><p>Lead Succesvol toegevoegd</p>";
        echo generateDeleteLink($gclid, $campaign);
        echo "</div>";
    } else {
        echo "Error: " . $insertStmt->error;
    }

    $insertStmt->close();
}


$conn->close();
ob_end_flush(); // Send the buffer output and turn off output buffering
?>

</div>
</body>
</html>