<?php
 // Initialize the session
 session_start();

 // Unset all of the session variable.
 $_SESSION = array();

 // Destroy the session.
 session_destroy();

 // Redirect to the home page
 header("location: ". $base_url. "index.php");
?>