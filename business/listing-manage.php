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

$id_venue = $ref;
$today = date("D, M j, Y");
$GLOBALS["tabs"] = "Listings";

$sql_venue = "SELECT * FROM vw_listing where id = " . $id_venue;
$db = new Server();
$qry_venue = $db->DbQuery($sql_venue);
$info_venue = mysqli_fetch_array($qry_venue);

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
                            <h3><i class="fa-solid fa-gauge me-3"></i>Update venue</h3>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="wizard-steps-block">
                            <form class="step-app"
                                method="POST" 
                                action="./process/listing-manage.php" 
                                onsubmit="return PostRequestReload(this);" 
                                data-redirect="<?php echo BASE_URL() . 'business/listing.php' ?>"
                                data-confirm="#btnCreate">
                                <div class="step-content">
                                    <div class="main-card">
                                        <div class="bp-title">
                                            <h4><i class="fa-solid fa-circle-info step_icon me-3"></i>Details</h4>
                                        </div>
                                        <div class="p-4 bp-form main-form">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="form-group border_bottom pb_30">
                                                        <label class="form-label fs-16">Unique name.*</label>
                                                        <input name="name" class="form-control" type="text" placeholder="Type name here" value="<?php echo $info_venue['name']; ?>" required maxlength="300">
                                                    </div>
                                                    <div class="form-group border_bottom pb_30">
                                                        <label class="form-label fs-16">Description.*</label>
                                                        <textarea name="description" class="form-control" type="text" placeholder="Type name here" rows="5" maxlength="3000" required><?php echo $info_venue['description']; ?></textarea>
                                                    </div>
                                                    <div class="row g-4">
                                                        <div class="col-md-6">
                                                            <div class="form-group mt-1">
                                                                <label class="form-label fs-6">Additional Info*</label>
                                                                <input name="info" class="form-control" type="text" placeholder="" value="<?php echo $info_venue['subinfo']; ?>" required maxlength="300">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mt-1">
                                                                <label class="form-label fs-6">Rates*</label>
                                                                <input name="rates" class="form-control" type="text" placeholder="0" min="0" max="100000" value="<?php echo $info_venue['rates']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-footer step-tab-pager mt-4 ta-center">
                                    <button id="btnCreate" data-direction="finish" class="btn btn-default btn-hover steps_btn">Update</button>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $id_venue; ?>" />
                            </form>
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