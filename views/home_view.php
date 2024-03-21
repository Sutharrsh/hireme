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
?>

<?php if (!empty($jobPosts)): ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Job Posts</h2>
        <div class="row">
            <?php foreach ($jobPosts as $jobPost): ?>
                <div class="col-md-4 mb-4">
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
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" onclick="updateJobId(<?php echo $jobPost['id']; ?>)">
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
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Why you need this job?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form inside modal -->
                    <form action="?action=apply-job" method="post">
                        <input type="hidden" id="job_id" name="job_id" value="">
                        <div class="mb-3">
                            <label for="content" class="content">Description</label>
                            <textarea type="text" class="form-control" id="content" name="content" placeholder="Enter your name"></textarea>
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
<?php else: ?>
    <div class="alert alert-primary" role="alert">
        No Job Available!
    </div>
<?php endif; ?>