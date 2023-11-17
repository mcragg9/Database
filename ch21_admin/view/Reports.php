<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('util/secure_conn.php');
require_once('util/valid_admin.php');
require_once('model/admin_db.php');
require_once('model/database.php');

// Provides rights for the logged-in user
$user = $_SESSION['user'];
$rights = $user['Rights'];

// Initialize filter values
$incidentDateFilter = isset($_POST['incidentDate']) ? '%' . $_POST['incidentDate'] . '%' : '';
$classificationNameFilter = isset($_POST['classificationName']) ? '%' . $_POST['classificationName'] . '%' : '';
$createdByFilter = isset($_POST['createdBy']) ? '%' . $_POST['createdBy'] . '%' : '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Modify your query to use prepared statements
    $stmt = $db->prepare("SELECT reports.reports_id, 
                    reports.IncidentDate, 
                    reports.CreatedDate, 
                    classification.classificationname, 
                    impact.ImpactPhrase, 
                    reports.location_id, 
                    reports.Description, 
                    CONCAT(usersCreated.FirstName, ' ', usersCreated.LastName) AS CreatedByName, 
                    reports.ModifiedDate, 
                    CONCAT(usersModified.FirstName, ' ', usersModified.LastName) AS ModifiedByName
             FROM reports 
             JOIN classification ON reports.classification_id = classification.classification_id
             JOIN impact ON reports.impact_id = impact.impact_id
             JOIN users AS usersCreated ON reports.CreatedBy = usersCreated.user_id
             JOIN users AS usersModified ON reports.ModifiedBy = usersModified.user_id
             WHERE reports.IncidentDate LIKE :incidentDate
             AND classification.classificationname LIKE :classificationName
             AND CONCAT(usersCreated.FirstName, ' ', usersCreated.LastName) LIKE :createdBy"); 

    $stmt->bindParam(':incidentDate', $incidentDateFilter, PDO::PARAM_STR);
    $stmt->bindParam(':classificationName', $classificationNameFilter, PDO::PARAM_STR);
    $stmt->bindParam(':createdBy', $createdByFilter, PDO::PARAM_STR);

    $stmt->execute();
} else {
    // If the form is not submitted, execute the original query without any filters
    $stmt = $db->prepare("SELECT reports.reports_id, 
                            reports.IncidentDate, 
                            reports.CreatedDate, 
                            classification.classificationname, 
                            impact.ImpactPhrase, 
                            reports.location_id, 
                            reports.Description, 
                            CONCAT(usersCreated.FirstName, ' ', usersCreated.LastName) AS CreatedByName, 
                            reports.ModifiedDate, 
                            CONCAT(usersModified.FirstName, ' ', usersModified.LastName) AS ModifiedByName
                     FROM reports 
                     JOIN classification ON reports.classification_id = classification.classification_id
                     JOIN impact ON reports.impact_id = impact.impact_id
                     JOIN users AS usersCreated ON reports.CreatedBy = usersCreated.user_id
                     JOIN users AS usersModified ON reports.ModifiedBy = usersModified.user_id"); 
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
    <header>
        <h1>Reports</h1>
    </header>
    <title>Reports</title>
    <link rel="stylesheet" type="text/css" href="main.css"/>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php
    include("util/nav_menu.php");
    ?>
    <!-- Add search form -->
    <form method="post" action="">
        <input type="text" name="incidentDate" placeholder="Search by Incident Date">
        <input type="text" name="classificationName" placeholder="Search by Classification Name">
        <input type="text" name="createdBy" placeholder="Search by Created By">
        <input type="submit" value="Search">
    </form>
    <!-- Add clear search form  -->
    <form method="post" action="">
        </br>
            <input type="submit" value="Clear Search">
    </form>

    <?php
    // Displays results in a table
    $headerPrinted = false;
    echo '<form method="post" action="">'; // Add a form for deleting items
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!$headerPrinted) {
            echo '<table>';
            echo '<tr>';
            if ($rights === "Admin") {
                echo '<th>Edit</th>'; // Add a column header for "Edit"
            }
            // Add headers for other columns
            echo '<th>Incident Date</th>';
            echo '<th>Created Date</th>';
            echo '<th>Classification ID</th>';
            echo '<th>Impact ID</th>';
            echo '<th>Location ID</th>';
            echo '<th>Description</th>';
            echo '<th>Created By</th>';
            echo '<th>Modified Date</th>';
            echo '<th>Modified By</th>';
            echo '<th>Classification Name</th>';
            echo '</tr>';
            $headerPrinted = true;
        }
        echo '<tr>';
        if (isset($row['reports_id'])) {
            if ($rights === "Admin") {
                echo '<td><a href="index.php?action=edit_reports_page&reports_id=' . $row['reports_id'] . '">Edit</a></td>';
            }
        } else {
            echo '<td>Missing reports_id</td>';
        }
        // Output the values for each column
        echo '<td>' . htmlspecialchars($row['IncidentDate']) . '</td>';
        echo '<td>' . htmlspecialchars($row['CreatedDate']) . '</td>';
        echo '<td>' . htmlspecialchars($row['classificationname']) . '</td>';
        echo '<td>' . htmlspecialchars($row['ImpactPhrase']) . '</td>';
        echo '<td>' . htmlspecialchars($row['location_id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['Description']) . '</td>';
        echo '<td>' . htmlspecialchars($row['CreatedByName']) . '</td>';
        echo '<td>' . htmlspecialchars($row['ModifiedDate']) . '</td>';
        echo '<td>' . htmlspecialchars($row['ModifiedByName']) . '</td>';
        echo '<td>' . htmlspecialchars($row['classificationname']) . '</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '</form>';
    ?>
</body>
</html>
