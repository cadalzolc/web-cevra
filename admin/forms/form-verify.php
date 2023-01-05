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
            <div class="col-xl-5 col-lg-6 col-md-6">
                <form class="modal modal-confirm" tabindex="-1" role="dialog"
                    method="POST" action="<?php echo BASE_URL() . 'admin/process/verify.php' ?>"
                    onsubmit="return PostRequestReload(this);" data-div="#<?php echo $_GET['div']; ?>"
                    data-confirm="#btnSignUp" data-cancel="#btnCancel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Business Validation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    data-dialog-close="#<?php echo $_GET['div'] ?>">
                                    <span aria-hidden="true" data-dialog-close="#<?php echo $_GET['div'] ?>">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style="padding: 15px !important;">
                                <p>Are your sure you want confirm this business?</p>
                            </div>
                            <div class="modal-footer">
                                <button id="btnSignUp"  type="submit" class="btn btn-primary">Confirm</button>
                                <button type="button" class="btn btn-secondary" 
                                    data-dialog-close="#<?php echo $_GET['div'] ?>">Close</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                </form>
            </div>
        </div>
    </div>
</div>