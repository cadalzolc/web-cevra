<?php
include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$id =  $_GET['id'];
$sql_user = "SELECT * FROM accounts WHERE id = $id ";

$db = new Server();
$res_user = $db->DbQuery($sql_user);
$row_user = mysqli_fetch_array($res_user);
?>
<div class="event-dt-block p-80">
    <div class="container">
        <div class="row justify-content-center">
            <button class="btn btn-primary" style="position: fixed; z-index: 100; top: 20px; right: 27px; width: 100px;"
            data-dialog-close="#<?php echo $_GET['div'] ?>">Close PDF</button>
            <iframe src="<?php echo BASE_URL(). 'assets/uploads/docs/'. $row_user['proof'];  ?>" 
                frameborder="0" height="100%" width="100%" style="position: absolute;">
            </iframe>
        </div>
    </div>
</div>