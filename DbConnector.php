<?php

class DbConnector {
    private $hostname = "localhost";
    private $dbuser = "root";
    private $dbpwd = "";
    private $dbname = "virtuomart_db";
    
    public function getConnection() {
        $dsn = "mysql:host=".$this->hostname.";dbname=".$this->dbname;
        
        try{
           $con = new PDO($dsn, $this->dbuser, $this->dbpwd);
           $con->exec("USE " .$this->dbname);
           return $con;
        }catch (Exception $ex){
            die("Connection failed".$ex->getMessage());
        }
    }
}
