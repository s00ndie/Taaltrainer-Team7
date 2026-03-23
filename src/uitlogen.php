<?php
session_start();
    if (isset($_SESSION["user"]))
        {
// remove all session variables
session_unset();

// destroy the session
session_destroy();
header("Location: register.php");
        }
    ?>
