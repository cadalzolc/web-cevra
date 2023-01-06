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
                <div class="dialog">
                    <form method="POST" action="<?php echo BASE_URL() . 'business/process/business-info.php' ?>"
                        onsubmit="return PostRequestMediaReload(this);" data-div="#<?php echo $_GET['div'] ?>"
                        data-confirm="#btnSignUp" data-cancel="#btnCancel" class="login-form">
                        <h2 class="registration-title">Business Profile</h2>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group text-center mt-4">
                                <label class="form-label">Business Logo*</label>
                                <div class="img-b-logo">
                                    <img id="img-b-logo" src="<?php echo BASE_URL() . 'assets/uploads/photo/'. IIF($row_user['photo'], "", "default.png") ?>" style="width: 200px;">
                                </div>
                                <span class="org_design_button btn-file">
                                    <span><i class="fa-solid fa-camera"></i></span>
                                    <?php if ($row_user['photo'] == "") {
                                        ?>
                                        <input type="file" id="photo" accept="image/*" name="photo" onchange="OnImageSelection(this)" data-image="#img-b-logo" required="" value="<?php echo $row_user['photo'] ?>" data-input="#changePhoto">
                                        <?php
                                    } else {
                                        ?>
                                        <input type="file" id="photo" accept="image/*" name="photo" onchange="OnImageSelection(this)" data-image="#img-b-logo" value="<?php echo $row_user['photo'] ?>" data-input="#changePhoto">
                                        <?php
                                    } ?>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group mt-4">
                                    <label class="form-label">Business Name</label>
                                    <input class="form-control h_40" name="name" type="text" value="<?php echo $row_user['name']; ?>" required="">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group mt-4">
                                    <label class="form-label">Contact No</label>
                                    <input class="form-control h_40" name="contact" type="text" value="<?php echo $row_user['contact_no']; ?>" required="">
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
                        <input type="hidden" name="photoVal" value="<?php echo $row_user['photo']; ?>" />
                        <input type="hidden" name="changePhoto" value="0" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>