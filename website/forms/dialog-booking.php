<?php
include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

$today = date("Y-m-d", strtotime('+7 day'));

$id = $_GET['id'];
$sql = "SELECT * FROM vw_listing WHERE id = $id";
$db = new Server();
$res = $db->DbQuery($sql);
$row = mysqli_fetch_array($res);

?>
<div class="event-dt-block p-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4col-lg-4 col-md-4">
                <form class="forms"
                    method="POST" 
                    action="<?php echo BASE_URL() . 'website/process/reservation.php' ?>" 
                    onsubmit="return PostReservation(this);"
                    data-redirect="<?php echo BASE_URL() . 'reserve.php?' ?>"
                    data-div="#<?php echo $_GET['div'] ?>"
                    data-confirm="#btnContinue"
                    data-cancel="#btnCancel">
                    <div class="card">
                        <div class="card-header">
                            Reservation Details
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="forms-label"><strong>Venue: </strong></label>
                                <span class="forms-value"><?php echo $row['name']; ?></span>
                            </div>
                            <div class="form-group">
                                <label class="forms-label"><strong>Rates: </strong></label>
                                <span class="forms-value"><?php echo $row['rates']; ?></span>
                            </div>
                            <hr>
                            <div class="forms-note">Venue Status:
                                    <strong id="dtS1" class="status-yes" style="display: none;">Available</strong>
                                    <strong id="dtS2" class="status-no" style="display: none;">Not Available</strong>
                            </div>
                            <div class="form-group">
                                <label class="forms-label"><strong>Date: </strong></label>
                                <input class="forms-value forms-input" 
                                    type="date" 
                                    name="date" 
                                    id="bkDate" 
                                    placeholder="<?php echo $today; ?>" 
                                    min="<?php echo $today; ?>" 
                                    onchange="ReservationDateChecked(this)"
                                    data-url="<?php echo BASE_URL() . 'website/process/reservation-date-check.php?id='. $id ; ?>"
                                    />
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <div style="float: right;">
                                <button id="btnContinue" type="submit" class="btn btn-primary" disabled>Confirm Reservation</button>
                                <button id="btnCancel" type="button" class="btn btn-secondary" data-dialog-close="#<?php echo $_GET['div'] ?>" >Cancel</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="rates" value="<?php echo $row['rates']; ?>" />
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                </form>
            </div>
        </div>
    </div>
</div>