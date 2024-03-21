<?php
class UserController
{
    private $userModel;
    private $JobApplicationModel;
    private $JobModel;

    public function __construct($userModel, $JobApplicationModel, $JobModel)
    {
        $this->userModel = $userModel;
        $this->JobApplicationModel = $JobApplicationModel;
        $this->JobModel = $JobModel;
    }

    public function registerUser($username, $email, $password,$role)
    {
        // Example: Register a new user
        $token = $this->generateUserToken(); // Generate a user token
        $user = $this->userModel->registerUser($username, $email, $password,$role);
        
        // Start a new session (if not already started)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Set session variables
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user;
        $_SESSION['role'] = $role;
        // Redirect the user to the index page
        header("Location: index.php");
        exit();
    }

    public function loginUser($email, $password)
    {
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
            $_SESSION['role'] = $user['role'];

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

    public function completeProfile($userId, $dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath)
    {
        try {

            $job = $this->JobApplicationModel->insertOrUpdateJobApplication($userId, $dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath);

            if ($job) {
                // Start a new session (if not already started)
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                header("Location: index.php");
                exit();
            }
        } catch (Exception $e) {
            // Handle the exception
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function getData($id)
    {
        if ($id) {
            $data = $this->JobApplicationModel->getJobApplicationById($id);
        }
        if (!empty ($data)) {
            // Start a new session (if not already started)
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            return $data;
        }
    }
    private function generateUserToken()
    {
        // Generate a unique user token (you can use any method suitable for your application)
        return md5(uniqid(rand(), true));
    }
    public function createJobPost($employerId, $thumbnail, $salary, $position, $description, $numberOfPositions)
    {
        $job = $this->JobModel->postJob($employerId, $thumbnail, $salary, $position, $description, $numberOfPositions);
        if ($job) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            echo 'job created';
        }
    }
    public function updateJobPost($jobId, $employerId, $thumbnail, $salary, $position, $description, $numberOfPositions)
    {
        $job = $this->JobModel->updateJob($jobId, $employerId, $thumbnail, $salary, $position, $description, $numberOfPositions);

        if ($job) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            echo 'job updated';
        }
    }
    public function GetJobs($employerId)
    {
        try {
            //code...
            return $this->JobModel->getJobByEmployerAndPosition($employerId);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function GetJobId($employerId)
    {
        try {
            //code...
            return $this->JobModel->getJobById($employerId);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function GetJobAll()
    {
        try {
            //code...
            return $this->JobModel->getAllJobs();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function applyForJob($jobId, $userId, $content)
    {
        $data = $this->JobModel->applyForJob($jobId, $userId, $content);
        if ($data) {
            echo '<script>alert("Job Applied!")</script>';
            exit();
        }
        echo '<script>alert("Job Apply Failed!")</script>';

    }
    public function selectRequestedJob($jobId, $userId)
    {
        return $this->JobModel->selectApply($jobId, $userId);
    }
    public function baseUrl()
    {
        $baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';
        return $baseURL;
    }
    // Add more methods for other user-related actions
}


?>