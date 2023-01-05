<?php 

session_start();

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$success = false;
$msg = "Saving payment method failed: Something went wrong in your request.";

$id = $_POST['id'];
$payment = $_POST['payment'];

$sql = "CALL sp_account_payment($id, '$payment ')";
$db = new Server();
$qry = $db->DbQuery($sql);

if ($qry) {
    $success = true;
    $msg = "Payment method was successfully uploaded!";
}

$data = '{
    "success": '. ToBoolean($success) .',
    "message": "'. $msg .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>