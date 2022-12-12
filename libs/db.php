<?php
require_once('env.php');
class Server
{
    function DbQuery($Sql)
    {
        $conn = new mysqli(
            Configuration::Setting('server'),
            Configuration::Setting('username'),
            Configuration::Setting('password'),
            Configuration::Setting('database')
        );
        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        } else 
        {
            return $conn->query($Sql);
        }
    }
}
?>
