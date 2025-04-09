<?php
class Connect
{
    public $conn;

    function __CONSTRUCT()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db_name = "ithelpdesk";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    }
}
?>