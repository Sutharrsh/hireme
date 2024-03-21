<?php

// Include the Auth class definition
require_once 'services/AuthService.php'; // Assuming your Auth class is defined in Auth.php

// Check if the user is logged in
$isLoggedIn = AuthService::isLoggedIn();

?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="?action=index">Decode Forest</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=add-job">Add Job Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=job-view">View Job</a>
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
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>