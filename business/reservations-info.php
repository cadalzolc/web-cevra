<?php 

session_start(); 

include('../libs/base.php');
include('../libs/func.php');
include('../libs/db.php');

if (empty($_SESSION['B-ID'])) {
    header("Location: " . BASE_URL() . 'business/login.php');
    exit;
}

if (empty($_GET['ref'])) {
    header("Location: " . BASE_URL() . 'business/reservations.php');
    exit;
}

$ref_no =  $_GET['ref'];
$sql_rsv = "CALL sp_reservation_by_no('$ref_no');";
$db = new Server();
$res_rsv = $db->DbQuery($sql_rsv);
$cnt_rsv = mysqli_num_rows($res_rsv);

if ($cnt_rsv == 0) {
    header("Location: " . BASE_URL() . 'business/reservations.php');
    exit;
}

$GLOBALS["tabs"] = "Reservations";
$row_rsv = mysqli_fetch_array($res_rsv);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Business - Reservations Info</title>
    <link rel="icon" href="<?php echo BASE_URL() . 'assets/base/img/icon.png' ?>" type="image/png" sizes="16x16">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/dashboard.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/fontface' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/unicons.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/style.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/vertical-responsive-menu.min.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/responsive.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/night-mode.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/all.min.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/owl.carousel.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/owl.theme.default.min.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/bootstrap-select.min.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/custom.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/plugins/css/toastr.css' ?>">
</head>

<body class="d-flex flex-column h-100">
    <?php include("./layouts/header.php"); ?>
    <?php include("./layouts/sidebar.php"); ?>
    <div class="wrapper wrapper-body" id="vbody">
        <div class="dashboard-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="barren-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb" style="padding-left: 0 !important;">
                                    <li class="breadcrumb-item"><a
                                            href="<?php echo BASE_URL() . 'business' ?>">Dahsboard</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="<?php echo BASE_URL() . 'business/reservations.php' ?>">Reservations</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Info</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-main-title mt-4">
                            <h3><i class="fas fa-bookmark me-3"></i></i>Reservation Details</h3>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="main-card order-summary">
                            <div class="bp-title">
                                <h4>REF: <?php echo $row_rsv["ref_no"]; ?></h4>
                            </div>
                            <form class="order-summary-content p_30"
                                method="POST" 
                                action="./process/reservation-confirm.php" 
                                onsubmit="return PostRequestRedirect(this);" 
                                data-redirect="<?php echo BASE_URL() . 'business/reservations.php' ?>"
                                data-confirm="#btnConfirm">
                                <div class="event-order-dt">
                                    <div class="event-thumbnail-img">
                                        <img src="<?= BASE_URL() . 'assets/uploads/listings/'. IIF($row_rsv['listing_photo'], "", "default.jpg") ?>" alt="" style="width: 160px; height: 140px;">
                                    </div>
                                    <div class="event-order-dt-content">
                                        <h5><?php echo $row_rsv["listing_name"]; ?></h5>
                                        <div class="d-flex">
                                            <label class="l-caption">Customer :</label>
                                            <span><?php echo $row_rsv["customer"]; ?></span>
                                        </div>
                                        <div class="d-flex">
                                            <label class="l-caption">Reservation Date :</label>
                                            <span><?php echo $row_rsv["booking_date"]; ?></span>
                                        </div>
                                        <div class="d-flex">
                                            <label class="l-caption">Amount :</label>
                                            <span>₱ <?php echo $row_rsv["amount"]; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="confirmation-btn">
                                    <button id="btnConfirm" type="submit" class="main-btn btn-hover h_50 w-100 mt-5">Confirm Payment</button>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $row_rsv["id"]; ?>" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo BASE_URL() . 'assets/base/js/jquery-3.6.0.min.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/bootstrap.bundle.min.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/owl.carousel.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/bootstrap-select.min.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/custom.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/night-mode.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/app.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/plugins/js/toastr.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'business/js/app.js' ?>"></script>
</body>

</html>