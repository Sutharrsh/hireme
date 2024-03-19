<?php


$action = isset($_GET['action']) ? $_GET['action'] : 'index';
function uploadFile($file, $uploadDir)
{
    // Create the directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // 0777 allows read, write, and execute permissions for everyone
    }

    $targetFile = $uploadDir . basename($file['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check file size (limit it to 5MB)
    if ($file['size'] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "pdf") {
        echo "Sorry, only JPG, JPEG, PNG, GIF & PDF files are allowed.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        // If file exists, replace it
        unlink($targetFile); // Remove the existing file
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        return false;
    } else {
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $targetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
}


switch ($action) {
    case 'index':
        // Display the homepage or default view
        include 'views/home_view.php';
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
                include 'views/profile.php';
                break;
    case 'logout':
            // Example: User registration form
            include 'views/logout.php';
            break;
            case 'profile-view':
                // Example: User registration form
                include 'views/ProfileView.php';
                break;
    case 'process_registration':
        // Example: Process user registration form
        $userController->registerUser($_POST['username'], $_POST['email'], $_POST['password']);
        break;
    case 'login_process':
   
            // Example: Process user registration form
            $userController->loginUser($_POST['email'], $_POST['password']);
            break;

    case 'submit_application':
        $uploadDir = "uploads/";

        // Upload DP
        $dpPath = uploadFile($_FILES["dp"], $uploadDir);
        if (!$dpPath) {
            die();
        }

        // Upload Resume
        $resumePath = uploadFile($_FILES["resume_path"], $uploadDir);
        if (!$resumePath) {
            die();
        }
                $userController->completeProfile($dpPath,$_POST['fullname'], $_POST['career_objective'],$_POST['contact_number'],$_POST['experience_years'],$resumePath);
    // Add more cases for other actions
    default:
        echo "Invalid action";


// Function to handle file upload

}

?>