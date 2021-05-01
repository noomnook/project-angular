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
            $query = $stmt->fetchAll();
            $data = $query;
            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function memberDetail($request)
    {
        try {
            $memberid = $request->getAttribute("member_id");
            // $memberid = $request->getArgument("member_id");
            $sql = "SELECT * FROM member WHERE member_id = :member_id";
            $stmt = $this->db->pdoQuery()->prepare($sql);
            $stmt->bindParam(":member_id", $memberid);
            $stmt->execute();
            $query = $stmt->fetch(\PDO::FETCH_ASSOC);
            $data = $query;
            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function memberAdd($request)
    {
        $datetime = new DateTime();
        $datetime_format = $datetime->format('Y-m-d H:s:i');
        $name = $request->getParam("m_name");

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

    public function memberUpdate($request)
    {
        $memberid = $request->getParam("member_id");
        $name = $request->getParam("name");
        $datetime = new DateTime();
        $datetime_format = $datetime->format("Y-m-d H:s:i");

        try {
            $sql = "UPDATE member SET member_name  = :member_name, member_datetime = :member_datetime 
            WHERE member_id = :member_id";
            $stmt = $this->db->pdoQuery()->prepare($sql);
            $stmt->bindParam(":member_name", $name);
            $stmt->bindParam(":member_datetime", $datetime_format);
            $stmt->bindParam(":member_id", $memberid);
            $result = $stmt->execute();
            if ($result) {
                $date["status"] = "Your account has been successfully updated.";
            } else {
                $data["status"] = "Error: Your account cannot to be updated at this time. Please try again later.";
            }
            return $date;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function memberDelete($request)
    {
        // $memberid = $request->getParam("member_id");
        $memberid = $request->getAttribute("member_id");
        try {
            $sql = "DELETE FROM member WHERE member_id = :member_id";
            $stmt = $this->db->pdoQuery()->prepare($sql);
            $stmt->bindParam(":member_id", $memberid);
            $result = $stmt->execute();
            if ($result) {
                $data["status"] = "suceess";
                $data["text"] = "Your account has been succussful delete.";                
            } else {
                $data["status"] = "fail";
                $data["text"] = "Error: Your account cannot to be deelte at this time,Please try again later.";
            }
            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
