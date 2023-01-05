<?php 

session_start(); 

include('../libs/base.php');
include('../libs/db.php');
include('../libs/func.php');

if (empty($_SESSION['B-ID'])) {
    header("Location: " . BASE_URL() . 'business/login.php');
    exit;
}

$ref = $_GET['ref'];

if (empty($ref)) {
    header("Location: " . BASE_URL() . 'business/listing.php');
    exit;
}

$id = $ref;
$today = date("D, M j, Y");
$GLOBALS["tabs"] = "Listings";

$sql = "SELECT * FROM vw_listing where id = " . $id;
$db = new Server();
$qry = $db->DbQuery($sql);
$info = mysqli_fetch_array($qry);

$sql_photo = "CALL sp_listings_photo_by_listing_id($id)";
$db = new Server();
$qry_photo = $db->DbQuery($sql_photo);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Business - Venues</title>
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
                            <h3><i class="fa-solid fa-gauge me-3">Gallery</i></h3>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="wizard-steps-block">
                            <div class="step-app">
                                <div class="step-content">
                                    <div class="main-card">
                                        <div class="bp-title">
                                            <h4><i class="fa-sharp fa-solid fa-images step_icon me-3"></i><?php echo $info['name']; ?></h4>
                                        </div>
                                        <div class="p-4 bp-form main-form">
                                            <div class="row">
                                                <?php 
                                                    foreach($qry_photo as $row) {
                                                        if ($row['orders'] == 1) {
                                                            ?>
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="form-group">
                                                                    <div class="content-holder mt-4">
                                                                        <div class="default-event-thumb">
                                                                            <div class="default-event-thumb-btn">
                                                                                <div class="thumb-change-btn">
                                                                                    <input type="file" id="thumb-img1" name="file" accept="image/*" data-thumb="#thumb-img1" data-image="#img1" data-order="1" data-venue="<?php echo $id; ?>" data-action="<?php echo BASE_URL() . 'business/process/listing-gallery.php' ?>">
                                                                                    <label for="thumb-img1"><i class="fa-sharp fa-solid fa-images step_icon" title="Upload Image"></i></label>
                                                                                    <?php
                                                                                        if ( $row['id'] != 0) {
                                                                                            ?>
                                                                                                <label class="thumb-remove" data-id="<?= $row['id'] ?>" data-dialog="<?php echo BASE_URL() . 'business/forms/remove-listing-gallery.php' ?>"><i class="fa-solid fa-trash step_icon" title="Remove Image"></i></label>
                                                                                            <?php
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <img id="img1" src="<?php echo BASE_URL() . 'assets/uploads/listings/'. IIF($row['photo'], "", "default.jpg") ?>" alt="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="form-group">
                                                                    <div class="content-holder mt-4">
                                                                        <div class="default-event-thumb">
                                                                            <div class="default-event-thumb-btn">
                                                                                <div class="thumb-change-btn">
                                                                                    <input type="file" id="<?= 'thumb-img'.$row['orders'] ?>" name="file" accept="image/*" data-thumb="#<?= 'thumb-img'.$row['orders'] ?>" data-image="#img<?= $row['orders'] ?>" data-order="<?= $row['orders'] ?>" data-venue="<?php echo $id; ?>" data-action="<?php echo BASE_URL() . 'business/process/listing-gallery.php' ?>">
                                                                                    <label for="<?= 'thumb-img'.$row['orders'] ?>"> <i class="fa-sharp fa-solid fa-images step_icon" title="Upload Image"></i></label>
                                                                                    <?php
                                                                                        if ( $row['id'] != 0) {
                                                                                            ?>
                                                                                                <label class="thumb-remove" data-id="<?= $row['id'] ?>" data-dialog="<?php echo BASE_URL() . 'business/forms/remove-listing-gallery.php' ?>"><i class="fa-solid fa-trash step_icon" title="Remove Image"></i></label>
                                                                                            <?php
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <img id="img<?= $row['orders'] ?>" src="<?php echo BASE_URL() . 'assets/uploads/listings/'. IIF($row['photo'], "", "default.jpg") ?>" alt="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                        </div>
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