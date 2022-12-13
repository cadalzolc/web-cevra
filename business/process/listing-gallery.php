<?php 

session_start();

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$success = false;
$msg = "Upload Image Failed: Something went wrong in your request.";
$order = $_POST['order'];
$venue = $_POST['venue'];

$dirListings = DIR_Upload_Folder("listings");
$allowedTypes = array('jpg', 'jpeg', 'png', 'bmp', 'webp');
$photo = $_FILES['photo']['name'];
$photoPath = $_FILES["photo"]["tmp_name"];
$fileType  = pathinfo($photo, PATHINFO_EXTENSION );

if (!empty($photo)) {

    if (in_array($fileType, $allowedTypes)) {

        $sql_id = "CALL sp_listings_photo_id($order, $venue)";
        $db = new Server();
        $qry_id = $db->DbQuery($sql_id);
        $arr = mysqli_fetch_array($qry_id);

        if ($arr['photo'] != "") {
            if (file_exists($dirListings.$arr['photo'])){
                unlink($dirListings.$arr['photo']);
            }
        }

        $fileId = GUID();
        $photoName = $fileId . '.' . $fileType;
        $dirPath = $dirListings . $photoName;
        $id = $arr['id'];

        if (move_uploaded_file($photoPath, $dirPath)) {
            $sql_update = "CALL sp_listings_photo_update($id, '$photoName');";
            $db = new Server();
            $res = $db->DbQuery($sql_update);
            if ($res) {
                $success = true;
                $msg = "Photo was successfully uploaded!";
            }
        }
    }
    else {
        $success = false;
        $msg = "Photo was successfully uploaded!";
    }
}

$data = '{
    "success": '. ToBoolean($success) .',
    "message": "File type '. $fileType .' is not supported."
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>