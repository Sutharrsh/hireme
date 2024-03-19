<?php
// Start the session

// Unset all session variables

// Destroy the session
session_destroy();
// Include the Auth class definition
require_once 'services/AuthService.php'; // Assuming your Auth class is defined in Auth.php

// Check if the user is logged in
header("Location:?action=login");
exit();
?>
