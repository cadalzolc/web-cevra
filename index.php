<?php

session_start();

include('./libs/base.php');
include('./libs/func.php');
include('./libs/db.php');


$today = date("D, M j, Y");

$sql_venues = "SELECT * FROM vw_listing LIMIT 12";
$db = new Server();
$res_venues = $db->DbQuery($sql_venues);
$cnt_venues = mysqli_num_rows($res_venues);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Home</title>
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
        
        <div class="hero-banner">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-9 col-md-10">
                        <div class="hero-banner-content">
                            <img src="./assets/base/img/logo-1.png" class="hero-logo" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="explore-events p-80">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <?php 
                            if ($cnt_venues == 0) {
                        ?>
                            <h5>No venue selectrion to display.</h5>
                        <?php
                            } else {
                        ?>
                            <div class="featured-controls">
                                <div class="row">
                                <?php 
                                    foreach($res_venues as $row):
                                        ?>
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mix arts concert workshops volunteer sports health_Wellness">
                                            <div class="main-card mt-4">
                                                <div class="event-thumbnail">
                                                    <a href="<?= BASE_URL() .'venues-info.php?ref='. Encrypt($row['id']) ?>" class="thumbnail-img">
                                                        <img src="<?= BASE_URL() . 'assets/uploads/listings/'. IIF($row['photo'], "", "default.jpg") ?>" alt="">
                                                    </a>
                                                </div>
                                                <div class="event-content" style="text-align: center;">
                                                    <a href="<?= BASE_URL() .'venues-info.php?ref='. Encrypt($row['id']) ?>" class="event-name"><?= $row['name'] ?></a>
                                                    <span><?php echo $row['account_name'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                ?>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
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