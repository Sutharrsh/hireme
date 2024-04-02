<?php
class UserModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->createTableIfNotExists(); // Call the method to create table if it doesn't exist
    }

    private function createTableIfNotExists()
    {
        $query = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255)  NULL,
            email VARCHAR(255)  NULL UNIQUE,
            password_hash VARCHAR(255)  NULL,
            role VARCHAR(50) DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $this->db->exec($query);

        $query = "CREATE TABLE IF NOT EXISTS password_reset (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255)  NULL,
            token VARCHAR(255)  NULL,
            expiration TIMESTAMP  NULL,
            UNIQUE KEY unique_email (email),
            UNIQUE KEY unique_token (token)    
        )";
        $this->db->exec($query);
    }
    public function registerUser($username, $email, $password, $role = 'user')
    {
        // Add validation and hashing for password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $currentTime = time();

        // Insert user data into the database with created_at and updated_at timestamps
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash,role) VALUES (?, ?, ?,?)");
        $stmt->execute([$username, $email, $hashedPassword, $role]);

        $userId = $this->db->lastInsertId();
        return $userId;
    }
    public function loginUser($email, $password)
    {
        try {
            // Check if the email exists in the database
            $stmt = $this->db->prepare("SELECT id,username, password_hash,role FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // If user found, verify password
            if ($user) {
                // Verify the password
                if (password_verify($password, $user['password_hash'])) {
                    // Password is correct, return user data
                    return $user;
                } else {
                    // Password incorrect
                    return false;
                }
            } else {
                // User not found with the given email
                return false;
            }
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function getEmployeeDetails()
    {
        // $stmt = $this->db->prepare("SELECT a.dp_path, a.full_name, r.content, a.career_objective, a.contact_number, a.experience_years, a.resume_path, j.position, r.status, r.created_at, r.job_id, r.user_id 
        //                             FROM `job_requests` r 
        //                             JOIN jobs j ON j.id = r.job_id 
        //                             JOIN job_applications a ON a.user_id = r.user_id 
        //                             WHERE j.employer_id = ?");
        // echo $_SESSION['user_id'];die;
        if(isset($_SESSION['user_id'])){
            $stmt = $this->db->prepare("SELECT a.dp_path, a.full_name, r.content, a.career_objective, a.contact_number, a.experience_years, a.resume_path, j.position, r.status, r.created_at, r.job_id, r.user_id 
            FROM `job_requests` r 
            JOIN jobs j ON j.id = r.job_id 
            JOIN job_applications a ON a.user_id = r.user_id 
            WHERE j.employer_id = ?");
            $stmt->execute([$_SESSION['user_id']]);
               $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //    echo json_encode($user);die;
               return $user;
        }else{
            $stmt = $this->db->prepare("SELECT a.dp_path, a.full_name, r.content, a.career_objective, a.contact_number, a.experience_years, a.resume_path, j.position, r.status, r.created_at, r.job_id, r.user_id 
            FROM `job_requests` r 
            JOIN jobs j ON j.id = r.job_id 
            JOIN job_applications a ON a.user_id = r.user_id 
            ");
            $stmt->execute([]);
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $user;

        }
        // $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // return $user;
    }
    
    public function getjobDetails($userID)
    {
        try {
                        $stmt = $this->db->prepare("SELECT u.email, 
                        j.position, 
                        r.status, 
                        CASE 
                            WHEN r.status = 'reject' THEN (SELECT rr.reason FROM reject_reason rr WHERE rr.job_id = r.job_id)
                            ELSE NULL 
                        END AS reason 
                FROM jobs j 
                JOIN job_requests r ON r.job_id = j.id 
                JOIN users u ON u.id = r.user_id 
                WHERE u.id = ?");
            $stmt->execute([$userID]);

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $user;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function rejectApplication($job_id, $user_id, $reason)
    {
        // Update the status of the job request to 'rejected'
        $stmt = $this->db->prepare("UPDATE job_requests
                                    SET status = 'rejected'
                                    WHERE job_id = ? AND user_id = ?");
        $stmt->execute([$job_id, $user_id]);

        // Insert the rejection reason into the 'reject_reason' table
        $stmt = $this->db->prepare("INSERT INTO reject_reason (user_id, job_id, reason) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $job_id, $reason]);
    }
    public function acceptJobApplication($job_id, $user_id)
    {
        // Update the status of the job request to 'rejected'
        $stmt = $this->db->prepare("UPDATE job_requests
                                    SET status = 'accepted'
                                    WHERE job_id = ? AND user_id = ?");
        return $stmt->execute([$job_id, $user_id]);
    }
    public function getUserByEmail($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT id, username, email, role FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user; // Return the user data if found, or false if not found
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function getUsers()
    {
        try {
            $stmt = $this->db->prepare("SELECT id, username, email, role FROM users");
            $stmt->execute([]);
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $user; // Return the user data if found, or false if not found
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function resetPassword($email)
    {
        // Check if the user exists with the given email
        $user = $this->getUserByEmail($email);
        if (!$user) {
            // User with the given email does not exist
            echo '<script>
            Swal.fire({
                title: "sorry!",
                text: "no user found!",
                icon: "success"
            }).then(() => {
                setTimeout(function() {
                    window.location.href = "?action=index";
                }); // Redirect after 2 seconds
            });
        </script>';
            exit();
        }

        // Delete existing password reset entries for the same email
        $stmtDelete = $this->db->prepare("DELETE FROM password_reset WHERE email = ?");
        $stmtDelete->execute([$email]);

        // Generate token and expiration
        $baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';
        $token = bin2hex(random_bytes(16));
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour

        // Store the new token and its expiration time in the database
        $stmtInsert = $this->db->prepare("INSERT INTO password_reset (email, token, expiration) VALUES (?, ?, ?)");
        $success = $stmtInsert->execute([$email, $token, $expiration]);

        if ($success) {
            // Construct the reset link
            $resetLink = $baseURL . "?action=forgot&token=$token";
            return $resetLink;
        }

        return false;
    }

    public function verifyToken($token, $newPassword)
    {
        try {
            //code...
            $stmt = $this->db->prepare("SELECT email FROM password_reset WHERE token = ?");

            $stmt->execute([$token]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                // Token is invalid or expired
                echo "Invalid or expired token.";
                exit();
            }
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
            $stmt->execute([$hashedPassword, $row['email']]);
            // Delete the token from the database
            $stmt = $this->db->prepare("DELETE FROM password_reset WHERE token = ?");
            $stmt->execute([$token]);

            header("Location: ?action=login");
            exit();
        } catch (\Throwable $th) {
            echo "/n\$th-ajay 💀<pre>";
            print_r($th);
            echo "\n</pre>";
            exit;
            //throw $th;
        }

    }

    public function getEmployersCount(){
        $stmt = $this->db->prepare("SELECT count(*) FROM users WHERE role = 'employer'");
        $stmt->execute([]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return [$user]; // Return the user data if found, or false if not found
    }
}


?>