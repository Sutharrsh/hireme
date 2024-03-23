<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
    public function sendMail($email, $subject, $message)
    {
        try {
            //code...
            $mail = new PHPMailer();

            // Set up SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'help.jobify@gmail.com';
            $mail->Password = 'jqmgrdycsrjbfvaw';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Set up email content
            $mail->setFrom('support@jobify.co', $email);
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $message;

            // Send the email
            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            echo "/n\$th-ajay 💀<pre>";
            print_r($th);
            echo "\n</pre>";
            exit;
            //throw $th;
        }

    }
    public function registerUser($username, $email, $password, $role)
    {
        // Example: Register a new user
        $token = $this->generateUserToken(); // Generate a user token
        $user = $this->userModel->registerUser($username, $email, $password, $role);

        // Start a new session (if not already started)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Set session variables
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user;
        $_SESSION['role'] = $role;
        $subject = "Welcome to Jobify!";
        $message = '
        
        <body style="   font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;">
            <div class="container" style=" max-width: 600px;
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="logo" style="  text-align: center;
                margin-bottom: 30px;">
                    <img src="https://i0.wp.com/www.writefromscratch.com/wp-content/uploads/2018/12/demo-logo.png?fit=539%2C244&ssl=1&w=640" alt="Jobify Logo" style=" max-width: 120px;
                    height: auto;">
                </div>
                <h2 style=" color: #333333;
                margin-bottom: 20px;">Dear ' . $username . ',</h2>
                <p style="   color: #666666;
                margin-bottom: 15px;
                line-height: 1.6;">Welcome to Jobify! We"re thrilled to have you on board.</p>
                <p style="   color: #666666;
                margin-bottom: 15px;
                line-height: 1.6;">Thank you for registering with us. Your interest in joining our community means a lot to us.</p>
                <p style="   color: #666666;
                margin-bottom: 15px;
                line-height: 1.6;">At Jobify, we"re committed to helping you find meaningful opportunities that align with your goals and aspirations.</p>
                <p style="   color: #666666;
                margin-bottom: 15px;
                line-height: 1.6;">If you have any questions or need assistance, feel free to reach out to our support team. We"re here to help!</p>
                <div class="footer" style=" margin-top: 30px;
                text-align: center;
                color: #999999;
                font-size: 14px;">
                    <p>Best regards,</p>
                    <p>The Jobify Team</p>
                </div>
            </div>
        </body>
    
        
        
        ';

        $this->sendMail($email, $subject, $message);
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

            $data = $this->userModel->getUsers();
            foreach ($data as $key => $value) {
                if ($value['role'] == 'user') {
                    $subject = "New Job Position Available!";
                    $message = '<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
            <div class="container" style="max-width: 600px; margin: 20px auto; padding: 30px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="logo" style="text-align: center; margin-bottom: 30px;">
                    <img src="https://i0.wp.com/www.writefromscratch.com/wp-content/uploads/2018/12/demo-logo.png?fit=539%2C244&ssl=1&w=640" alt="Jobify Logo" style="max-width: 120px; height: auto;">
                </div>
                <h2 style="color: #333333; margin-bottom: 20px;">Dear ' . $value['username'] . '</h2>
                <p style="color: #666666; margin-bottom: 15px; line-height: 1.6;">Welcome to Jobify! We are thrilled to have you on board.</p>
                <p style="color: #666666; margin-bottom: 15px; line-height: 1.6;">Thank you for registering with us. Your interest in joining our community means a lot to us.</p>
                <p style="color: #666666; margin-bottom: 15px; line-height: 1.6;">We are excited to inform you about new job opportunities available in your area. Take a look at the latest openings:</p>
                <!-- Insert dynamic job listings here -->
                <ul style="color: #666666; margin-bottom: 15px; line-height: 1.6;">
                    <li>Job Title 1 - Company Name 1</li>
                    <li>Job Title 2 - Company Name 2</li>
                    <li>Job Title 3 - Company Name 3</li>
                </ul>
                <p style="color: #666666; margin-bottom: 15px; line-height: 1.6;">If you find a job that interests you, dont hesitate to apply!</p>
                <p style="color: #666666; margin-bottom: 15px; line-height: 1.6;">If you have any questions or need assistance, feel free to reach out to our support team. We are here to help!</p>
                <div class="footer" style="margin-top: 30px; text-align: center; color: #999999; font-size: 14px;">
                    <p>Best regards,</p>
                    <p>The Jobify Team</p>
                </div>
            </div>
        </body>
        ';
                    $this->sendMail($value['email'], $subject, $message);
                }
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
            echo '<script>
            Swal.fire({
                title: "Great!",
                text: "Your Job Is Updated!!",
                icon: "success"
            }).then(() => {
                setTimeout(function() {
                    window.location.href = "?action=index";
                }); // Redirect after 2 seconds
            });
        </script>';
            exit();
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
            echo '<script>
            Swal.fire({
                title: "Joob Procced!",
                text: "Application Applied Successfully!",
                icon: "success"
            }).then(() => {
                setTimeout(function() {
                    window.location.href = "?action=index";
                }); // Redirect after 2 seconds
            });
        </script>';
            exit();
        }
        echo '<script>alert("Job Apply Failed!")</script>';

    }
    public function selectRequestedJob($jobId, $userId)
    {
        return $this->JobModel->selectApply($jobId, $userId);
    }
    public function AllEmployeeDetails()
    {
        try {
            //code...
            return $this->userModel->getEmployeeDetails();
        } catch (\Throwable $th) {
            echo "/n\$th-ajay 💀<pre>"; print_r($th); echo "\n</pre>";exit;
            //throw $th;
        }
    }
    public function appliedJobs($user)
    {
        return $this->userModel->getjobDetails($user);
    }
    public function RejectAplication($job_id, $user_id, $reason)
    {
        $data = $this->userModel->rejectApplication($job_id, $user_id, $reason);
        if ($data) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            echo '<script>
            Swal.fire({
                title: "Rejection Procced!",
                text: "Application Successfully Rejected!",
                icon: "success"
            }).then(() => {
                setTimeout(function() {
                    window.location.href = "?action=index";
                }); // Redirect after 2 seconds
            });
        </script>';
            exit();
        }
    }
    public function acceptAplication($job_id, $user_id)
    {
        $data = $this->userModel->acceptJobApplication($job_id, $user_id);
        if ($data) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            echo '<script>
            Swal.fire({
                title: "congratulations!",
                text: "your job application is accepted! check mail for interview details!",
                icon: "success"
            }).then(() => {
                setTimeout(function() {
                    window.location.href = "?action=index";
                }); // Redirect after 2 seconds
            });
        </script>';
            exit();
        }
    }
    public function baseUrl()
    {
        $baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';
        return $baseURL;
    }



    public function ResetFunctions($email)
    {
        $data = $this->userModel->resetPassword($email);
        if ($data) {
            $subject = "Password Reset Request";
            $message = "Click the following link to reset your password: $data";
            // Send the email (you can use PHPMailer or another library)
            $send = $this->sendMail($email, $subject, $message);

            if ($send) {
                echo '<script>
                Swal.fire({
                    title: "congratulations!",
                    text: "Reset link is sent to your email",
                    icon: "success"
                }).then(() => {
                    setTimeout(function() {
                        window.location.href = "?action=index";
                    }); // Redirect after 2 seconds
                });
                </script>';
                exit();
            } else {
                echo "Failed to send email";
            }
        } else {
            echo "No data found";
        }
    }
    public function VerifyPassword($token, $password)
    {
        try {
            //code...
            return $this->userModel->verifyToken($token, $password);
        } catch (\Throwable $th) {
            echo "/n\$th-ajay 💀<pre>";
            print_r($th);
            echo "\n</pre>";
            exit;
            //throw $th;
        }
    }
    public function getEmployersCount(){
        return $this->userModel->getEmployersCount();
    }
    // Add more methods for other user-related actions
}


?>