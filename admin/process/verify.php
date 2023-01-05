<?php

session_start(); 

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$no = "";
$name = "";
$success = false;
$msg = "Verification failed";
$id = $_POST['id'];

$sql = "CALL sp_account_verify_business($id )";
$db = new Server();
$qry = $db->DbQuery($sql);

if ($qry){
    $success = true;
    $msg = 'Verification Successful';
}

$data = '{ 
    "success": '. ToBoolean($success) .',
    "message": "'. $sql .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>