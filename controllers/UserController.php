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
    public function  sendMail($email, $subject, $message)
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
    public function calculateProfileCompleteness($userId)
    {
        // Fetch the user's profile from the database
        if ($userId) {
            $profile = $this->JobApplicationModel->getJobApplicationById($userId);
       
        }
    
        // Check if the profile exists and is not empty
        if ($profile) {
            $filledFields = 0;
    
            // Count the filled fields
            if (!empty($profile['dp_path'])) {
                $filledFields++;
            }
            if (!empty($profile['full_name'])) {
                $filledFields++;
            }
            if (!empty($profile['career_objective'])) {
                $filledFields++;
            }
            if (!empty($profile['contact_number'])) {
                $filledFields++;
            }
            if (!empty($profile['experience_years'])) {
                $filledFields++;
            }
            if (!empty($profile['resume_path'])) {
                $filledFields++;
            }
    
            // Calculate the profile completeness percentage
            $totalFields = 6; // Total number of fields in the profile
            $profileCompleteness = ($filledFields / $totalFields) * 100;
    
            return $profileCompleteness;
        } else {
          
            return 0; // If the profile doesn't exist or is empty, completeness is 0%
        }
    }
    
    public function completeProfile($userId, $dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath)
    {
        try {
            // Validation
            $errors = [];

            if (empty($fullName)) {
                $errors[] = "Full name is required.";
            } elseif (!preg_match('/^[A-Za-z\s]+$/', $fullName)) {
                $errors[] = "Full name should only contain letters and spaces.";
            }
            if (empty($contactNumber)) {
                $errors[] = "Contact number is required.";
            } elseif (!preg_match('/^\d+$/', $contactNumber)) {
                $errors[] = "Contact number should contain only numbers.";
            }
            // Add more validation rules as needed

            // If there are validation errors, display them using SweetAlert
            if (!empty($errors)) {
                $errorMessages = implode('\n', $errors);
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: '$errorMessages',
                        }).then(() => {
                            setTimeout(function() {
                                window.location.href = '?action=profile';
                            }); // Redirect after 2 seconds
                        });;
                    </script>";
                return; // Stop further execution
                //  exit();
            }
            $job = $this->JobApplicationModel->insertOrUpdateJobApplication($userId, $dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath);

            if ($job) {
                // Start a new session (if not already started)
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
              
                header("Location: index.php?action=profile-view");
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
        $errors = [];

        if (empty($thumbnail)) {
            $errors[] = "Thumbnail  is required.";
        }
        if (empty($salary)) {
            $errors[] = "Esimated salary  is required.";
        }
        // Add more validation rules as needed

        // If there are validation errors, display them using SweetAlert
        if (!empty($errors)) {
            $errorMessages = implode('\n', $errors);
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: '$errorMessages',
                    }).then(() => {
                        setTimeout(function() {
                            window.location.href = '?action=index';
                        }); // Redirect after 2 seconds
                    });;
                </script>";
            return; // Stop further execution
            //  exit();
        }
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
                    // $this->sendMail($value['email'], $subject, $message);
                }
            }
            echo '<script>
            Swal.fire({
                title: "Great!",
                text: "Your Job Is Create!!",
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

    public function getSearch($search)
    {
        try {
            //code...
            return $this->JobModel->getSearch($search);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function applyForJob($jobId, $userId, $content)
    {
            // Calculate profile completeness
        $per = $this->calculateProfileCompleteness($userId);

        // If profile completeness is not 100%, display error using SweetAlert
        if ($per !== 100) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Profile Incomplete',
                        text: 'Please complete your profile 100%.',
                    }).then(() => {
                        setTimeout(function() {
                            window.location.href = '?action=index';
                        }); // Redirect after 2 seconds
                    });
                </script>";
            exit(); // Stop further execution
        }
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