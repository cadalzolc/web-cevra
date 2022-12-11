<?php

session_start();

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$no = "";
$name = "";
$success = false;
$msg = "Venue update failed";
$p_id = $_POST['id'];
$p_name = $_POST['name'];
$p_description = $_POST['description'];
$p_info = $_POST['info'];
$p_rates = $_POST['rates'];

$sql = "CALL sp_listings_update($p_id, '$p_name', '$p_description', '$p_info', $p_rates)";

$db = new Server();
$qry = $db->DbQuery($sql);

if ($qry){
    $arr = mysqli_fetch_array($qry);
    $no = $arr['id'];
    $msg = $arr['message'];
    if (empty($arr['message']))  {
        $success = true;
        $msg = 'Venue is successfully updated';
    }
}

$data = '{ 
    "success": '. ToBoolean($success) .',
    "message": "'. $msg .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>