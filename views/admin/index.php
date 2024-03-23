<?php
// Get data for all employee details
$rowvalues = $userController->AllEmployeeDetails();
$employersCount = $employeesCount = $totalJobsCount = 10;
// Get counts for employers, employees, and total jobs
// $employersCount = $userController->getEmployersCount();

// $employeesCount = $userController->getEmployeesCount();
// $totalJobsCount = $userController->getTotalJobsCount();
?>
<div class="container mt-5">
    <div class="row">
        <!-- Cards for Employer, Employee, and Total Jobs Counts -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Employers</h5>
                    <p class="card-text"><?php echo $employersCount; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Employees</h5>
                    <p class="card-text"><?php echo $employeesCount; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Jobs</h5>
                    <p class="card-text"><?php echo $totalJobsCount; ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Employee Details Cards -->
    <div class="row">
        <?php foreach ($rowvalues as $employee): ?>
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <img src="<?php echo $employee['dp_path']; ?>" class="card-img-top" alt="Profile Picture">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $employee['full_name']; ?></h5>
                        <p class="card-text"><?php echo $employee['career_objective']; ?></p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Contact Number:</strong> <?php echo $employee['contact_number']; ?></li>
                            <li class="list-group-item"><strong>Experience Years:</strong> <?php echo $employee['experience_years']; ?></li>
                            <li class="list-group-item"><strong>Position:</strong> <?php echo $employee['position']; ?></li>
                            <li class="list-group-item"><strong>Status:</strong> <?php echo $employee['status']; ?></li>
                            <li class="list-group-item"><strong>Applied At:</strong> <?php echo $employee['created_at']; ?></li>
                        </ul>
                        <a href="<?php echo $employee['resume_path']; ?>" class="btn btn-primary mt-3">Download Resume</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
