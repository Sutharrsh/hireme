<?php

$isLoggedIn = AuthService::isLoggedIn();
// If the user is not logged in or not an employer, redirect them to the index page
if (!$isLoggedIn || $_SESSION['role'] != 'employer') {
    header("Location: ?action=index");
    exit();
}

$jobPost = [
    'id' => null,
    'thumbnail' => null,
    'salary' => null,
    'position' => null,
    'description' => null,
    'number_of_positions' => null
];

if (isset($_GET['id'])) {
    $jobPost = $userController->GetJobId($_GET['id']);
}

?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
    }

    input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        background-color: #f9f9f9;
        border-radius: 5px;
    }

    img {
        height: 150px;
        width: auto;
        border-radius: 5px;
        margin-top: 10px;
    }

    textarea {
        resize: vertical;
    }

    .btn {
        background-color: #0077b5 !important;
        color: #fff !important;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #0056b3;
    }
    
    .breadcrumb a {
        text-decoration: none;
        color: #9fd3c7;
    }

</style>

<div class="container">
<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?action=index">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Job Requests</li>
        </ol>
    <h2 class="mb-4">Edit Job Post</h2>
    <form action="index.php?action=job-post-processing" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="job_id" value="<?php echo $jobPost['id']; ?>">
        <div class="form-group">
            <label for="thumbnail">Thumbnail:</label><br>
            <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
            <label for="thumbnail" class="custom-file-upload">Upload Thumbnail</label>
            <?php if ($jobPost['thumbnail']): ?>
                <img src="<?php echo $userController->baseUrl() . $jobPost['thumbnail']; ?>" alt="Thumbnail">
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="salary">Salary:</label>
            <input type="number" class="form-control" id="salary" name="salary" placeholder="Salary" value="<?php echo $jobPost['salary']; ?>">
        </div>
        <div class="form-group">
            <label for="position">Position:</label>
            <input type="text" class="form-control" id="position" name="position" placeholder="Position" required value="<?php echo $jobPost['position']; ?>">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Job Description" required><?php echo $jobPost['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="numberOfPositions">Number of Positions:</label>
            <input type="number" class="form-control" id="numberOfPositions" name="numberOfPositions" placeholder="Number of Positions" required value="<?php echo $jobPost['number_of_positions']; ?>">
        </div>
        <button type="submit" class="btn mt-2">Update Job</button>
    </form>
</div>
