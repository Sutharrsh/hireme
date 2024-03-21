<?php

$jobApplication = $userController->getData($_SESSION['user_id']);


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
    .container{
        background: #ececec; 
    }
</style>
</head>

<body>
<?php if($jobApplication) : ?>
    <div class="container">
        <h2 class="text-center mt-5 mb-4">Job Applications</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?php echo $jobApplication['dp_path']; ?>" class="img-fluid" alt="DP">
                            </div>
                            <div class="col-md-8">
                                <p><strong>ID:</strong>
                                    <?php echo $jobApplication['id']; ?>
                                </p>
                                <p><strong>Full Name:</strong>
                                    <?php echo $jobApplication['full_name']; ?>
                                </p>
                                <p><strong>Career Objective:</strong>
                                    <?php echo $jobApplication['career_objective']; ?>
                                </p>
                                <p><strong>Contact Number:</strong>
                                    <?php echo $jobApplication['contact_number']; ?>
                                </p>
                                <p><strong>Experience Years:</strong>
                                    <?php echo $jobApplication['experience_years']; ?>
                                </p>
                                <p><strong>Resume:</strong> <a href="<?php echo $jobApplication['resume_path']; ?>"
                                        target="_blank">View Resume</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php else: ?>
    <div class="alert alert-primary" role="alert">
  Please Complete Your Profile!
</div>
<?php endif; ?>
</html>