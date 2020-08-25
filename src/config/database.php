<?php

class Database
{
    private $dbHost = 'mante.hosting.acm.org';
    private $dbUser = 'mantehostingacm_chino';
    private $dbPass = 'tecmante159357';
    private $dbName = 'mantehostingacm_SIIAA';

    public function connectDB()
    {
        $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName"; //DBO
        $dbConnection = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}