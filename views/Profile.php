<?php

// Include the Auth class definition
require_once 'services/AuthService.php'; // Assuming your Auth class is defined in Auth.php

// Check if the user is logged in
$isLoggedIn = AuthService::isLoggedIn();
// If the user is not logged in, redirect them to the login page
if (!$isLoggedIn) {
  
    header("Location:?action=login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Form</title>
</head>
<body>
    <h2>Job Application Form</h2>
    <form action="?action=submit_application" method="POST" enctype="multipart/form-data">
        <label for="dp">Upload Photo (DP):</label><br>
        <input type="file" id="dp" name="dp"><br><br>

        <label for="fullname">Full Name:</label><br>
        <input type="text" id="fullname" name="fullname" required><br><br>

        <label for="career_objective">Career Objective:</label><br>
        <textarea id="career_objective" name="career_objective" rows="4" cols="50" required></textarea><br><br>

        <label for="contact_number">Contact Number:</label><br>
        <input type="text" id="contact_number" name="contact_number" required><br><br>

        <label for="experience_years">Experience in Years:</label><br>
        <input type="number" id="experience_years" name="experience_years" required><br><br>

        <label for="resume_path">Upload Resume:</label><br>
        <input type="file" id="resume_path" name="resume_path" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
