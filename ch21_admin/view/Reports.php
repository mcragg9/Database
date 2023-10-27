<?php
    require_once('util/secure_conn.php');
    require_once('util/valid_admin.php');

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $incidentDate = $_POST['incidentDate'];
        $classificationName = $_POST['classificationName'];
        $createdBy = $_POST['createdBy'];

        // Modify your query to use prepared statements and add WHERE clauses based on user input
        $stmt = $db->prepare("SELECT reports.IncidentDate, classification.classificationname, reports.CreatedBy, reports.description 
            FROM reports 
            JOIN classification ON reports.classification_id = classification.classification_id
            WHERE reports.IncidentDate LIKE :incidentDate
            AND classification.classificationname LIKE :classificationName
            AND reports.CreatedBy LIKE :createdBy");

        $stmt->bindValue(':incidentDate', "%$incidentDate%", PDO::PARAM_STR);
        $stmt->bindValue(':classificationName', "%$classificationName%", PDO::PARAM_STR);
        $stmt->bindValue(':createdBy', "%$createdBy%", PDO::PARAM_STR);

        $stmt->execute();
    } else {
        // If the form is not submitted, execute the original query without any filters
        $stmt = $db->prepare("SELECT reports.IncidentDate, classification.classificationname, reports.CreatedBy, reports.description 
            FROM reports 
            JOIN classification ON reports.classification_id = classification.classification_id");
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
        include("util/nav_menu.php")
    ?>

    <!-- Add search form -->
    <form method="post" action="">
        <input type="text" name="incidentDate" placeholder="Search by Incident Date">
        <input type="text" name="classificationName" placeholder="Search by Classification Name">
        <input type="text" name="createdBy" placeholder="Search by Created By">
        <input type="submit" value="Search">
    </form>

    <!-- Add clear search form -->
    <form method="post" action="">
        <input type="submit" value="Clear Search">
    </form>

    <?php
        // Display the results in a table
        $headerPrinted = false;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!$headerPrinted) {
                echo '<table>';
                echo '<tr>';
                foreach ($row as $key => $value) {
                    echo '<th>' . htmlspecialchars($key) . '</th>';
                }
                echo '</tr>';
                $headerPrinted = true;
            }
            echo '<tr>';
            foreach ($row as $value) {
                echo '<td>' . htmlspecialchars($value) . '</td>';
            }
            echo '</tr>';
        }
        if ($headerPrinted) {
            echo '</table>';
        } else {
            echo '<p>No results found.</p>';
        }
    ?>
</body>
</html>


