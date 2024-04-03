<?php
$isLoggedIn = AuthService::isLoggedIn();
// If the user is not logged in, redirect them to the login page

if (!$isLoggedIn || $_SESSION['role'] != 'employer') {
    header("Location:?action=index");
    exit();
}
$jobPosts = $userController->GetJobs($_SESSION['user_id']);
?>
    <style>
        /* Custom styles */
        .job-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .job-card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .job-thumbnail {
            height: 200px;
            object-fit: cover;
        }

        .job-title {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .job-details {
            font-size: 0.9rem;
            color: #666;
        }

        .btn-edit {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-edit:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-delete {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
<div class="container mt-5">
    <h2 class="text-center mb-4">Job Posts</h2>
    <div class="row">
    <?php if($jobPosts) : ?>

        <?php foreach ($jobPosts as $jobPost): ?>
            <div class="col-md-4 mb-4">
                <div class="card job-card h-100">
                    <img src="<?php echo $userController->baseUrl() . $jobPost['thumbnail']; ?>" class="card-img-top job-thumbnail"
                         alt="Job Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title job-title">
                            <?php echo $jobPost['position']; ?>
                        </h5>
                        <p class="card-text job-details"><strong>Salary:</strong>
                            <?php echo $jobPost['salary']; ?>
                        </p>
                        <p class="card-text job-details"><strong>Description:</strong>
                            <?php echo $jobPost['description']; ?>
                        </p>
                        <hr>
                        <p class="card-text job-details"><strong>Published Date:</strong>
                            <?php echo $jobPost['post_date']; ?>
                        </p>
                        <p class="card-text job-details"><strong>Opening:</strong>
                            <?php echo $jobPost['number_of_positions']; ?>
                        </p>
                        <p class="card-text job-details"><strong>Status:</strong>
                            <?php echo $jobPost['status']; ?>
                        </p>
                        <!-- Add buttons -->
                        <div class="text-center">
                            <a href="?action=add-job&id=<?php echo $jobPost['id'] ?>"
                               class="btn btn-primary btn-sm mb-2 btn-edit">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm mb-2 btn-delete">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
                <div class="alert alert-danger" role="alert">
                                            No data Found!
                                        </div>
            <?php endif; ?>
    </div>
</div>