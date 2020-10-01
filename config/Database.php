<?php
class Database
{
    //DB params
    private $host = 'localhost';
    private $db_name = 'php_rest_api';
    private $username = 'root';
    private $password = '';
    private $conn;

    //db connect
    public function connect()
    {
        $this->conn = null;

        //create pdo object
        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            echo 'connection Error : ' . $e->getMessage();
        }

        return $this->conn;
    }
}
