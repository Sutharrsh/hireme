<?php

// Include the Auth class definition
require_once 'services/AuthService.php'; // Assuming your Auth class is defined in Auth.php

// Check if the user is logged in
$isLoggedIn = AuthService::isLoggedIn();
// If the user is not logged in, redirect them to the login page

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <style>
        /* Add your CSS styles for header here */
        .header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .nav {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .nav li {
            display: inline;
            margin-right: 10px;
        }
        .nav li a {
            color: #fff;
            text-decoration: none;
        }
        .nav li a:hover {
            text-decoration: underline;
        }
        .active {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <ul class="nav">
            <li><a href="?action=index">Home</a></li>
            <?php if(!$isLoggedIn){ ?>
            <li><a href="?action=register">Register</a></li>
            <li><a href="?action=login">Login</a></li>
            <?php }else{ ?>
                <li><a href="?action=logout">Logout</a></li>
                <?php } ?>
            <li><a href="?action=profile">Profile</a></li>
            <li><a href="?action=profile-view">Profile View</a></li>
        </ul>
    </div>
</body>
</html>
