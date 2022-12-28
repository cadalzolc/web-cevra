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
$msg = 'Verification link not sent';

$id =  $_SESSION['B-ID'];
$sql = "SELECT * FROM accounts WHERE id = $id ";
$db = new Server();
$res = $db->DbQuery($sql);
$body = "";

if ($res){

    $row = mysqli_fetch_array($res);
    $name = $row['name'];
    $email = $row['email'];
    $link = BASE_URL() .'verify-account.php?ref=' .  Encrypt($id );

    $body = "<br><p>Hi " . $name .", Thank you for your registration. Please click or visit the link to verify you account.</p><p>Verify Link: <strong>".  $link ." </strong></p>";

    $reciept = SendEmail($email, $name, 'Account Verification', $body, $body);

    if ($reciept[0] == '1') {
        $success = true;
        $msg = 'A verification link was sent to your email';
    }else {
        $msg = $reciept[1];
    }

}

$data = '{ "success": '. ToBoolean($success) .', "message": "'. $msg .'" }';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>