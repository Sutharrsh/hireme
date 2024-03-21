<?php
class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'hireme';
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->host}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->createDatabaseIfNotExists();
            $this->conn->exec("USE {$this->database}");
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    private function createDatabaseIfNotExists()
    {
        $query = "CREATE DATABASE IF NOT EXISTS {$this->database}";
        $this->conn->exec($query);
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
?>