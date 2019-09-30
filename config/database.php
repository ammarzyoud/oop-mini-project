<?php

class Database
{
    private $host = "localhost";
    private $db_name = "oop_";
    private $username = "root";
    private $password = "";
    public $conn;

    // get the database connection
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            echo "Connected successfully";
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

?>