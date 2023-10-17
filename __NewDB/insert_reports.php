<?php
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
    $incident_date = $_POST['incident_date'];
    $classification_id = $_POST['classification_id'];
    $impact_id = $_POST['impact_id'];
    $location_id = $_POST['location_id'];
    $description = $_POST['description'];
    $created_by = $_POST['created_by'];

    // SQL query to insert data into the reports table
    //
    //
    // Remember, my quotes are different? from the class
    $sql = "INSERT INTO reports (IncidentDate, classification_id, impact_id, location_id, Description, CreatedBy, CreatedDate)
            VALUES ('$incident_date', '$classification_id', '$impact_id', '$location_id', '$description', '$created_by', NOW())"; 
    
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
