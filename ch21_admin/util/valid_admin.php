<?php
    // make sure the user is logged in as a valid user
    if (!isset($_SESSION['is_valid_admin'])) {
        header("Location: ." );
    }
?>
