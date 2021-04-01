<?php
class Database
{
    private $pdo;
    public function __construct($host, $dbname, $username, $password)
    {
        $con = new PDO("mysql:host=" . $host . "; dbname=" . $dbname . ";", $username, $password);
        $con->exec("SET NAMES utf8");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $con;
    }

    public function pdoQuery()
    {
        return $this->pdo;
    }
}
