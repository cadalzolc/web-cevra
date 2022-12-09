<?php

session_start();

include('../libs/base.php');
include('../libs/db.php');

$today = date("D, M j, Y");

if (!empty($_SESSION['C-ID'])) {
    header("Location: " . BASE_URL() . 'customer');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>CEVRA - Customer Login</title>
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

<body>

    <div class="form-wrapper">
        <div class="app-form">
            <div class="app-form-sidebar">
                <div class="sidebar-sign-logo"></div>
                <div class="sign_sidebar_text"></div>
            </div>
            <div class="app-form-content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-10">
                            <div class="app-top-items">
                                <a href="index.html">
                                    <div class="sign-logo" id="logo">
                                        <img src="<?php echo BASE_URL() . 'assets/base/svg/logo.svg' ?>" alt="">
                                        <img class="logo-inverse" src="<?php echo BASE_URL() . 'assets/base/svg/dark-logo.svg' ?>" alt="">
                                    </div>
                                </a>
                                <div class="app-top-right-link">
                                    New Customer?<a class="sidebar-register-link" href="<?php echo BASE_URL() . 'customer/register.php' ?>">Register Here</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 col-md-7">
                            <div class="registration">
                                <form   method="POST" 
                                        action="./process/login.php" 
                                        onsubmit="return PostRequestRedirect(this);" 
                                        data-redirect="<?php echo BASE_URL() . 'customer/' ?>"
                                        data-confirm="#btnSignUp">
                                    <h2 class="registration-title">Customer Login</h2>
                                    <div class="row mt-3">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group mt-4">
                                                <label class="form-label">Email*</label>
                                                <input class="form-control h_50" type="email" placeholder="" value="" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group mt-4">
                                                <div class="field-password">
                                                    <label class="form-label">Password*</label>
                                                </div>
                                                <div class="loc-group position-relative">
                                                    <input class="form-control h_50" type="password" placeholder="" name="password" maxlength="35" minlength="6" required>
                                                    <span class="pass-show-eye"><i class="fas fa-eye-slash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <button id="btnSignUp" class="main-btn btn-hover w-100 mt-4" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright-footer">
                    © 2022. All rights reserved. Powered by CEVRA
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
    <script src="<?php echo BASE_URL() . 'customer/js/app.js' ?>"></script>
</body>

</html>