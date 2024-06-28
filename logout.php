<?php
session_start();
session_destroy();

// Redirect to admin login page
header('Location: login2_form.php');

// If the above redirect fails, redirect to the main index page
if (!headers_sent()) {
    header('Location: index.php');
}

exit();
?>