<?php



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
     .container {
            margin: auto;
            /* padding-top: 50px; */
            background: #142d4c; 
            /* margin-top: 50px; */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 8px;
            font-family: sans-serif;
            color: #ececec;

    box-shadow: 13px 13px 0px -2px #ccd1dddd;
            padding: 2rem;
        }
</style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Job Application Form</h2>
        <form action="?action=submit_application" method="POST" enctype="multipart/form-data">
            <?php if (isset ($_SESSION['user_id'])) { ?>
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <?php } ?>
            <div class="form-group">
                <label for="dp">Upload Photo (DP):</label>
                <input type="file" class="form-control-file" id="dp" name="dp">
            </div>

            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" class="form-control" id="full_name" name="full_name"
                    value="<?php echo htmlspecialchars($fullname); ?>" required>
            </div>

            <div class="form-group">
                <label for="career_objective">Career Objective:</label>
                <textarea class="form-control" id="career_objective" name="career_objective" rows="4"
                    required><?php echo htmlspecialchars($careerObjective); ?></textarea>
            </div>

            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number"
                    value="<?php echo htmlspecialchars($contactNumber); ?>" required>
            </div>

            <div class="form-group">
                <label for="experience_years">Experience in Years:</label>
                <input type="number" class="form-control" id="experience_years" name="experience_years"
                    value="<?php echo htmlspecialchars($experienceYears); ?>" required>
            </div>

            <div class="form-group">
                <label for="resume_path">Upload Resume:</label>
                <input type="file" class="form-control-file" id="resume_path" name="resume_path">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>