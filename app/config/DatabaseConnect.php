<?php 


class DatabaseConnect {
    private $host = "localhost";               // for local testing
    private $database = "ecommerce_zmonteras"; // "ecommerce"
    private $dbusername = "zmonteras";         // "root"
    private $dbpassword = "Zm0nt3ras_2024";    // ""
    private $charset    = 'utf8mb4';
    private $conn = null;


    public function connectDB(){
        $dsn = "mysql: host=$this->host;dbname=$this->database;charset=" . $this->charset;
        try {
            $this->conn = new PDO($dsn, $this->dbusername, $this->dbpassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $this->conn;
        } catch (PDOException $e){
            echo "Connection Failed: " . $e->getMessage();
            return null;
        }    
    }

}
