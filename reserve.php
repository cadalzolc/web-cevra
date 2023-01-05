<?php

session_start();

include('./libs/base.php');
include('./libs/db.php');
include('./libs/func.php');

if (empty($_GET['ref'])) {
    header("Location: " . BASE_URL());
    exit;
}

$ref_no =  $_GET['ref'];
$sql = "CALL sp_reservation_by_no('$ref_no');";
$db = new Server();
$res = $db->DbQuery($sql);
$cnt = mysqli_num_rows($res);

if ($cnt == 0) {
    header("Location: " . BASE_URL());
    exit;
}

$row = mysqli_fetch_array($res);

$id =  $row['business_id'];
$sql_owner = "SELECT * FROM accounts WHERE id = $id";
$db = new Server();
$res_owner = $db->DbQuery($sql_owner);
$row_owner = mysqli_fetch_array($res_owner);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Reservation Success - Home</title>
    <link rel="icon" href="<?php echo BASE_URL() . 'assets/base/img/icon.png' ?>" type="image/png" sizes="16x16">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/fontface' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/unicons.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/style.css' ?>">
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
    <?php include("./website/layouts/header.php"); ?>
    <div class="wrapper">
        <div class="breadcrumb-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-10">
                        <div class="barren-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL() ?>">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Venue Reserved</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="event-dt-block p-80">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-7 col-md-10">
                        <div class="booking-confirmed-content">
                            <div class="main-card">
                                <div class="booking-confirmed-top text-center p_30">
                                    <div class="booking-confirmed-img mt-4">
                                        <img src="images/confirmed.png" alt="">
                                    </div>
                                    <h4>Reservation Recieved</h4>
                                    <p class="ps-lg-4 pe-lg-4">We are pleased to inform you that your reservation
                                        request has been received. Please pay the amount and choose the payment method that suits you.
                                    </p>
                                </div>
                                <div class="d-block text-center">
                                    <p style="margin: 0; color: #198754;"><strong>Transaction No</strong></p>
                                    <h5 style="margin: 0; color: #198754;"><?php echo $row['ref_no']; ?></h5>
                                </div>
                                <div class="booking-confirmed-bottom">
                                    <div class="booking-confirmed-bottom-bg p_30">
                                        <div class="event-order-dt">
                                            <div class="event-thumbnail-img">
                                                <img src="<?php echo BASE_URL() . 'assets/uploads/listings/'. IIF($row['listing_photo'], "", "default.jpg") ?>" alt="">
                                            </div>
                                            <div class="event-order-dt-content">
                                                <h5><?php echo $row['listing_name']; ?></h5>
                                                <span><?php echo $row['business']; ?></span>
                                                <div class="buyer-name"><?php echo $row['customer']; ?></div>
                                                <div class="booking-total-grand">
                                                    Total : <span>₱ <?php echo $row['amount']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-block" style="margin-top: 15px;">
                                            <h6>Payment Method</h6>
                                            <textarea rows="20" readonly class="form-control">
                                                <?php echo $row_owner['payment_method']; ?>
                                            </textarea>
                                        </div>
                                        <a href="<?php echo BASE_URL() . 'customer/reservations-info.php?ref='.$row['ref_no']; ?>" class="main-btn btn-hover h_50 w-100 mt-5"><i class="fa-solid fa-ticket rotate-icon me-3"></i>View Reservation</a>
                                    </div>
                                </div>
                            </div>
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
    <script src="<?php echo BASE_URL() . 'assets/plugins/js/toastr.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/app.js' ?>"></script>
    <?php include("./website/layouts/scripts.php"); ?>
</body>

</html>