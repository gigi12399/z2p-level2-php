<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    require "includes/nav_sidebar.php";
?>


    <!-- Page content-->
    <div class="container-fluid">
        <h1 class="mt-4">Simple Sidebar</h1>
        <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
        <p>
            Make sure to keep all page content within the
            <code>#page-content-wrapper</code>
            . The top navbar is optional, and just for demonstration. Just create an element with the
            <code>#sidebarToggle</code>
            ID which will toggle the menu when clicked.
        </p>
    </div>

<?php 
    require "includes/footer.php";
?>
            
