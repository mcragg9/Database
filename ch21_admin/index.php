<?php

// Start session management and include necessary functions
session_start();
require_once('model/database.php');
require_once('model/admin_db.php');

// Get the action to perform
$action = filter_input(INPUT_POST, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'show_admin_menu';
    }
}

// If the user isn't logged in, force the user to login
if (!isset($_SESSION['is_valid_admin'])) {
    $action = 'login';
}

//testing to see if other pages are accessible, it looks to be working
// echo $action;
// print_r($_SESSION);

// Perform the specified action
switch($action) {
    case 'login':
        //TODO For Permission
        //Need to get currently logged in users permissions
        //is where permissions = admin or other

        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
     

        $login_result = is_valid_user_login($username, $password);

        if ($login_result) {
            $_SESSION['is_valid_admin'] = true;
            // $_SESSION['user_rights'] = $login_result['Rights'];
            include('view/admin_menu.php');
        } else {
            $login_message = 'You must login to view this page.';
            include('view/login.php');
        }
        break;
    case 'left_off':
        include("view/Reports.php");
        break;
    case 'show_admin_menu':
        include('view/admin_menu.php');
        break;
    case 'show_product_manager':
        include('view/product_manager.php');
        break;
    case 'show_order_manager':
        include('view/generate_reports.php');
        break;
    case 'edit_reports_page':
        include('view/edit_reports.php');
        break;
    case 'update_reports_page':
        $reportId = isset($_GET['reports_id']) ? $_GET['reports_id'] : null;
    
        if ($reportId) {
            // Fetch report data from the database
            $stmt = $db->prepare("SELECT * FROM reports WHERE reports_id = :reportId");
            $stmt->bindParam(':reportId', $reportId, PDO::PARAM_INT);
            $stmt->execute();
            $report = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Include the view file to display the update form
            include("view/update_reports.php");
        } else {
            // Handle the case when no report ID is provided
            // You may display an error message or redirect to an appropriate page
        }
        break;
        
    case 'logout':
        $_SESSION = array();   // Clear all session data from memory
        session_destroy();     // Clean up the session ID
        $login_message = 'You have been logged out.';
        include('view/login.php');
        break;
}
?>
