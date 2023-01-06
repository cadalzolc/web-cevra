<?php 

session_start(); 

include('../libs/base.php');
include('../libs/func.php');
include('../libs/db.php');

if (empty($_SESSION['B-ID'])) {
    header("Location: " . BASE_URL() . 'business/login.php');
    exit;
}

$GLOBALS["tabs"] = "Reservations";

$owner = $_SESSION['B-ID'];
$sql = "SELECT * FROM vw_resevation WHERE status = 'FV' AND business_id = $owner";
$db = new Server();
$rows = $db->DbQuery($sql);
$cnt = mysqli_num_rows($rows);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Business - Reservations</title>
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
                            <h3><i class="fas fa-bookmark me-3"></i></i>Reservations</h3>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="main-card p-4 mt-5">
                            <div class="dashboard-wrap-content">
                                <div class="d-md-flex flex-wrap align-items-center">
                                    <div class="dashboard-date-wrap mt-4" style="display: none !important;">
                                        <div class="form-group">
                                            <div class="relative-input position-relative">
                                                <input class="form-control h_40" type="text"
                                                    placeholder="Search by name" value="">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rs ms-auto mt-4 mt_r4">
                                        <a href="#" class="pe-4 w-100 ps-4 text-center co-main-btn h_40 d-inline-block">
                                            <i class="fa-solid fa-arrow-rotate-right me-3"></i>
                                            Search
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="event-list" id="tbList">
                            <div class="table-card mt-4">
                                <div class="main-table">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col">#</th>
                                                    <th scope="col">REF. NO.</th>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Venue</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                if ($cnt == 0) {
                                            ?>
                                                <tr>
                                                    <td colspan="25">No records to display</td>
                                                </tr>
                                            <?php
                                                } else {
                                                    $ctr = 1;
                                                    foreach($rows as $row):
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <a href="<?= BASE_URL() . 'business/reservations-info.php?ref=' . $row["ref_no"]; ?>"><i class="far fa-eye"></i></a>
                                                            </td>
                                                            <td><?= $ctr; ?></td>
                                                            <td><?= $row["ref_no"]; ?></td>
                                                            <td><?= $row["customer"]; ?></td>
                                                            <td><?= $row["listing_name"]; ?></td>
                                                            <td><?= $row["booking_date"]; ?></td>
                                                            <td><span class="status-circle <?= CirlceStatus($row["status"]); ?>"></span><?= StatusName($row["status"]); ?></td>
                                                            <td><?= $row["amount"]; ?></td>
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