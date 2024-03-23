<?php


$action = isset ($_GET['action']) ? $_GET['action'] : 'index';
function uploadFile($file, $uploadDir)
{
    try {
        // Create the directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); // 0777 allows read, write, and execute permissions for everyone
        }

        $targetFile = $uploadDir . basename($file['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check file size (limit it to 5MB)
        if ($file['size'] > 5000000) {
            throw new Exception("Sorry, your file is too large.");
        }

        // Allow only certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $imageFileType != "pdf"
        ) {
            throw new Exception("Sorry, only JPG, JPEG, PNG, GIF & PDF files are allowed.");
        }

        // If file already exists, unlink it
        if (file_exists($targetFile)) {
            unlink($targetFile); // Remove the existing file
        }

        // Upload the new file
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $targetFile;
        } else {
            throw new Exception("Sorry, there was an error uploading your file.");
        }
    } catch (Exception $e) {
        // Handle the exception
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}




switch ($action) {
    case 'index':
        // Display the homepage or default view
        include 'views/home_view.php';
        break;
    case 'admin-lock':
            if(isset($_POST['email']) && $_POST['password'] == 'admin') {
                $_SESSION['role'] = $_POST['email'];
            include 'views/admin/index.php';
            }
            break;
    case 'admin':
                include 'views/admin.php';
                break;
    case 'register':
        // Example: User registration form
        include 'views/register_view.php';
        break;
    case 'login':
        // Example: User registration form
        include 'views/login.php';
        break;
    case 'profile':
        // Example: User registration form
        include 'views/Profile.php';
        break;
    case 'add-job':
        // Example: User registration form
        include 'views/employeer/AddJobs.php';
        break;
    case 'logout':
        // Example: User registration form
        include 'views/logout.php';
        break;
    case 'get-job-status':
        // Example: User registration form
        include 'views/GetApplied.php';
        break;
    case 'reject':
        // Example: User registration form
        if (isset ($_POST['job_id']) && isset ($_POST['user_id']) && isset ($_POST['reason'])) {
            $userController->RejectAplication($_POST['job_id'], $_POST['user_id'], $_POST['reason']);
        }
        break;
    case 'profile-view':
        // Example: User registration form
        include 'views/ProfileView.php';
        break;
    case 'reset-password':
        if (isset ($_POST['email'])) {
            $userController->ResetFunctions($_POST['email']);
        }
        break;
    case 'employees-detail':
        // Example: User registration form
        if (isset ($_GET['job_id']) && isset ($_GET['user_id'])) {
            $userController->acceptAplication($_GET['job_id'], $_GET['user_id']);
        }
        include 'views/employeer/Showdata.php';
        break;
    case 'job-view':
        // Example: User registration form
        include 'views/employeer/GetJobs.php';
        break;
    case 'process_registration':
        // Example: Process user registration form
        $userController->registerUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['role']);
        break;
    case 'login_process':

        // Example: Process user registration form
        $userController->loginUser($_POST['email'], $_POST['password']);
        break;
    case 'forgot':
        include 'views/forgot.php';
        break;
    case 'forgot-password':
        // Example: Process user registration form
      
        $userController->VerifyPassword($_POST['token'], $_POST['password']);
        break;
    case 'submit_application':
        $uploadDir = "uploads/";
        $resumePath = $dpPath = null;
        // Upload DP
        // echo "/n\$_FILES[\"dp\"]-ajay 💀<pre>"; print_r($_FILES["dp"]); echo "\n</pre>";exit;
        if (isset ($_FILES["dp"]) && $_FILES["dp"]["error"] === UPLOAD_ERR_OK) {
            $dpPath = uploadFile($_FILES["dp"], $uploadDir);
            if (!$dpPath) {
                die(); // Handle the error condition as needed
            }
        }
        // echo "/n\$dpPath-ajay 💀<pre>"; print_r($dpPath); echo "\n</pre>";exit;
        if (isset ($_FILES["resume_path"]) && $_FILES["resume_path"]["error"] === UPLOAD_ERR_OK) {
            // Upload Resume
            $resumePath = uploadFile($_FILES["resume_path"], $uploadDir);
            if (!$resumePath) {
                die();
            }
        }
        $userController->completeProfile($_SESSION['user_id'], $dpPath, $_POST['full_name'], $_POST['career_objective'], $_POST['contact_number'], $_POST['experience_years'], $resumePath);
        break;
    // Add more cases for other actions
    case 'job-post-processing':
        $uploadDir = "uploads/job-thumbnails/";
        $dpPath = null;
        // Upload DP
        // echo "/n\$_FILES[\"dp\"]-ajay 💀<pre>"; print_r($_FILES["dp"]); echo "\n</pre>";exit;
        if (isset ($_FILES["thumbnail"]) && $_FILES["thumbnail"]["error"] === UPLOAD_ERR_OK) {
            $dpPath = uploadFile($_FILES["thumbnail"], $uploadDir);
            if (!$dpPath) {
                die(); // Handle the error condition as needed
            }
        }
        // echo "/n\$dpPath-ajay 💀<pre>"; print_r($dpPath); echo "\n</pre>";exit;
        if (isset ($_POST['job_id']) && $_POST['job_id'] != NULL) {
            $userController->updateJobPost($_POST['job_id'], $_SESSION['user_id'], $dpPath, $_POST['salary'], $_POST['position'], $_POST['description'], $_POST['numberOfPositions']);
            break;
        }
        $userController->createJobPost($_SESSION['user_id'], $dpPath, $_POST['salary'], $_POST['position'], $_POST['description'], $_POST['numberOfPositions']);
        break;
    // Add more cases for other actions
    case 'apply-job':
        $userController->applyForJob($_POST['job_id'], $_SESSION['user_id'], $_POST['content']);

    default:
        echo "Invalid action";


    // Function to handle file upload

}

?>