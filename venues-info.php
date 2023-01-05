<?php

session_start();

include('./libs/base.php');
include('./libs/mailer.php');
include('./libs/func.php');
include('./libs/db.php');

$today = date("D, M j, Y");
$GLOBALS["tabs"] = "Venues";

if (empty($_GET['ref'])) {
    header("Location: " . BASE_URL() . 'venues.php');
    exit;
}

$id =  Decrypt($_GET['ref']);
$sql = "SELECT * FROM vw_listing WHERE id = $id";
$db = new Server();
$res = $db->DbQuery($sql);
$row = mysqli_fetch_array($res);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>CEVRA - Venues</title>
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
                                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL() . 'venues.php' ?>">Venues</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="event-dt-block p-80">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-7 col-md-12">
                        <div class="main-event-dt">
                            <div class="event-img">
                                <img src="<?php echo BASE_URL() . 'assets/uploads/listings/'. IIF($row['photo'], "", "default.jpg") ?>" alt="">
                            </div>
                            <div class="main-event-content">
                                <h4><?php echo $row['name'] ?></h4>
                                <p><?php echo $row['description'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-md-12">
                        <div class="main-card event-right-dt">
                            <div class="bp-title">
                               <div style="padding: 15px;">
                                    <div class="xtotel-tickets-count" style="padding-top: 0; border-top: 0;">
                                        <h5><span><?php echo $row['name'] ?></span></h5>
                                        <p><?php echo $row['account_name'] ?></p>
                                    </div>
                               </div>
                            </div>
                            <div class="select-tickets-block">
                                <div class="xtotel-tickets-count">
                                    <label><strong>Rates:</strong></label>
                                    <h5><span>₱ <?php echo $row['rates'] ?></span></h5>
                                </div>
                            </div>
                            <div class="booking-btn">
                                <?php
                                    if (empty($_SESSION['C-ID'])) {
                                ?>
                                    <a href="#" data-id="<?= $row['id'] ?>" data-dialog="<?php echo BASE_URL() . 'website/forms/dialog-login.php' ?>" class="main-btn btn-hover w-100" style="margin-bottom: 15px;">Sign In to Book this Venue</a>
                                    <span>Dont have an account? <a href="<?php echo BASE_URL() . 'customer/register.php' ?>">Register here</a></span>
                                <?php
                                    } else {

                                        $cs_id = $_SESSION['C-ID'];
                                        $sql_cs = "SELECT * FROM accounts WHERE id = $cs_id ";
                                        $db = new Server();
                                        $res_cs = $db->DbQuery($sql_cs);
                                        $row_cs = mysqli_fetch_array($res_cs);

                                        if ($row_cs['email_valid'] == 1) {
                                            ?>
                                                 <a href="#" data-id="<?= $row['id'] ?>" data-dialog="<?php echo BASE_URL() . 'website/forms/dialog-booking.php' ?>" class="main-btn btn-hover w-100">Book Now</a>
                                            <?php
                                        } else {
                                            ?>
                                                 <div class="alert alert-danger" role="alert" style="margin: 5px;">
                                                    <span>Please verify your email <?php echo $row_cs['email']; ?>. or 
                                                    <a href="#" onclick="SendVerification(this)" data-url="<?php echo BASE_URL() . '/customer/process/send-verification.php'; ?>">Resend Verification</a></span>
                                                </div>
                                            <?php
                                        }
                                ?>
                                <?php
                                    }
                                ?>
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