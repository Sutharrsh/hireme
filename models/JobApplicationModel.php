<?php

class JobApplicationModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->createTableIfNotExists(); // Call the method to create table if it doesn't exist
    }
    private function createTableIfNotExists()
    {
        $query = "CREATE TABLE IF NOT EXISTS job_applications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            dp_path VARCHAR(255) NULL,
            full_name VARCHAR(255)  NULL,
            career_objective TEXT NULL,
            contact_number VARCHAR(20) NULL,
            experience_years INT NULL,
            resume_path VARCHAR(255) NULL
        )";
        $this->db->exec($query);
    }

    public function insertJobApplication($userId, $dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath)
    {
        $stmt = $this->db->prepare("INSERT INTO job_applications (user_id,dp_path, full_name, career_objective, contact_number, experience_years, resume_path) VALUES (?,?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath]);
    }


    public function updateJobApplication($id, $dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath)
    {
        $stmt = $this->db->prepare("UPDATE job_applications SET dp_path = ?, full_name = ?, career_objective = ?, contact_number = ?, experience_years = ?, resume_path = ? WHERE id = ?");
        return $stmt->execute([$dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath, $id]);
    }


    public function insertOrUpdateJobApplication($userId, $dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath)
    {
        // echo "/n\$fullName-ajay 💀<pre>"; print_r($fullName); echo "\n</pre>";exit;

        try {
            // Check if the job application already exists for the user
            $existingApplication = $this->getJobApplicationById($userId);
          
            if ($existingApplication) {
                if(!$dpPath){
                    $dpPath = $existingApplication['dp_path2'];
                  
                }
                if(!$resumePath){
                    $resumePath = $existingApplication['resume_path2'];
                }
                // If application exists, update it
                return $this->updateJobApplication($existingApplication['id'], $dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath);
            } else {
                // If application doesn't exist, insert a new one
                return $this->insertJobApplication($userId, $dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath);
            }
            // echo "/n\$userId-ajay 💀<pre>"; print_r($userId); echo "\n</pre>";exit;
        } catch (Exception $e) {
            // Handle the exception
            echo 'Error: ' . $e->getMessage();
            return false; // Or handle the error in a different way, depending on your application's requirements
        }
    }


    public function deleteJobApplication($id)
    {
        $stmt = $this->db->prepare("DELETE FROM job_applications WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function getAllJobApplicationsWithBaseURL()
    {
        // Construct base URL dynamically
        $baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';

        $stmt = $this->db->query("SELECT id, dp_path, full_name, career_objective, contact_number, experience_years, resume_path FROM job_applications");
        $jobApplications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Append base URL to DP and resume paths
        foreach ($jobApplications as &$jobApplication) {
            $jobApplication['dp_path'] = $baseURL . $jobApplication['dp_path'];
            $jobApplication['resume_path'] = $baseURL . $jobApplication['resume_path'];
        }

        return $jobApplications;
    }
    public function getJobApplicationById($id)
    {
        $baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';
        $stmt = $this->db->prepare("SELECT * FROM job_applications WHERE user_id = ?");
        $stmt->execute([$id]);
        $jobApplication = $stmt->fetch(PDO::FETCH_ASSOC);
        // foreach ($jobApplications as &$jobApplication) {
        if (!empty ($jobApplication)) {
            $jobApplication['resume_path2']= $jobApplication['resume_path'];
            $jobApplication['dp_path2']= $jobApplication['dp_path'];
            $jobApplication['dp_path'] = $baseURL . $jobApplication['dp_path'];
            $jobApplication['resume_path'] = $baseURL . $jobApplication['resume_path'];
            
            // }

            return $jobApplication;
        }
        return false;
    }

}
?>