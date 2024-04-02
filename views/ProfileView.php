<?php
$isLoggedIn = AuthService::isLoggedIn();
// If the user is not logged in or not a user, redirect them to the index page
if (!$isLoggedIn || $_SESSION['role'] != 'user') {
    header("Location: ?action=index");
    exit();
}

// Include the Auth class definition
require_once 'services/AuthService.php'; // Assuming your Auth class is defined in AuthService.php

// Check if the user is logged in
$isLoggedIn = AuthService::isLoggedIn();
// If the user is not logged in, redirect them to the login page
if (!$isLoggedIn) {
    header("Location: ?action=login");
    exit();
}

$user_id = $_SESSION['user_id'];
$jobApplication = $userController->getData($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            background-color: #0077b5;
            color: #fff;
            padding: 30px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid #fff;
        }

        .profile-header h2 {
            margin-top: 10px;
            font-size: 24px;
        }

        .profile-header p {
            font-size: 18px;
        }

        .profile-content {
            padding: 20px;
        }

        .profile-content p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .profile-content p strong {
            font-weight: bold;
        }

        .profile-content a {
            color: #0077b5;
            text-decoration: none;
        }

        .profile-content a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <img src="<?php echo $jobApplication['dp_path']; ?>" alt="Profile Picture">
            <h2><?php echo $jobApplication['full_name']; ?></h2>
            <p>Career Objective: <?php echo $jobApplication['career_objective']; ?></p>
        </div>
        <div class="profile-content">
            <p><strong>ID:</strong> <?php echo $jobApplication['id']; ?></p>
            <p><strong>Contact Number:</strong> <?php echo $jobApplication['contact_number']; ?></p>
            <p><strong>Experience Years:</strong> <?php echo $jobApplication['experience_years']; ?></p>
            <p><strong>Resume:</strong> <a href="<?php echo $jobApplication['resume_path']; ?>" target="_blank">View Resume <i class="fas fa-external-link-alt"></i></a></p>
        </div>
    </div>
</body>
</html>
