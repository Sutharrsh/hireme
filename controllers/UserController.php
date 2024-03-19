<?php
class UserController {
    private $userModel;
    private $JobApplicationModel;

    public function __construct($userModel,$JobApplicationModel) {
        $this->userModel = $userModel;
        $this->JobApplicationModel = $JobApplicationModel;
    }

    public function registerUser($username, $email, $password) {
        // Example: Register a new user
        $token = $this->generateUserToken(); // Generate a user token
        $userId = $this->userModel->registerUser($username, $email, $password);

        // Start a new session (if not already started)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Set session variables
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['userId'] = $$userId;

        // Redirect the user to the index page
        header("Location: index.php");
        exit();
    }

    public function loginUser($email, $password) {
        // Authenticate user
        $user = $this->userModel->loginUser($email, $password);
      
        if ($user) {
            // Start a new session (if not already started)
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Set session variables
            $_SESSION['user_logged_in'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];

            // Redirect the user to the index page or any other desired page
            header("Location: index.php");
            exit();
        } else {
            // echo $user;die;
            // Redirect the user to the login page with an error message
            header("Location: login.php?error=invalid_credentials");
            exit();
        }
    }

    public function completeProfile($dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath){
        $job = $this->JobApplicationModel->insertJobApplication($dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath);
        if ($job) {
            // Start a new session (if not already started)
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            header("Location: index.php");
            exit();
        }

    }

    public function getData(){
       $data = $this->JobApplicationModel->getAllJobApplicationsWithBaseURL();
       if (!empty($data)) {
        // Start a new session (if not already started)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $data;
    }
    }
    private function generateUserToken() {
        // Generate a unique user token (you can use any method suitable for your application)
        return md5(uniqid(rand(), true));
    }
    
    // Add more methods for other user-related actions
}


?>