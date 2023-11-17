<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('util/secure_conn.php');
require_once('util/valid_admin.php');
require_once('model/admin_db.php');
require_once('model/database.php');

//Provdes rights for logged in user
$user = $_SESSION['user'];
$rights = $user['Rights'];

// Get data from the form submission
$reportId = $_POST['reportId'];
$incidentDate = $_POST['incidentDate'];
$createdDate = $_POST['createdDate'];
$classification = $_POST['classification'];
$impact = $_POST['impact'];
$locationId = $_POST['locationId'];
$description = $_POST['description'];
$createdBy = $_POST['createdBy'];
$modifiedDate = $_POST['modifiedDate'];
$modifiedBy = $_POST['modifiedBy'];

// Update the report in the database
$stmt = $db->prepare("UPDATE reports 
                     SET IncidentDate = :incidentDate,
                         CreatedDate = :createdDate,
                         classification_id = (SELECT classification_id FROM classification WHERE classificationname = :classification),
                         impact_id = (SELECT impact_id FROM impact WHERE ImpactPhrase = :impact),
                         location_id = :locationId,
                         Description = :description,
                         CreatedBy = :createdBy,
                         ModifiedDate = CURRENT_TIMESTAMP,
                         ModifiedBy = :modifiedBy
                     WHERE reports_id = :reportId");

$stmt->bindParam(':reportId', $reportId, PDO::PARAM_INT);
$stmt->bindParam(':incidentDate', $incidentDate, PDO::PARAM_STR);
$stmt->bindParam(':createdDate', $createdDate, PDO::PARAM_STR);
$stmt->bindParam(':classification', $classification, PDO::PARAM_STR);
$stmt->bindParam(':impact', $impact, PDO::PARAM_STR);
$stmt->bindParam(':locationId', $locationId, PDO::PARAM_INT);
$stmt->bindParam(':description', $description, PDO::PARAM_STR);
$stmt->bindParam(':createdBy', $createdBy, PDO::PARAM_STR);

$stmt->bindParam(':modifiedBy', $modifiedBy, PDO::PARAM_STR);

if ($stmt->execute()) {
    $message = "Report updated successfully.";
} else {
    $message = "Error updating report: " . $stmt->errorInfo()[2];
}

// Include the navigation menu
include("util/nav_menu.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Report</title>
    <link rel="stylesheet" type="text/css" href="main.css"/>
</head>
<body>
    <h2>Update Report</h2>

    <?php
    // Display the result message
    if (isset($message)) {
        echo "<p>$message</p>";
    }
    ?>

    <!-- Add a link to go back to the reports table view -->
    <p><a href="index.php?action=left_off">Go back to reports</a></p>
</body>
</html>

