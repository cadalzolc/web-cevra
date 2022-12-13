<?php

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$no = "";
$name = "";
$success = false;
$msg = "Customer registration failed";
$p_first_name = $_POST['first_name'];
$p_last_name = $_POST['last_name'];
$p_email = $_POST['email'];
$p_password = ToHash($_POST['password']);

$sql = "CALL sp_account_create_customer('$p_email', '$p_password', '$p_first_name', '$p_last_name')";

$db = new Server();
$qry = $db->DbQuery($sql);

if ($qry){
    $arr = mysqli_fetch_array($qry);
    $no = $arr['id'];
    $name = $arr['name'];
    $msg = $arr['message'];
    if (empty($arr['message']))  {
        $success = true;
        $msg = 'Customer registration is successful';
    }
}

$data = '{ 
    "success": '. ToBoolean($success) .',
    "message": "'. $msg .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>