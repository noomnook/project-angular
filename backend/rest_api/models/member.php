<?php
require_once('../lib/dbconnection.php');
class Member
{
    private $db;
    public function __construct()
    {
        $this->db = new Database("localhost", "dbangular", "root", "theadmin");
    }

    public function clearConn(){
        $this->db = null;
    }

    public function memberList()
    {
        try {
            $sql = "SELECT * FROM member;";
            $stmt = $this->db->pdoQuery()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
