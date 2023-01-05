<?php 

session_start(); 

include('../libs/base.php');
include('../libs/db.php');

if (empty($_SESSION['A-ID'])) {
    header("Location: " . BASE_URL() . 'admin/login.php');
    exit;
}

$today = date("D, M j, Y");
$GLOBALS["tabs"] = "Home";

$sql_count = "SELECT * FROM vw_admin_dashboard";
$db = new Server();
$res_count = $db->DbQuery($sql_count);
$row_count = mysqli_fetch_array($res_count);

$sql_verify = "SELECT * FROM accounts WHERE verify = 0 and proof !='' AND account_type_id = 2";
$db = new Server();
$res_verify = $db->DbQuery($sql_verify);
$cnt_verify = mysqli_num_rows($res_verify);

$cnt_all = mysqli_num_rows($res_count);

$verify = 0;
$clients = 0;
$business = 0;

if ($cnt_all != 0) {
    $verify = $row_count['verify'];
    $clients = $row_count['clients'];
    $business = $row_count['business'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Administrator - Home</title>
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
                            <h3><i class="fa-solid fa-home me-3"></i></i>Dashboard</h3>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="main-card p-4 mt-5">
                            <div class="dashboard-wrap-content">
                                <div class="dashboard-report-content">
                                    <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-md-6">
                                            <div class="dashboard-report-card info">
                                                <div class="card-content">
                                                    <div class="card-content">
                                                        <span class="card-title fs-6">For Validation</span>
                                                        <span class="card-sub-title fs-3"><?php echo $verify; ?></span>
                                                    </div>
                                                    <div class="card-media">
                                                        <i class="far fa-folder"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-6">
                                            <div class="dashboard-report-card purple">
                                                <div class="card-content">
                                                    <div class="card-content">
                                                        <span class="card-title fs-6">Clients</span>
                                                        <span class="card-sub-title fs-3"><?php echo $clients; ?></span>
                                                    </div>
                                                    <div class="card-media">
                                                        <i class="far fa-folder"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-6">
                                            <div class="dashboard-report-card red">
                                                <div class="card-content">
                                                    <div class="card-content">
                                                        <span class="card-title fs-6">Business</span>
                                                        <span class="card-sub-title fs-3"><?php echo $business; ?></span>
                                                    </div>
                                                    <div class="card-media">
                                                        <i class="far fa-folder"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-card p-4 mt-5">
                            <h5>List of Business for Validation</h5>
                            <div class="dashboard-wrap-content">
                                <div class="event-list" id="tbList">
                                    <div class="table-card mt-4">
                                        <div class="main-table">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Date Submitted</th>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Document</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                        if ($cnt_verify == 0) {
                                                    ?>
                                                        <tr>
                                                            <td colspan="25">No records to display</td>
                                                        </tr>
                                                    <?php
                                                        } else {
                                                            $ctr = 1;
                                                            foreach($res_verify as $row):
                                                                ?>
                                                                <tr>
                                                                    <td><?= $ctr; ?></td>
                                                                    <td><?= $row["verify_date"]; ?></td>
                                                                    <td><?= $row["name"]; ?></td>
                                                                    <td><a href="#" data-id="<?= $row["id"]; ?>" data-dialog="<?php echo BASE_URL().'admin/forms/form-viewer.php?' ?>" style="color: #0d6efd;"><?= $row["proof"]; ?></a></td>
                                                                    <td>
                                                                        <a href="#" data-id="<?= $row["id"]; ?>" data-dialog="<?php echo BASE_URL().'admin/forms/form-verify.php?' ?>"><strong>Verify</strong></a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $ctr++;
                                                            endforeach;
                                                        }
                                                    ?>
                                                    </tbody>
                                                </table>
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
    </div>
    <script src="<?php echo BASE_URL() . 'assets/base/js/jquery-3.6.0.min.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/bootstrap.bundle.min.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/owl.carousel.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/bootstrap-select.min.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/custom.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/night-mode.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/app.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/plugins/js/toastr.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'admin/js/app.js' ?>"></script>
</body>
</html>