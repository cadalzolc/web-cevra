<?php

session_start(); 

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$no = "";
$name = "";
$success = false;
$msg = "Admin login failed";
$p_username = $_POST['username'];
$p_password = $_POST['password'];

$sql = "CALL sp_login_admin('$p_username', '$p_password')";

$db = new Server();
$qry = $db->DbQuery($sql);
$cnt = mysqli_num_rows($qry);

if ($cnt == 1){
    $arr = mysqli_fetch_array($qry);
    $no = $arr['id'];
    $name = $arr['name'];
    $success = true;
    $msg = 'Login Successful';
    $_SESSION['A-ID'] = $arr['id'];
    $_SESSION['A-NAME'] =  $arr['name'];
}

$data = '{ 
    "success": '. ToBoolean($success) .',
    "message": "'. $sql .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>