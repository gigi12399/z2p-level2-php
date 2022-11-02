<?php 

abstract class Dbconnect {
    private $server_name = "localhost";
    private $db_name = "car_wash";
    private $db_user = "root";
    private $db_password = "";
    
    protected $connection; // for can call child class

    // PDO - PHP Data Object (light weight, secure)
    public function __construct(){
        if (!isset($this->connection)){
            try {
                $conn = new PDO("mysql:host=".$this->server_name.";dbname=".$this->db_name, $this->db_user, $this->db_password);
                $this->pdo = $conn;

                //echo "success";
                return $this->pdo;
            } catch (PDOException $e) {
                die("Fail to connect with MYSQL". $e->getMessage());
            }
        }
    }
}
//$obj = new Dbconnect();
?>