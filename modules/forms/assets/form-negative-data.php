<?php
ob_start(); // Start output buffering
// Send headers to prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past


// Capture GCLID from URL
$gclid = isset($_GET['version']) ? $_GET['version'] : null;
if ($gclid == null) {
    $gclid = isset($_GET['gclid']) ? $_GET['gclid'] : null;
}

$campaign = isset($_GET['campaign']) ? $_GET['campaign'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;
$makemodel = isset($_GET['makemodel']) ? $_GET['makemodel'] : null;
// Database credentials - REPLACE with your actual database credentials
$servername = "35.214.174.30"; // Server IP
$username = "ubxdekdgeto3z";     // Database username
$password = "t0e4xbypqgdu";     // Database password
$dbname = "dbmirth08tqnsl";     // Database name
$port = 3306;                   // Port number

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$formSubmitted = false;
$exists =false;
// Check if the gclid already exists in the database
$checkQuery = "SELECT * FROM Negative_mails WHERE GCLID = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("s", $gclid);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    $exists = true;
    echo "<div class='feedbackactive' style='display:none;'>Feedback is al verstuurd.</div>";
    $checkStmt->close();
} else {
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $formSubmitted = true;
        $reason = isset($_POST['reason']) ? $_POST['reason'] : null;
        if ($reason == 'other') {
            $reason = isset($_POST['custom_reason']) ? $_POST['custom_reason'] : null;
        }

        $conversionTime = date('Y-m-d H:i:s');

        // Prepare INSERT statement
        $stmt = $conn->prepare("INSERT INTO Negative_mails (GCLID, Domain, ConversionTime, Makemodel, Reason) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $gclid, $campaign, $conversionTime, $makemodel, $reason);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<div class='record-insertion' style='display:none;'>Record successfully inserted</div>";
        } else {
            echo "<div class='insertion-error' style='display:none;'>Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
    $checkStmt->close();
}

$conn->close();
ob_end_flush(); // Send the buffer output and turn off output buffering
?>

<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Noto Sans' rel='stylesheet'>
    <title>Feedback succesvol verstuurd.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
    <style>
     body {
            margin: 0;
            font-family: "Noto Sans", "Sans serif";
        }

        nav img {
            width: 40%;
            max-width: 207px;
        }

        nav {
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
            cursor: pointer;
        }

        .wrapper {
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
            cursor: pointer;
        }
        form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    background: #fff;
}

form p {
    font-size: 18px;
    margin-bottom: 15px;
}

form input[type="radio"],
form textarea,
form input[type="submit"] {
    margin-top: 10px;
}

form label {
    margin-left: 5px;
    font-size: 16px;
}

form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-family: Arial, sans-serif;
    margin-bottom: 20px;
}

form input[type="submit"] {
    background-color: #167ee1;
    color: white;
    border: none;
    padding: 10px 20px;
    text-transform: uppercase;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #0a58ca;
}
img{
    width: 70%;
}
/* Mobile responsiveness */
@media (max-width: 768px) {
    form {
        width: 90%;
        padding: 10px;
    }

    form label {
        font-size: 14px;
    }

    form p {
        font-size: 16px;
    }
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
    <div class="wrapper">
        <?php if ($checkResult->num_rows === 0 && !$formSubmitted) { ?>
            <form action="" method="post">
                <p>Kies de reden waarom deze e-mail als 'Niet interessant' wordt gemarkeerd:</p>
                <input type="radio" id="reason1" name="reason" value="vergelijkt">
                <label for="reason1">Vergelijking met andere handelaren</label><br>
                <input type="radio" id="reason2" name="reason" value="verzekering">
                <label for="reason2">Verzekeringsevaluatie</label><br>
                <input type="radio" id="reason3" name="reason" value="Voorbereiding prive verkoop">
                <label for="reason3">Voorbereiding op een privéverkoop</label><br>
                <input type="radio" id="reason4" name="reason" value="erfenis">
                <label for="reason4">Erfenis- of successieplanning</label><br>
                <input type="radio" id="reason5" name="reason" value="schadegeval">
                <label for="reason5">Schadegeval</label><br>
                <input type="radio" id="other" name="reason" value="other">
                <label for="other">Andere</label><br>
                <textarea id="custom_reason" name="custom_reason" placeholder="Geef hier de reden waarom deze mail niet interessant is..." rows="10" cols="50" style="display:none;"></textarea><br>
                <input type="hidden" id="successParam" name="successParam" value="0">
                <input type="submit" value="Verzenden">
            </form>
        <?php } ?>
        <?php if ($formSubmitted) { ?>
            <div id="successMessage">
           <div style="text-align:center;"><img src='/wp-content/plugins/dds-tools/modules/forms/assets/loading-adwords.gif' /></div>
                <p  class='later_arrived'>Feedback is succesvol verstuurd</p>
            </div>
        <?php } ?>
        <?php if($exists){
        ?>
   <div id="successMessage">
   <div style="text-align:center;"><img src='/wp-content/plugins/dds-tools/modules/forms/assets/loading-adwords.gif' /></div>
                <p  class='later_arrived'>De feedback is verstuurd.</p>
            </div>
        <?php
        } ?>
    </div>

    <script>
        // Get all radio buttons
        var reasonRadios = document.getElementsByName('reason');

        // Add change event listener to each radio button
        for(var i = 0; i < reasonRadios.length; i++) {
            reasonRadios[i].addEventListener('change', function() {
                // Show textarea if 'other' is selected, otherwise hide
                document.getElementById('custom_reason').style.display = this.value === 'other' ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>
