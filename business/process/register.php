<?php

include('../../libs/base.php');
include('../../libs/mailer.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$no = "";
$name = "";
$success = false;
$msg = "Business registration failed";
$name = $_POST['name'];
$email = $_POST['email'];
$password = ToHash($_POST['password']);

$sql = "CALL sp_account_create_business('$email', '$password', '$name')";

$db = new Server();
$qry = $db->DbQuery($sql);

if ($qry){

    $arr = mysqli_fetch_array($qry);
    $no = $arr['id'];
    $msg = "Registration was successful";

    if (empty($arr['message']))  {

        $success = true;
        $msg = 'Business registration is successful';
        $link = BASE_URL() .'verify-account.php?ref=' .  Encrypt($no);
        $body = "<br><p>Hi " . $name .", Thank you for your registration. Please click or visit the link to verify you account.</p><p>Verify Link: <strong>".  $link ." </strong></p>";

        $reciept = SendEmail($email, $name, 'Account Verification', $body, $body);

        if ($reciept[0] == '1') {
            $msg = $msg . ' And a verification link was sent to your email';
        }
    }
}

$data = '{ 
    "success": '. ToBoolean($success) .',
    "message": "'. $msg .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>