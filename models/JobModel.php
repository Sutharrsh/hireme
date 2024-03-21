<?php

class JobModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->createTableIfNotExists(); // Call the method to create table if it doesn't exist
    }

    private function createTableIfNotExists()
    {
        $query = "CREATE TABLE IF NOT EXISTS jobs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            employer_id INT,
            thumbnail VARCHAR(255),
            salary DECIMAL(10, 2),
            position VARCHAR(255) NOT NULL,
            description TEXT,
            post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            number_of_positions INT,
            status ENUM('verified', 'pending') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $this->db->exec($query);

        $query = "CREATE TABLE IF NOT EXISTS job_requests (
            id INT AUTO_INCREMENT PRIMARY KEY,
            job_id INT,
            user_id INT,
            status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
            content TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $this->db->exec($query);
    }

    public function postJob($employerId, $thumbnail, $salary, $position, $description, $numberOfPositions)
    {
        $stmt = $this->db->prepare("INSERT INTO jobs (employer_id, thumbnail, salary, position, description, number_of_positions) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$employerId, $thumbnail, $salary, $position, $description, $numberOfPositions]);
    }

    public function updateJob($jobId, $employerId, $thumbnail, $salary, $position, $description, $numberOfPositions)
    {
        $stmt = $this->db->prepare("UPDATE jobs SET employer_id = ?, thumbnail = ?, salary = ?, position = ?, description = ?, number_of_positions = ? WHERE id = ?");
        return $stmt->execute([$employerId, $thumbnail, $salary, $position, $description, $numberOfPositions, $jobId]);
    }
    public function postOrUpdateJob($employerId, $thumbnail, $salary, $position, $description, $numberOfPositions)
    {
        // Check if the job already exists based on employer ID and position
        $existingJob = $this->getJobByEmployerAndPosition($employerId, $position);

        if ($existingJob) {
            // Job already exists, update it
            return $this->updateJob($existingJob['id'], $employerId, $thumbnail, $salary, $position, $description, $numberOfPositions);
        } else {
            // Job does not exist, create a new one
            return $this->postJob($employerId, $thumbnail, $salary, $position, $description, $numberOfPositions);
        }
    }

    public function getJobByEmployerAndPosition($employerId)
    {
        $stmt = $this->db->prepare("SELECT * FROM jobs WHERE employer_id = ?");
        $stmt->execute([$employerId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty ($data)) {
            return $data;
        }
        return false;
    }

    public function getJobById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM jobs WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        }
        return false;
    }

    public function getAllJobs()
    {
        $stmt = $this->db->prepare("SELECT * FROM jobs;");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        }
        return false;
    }
    public function deleteJob($jobId)
    {
        $stmt = $this->db->prepare("DELETE FROM jobs WHERE id = ?");
        return $stmt->execute([$jobId]);
    }

    public function applyForJob($jobId, $userId, $content)
    {
        $stmt = $this->db->prepare("INSERT INTO job_requests (job_id, user_id, content) VALUES (?, ?, ?)");
        $success = $stmt->execute([$jobId, $userId, $content]);
        if ($success) {
            return true;
        } else {
            return false;
        }
    }


    public function withdrawJobApplication($applicationId)
    {
        $stmt = $this->db->prepare("DELETE FROM job_requests WHERE id = ?");
        return $stmt->execute([$applicationId]);
    }
    public function selectApply($job, $user)
    {
        // echo "/n\$job-ajay 💀<pre>"; print_r($job); echo "\n</pre>";exit;
        $stmt = $this->db->prepare("Select * FROM job_requests WHERE job_id = ? AND user_id = ?");
        $stmt->execute([$job, $user]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public function updateJobApplicationStatus($applicationId, $status)
    {
        $stmt = $this->db->prepare("UPDATE job_requests SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $applicationId]);
    }
}

?>