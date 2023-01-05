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
                    <form method="POST" action="<?php echo BASE_URL() . 'business/process/business-payment.php' ?>"
                        onsubmit="return PostRequestMediaReload(this);" data-div="#<?php echo $_GET['div']; ?>"
                        data-confirm="#btnSignUp" data-cancel="#btnCancel" class="login-form">
                        <h2 class="registration-title">Payment Method</h2>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group mt-4">
                                    <label class="form-label">Document</label>
                                    <textarea class="form-control" rows="10" name="payment" required="" style="padding: 10px !important;"><?php echo $row_user['payment_method']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12" style="background: #eee; padding: 15px; margin-top: 15px;">
                                <p><strong>Sample Template of Payment Method</strong></p>
                                <p>Pay with Gcash 3 simple steps!</p>
                                <p>1.	Send your payment (exact amount) to GCASH Number 09655291005. Make sure you take a screenshot.</p>
                                <p>2.	Send the screenshot of your transaction to our official Facebook page. Make sure the Gcash Reference Number is visible.</p>
                                <p>3.	Wait for a confirmation of your payment in the Calbayog Events Venue Rentals Web App. This usually takes a few minutes after you send us your payment.</p>
                                <p>Please note that your reservation will not be processed if no payment is received.</p>
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