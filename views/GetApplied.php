<?php
$isLoggedIn = AuthService::isLoggedIn();
// If the user is not logged in, redirect them to the login page

if (!$isLoggedIn || $_SESSION['role'] != 'user') {
    header("Location:?action=index");
    exit();
}
$data = $userController->appliedJobs($_SESSION['user_id']);
?>
<style>
      .breadcrumb a {
        text-decoration: none;
        color: #9fd3c7;
    }
</style>
<div class="container mt-5">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?action=index">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Job Status</li>
    </ol>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['position']; ?></td>
                        <td>
                            <?php
                            $statusClass = '';
                            switch ($row['status']) {
                                case 'rejected':
                                    $statusClass = 'text-danger';
                                    break;
                                case 'accepted':
                                    $statusClass = 'text-success';
                                    break;
                                default:
                                    $statusClass = 'text-warning';
                                    break;
                            }
                            ?>
                            <span class="<?php echo $statusClass; ?>"><?php echo ucfirst($row['status']); ?></span>
                        </td>
                        <td><?php echo $row['reason']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
