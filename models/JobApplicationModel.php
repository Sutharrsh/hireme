<?php

class JobApplicationModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertJobApplication($dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath)
    {
        $stmt = $this->db->prepare("INSERT INTO job_applications (dp_path, full_name, career_objective, contact_number, experience_years, resume_path) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath]);
    }

    public function updateJobApplication($id, $dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath)
    {
        $stmt = $this->db->prepare("UPDATE job_applications SET dp_path = ?, full_name = ?, career_objective = ?, contact_number = ?, experience_years = ?, resume_path = ? WHERE id = ?");
        return $stmt->execute([$dpPath, $fullName, $careerObjective, $contactNumber, $experienceYears, $resumePath, $id]);
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
    

}
?>
