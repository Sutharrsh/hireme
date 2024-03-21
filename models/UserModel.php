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
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            role VARCHAR(50) DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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


    // Add more methods for other user-related operations
}


?>