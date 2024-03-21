<?php
$isLoggedIn = AuthService::isLoggedIn();
// If the user is not logged in, redirect them to the login page

if (!$isLoggedIn || $_SESSION['role'] != 'employer') {
    header("Location:?action=index");
    exit();
}
$rowvalues = $userController->AllEmployeeDetails();
?>
<style>
    .breadcrumb a {
        text-decoration: none;
        color: #9fd3c7;
    }
</style>
<?php if (!empty($rowvalues)) : ?>
<div class="container mt-5">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?action=index" style="">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Job Requests</li>
    </ol>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Profile Picture</th>
                    <th>Full Name</th>
                    <th>Content</th>
                    <th>Career Objective</th>
                    <th>Contact Number</th>
                    <th>Experience Years</th>
                    <th>Resume</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Applied Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rowvalues as $key => $row) {
                    echo "<tr>";
                    echo "<td><img src=" . $userController->baseUrl() . $row['dp_path'] . " alt='Profile Picture' class='img-thumbnail' style='width: 80px;'></td>";
                    echo "<td>{$row['full_name']}</td>";
                    echo "<td>{$row['content']}</td>";
                    echo "<td>{$row['career_objective']}</td>";
                    echo "<td>{$row['contact_number']}</td>";
                    echo "<td>{$row['experience_years']}</td>";
                    echo "<td><a href=" . $userController->baseUrl() . $row['resume_path'] . " target='_blank' class='btn btn-primary btn-sm'>View Resume</a></td>";
                    echo "<td>{$row['position']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "<td>{$row['created_at']}</td>";
                    echo '<td>   <div class="text-center">
                    <a href="?action=employees-detail&job_id='.$row['job_id'].'&user_id='.$row['user_id'].'"
                        class="btn btn-primary btn-sm mb-2">Approve</a>
                </div><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                    Reject
                </button>';
                    echo "</tr>";
                }
                ?>
                <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Reject This Application!</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form inside modal -->
                                <form action="?action=reject" method="post">
                                    <input type="hidden" name="job_id" value="<?php echo $row['job_id']; ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                    <div class="mb-3">
                                        <label for="content" class="content">Description</label>
                                        <textarea type="text" class="form-control" id="reason" name="reason"
                                            placeholder="Enter Reason"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>