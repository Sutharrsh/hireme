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
            
            echo "<div class='container' style='
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 8px;
            font-family: sans-serif;
         
    background: radial-gradient(#fff511, #eaae03);
              '>
            <div class='card-header'>
              Hiii
            </div>
            <div class='card-body'>
              <blockquote class='blockquote mb-0'>
                <p>".$e->getMessage()."</p>
                <footer class='blockquote-footer'><cite title='Source Title'>Connection Failed!</cite></footer>
              </blockquote>
            </div>
          </div>";
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