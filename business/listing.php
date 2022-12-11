<?php 

session_start(); 

include('../libs/base.php');
include('../libs/db.php');

if (empty($_SESSION['B-ID'])) {
    header("Location: " . BASE_URL() . 'business/login.php');
    exit;
}

$today = date("D, M j, Y");
$GLOBALS["tabs"] = "Listings";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Business - Events Place</title>
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
    <div class="wrapper wrapper-body">
        <div class="dashboard-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-main-title">
                            <h3><i class="fa-solid fa-gauge me-3"></i>Events / Place</h3>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="main-card mt-5">
                            <div class="dashboard-wrap-content p-4">
                                <h5 class="mb-4">Listings</h5>
                                <div class="d-md-flex flex-wrap align-items-center">
                                    <div class="dashboard-date-wrap">
                                        <div class="form-group">
                                            <div class="relative-input position-relative">
                                                <input class="form-control h_40" type="text" placeholder="Search by event name, status" value="">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rs ms-auto mt_r4">
                                        <div class="nav custom2-tabs btn-group" role="tablist">
                                            <button class="tab-link active" title="New Listing">New Listing</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="event-list">
                            <div class="contact-list">
                                            <div
                                                class="card-top event-top p-4 align-items-center top d-md-flex flex-wrap justify-content-between">
                                                <div class="d-md-flex align-items-center event-top-info">
                                                    <div class="card-event-img">
                                                        <img src="<?php echo BASE_URL() . 'assets/uploads/listings/default.jpg' ?>" alt="">
                                                    </div>
                                                    <div class="card-event-dt">
                                                        <h5>Tutorial on Canvas Painting for Beginners</h5>
                                                    </div>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="option-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="#" class="dropdown-item"><i class="fa-solid fa-gear me-3"></i>Manage</a>
                                                        <a href="#" class="dropdown-item delete-event"><i class="fa-solid fa-trash-can me-3"></i>Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="bottom d-flex flex-wrap justify-content-between align-items-center p-4">
                                                <div class="icon-box ">
                                                    <span class="icon">
                                                        <i class="fa-solid fa-location-dot"></i>
                                                    </span>
                                                    <p>Status</p>
                                                    <h6 class="coupon-status">Publish</h6>
                                                </div>
                                                <div class="icon-box">
                                                    <span class="icon">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                    </span>
                                                    <p>Starts on</p>
                                                    <h6 class="coupon-status">30 Jun, 2022 10:00 AM</h6>
                                                </div>
                                                <div class="icon-box">
                                                    <span class="icon">
                                                        <i class="fa-solid fa-ticket"></i>
                                                    </span>
                                                    <p>Ticket</p>
                                                    <h6 class="coupon-status">250</h6>
                                                </div>
                                                <div class="icon-box">
                                                    <span class="icon">
                                                        <i class="fa-solid fa-tag"></i>
                                                    </span>
                                                    <p>Tickets sold</p>
                                                    <h6 class="coupon-status">20</h6>
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
    <script src="<?php echo BASE_URL() . 'assets/base/js/app.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/plugins/js/toastr.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'business/js/app.js' ?>"></script>
</body>

</html>