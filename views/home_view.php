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

$jobPosts = $userController->GetJobs($_SESSION['user_id']);
if ($_SESSION['role'] == 'user') {
    $jobPosts = $userController->GetJobAll();
}
if($_SESSION['role'] == 'user' && isset($_GET['search'])){
    $jobPosts = $userController->getSearch($_GET['search']);
    // echo 'jobs: ' . print_r($jobPosts).die;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .row{
            flex-direction: column-reverse;
            justify-content: center;
    align-items: center;
        }
        .container {
            margin-top: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-img-top {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            object-fit: cover;
            height: 200px;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #0077b5; /* LinkedIn theme color */
        }

        .card-text {
            color: #555;
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #0077b5; /* LinkedIn theme color */
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #005682; /* Darker shade of LinkedIn theme color */
        }

        .btn-outline-secondary {
            background-color: transparent;
            border: 1px solid #0077b5; /* LinkedIn theme color */
            color: #0077b5; /* LinkedIn theme color */
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-outline-secondary:hover {
            background-color: #f0f0f0;
            color: #555;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .input-group {
            width: 100%;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        #button-addon2 {
            background-color: #0077b5 !important; /* LinkedIn theme color */
            border: none;
            color: #fff !important;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #button-addon2:hover {
            background-color: #005682; /* Darker shade of LinkedIn theme color */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <?php if($jobPosts) : ?>
            <?php foreach ($jobPosts as $jobPost): ?>
                <div class="col-md-8 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo $userController->baseUrl() . $jobPost['thumbnail']; ?>" class="card-img-top" alt="Job Thumbnail">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $jobPost['position']; ?>
                            </h5>
                            <p class="card-text"><strong>Salary:</strong> <?php echo $jobPost['salary']; ?></p>
                            <p class="card-text"><strong>Description:</strong> <?php echo $jobPost['description']; ?></p>
                            <hr>
                            <p class="card-text"><strong>Published Date:</strong> <?php echo $jobPost['post_date']; ?></p>
                            <p class="card-text"><strong>Opening:</strong> <?php echo $jobPost['number_of_positions']; ?></p>
                            <p class="card-text"><strong>Status:</strong> <?php echo $jobPost['status']; ?></p>
                            <!-- Add buttons -->
                            <?php if ($_SESSION['role'] == 'user'): ?>
                                <?php $jobPosts = $userController->selectRequestedJob($jobPost['id'], $_SESSION['user_id']); ?>
                                <?php if ($jobPosts && $jobPost['id'] == $jobPosts['job_id']): ?>
                                    <?php if ($jobPosts['status'] == 'pending'): ?>
                                        <div class="alert alert-primary" role="alert">
                                            Your Position Is Being Examined! Wishing you luck!
                                        </div>
                                    <?php elseif ($jobPosts['status'] == 'rejected'): ?>
                                        <div class="alert alert-danger" role="alert">
                                            We apologize that the employer rejected your application for the position. For additional details, check your mail!
                                        </div>
                                    <?php elseif ($jobPosts['status'] == 'accepted'): ?>
                                        <div class="alert alert-success" role="alert">
                                            Congratulations! The employer has mailed you information about your walk-in interview round.
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="updateJobId(<?php echo $jobPost['id']; ?>)">
                                        Quick Apply
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="text-center">
                                    <a href="?action=add-job&id=<?php echo $jobPost['id'] ?>" class="btn btn-primary btn-sm mb-2">Edit</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if ($_SESSION['role'] == 'user') : ?>
            <div class="col-md-8">
                <div class="search-bar">
                    <form action="?action=index" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search for jobs" aria-label="Search for jobs" aria-describedby="button-addon2" name="search" style="height:44px">
                            <button type="submit" id="button-addon2">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                                            No data Found!
                                        </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Why do you need this job?</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form inside modal -->
                    <form action="?action=apply-job" method="post">
                        <input type="hidden" id="job_id" name="job_id" value="">
                        <div class="mb-3">
                            <label for="content" class="content">Description</label>
                            <textarea type="text" class="form-control" id="content" name="content" placeholder="Enter your reason"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateJobId(jobId) {
            // Update the job_id value in the modal form
            document.getElementById('job_id').value = jobId;
        }
    </script>


</body>
</html>
