<?php

class Database {
    
    public $conn;
    
    public function __construct() {
        
        $hostname = "localhost";
        $dbname = "drewjexc_musicmaker";
        $username = "drewjexc_root";
        $password = "delta7ywnbgah11";

        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed";
        }
        
    }
    
    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }
    
    public function query($sql) {
        return $this->conn->query($sql);
    }
    
}

?>