<?php

session_start(); 

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$no = "";
$name = "";
$success = false;
$msg = "Business login failed";
$p_email = $_POST['email'];
$p_password = ToHash($_POST['password']);


$sql = "CALL sp_login_business('$p_email', '$p_password')";

$db = new Server();
$qry = $db->DbQuery($sql);
$cnt = mysqli_num_rows($qry);

if ($cnt == 1){
    $arr = mysqli_fetch_array($qry);
    $no = $arr['id'];
    $name = $arr['name'];
    $success = true;
    $msg = 'Login Successful';
    $_SESSION['B-ID'] = $arr['id'];
    $_SESSION['B-NAME'] =  $arr['name'];
    $_SESSION['B-EMAIL'] =  $arr['email'];
}

$data = '{ 
    "success": '. ToBoolean($success) .',
    "message": "'. $msg .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>