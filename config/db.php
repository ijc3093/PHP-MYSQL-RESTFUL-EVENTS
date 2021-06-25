<?php 
    class Database {
        private $dbh;
        
        private $host = "127.0.0.1";
        private $database_name = "events";
        private $username = "root";
        private $password = "Merciful$100";

        //Constructor
        function getConnection(){

            $this->dbh = null;
            try{
                $this->dbh = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
                $this->dbh->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->dbh;

        }//End of function constructor
    }  
?>