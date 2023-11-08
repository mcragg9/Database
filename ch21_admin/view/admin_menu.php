<?php
    require_once('util/secure_conn.php');  // require a secure connection
    require_once('util/valid_admin.php');  // require a valid admin user

if (isset($_SESSION['user'])) {

    // these will have to be present to access user rights level
    $user = $_SESSION['user'];
    $rights = $user['Rights'];
    
    // Now you can use $rights to display the user's rights on the page
} else {
    // User is not logged in, handle accordingly (e.g., redirect to login page)
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Tracker</title>
        <link rel="stylesheet" type="text/css" href="main.css"/>
    </head>
    <body>
        <header>
            <h1>Menu 
                <?php
                    if($rights === "Admin") {
                    echo "- Administrator";
                    }
                    else { "- User";}
                ?>
            </h1>
        </header>
        <?php
            
            //echo "<p>User Rights: $rights</p>"; // Display user's rights
            include("util/nav_menu.php");
        ?>
    </body>
</html>
