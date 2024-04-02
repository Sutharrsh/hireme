<?php

// Include the Auth class definition
require_once 'services/AuthService.php'; // Assuming your Auth class is defined in Auth.php

// Check if the user is logged in
$isLoggedIn = AuthService::isLoggedIn();
// echo $_SESSION['role'];die;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobify</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        nav {
            background: #0077b5;
            padding: 1rem 2rem;
            border-bottom: 1px solid #9fd3c7;
            border-radius: 0;
        }

        .navbar-brand,
        .nav-link {
            color: #fff;
            font-weight: bold;
            font-size: 18px;
            text-decoration: none;
        }

        .navbar-brand:hover,
        .nav-link:hover {
            color: #fff;
            opacity: 0.8;
        }

        .navbar-toggler {
            border: none;
            color: #fff;
        }

        .navbar-toggler:hover {
            color: #9fd3c7;
        }

        .navbar-nav {
            margin-left: auto;
        }

        .nav-item {
            margin-left: 20px;
        }

        .search-form {
            display: flex;
            align-items: center;
        }

        .search-form input[type="search"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
            width: 200px;
        }

        .search-form button {
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            background-color: #0056b3;
            color: #fff;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #004080;
        }
    </style>
</head>
<body>
    <?php if($isLoggedIn) : ?>
    <nav class="navbar navbar-expand-lg" id='nav'>
        <div class="container-fluid">
            <a class="navbar-brand" href="?action=index">Jobify</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <?php if (!$isLoggedIn) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=register">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=login">Login</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=logout">Logout</a>
                        </li>
                        <?php if ($_SESSION['role'] == 'user') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="?action=profile">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?action=profile-view">Profile View</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?action=get-job-status">Job Status</a>
                            </li>
                        <?php } else if (isset($_SESSION['role']) && $_SESSION['role'] == 'employer') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="?action=add-job">Add Job Post</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?action=job-view">View Job</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?action=employees-detail">Job Request</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link">
                                <?php $data = $_SESSION['role'] != 'admin' ? $_SESSION['username'] : $_SESSION['role'];
                                echo $data; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
