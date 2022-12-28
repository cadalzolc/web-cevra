<?php

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$no = "";
$success = false;
$msg = "Customer registration failed";
$p_first_name = $_POST['first_name'];
$p_last_name = $_POST['last_name'];
$p_email = $_POST['email'];
$p_password = ToHash($_POST['password']);

$sql = "CALL sp_account_create_customer('$p_email', '$p_password', '$p_first_name', '$p_last_name')";

$db = new Server();
$qry = $db->DbQuery($sql);

if ($qry){
    $arr = mysqli_fetch_array($qry);
    $no = $arr['id'];
    $name = $p_first_name .''. $p_last_name;
    $msg = $arr['message'];
    if (empty($arr['message']))  {
        $success = true;
        $msg = 'Customer registration is successful';

        $link = BASE_URL() .'verify-account.php?ref=' .  Encrypt($no);
        $body = "<br><p>Hi " . $name .", Thank you for your registration. Please click or visit the link to verify you account.</p><p>Verify Link: <strong>".  $link ." </strong></p>";

        $reciept = SendEmail($p_email, $name, 'Account Verification', $body, $body);

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