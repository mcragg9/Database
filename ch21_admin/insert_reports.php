<?php

require_once('util/secure_conn.php');  // require a secure connection
require_once('util/valid_admin.php');  // require a valid admin user


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dsn = 'mysql:host=localhost;dbname=tracker';
    $username = 'root';
    $password = '';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }

    // Retrieve values from the form
    $incident_date = $db->quote($_POST['incident_date']);
    $classification_id = $db->quote($_POST['classification_id']);
    $impact_id = $db->quote($_POST['impact_id']);
    $location_id = $db->quote($_POST['location_id']);
    $description = $db->quote($_POST['description']);
    $created_by = $db->quote($_POST['created_by']);

    // SQL query to insert data into the reports table
    //
    //
    // Remember, my quotes are different? from the class
    $sql = "INSERT INTO reports (IncidentDate, classification_id, impact_id, location_id, Description, CreatedBy, CreatedDate)
            VALUES ($incident_date, $classification_id, $impact_id, $location_id, $description, $created_by, NOW())"; 
    
    //Prepare and execute the SQL statement
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }

} else {
    echo "Invalid request method. Please submit the form.";
}
?>
