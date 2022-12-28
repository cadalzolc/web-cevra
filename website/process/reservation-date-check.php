<?php

session_start(); 

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$id = $_GET['id'];
$date = $_GET['date'];
$success = false;
$msg = "Date is not available";
$sql = "SELECT * FROM reservations WHERE listing_id = $id AND booking_date = '$date';";

$db = new Server();
$res = $db->DbQuery($sql);
$cnt = mysqli_num_rows($res);

if ($cnt == 0) {
    $success = true;
    $msg = 'Date is available';
}

$data = '{ 
    "success": '. ToBoolean($success) .',
    "message": "'. $msg .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>