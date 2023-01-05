<?php 

session_start(); 

include('../libs/base.php');
include('../libs/db.php');
include('../libs/func.php');

if (empty($_SESSION['B-ID'])) {
    header("Location: " . BASE_URL() . 'business/login.php');
    exit;
}

$today = date("D, M j, Y");
$GLOBALS["tabs"] = "Listings";

$id = $_SESSION['B-ID'];
$sql = "SELECT * FROM vw_listing WHERE account_id = $id";
$db = new Server();
$qry = $db->DbQuery($sql);
$cntLst = mysqli_num_rows($qry);

$sql_user = "SELECT * FROM accounts WHERE id = $id ";

$db = new Server();
$res_user = $db->DbQuery($sql_user);
$row_user = mysqli_fetch_array($res_user);

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
                            <h3><i class="fa-solid fa-gauge me-3"></i>Venues</h3>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="main-card mt-5">
                            <div class="dashboard-wrap-content p-4">
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
                                            <?php
                                                if ($row_user['verify'] == 1 && $row_user['email_valid'] == 1) {
                                            ?>
                                                 <a href="<?php echo BASE_URL() . 'business/listing-new.php' ?>" class="tab-link active btn-tabs" title="New Listing">New venue</a>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="event-list">
                            <?php 
                               if ($cntLst == 0) {
                                ?>
                                <p>No list of venue to display.</p>
                                <?php
                                } else{
                                        $r = 1;
                                        foreach($qry as $row)
                                        {
                                ?>
                                <div class="contact-list">
                                    <div class="card-top event-top p-4 align-items-center top d-md-flex flex-wrap justify-content-between">
                                        <div class="d-md-flex align-items-center event-top-info">
                                            <div class="card-event-img">
                                                <img src="<?php echo BASE_URL() . 'assets/uploads/listings/'. IIF($row['photo'], "", "default.jpg") ?>" alt="">
                                            </div>
                                            <div class="card-event-dt">
                                                <h5 class="mb-0"><?=  $row['name']; ?></h5>
                                                <p class="mb-0"><?=  LimitString($row['description'], 120) . '..'; ?></p>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="option-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="<?php echo BASE_URL() . 'business/listing-manage.php?ref=' . $row['id']  ?>" class="dropdown-item"><i class="fa-solid fa-gear me-3"></i>Update</a>
                                                <a href="<?php echo BASE_URL() . 'business/listing-gallery.php?ref=' . $row['id']  ?>" class="dropdown-item"><i class="fa-regular fa-image me-3"></i>Gallery</a>
                                                <a href="#" class="dropdown-item delete-event"><i class="fa-solid fa-trash-can me-3"></i>Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="bottom d-flex flex-wrap justify-content-between align-items-center p-4">
                                        <div class="icon-box ">
                                            <span class="icon">
                                                <i class="fa-solid fa-circle-info menu--icon"></i>
                                            </span>
                                            <p>Status</p>
                                            <h6 class="coupon-status"><?=  $row['status']; ?></h6>
                                        </div>
                                        <div class="icon-box">
                                            <span class="icon">
                                                <i class="fa-solid fa-tag"></i>
                                            </span>
                                            <p>Sub Info</p>
                                            <h6 class="coupon-status"><?=  $row['subinfo']; ?></h6>
                                        </div>
                                        <div class="icon-box">
                                            <span class="icon">
                                                <i class="fa-solid fa-dollar-sign"></i>
                                            </span>
                                            <p>Rates</p>
                                            <h6 class="coupon-status"><?=  $row['rates']; ?></h6>
                                        </div>
                                        <div class="icon-box">
                                            <span class="icon">
                                                <i class="fa-solid fa-calendar-days"></i>
                                            </span>
                                            <p>Booking Date</p>
                                            <h6 class="coupon-status"><?=  $row['book_date']; ?></h6>
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