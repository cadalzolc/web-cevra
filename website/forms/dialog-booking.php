<?php
include('../../libs/base.php');
include('../../libs/func.php');
?>
<div class="event-dt-block p-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7 col-md-10">
                <div class="booking-confirmed-content">
                    <form class="main-card" method="POST"
                        onsubmit="return PostRequestReload(this)"
                        data-confirm="#btnYes"
                        data-cancel="#btnNo"
                        data-div="#<?php echo $_GET['div'] ?>"
                        action="<?php echo BASE_URL() . 'business/process/listing-gallery-remove.php' ?>">
                        <div class="booking-confirmed-top text-center p_30">
                            <div class="booking-confirmed-img mt-4">
                                <img src="<?php echo BASE_URL() . 'assets/base/img/delete.ico' ?>" alt="">
                            </div>
                            <h4>Delete Photo</h4>
                        </div>
                        <div class="booking-confirmed-bottom" style="display: flex;">
                           <button id="btnYes" type="submit" class="main-btn btn-hover h_50 w-100 mt-5">Yes</button>
                           <label style="width: 10px;"></label>
                           <button id="btnNo" type="button" class="main-btn btn-hover h_50 w-100 mt-5 dialog-close"
                                data-dialog-close="#<?php echo $_GET['div'] ?>" >No</button>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>