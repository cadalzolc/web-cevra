<?php 

session_start();

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$success = false;
$msg = "Saving image failed: Something went wrong in your request.";

$dirUpload = DIR_Upload_Folder("photo");
$allowedTypes = array('jpg', 'jpeg', 'png', 'bmp', 'webp');

$id = $_POST['id'];
$name = $_POST['name'];
$contact = $_POST['contact'];
$photo = $_FILES['photo']['name'];
$photoPath = $_FILES["photo"]["tmp_name"];
$fileType  = pathinfo($photo, PATHINFO_EXTENSION );

if (!empty($photo)) {
    if (in_array($fileType, $allowedTypes)) {

        $fileId = GUID();
        $photoName = $fileId . '.' . $fileType;
        $dirPath = $dirUpload . $photoName;

        $sql = "CALL sp_account_update($id, '$name', '$photoName ', '$contact')";
        $db = new Server();
        $qry = $db->DbQuery($sql);

        if (move_uploaded_file($photoPath, $dirPath)) {
            $success = true;
            $msg = "Photo was successfully uploaded!";
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