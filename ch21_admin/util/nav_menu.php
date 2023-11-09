<main>
    <?php
        if($rights === "Admin") {
            echo "Administrator Access";
        } else {
            echo "Standard User";
        }
    ?>
    <p><a href="index.php?action=show_admin_menu">Main Page</a></p>
    <p><a href="index.php?action=left_off">Reports</a></p>
    <p><a href="index.php?action=show_order_manager">Generate Report</a></p>
    <p><a href="index.php?action=logout">Logout</a></p>
</main>