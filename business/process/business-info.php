<?php 

session_start();

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$success = false;
$msg = "Saving image failed: Something went wrong in your request.";
/*
$dirListings = DIR_Upload_Folder("listings");

$id = $_POST['id'];

$sql_id = "SELECT * FROM listings_photo WHERE id = $id;";
$db = new Server();
$qry_id = $db->DbQuery($sql_id);
$arr = mysqli_fetch_array($qry_id);

$sql_delete = "DELETE FROM listings_photo WHERE id = $id;";
$db = new Server();
$res = $db->DbQuery($sql_delete);

if ($res) {

    if ($arr['photo'] != "") {
        if (file_exists($dirListings.$arr['photo'])){
            unlink($dirListings.$arr['photo']);
        }
    }

    $success = true;
    $msg = "Photo was successfully removed!";
}
*/
$data = '{
    "success": '. ToBoolean($success) .',
    "message": "'. $msg .'"
}';

header('Content-Type: application/json');

echo json_encode(json_decode($data), JSON_PRETTY_PRINT);

?>