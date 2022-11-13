<?php
class Server
{

  public $server = "localhost";
  public $database = "db_events";
  public $username = "root";
  public $password = "";

  function DbQuery($Sql)
  {
    $conn = new mysqli($this->server, $this->username, $this->password, $this->database);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } else {
      return $conn->query($Sql);
    }
  }
}

?>
