<?php

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$no = "";
$name = "";
$success = false;
$msg = "Business registration failed";
$p_name = $_POST['name'];
$p_email = $_POST['email'];
$p_password = $_POST['password'];

$sql = "CALL sp_account_create_business('$p_email', '$p_password', '$p_name')";

$db = new Server();
$qry = $db->DbQuery($sql);

if ($qry){
    $arr = mysqli_fetch_array($qry);
    $no = $arr['id'];
    $name = $arr['name'];
    $msg = $arr['message'];
    if (empty($arr['message']))  {
        $success = true;
        $msg = 'Business registration is successful';
    }
}

$data = '{ 
    "success": '. ToBoolean($success) .',
    "message": "'. $msg .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>