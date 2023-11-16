<?php
require_once('util/secure_conn.php');
require_once('util/valid_admin.php');
require_once('model/admin_db.php');
require_once('model/database.php');

// Get the report ID from the URL
$reportId = $_GET['reports_id'];

//Provdes rights for logged in user
$user = $_SESSION['user'];
$rights = $user['Rights'];

// Fetch the selected report from the database
$stmt = $db->prepare("SELECT reports.reports_id, 
                              reports.IncidentDate, 
                              reports.CreatedDate, 
                              classification.classificationname, 
                              impact.ImpactPhrase, 
                              reports.location_id, 
                              reports.Description, 
                              reports.CreatedBy, 
                              reports.ModifiedDate, 
                              reports.ModifiedBy
                       FROM reports 
                       JOIN classification ON reports.classification_id = classification.classification_id
                       JOIN impact ON reports.impact_id = impact.impact_id
                       WHERE reports.reports_id = :reportId");
$stmt->bindParam(':reportId', $reportId, PDO::PARAM_INT);
$stmt->execute();
$report = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $updatedIncidentDate = $_POST['incidentDate'];
    $updatedCreatedDate = $_POST['createdDate'];
    $updatedClassification = $_POST['classification'];
    $updatedImpact = $_POST['impact'];
    $updatedLocationId = $_POST['locationId'];
    $updatedDescription = $_POST['description'];
    $updatedCreatedBy = $_POST['createdBy'];
    $updatedModifiedDate = $_POST['modifiedDate'];
    $updatedModifiedBy = $_POST['modifiedBy'];

    // Update the database
    $updateStmt = $db->prepare("UPDATE reports 
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

    $updateStmt->bindParam(':incidentDate', $updatedIncidentDate, PDO::PARAM_STR);
    $updateStmt->bindParam(':createdDate', $updatedCreatedDate, PDO::PARAM_STR);
    $updateStmt->bindParam(':classification', $updatedClassification, PDO::PARAM_STR);
    $updateStmt->bindParam(':impact', $updatedImpact, PDO::PARAM_STR);
    $updateStmt->bindParam(':locationId', $updatedLocationId, PDO::PARAM_INT);
    $updateStmt->bindParam(':description', $updatedDescription, PDO::PARAM_STR);
    $updateStmt->bindParam(':createdBy', $updatedCreatedBy, PDO::PARAM_STR);
    $updateStmt->bindParam(':modifiedDate', $updatedModifiedDate, PDO::PARAM_STR);
    $updateStmt->bindParam(':modifiedBy', $updatedModifiedBy, PDO::PARAM_STR);
    $updateStmt->bindParam(':reportId', $reportId, PDO::PARAM_INT);

    $updateStmt->execute();

    // Redirect back to the reports table view
    header("Location: index.php?action=show_order_manager");
    exit();
}

// Display the form for editing
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Report</title>
    <link rel="stylesheet" type="text/css" href="main.css"/>
</head>
<body>
    <?php include("util/nav_menu.php") ?>

    <h2>Edit Report</h2>
    <form action="update_reports.php" method="post">

        <!-- Include other input fields for editing -->
        Incident Date: <input type="text" name="incidentDate" value="<?php echo $report['IncidentDate']; ?>"><br>
        Created Date: <input type="text" name="createdDate" value="<?php echo $report['CreatedDate']; ?>"><br>
        Classification: <input type="text" name="classification" value="<?php echo $report['classificationname']; ?>"><br>
        Impact: <input type="text" name="impact" value="<?php echo $report['ImpactPhrase']; ?>"><br>
        Location ID: <input type="text" name="locationId" value="<?php echo $report['location_id']; ?>"><br>
        Description: <textarea name="description"><?php echo $report['Description']; ?></textarea><br>
        Created By: <input type="text" name="createdBy" value="<?php echo $report['CreatedBy']; ?>"><br>
        Modified Date: <input type="text" name="modifiedDate" value="<?php echo $report['ModifiedDate']; ?>"><br>
        Modified By: <input type="text" name="modifiedBy" value="<?php echo $report['ModifiedBy']; ?>"><br>

        <input type="submit" value="Save Changes">
    </form>
</body>
</html>
