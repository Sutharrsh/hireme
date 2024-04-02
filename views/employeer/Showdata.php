<?php
$isLoggedIn = AuthService::isLoggedIn();
// If the user is not logged in, redirect them to the login page

if (!$isLoggedIn || $_SESSION['role'] != 'employer') {
    header("Location:?action=index");
    exit();
}
$rowvalues = $userController->AllEmployeeDetails();
// echo json_encode($rowvalues);do;
?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    .breadcrumb a {
        text-decoration: none;
        color: #9fd3c7;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        background-color: #fff;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .table thead th {
        background-color: #343a40;
        color: #fff;
        border-color: #454d55;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table-hover tbody tr:hover {
        background-color: #f2f2f2;
    }

    .img-thumbnail {
        border: 0;
        border-radius: 0.25rem;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 500;
    }

    .form-control {
        border-radius: 0.25rem;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .modal-content {
        border-radius: 0.25rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>

<?php if (!empty($rowvalues)) : ?>
    <div class="container mt-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?action=index">Home</a></li>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rowvalues as $key => $row) : ?>
                        <tr>
                            <td><img src="<?php echo $userController->baseUrl() . $row['dp_path']; ?>" alt="Profile Picture" class="img-thumbnail" style="width: 80px;"></td>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['content']; ?></td>
                            <td><?php echo $row['career_objective']; ?></td>
                            <td><?php echo $row['contact_number']; ?></td>
                            <td><?php echo $row['experience_years']; ?></td>
                            <td><a href="<?php echo $userController->baseUrl() . $row['resume_path']; ?>" target="_blank" class="btn btn-primary btn-sm">View Resume</a></td>
                            <td><?php echo $row['position']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="?action=employees-detail&job_id=<?php echo $row['job_id']; ?>&user_id=<?php echo $row['user_id']; ?>" class="btn btn-primary btn-sm mr-2">Approve</a>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal<?php echo $row['user_id']; ?>">Reject</button>
                                </div>
                            </td>
                        </tr>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal<?php echo $row['user_id']; ?>" tabindex="-1" aria-labelledby="rejectModalLabel<?php echo $row['user_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectModalLabel<?php echo $row['user_id']; ?>">Reject Application</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="?action=reject" method="post">
                                            <input type="hidden" name="job_id" value="<?php echo $row['job_id']; ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                            <div class="mb-3">
                                                <label for="reason" class="form-label">Reason for Rejection</label>
                                                <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Enter reason for rejection"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else : ?>
    <div class="container mt-5">
        <div class="alert alert-info" role="alert">
            No job requests found.
        </div>
    </div>
<?php endif; ?>
