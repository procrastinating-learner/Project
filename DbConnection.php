<?php

class DbConnection
{
  private $host = 'localhost:3306';
  private $username = 'root';
  private $password = '';
  private $dbname = 'e_commerce';
  private $conn;

  public function __construct()
  {
    $this->conn = mysqli_connect($this->host, $this->username, $this->password);

    if (!$this->conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_select_db($this->conn, $this->dbname);
  }

  public function getConnection()
  {
    return $this->conn;
  }
}
