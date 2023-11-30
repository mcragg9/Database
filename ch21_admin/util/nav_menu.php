<main class="menu">
    <?php
    if ($rights === "Admin") {
        echo "Administrator Access";
    } else {
        echo "Standard User";
    }
    ?>
    <a href="index.php?action=show_admin_menu">Main Page</a>
    <a href="index.php?action=left_off">Reports</a>
    <a href="index.php?action=show_order_manager">Generate Report</a>
    <a href="index.php?action=logout">Logout</a>
</main>
