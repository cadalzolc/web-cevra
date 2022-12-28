<?php

session_start();

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$no = "";
$success = false;
$msg = "Confirmation failed";

$id = $_POST['id'];
$sql = "CALL sp_reservation_confirm($id)";

$db = new Server();
$qry = $db->DbQuery($sql);

if ($qry) {
    $success = true;
    $msg = 'Confirmation is successful';
}

$data = '{ 
    "success": '. ToBoolean($success) .',
    "message": "'. $msg .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>