<?php
require_once('util/secure_conn.php');
require_once('util/valid_admin.php');
require_once('model/admin_db.php');
require_once('model/database.php');

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
                         ModifiedDate = :modifiedDate,
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
$stmt->bindParam(':modifiedDate', $modifiedDate, PDO::PARAM_STR);
$stmt->bindParam(':modifiedBy', $modifiedBy, PDO::PARAM_STR);

if ($stmt->execute()) {
    echo "Report updated successfully";
} else {
    echo "Error updating report: " . $stmt->errorInfo()[2];
}

// Redirect back to the reports table view
header("Location: index.php?action=show_order_manager");
exit();
?>
