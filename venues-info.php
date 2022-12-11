<?php

session_start();

include('./libs/base.php');
include('./libs/db.php');

$today = date("D, M j, Y");
$GLOBALS["tabs"] = "Venues";

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
                                <img src="./assets/uploads/listings/BE56FF59-59EF-E922-641C-ECB9A7D2448F.jpg" alt="">
                            </div>
                            <div class="main-event-content">
                                <h4>About This Event</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin dolor justo, sodales
                                    mattis orci et, mattis faucibus est. Nulla semper consectetur sapien a tempor. Ut
                                    vel lacus lorem. Nulla mauris massa, pharetra a mi ut, mattis euismod libero. Ut
                                    pretium bibendum urna nec egestas. Etiam tempor vehicula libero. Aenean cursus
                                    venenatis orci, ac porttitor leo porta sit amet. Nulla eleifend mollis enim sed
                                    rutrum. Nunc cursus ex a ligula consequat aliquet. Donec semper tellus ac ante
                                    vestibulum, vitae varius leo mattis. In vestibulum blandit tempus. Etiam elit
                                    turpis, volutpat hendrerit varius ut, posuere a sapien. Maecenas molestie bibendum
                                    finibus. Nulla euismod neque vel sem hendrerit faucibus. Nam sit amet metus
                                    sollicitudin, luctus eros at, consectetur libero.</p>
                                <p>In malesuada luctus libero sed gravida. Suspendisse nunc est, maximus vel viverra
                                    nec, suscipit non massa. Maecenas efficitur vestibulum pellentesque. Ut finibus
                                    ullamcorper congue. Sed ut libero sit amet lorem venenatis facilisis. Mauris egestas
                                    tortor vel massa auctor, eget gravida mauris cursus. Etiam elementum semper
                                    fermentum. Suspendisse potenti. Morbi lobortis leo urna, non laoreet enim ultricies
                                    id. Integer id felis nec sapien consectetur porttitor. Proin tempor mauris in odio
                                    iaculis semper. Cras ultricies nulla et dui viverra, eu convallis orci fermentum.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-md-12">
                        <div class="main-card event-right-dt">
                            <div class="bp-title">
                                <h4>Details</h4>
                            </div>
                            <div class="event-dt-right-group">
                                <div class="event-dt-right-icon">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div class="event-dt-right-content">
                                    <h4>Location</h4>
                                    <h5 class="mb-0">00 Challis St, Newport, Victoria, 0000, Australia</h5>
                                    <a href="#"><i class="fa-solid fa-location-dot me-2"></i>View Map</a>
                                </div>
                            </div>
                            <div class="select-tickets-block">
                                <div class="xtotel-tickets-count">
                                    <h4><span>$0.00</span></h4>
                                </div>
                            </div>
                            <div class="booking-btn">
                                <a href="checkout.html" class="main-btn btn-hover w-100">Book Now</a>
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
</body>

</html>