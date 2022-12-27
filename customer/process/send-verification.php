<?php

session_start(); 

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');
include('../../libs/mailer.php');

$data = '';
$no = "";
$name = "";
$success = false;

$id =  $_SESSION['C-ID'];
$sql = "SELECT * FROM accounts WHERE id = $id ";
$db = new Server();
$res = $db->DbQuery($sql);

if ($res){
    $row = mysqli_fetch_array($res);

    $name = $p_fname . ' ' . $p_lname;
    $link = BASE_URL() .'verify-account.php?ref=' .  $no;

    $body = '<br>
        <p>Hi ' . $name .', Thank you for joining Re-Connect. Please click or visit the link to verify you account.</p>
        <p>Verify Link: <strong>'.  $link .' </strong></p>
        <p>Your verification code is: <strong>' . $pin .' </strong></p>' ;

    $res = SendEmail($p_email, $name, 'Account Verification', $body, $body);

    $success = true;
    $msg = 'A verification link was sent to your email';
}

$data = '{ 
    "success": '. ToBoolean($success) .',
    "message": "'. $msg .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>