<?php

class Database
{
    private $dbHost = 'mante.hosting.acm.org';
    private $dbUser = 'mantehostingacm_chino';
    private $dbPass = 'tecmante159357';
    private $dbName = 'mantehostingacm_SIIAA';

    public function connectDB()
    {
        $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName;charset=utf8mb4;"; //DBO
        $dbConnection = new PDO($mysqlConnect, $this->dbUser, $this->dbPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}