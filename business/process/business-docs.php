<?php 

session_start();

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$data = '';
$success = false;
$msg = "Saving document failed: Something went wrong in your request.";

$dirUpload = DIR_Upload_Folder("docs");
$allowedTypes = array('jpg', 'jpeg', 'png', 'pdf');

$id = $_POST['id'];
$docs = $_FILES['docs']['name'];
$docsPath = $_FILES["docs"]["tmp_name"];
$fileType  = pathinfo($docs, PATHINFO_EXTENSION );

if (!empty($docs)) {
    if (in_array($fileType, $allowedTypes)) {

        $fileId = GUID();
        $docsName = $fileId . '.' . $fileType;
        $dirPath = $dirUpload . $docsName;

        $sql = "CALL sp_account_document($id, '$docsName ')";
        $db = new Server();
        $qry = $db->DbQuery($sql);

        if (move_uploaded_file($docsPath, $dirPath)) {
            $success = true;
            $msg = "Document was successfully uploaded!";
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