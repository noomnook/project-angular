<?php
require_once('../lib/dbconnection.php');
class Member
{
    private $db;
    public function __construct()
    {
        $this->db = new Database("localhost", "dbangular", "root", "theadmin");
    }

    public function clearConn()
    {
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

    public function memberAdd($request)
    {
        $datetime = new DateTime();
        $datetime_format = $datetime->format('Y-m-d H:s:i');
        $name = $request->getParam("name");

        try {
            $sql = "SELECT * FROM member WHERE member_name = :name";
            $stmt = $this->db->pdoQuery()->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->execute();
            $query = $stmt->fetchObject();

            if ($query) {
                $data["status"] = "Error: Your account cannot be created at this time. Please try again later";
            } else {
                $sql = "INSERT INTO member (member_name, member_datetime) VALUES (:name, :datetime)";
                $stmt = $this->db->pdoQuery()->prepare($sql);
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":datetime", $datetime_format);
                $stmt->execute();
                $result = $this->db->pdoQuery()->lastInsertId();
                if ($result) {
                    $data["status"] = "Your account has been successfully created.";
                } else {
                    $data["status"] = "Error: Your account cannot be create at this time. Please try again later.";
                }
            }
            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
