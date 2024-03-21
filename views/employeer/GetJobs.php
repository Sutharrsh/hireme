<?php
$jobPosts = $userController->GetJobs($_SESSION['user_id']);
?>
<?php if($jobPosts): ?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Job Posts</h2>
    <div class="row">
        <?php foreach ($jobPosts as $jobPost): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo $userController->baseUrl() . $jobPost['thumbnail']; ?>" class="card-img-top"
                        alt="Job Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $jobPost['position']; ?>
                        </h5>
                        <p class="card-text"><strong>Salary:</strong>
                            <?php echo $jobPost['salary']; ?>
                        </p>
                        <p class="card-text"><strong>Description:</strong>
                            <?php echo $jobPost['description']; ?>
                        </p>
                        <hr>
                        <p class="card-text"><strong>Published Date:</strong>
                            <?php echo $jobPost['post_date']; ?>
                        </p>
                        <p class="card-text"><strong>Opening:</strong>
                            <?php echo $jobPost['number_of_positions']; ?>
                        </p>
                        <p class="card-text"><strong>Status:</strong>
                            <?php echo $jobPost['status']; ?>
                        </p>
                        <!-- Add buttons -->
                        <div class="text-center">
                            <a href="?action=add-job&id=<?php echo $jobPost['id'] ?>"
                                class="btn btn-primary btn-sm mb-2">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm mb-2">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php else: ?>
    <div class="alert alert-primary" role="alert">
  No Job Available!
</div>
    <?php endif; ?>