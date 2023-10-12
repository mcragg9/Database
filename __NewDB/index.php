<?php

    echo "</br></br>1</br></br>";

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


It worked!!!