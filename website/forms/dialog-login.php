<?php
include('../../libs/base.php');
include('../../libs/func.php');
?>
<div class="event-dt-block p-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-6">
                <div class="dialog">
                    <form   method="POST" 
                            action="<?php echo BASE_URL() . 'website/process/login.php' ?>" 
                            onsubmit="return PostRequestReload(this);" 
                            data-div="#<?php echo $_GET['div'] ?>"
                            data-confirm="#btnSignUp"
                            data-cancel="#btnCancel"
                            class="login-form">
                        <h2 class="registration-title">Customer Login</h2>
                        <div class="row mt-3">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group mt-4">
                                    <label class="form-label">Email*</label>
                                    <input class="form-control h_50" type="email" placeholder="" value="" name="email" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group mt-4">
                                    <div class="field-password">
                                        <label class="form-label">Password*</label>
                                    </div>
                                    <div class="loc-group position-relative">
                                        <input class="form-control h_50" type="password" placeholder="" name="password" maxlength="35" minlength="6" required>
                                        <span class="pass-show-eye"><i class="fas fa-eye-slash"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <button id="btnSignUp" class="main-btn btn-hover w-100" type="submit">Submit</button>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <button id="btnCancel" type="button" class="main-btn btn-hover w-100 dialog-close" data-dialog-close="#<?php echo $_GET['div'] ?>" >Cancel</button>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>