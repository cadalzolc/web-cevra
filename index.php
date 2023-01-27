<?php

session_start();

include('./libs/base.php');
include('./libs/func.php');
include('./libs/db.php');

$today = date("D, M j, Y");

$sql_venues = "SELECT * FROM vw_listing ORDER BY RAND()";
$db = new Server();
$res_venues = $db->DbQuery($sql_venues);
$cnt_venues = mysqli_num_rows($res_venues);
$arr_buss = GroupBy($res_venues, "account_name");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Home - CEVRA</title>
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
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/plugins/css/animate.min.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/plugins/css/owl.carousel.min.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/plugins/css/owl.theme.default.min.css' ?>">
</head>

<body class="d-flex flex-column h-100">
    <?php include("./website/layouts/header.php"); ?>
    <div class="wrapper">
        <div class="owl-carousel owl-theme">
        <?php
            foreach($res_venues as $slide):
                ?>
                <div class="owl-slide d-flex align-items-center cover" style="background-image: url(<?= BASE_URL() . 'assets/uploads/listings/'. IIF($slide['photo'], "", "default.jpg") ?>);">
                    <div class="container">
                        <div class="row justify-content-center justify-content-md-start">
                            <div class="col-10 col-md-6 static">
                                <div class="owl-slide-text">
                                    <h2 class="owl-slide-animated owl-slide-title"><?= $slide['name'] ?></h2>
                                    <div class="owl-slide-animated owl-slide-subtitle mb-3"><?= $slide['description'] ?></div>
                                    <a class="btn btn-primary owl-slide-animated owl-slide-cta" href="<?= BASE_URL() .'venues-info.php?ref='. Encrypt($slide['id']) ?>" target="_blank" role="button">More Info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
        ?>
       </div>
        <div class="explore-events p-80" style="display: block; position: relative;">
            <div class="container">
                <?php 
                    if ($cnt_venues == 0) {
                ?>
                    <h5>No venue selection to display.</h5>
                <?php
                    } 
                    else {
                        foreach($arr_buss as $bus):
                ?>
                    <h5 style="text-transform: uppercase;" class="mt-4"><?php echo $bus->key; ?></h5>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="featured-controls">
                                <div class="row">
                                <?php 
                                    foreach($bus->value as $row):
                                        ?>
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mix arts concert workshops volunteer sports health_Wellness">
                                            <div class="main-card">
                                                <div class="event-thumbnail">
                                                    <a href="<?= BASE_URL() .'venues-info.php?ref='. Encrypt($row['id']) ?>" class="thumbnail-img">
                                                        <img src="<?= BASE_URL() . 'assets/uploads/listings/'. IIF($row['photo'], "", "default.jpg") ?>" alt="">
                                                    </a>
                                                </div>
                                                <div class="event-content" style="text-align: center;">
                                                    <a href="<?= BASE_URL() .'venues-info.php?ref='. Encrypt($row['id']) ?>" class="event-name"><?= $row['name'] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                        endforeach;
                    }
                ?>
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
    <script src="<?php echo BASE_URL() . 'assets/plugins/js/owl.carousel.min.js' ?>"></script>
    <script>
        $(document).ready(function(){
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                rtl: false,
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                stagePadding: 0,
                smartSpeed: 450,
            });
        });
    </script>
</body>

</html>