<?php

session_start(); 

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

date_default_timezone_set('Asia/Manila');

$data = '';
$no = "";
$name = "";
$success = false;
$msg = "Reservation failed";

$pin  = GeneratePin();
$today = new DateTime('now');

$ref_no =  $pin . date_format($today, "YmdHis");
$id = $_POST['id'];
$rates = $_POST['rates'];
$date = $_POST['date'];
$customer = $_SESSION['C-ID'];

$sql = "CALL sp_reservation($id, $customer, '$date', $rates, '$ref_no')";

$db = new Server();
$res = $db->DbQuery($sql);

if ($res){
    $success = true;
    $msg = "Reservation is successfull";
}

$data = '{
    "success": '.ToBoolean($success).',
    "message": "'.$msg.'",
    "data": "'.$ref_no.'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>