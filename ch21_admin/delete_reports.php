<?php
require_once('util/secure_conn.php');
require_once('util/valid_admin.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reports_id'])) {
    $reports_id = $_POST['reports_id'];

    // Prepare and execute a delete query
    $stmt = $db->prepare("DELETE FROM reports WHERE reports_id = :reports_id");
    $stmt->bindValue(':reports_id', $reports_id, PDO::PARAM_INT);
    $stmt->execute();
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->errorInfo()[2]; // Output any error messages
    }

    // Redirect back to the page with the reports
    header("Location: Reports.php");
    exit();
}
