<?php
if(isset($_GET['id'])){
    $jobPost = $userController->GetJobId($_GET['id']);
}
$jobPost['id'] = $jobPost['thumbnail'] = $jobPost['salary'] = $jobPost['position'] = $jobPost['description'] = $jobPost['number_of_positions'] = NULL;


?>

<div class="container mt-5">
    <h2 class="mb-4">Edit Job Post</h2>
    <form action="index.php?action=job-post-processing" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="job_id" value="<?php echo $jobPost['id']; ?>">
        <div class="form-group">
            <label for="thumbnail">Thumbnail:</label>
            <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
            <img src="<?php echo $userController->baseUrl() . $jobPost['thumbnail']; ?>" alt="Thumbnail" class="mt-2">
        </div>
        <div class="form-group">
            <label for="salary">Salary:</label>
            <input type="number" class="form-control" id="salary" name="salary" placeholder="Salary"
                value="<?php echo $jobPost['salary']; ?>">
        </div>
        <div class="form-group">
            <label for="position">Position:</label>
            <input type="text" class="form-control" id="position" name="position" placeholder="Position" required
                value="<?php echo $jobPost['position']; ?>">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Job Description"
                required><?php echo $jobPost['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="numberOfPositions">Number of Positions:</label>
            <input type="number" class="form-control" id="numberOfPositions" name="numberOfPositions"
                placeholder="Number of Positions" required value="<?php echo $jobPost['number_of_positions']; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Job</button>
    </form>
</div>