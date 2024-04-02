<?php
$isLoggedIn = AuthService::isLoggedIn();
// If the user is not logged in or not a user, redirect them to the index page
if (!$isLoggedIn || $_SESSION['role'] != 'user') {
    header("Location:?action=index");
    exit();
}
$data = $userController->appliedJobs($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Status</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .breadcrumb a {
            text-decoration: none;
            color: #9fd3c7;
        }
        .status-rejected {
            color: #dc3545;
        }
        .status-accepted {
            color: #28a745;
        }
        .status-pending {
            color: #ffc107;
        }
        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
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
                                        $statusClass = 'status-rejected';
                                        break;
                                    case 'accepted':
                                        $statusClass = 'status-accepted';
                                        break;
                                    default:
                                        $statusClass = 'status-pending';
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
</body>
</html>
