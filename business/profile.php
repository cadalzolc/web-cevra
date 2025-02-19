<?php 

session_start(); 

include('../libs/base.php');
include('../libs/func.php');
include('../libs/db.php');

if (empty($_SESSION['B-ID'])) {
    header("Location: " . BASE_URL() . 'business/login.php');
    exit;
}

$GLOBALS["tabs"] = "Profile";

$id =  $_SESSION['B-ID'];
$name = $_SESSION['B-NAME'];
$sql = "SELECT * FROM accounts WHERE id = $id ";

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
    <title>Business - Profile</title>
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
                        <div class="d-main-title">
                            <h3><i class="fas fa-bookmark me-3"></i></i>Profile</h3>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="main-card add-organisation-card p-4 mt-5">
                            <div class="ocard-left">
                                <div class="ocard-avatar">
                                    <img src="<?php echo BASE_URL() . 'assets/uploads/photo/'. IIF($row['photo'], "", "default.png") ?>"
                                        alt="">
                                </div>
                                <div class="ocard-name">
                                    <h4><?php echo $row['name']; ?></h4>
                                    <span>Business</span>
                                </div>
                            </div>
                        </div>
                        <div class="main-card mt-4 p-4">
                            <div class="bp-info forms-display">
                                <div class="d-block">
                                    <h4>Business Information</h4>
                                    <button class="pe-4 ps-4 text-center co-main-btn h_40 d-inline-block tp-btn" data-id="<?= $row['id'] ?>" data-dialog="<?php echo BASE_URL() . 'business/forms/form-business-info.php' ?>">Edit</button>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group mt-4">
                                            <label class="form-label">Name</label>
                                            <input class="form-control h_40" type="text" value="<?php echo $row['name']; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group mt-4">
                                            <label class="form-label">Contact No</label>
                                            <input class="form-control h_40" type="contact" value="<?php echo $row['contact_no']; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group mt-4">
                                            <label class="form-label">Email</label>
                                            <input class="form-control h_40" type="text" value="<?php echo $row['email']; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group mt-4">
                                            <label class="form-label">Last Login</label>
                                            <input class="form-control h_40" type="text" value="<?php echo $row['last_login']; ?>" readonly="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-card mt-4 p-4">
                            <div class="bp-info forms-display">
                                <div class="d-block">
                                    <h4>Business Validation</h4>
                                    <?php 
                                        if ($row['verify'] == 0) {
                                    ?>
                                        <button class="pe-4 ps-4 text-center co-main-btn h_40 d-inline-block tp-btn" data-id="<?= $row['id'] ?>" data-dialog="<?php echo BASE_URL() . 'business/forms/form-business-docs.php' ?>">Edit</button>
                                    <?php
                                        } 
                                    ?>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group mt-4">
                                            <label class="form-label">Status</label>
                                            <?php 
                                                if ($row['verify'] == 1) {
                                            ?>
                                                <input class="form-control h_40" type="text" value="VERIFIED" readonly="" style="color: #0b7c28 !important; font-weight: bold;">
                                            <?php
                                                } else {
                                            ?>
                                                <input class="form-control h_40" type="text" value="FOR VERIFICATION" readonly="" style="color: #c73535 !important; font-weight: bold;">
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group mt-4">
                                            <label class="form-label">Document</label>
                                            <input class="form-control h_40" type="text" value="<?= $row['proof'] ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group mt-4">
                                            <label class="form-label">Submitted Date</label>
                                            <input class="form-control h_40" type="text" value="<?= $row['verify_date'] ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group mt-4">
                                            <label class="form-label">Verified Date</label>
                                            <input class="form-control h_40" type="text" value="<?= $row['proof_date'] ?>" readonly="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-card mt-4 p-4">
                            <div class="bp-info forms-display">
                                <div class="d-block">
                                    <h4>Payment Method</h4>
                                    <button class="pe-4 ps-4 text-center co-main-btn h_40 d-inline-block tp-btn" data-id="<?= $row['id'] ?>" data-dialog="<?php echo BASE_URL() . 'business/forms/form-business-payment.php' ?>">Edit</button>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group mt-4">
                                            <textarea class="form-control" rows="10" readonly="" style="padding: 10px !important;"><?php echo $row['payment_method']; ?></textarea>
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