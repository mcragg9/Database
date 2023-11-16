<?php
require_once('util/secure_conn.php');
require_once('util/valid_admin.php');
require_once('model/admin_db.php');
require_once('model/database.php');

// Get the report ID from the URL
$reportId = $_GET['reports_id'];

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
    <form action="update_report.php" method="post">
        <input type="hidden" name="reportId" value="<?php echo $report['reports_id']; ?>">
        <!-- Add other input fields for editing -->
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
