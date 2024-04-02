<?php

$isLoggedIn = AuthService::isLoggedIn();
// If the user is not logged in, redirect them to the login page

if (!$isLoggedIn || $_SESSION['role'] != 'user') {
    header("Location:?action=index");
    exit();
}

// Retrieve user data from session
$userData = $userController->getData($_SESSION['user_id']);
$fullname = $careerObjective = $contactNumber = $experienceYears = "";
if($userData){
// Extract user data
$fullname = $userData['full_name'];
$careerObjective = $userData['career_objective'];
$contactNumber = $userData['contact_number'];
$experienceYears = $userData['experience_years'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h2 {
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input[type="file"] {
            margin-top: 5px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
        
    .breadcrumb a {
        text-decoration: none;
        color: #9fd3c7;
    }

    </style>
</head>

<body>
    <div class="container">
    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?action=index">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Job Requests</li>
        </ol>
        <form action="?action=submit_application" method="POST" enctype="multipart/form-data">
            <?php if (isset ($_SESSION['user_id'])) { ?>
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <?php } ?>
            <div class="form-group">
                <label for="dp">Upload Photo (DP):</label>
                <input type="file" id="dp" name="dp">
            </div>

            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name"
                    value="<?php echo htmlspecialchars($fullname); ?>" required>
            </div>

            <div class="form-group">
                <label for="career_objective">Career Objective:</label>
                <textarea id="career_objective" name="career_objective" rows="4"
                    required><?php echo htmlspecialchars($careerObjective); ?></textarea>
            </div>

            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number"
                    value="<?php echo htmlspecialchars($contactNumber); ?>" required>
            </div>

            <div class="form-group">
                <label for="experience_years">Experience in Years:</label>
                <input type="number" id="experience_years" name="experience_years"
                    value="<?php echo htmlspecialchars($experienceYears); ?>" required>
            </div>

            <div class="form-group">
                <label for="resume_path">Upload Resume:</label>
                <input type="file" id="resume_path" name="resume_path">
            </div>

            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</body>

</html>
