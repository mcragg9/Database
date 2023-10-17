<?php

    echo "</br></br>1";

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $dsn = 'mysql:host=localhost;dbname=tracker';
    $username = 'root';
    $password = '';

    echo "</br></br>2</br></br>";

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }

    $stmt = $db->prepare("SELECT reports.IncidentDate, classification.classificationname, reports.CreatedBy 
    FROM reports 
    JOIN classification ON reports.classification_id = classification.classification_id");

    if (!$stmt) {
        echo "Error in preparing the statement: ";
        print_r($db->errorInfo());
        exit();
    }

    echo "</br></br>3</br></br>";

    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Incident Date: " . $row['IncidentDate'] . "<br>";
        echo "Classification Name: " . $row['classificationname'] . "<br>";
        echo "Created By: " . $row['CreatedBy'] . "<br>";
        echo "<hr>"; // Add a horizontal rule for better visibility
    }

    echo "</br></br>4</br></br>";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Form</title>

</head>
<body>
    <div class="container">
        <form action="insert_reports.php" method="post">

            <div class="form-group">
                <label for="incident_date">Incident Date:</label>
                <input type="date" id="incident_date" name="incident_date" required>
            </div>

            <div class="form-group">
                <label for="classification_id">Classification:</label>
                <select id="classification_id" name="classification_id" required>
                    <option value="1">Classification 1</option>
                    <option value="2">Classification 2</option>
                    <!-- Add more options as needed from your database -->
                </select>
            </div>

            <div class="form-group">
                <label for="impact_id">Impact:</label>
                <select id="impact_id" name="impact_id" required>
                    <option value="1">Impact 1</option>
                    <option value="2">Impact 2</option>
                    <!-- Add more options as needed from your database -->
                </select>
            </div>

            <div class="form-group checkbox-group">
                <label for="location_id">Location:</label>
                <select id="location_id" name="location_id" required>
                    <option value="1">Location 1</option>
                    <option value="2">Location 2</option>
                    <!-- Add more options as needed from your database -->
                </select>
                <label for="new_location_checkbox">
                    New Location? 
                    <input type="checkbox" id="new_location_checkbox">
                </label>
                <input type="text" id="new_location" name="new_location" disabled>
            </div>

            <div class="form-group">
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" cols="50" required></textarea>
            </div>

            <div class="form-group">
                <label for="created_by">Created By:</label>
                <select id="created_by" name="created_by" required>
                    <?php
                        $dsn = 'mysql:host=localhost;dbname=tracker';
                        $username = 'root';
                        $password = '';

                        try {
                            $db = new PDO($dsn, $username, $password);
                        } catch (PDOException $e) {
                            echo "Connection failed: " . $e->getMessage();
                            exit();
                        }

                        $stmt = $db->query("SELECT * FROM users");

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value=\"{$row['user_id']}\">{$row['FirstName']} {$row['LastName']}</option>";
                        }
                    ?>
                </select>
            </div>

            <input type="submit" class="submit-button" value="Submit">

        </form>
    </div>

    <script>
        document.getElementById('new_location_checkbox').addEventListener('change', function() {
            var newLocationInput = document.getElementById('new_location');
            newLocationInput.disabled = !this.checked;
            if (!this.checked) {
                newLocationInput.value = '';
            }
        });
    </script>
</body>
</html>





</br>
End of Page