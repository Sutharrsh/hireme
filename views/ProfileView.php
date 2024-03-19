<?php

$jobApplications = $userController->getData();


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
    <title>Job Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        img {
            max-width: 100px;
            height: auto;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Job Applications</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>DP</th>
            <th>Full Name</th>
            <th>Career Objective</th>
            <th>Contact Number</th>
            <th>Experience Years</th>
            <th>Resume</th>
        </tr>
        <?php foreach ($jobApplications as $jobApplication): ?>
        <tr>
            <td><?php echo $jobApplication['id']; ?></td>
            <td><img src="<?php echo $jobApplication['dp_path']; ?>" alt="DP"></td>
            <td><?php echo $jobApplication['full_name']; ?></td>
            <td><?php echo $jobApplication['career_objective']; ?></td>
            <td><?php echo $jobApplication['contact_number']; ?></td>
            <td><?php echo $jobApplication['experience_years']; ?></td>
            <td><a href="<?php echo $jobApplication['resume_path']; ?>" target="_blank">View Resume</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
