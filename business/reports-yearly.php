<?php 

session_start(); 

include('../libs/base.php');
include('../libs/func.php');
include('../libs/db.php');

if (empty($_SESSION['B-ID'])) {
    header("Location: " . BASE_URL() . 'business/login.php');
    exit;
}

$GLOBALS["tabs"] = "Reports";
$owner = $_SESSION['B-ID'];
$sql = "SELECT SUM(amount) AS amount, report_year, business_id FROM
        (
            SELECT amount, Year(booking_date) as report_year, business_id FROM vw_resevation WHERE status = 'PD'
        ) X
        WHERE business_id = $owner
        GROUP BY report_year, business_id
        ORDER BY report_year";
$db = new Server();
$rows = $db->DbQuery($sql);
$cnt = mysqli_num_rows($rows);

$years = range(2021, 2030);
$tot = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Business - Reports Yearly</title>
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
                            <h3><i class="fas fa-bookmark me-3"></i></i>Reports - Yearly</h3>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="main-card p-2 mt-2">
                            <div class="dashboard-wrap-content">
                                <div class="d-flex d-flex-col">
                                    <div class="d-block">
                                        <button class="btn btn-primary" style="float: right; width: 120px;" onclick="printJS({ printable: 'CnReports', type: 'html'})">Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="event-list" id="tbList">
                            <div class="table-card mt-4">
                                <div class="main-table">
                                    <div class="table-responsive">
                                        <table class="table" id="CnReports">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th colspan="3" style="text-align: center; background: #fff; text-transform: uppercase; padding: 0 !important;">
                                                        <span><?php echo $_SESSION['B-NAME']; ?></span>
                                                        <span> - Yearly Sales Summary</span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th scope="col" style="width: 30px; padding: 5px !important">#</th>
                                                    <th scope="col" style="padding: 5px !important;">Year</th>
                                                    <th scope="col" style="width: 50px; padding: 5px !important">Sales</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                $ctr = 1;
                                                   
                                                foreach($years as $row):
                                                    $fil = FilterBy($rows, "report_year", $row);
                                                    $amt = $fil ? $fil["amount"] : 0;
                                                    $tot = $tot + $amt;
                                                    ?>
                                                    <tr>
                                                        <td style="padding: 7px !important;"><?= $ctr; ?></td>
                                                        <td style="padding: 7px !important;"><?= $row; ?></td>
                                                        <td style="padding: 7px !important; text-align: right;"><?= FormatCurrency($amt) ?></td>
                                                    </tr>
                                                    <?php
                                                    $ctr++;
                                                endforeach;
                                            ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" style="padding: 7px !important; text-align: right;">Total Sales</td>
                                                    <td style="padding: 7px !important; text-align: right;"><?php echo FormatCurrency($tot); ?></td>
                                                </tr>
                                            </tfoot>
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
    <script src="<?php echo BASE_URL() . 'assets/plugins/js/moment.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/plugins/js/toastr.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/plugins/js/print.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'business/js/app.js' ?>"></script>
</body>

</html>