<?php

class Conexion
{
    private $host;
    private $userName;
    private $password;
    private $db;    
    private $conn;
    protected $configFile = "conf.csv";

    public function __construct()
    {
        $this->connect();
    }

    public function __destruct()
    {
    }

    public function getConn()
    {
        return $this->conn;
    }

    public function connect()
    {
        $configFile = fopen("conf.csv", "r") or die("Unable to open file!");
        if (!feof($configFile)) {
            $connData = fgetcsv($configFile);
            $this->host = $connData[0];
            $this->userName = $connData[1];
            $this->password = $connData[2];
            $this->db = $connData[3];
            $this->conn = new mysqli($this->host, $this->userName, $this->password, $this->db);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }

    }

}
