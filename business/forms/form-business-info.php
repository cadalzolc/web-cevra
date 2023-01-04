<?php
include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$id =  $_GET['id'];
$sql = "SELECT * FROM accounts WHERE id = $id ";

$db = new Server();
$res = $db->DbQuery($sql);
$row = mysqli_fetch_array($res);
?>
<div class="event-dt-block p-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-6">
                <div class="dialog">
                    <form method="POST" action="<?php echo BASE_URL() . 'website/process/login.php' ?>"
                        onsubmit="return PostRequestReload(this);" data-div="#<?php echo $_GET['div'] ?>"
                        data-confirm="#btnSignUp" data-cancel="#btnCancel" class="login-form">
                        <h2 class="registration-title">Business Profile</h2>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group text-center mt-4">
                                    <label class="form-label" for="photo" >Logo*</label>
                                    <span class="org_design_button btn-file">
                                        <span><i class="fa-solid fa-camera"></i></span>
                                        <input type="file" id="photo" accept="image/*" name="photo">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group mt-4">
                                    <label class="form-label">Business Name</label>
                                    <input class="form-control h_40" type="text" placeholder="" value="">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group mt-4">
                                    <label class="form-label">Payment Method</label>
                                    <textarea class="form-control" rows="10" name="payment" maxlength="3000"><?php echo $row['payment_method']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group mt-4">
                                    <label class="form-label">Business Proof</label>
                                    <input class="form-control h_40" type="file" name="proof">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6 col-md-6">
                                <button id="btnSignUp" class="main-btn btn-hover w-100" type="submit">Submit</button>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <button id="btnCancel" type="button" class="main-btn btn-hover w-100 dialog-close"
                                    data-dialog-close="#<?php echo $_GET['div'] ?>">Cancel</button>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>