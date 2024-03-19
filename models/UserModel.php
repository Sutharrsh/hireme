<?php
class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registerUser($username, $email, $password,$role='user') {
        // Add validation and hashing for password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $currentTime = time();

        // Insert user data into the database with created_at and updated_at timestamps
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash,role, created_at, updated_at) VALUES (?, ?, ?,?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword,$role, $currentTime, $currentTime]);
        
        $userId = $this->db->lastInsertId();
        return   $userId;
    }
    public function loginUser($email, $password) {
        try {
            // Check if the email exists in the database
            $stmt = $this->db->prepare("SELECT username, password_hash FROM users WHERE email = ?");
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
    
    
    // Add more methods for other user-related operations
}


?>