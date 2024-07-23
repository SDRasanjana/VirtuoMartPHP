<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of DbConnector
 *
 * @author User
 */
class DbConnector {
    //put your code here
    private $hostName ="localhost";
    private $dbName ="virtuomart_db ";
    private $dbUser ="root";
    private $dbPwd ="";
    
    public function getConnection() {
        $dsn ="mysql:host".$this->hostName.";dbname=".$this->dbName;
        try {
        $con = new PDO($dsn,$this->dbUser,$this->dbPwd);
        $con->exec("USE " .$this->dbName);
        return $con;
        } catch (Exception $ex) {
            die("Connection Failed".$ex->getMessage());
        }
    }
}
