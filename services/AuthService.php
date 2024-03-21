<?php

class AuthService
{
    // Function to check if the user is logged in
    public static function isLoggedIn()
    {
        if (isset ($_SESSION['username'])) {
            // User is logged in
            return true;
        } else {
            // User is not logged in
            return false;
        }
    }

    // Function to redirect to login page if not logged in
    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {
            // User is not logged in, redirect to login page
            header("Location: login.php");
            exit(); // Ensure that script execution stops after redirection
        }
    }
}

?>