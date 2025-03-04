<?php

namespace database;

use mysqli;

class dbconnector
{
    private static $instance = null;
    private $conn;

    private $db_host = "localhost";
    private $db_user = "root";
    private $db_password = "";
    private $db_name = "BOSTARTER";

    private function __construct()
    {
        $this->conn = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);

        if ($this->conn->connect_error) {
            die("Connessione fallita: " . $this->conn->connect_error);
        }
    }

    public static function getDbConnector()
    {
        if (!self::$instance) {
            self::$instance = new dbconnector();
        }
        return self::$instance->conn;
    }
}
