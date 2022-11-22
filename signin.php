<?php

session_start();

include('./libs/base.php');
include('./libs/db.php');

$today = date("D, M j, Y");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Signin</title>
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
</head>

<body class="d-flex flex-column h-100">


    <div class="form-wrapper">
        <div class="app-form">
            <div class="app-form-sidebar">
                <div class="sidebar-sign-logo">
                    <img src="images/sign-logo.svg" alt="">
                </div>
                <div class="sign_sidebar_text">
                    <h1>The Easiest Way to Reserve Events Place and Book Online</h1>
                </div>
            </div>
            <div class="app-form-content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-10">
                            <div class="app-top-items">
                                <a href="index.html">
                                    <div class="sign-logo" id="logo">
                                        <img src="images/logo.svg" alt="">
                                        <img class="logo-inverse" src="images/dark-logo.svg" alt="">
                                    </div>
                                </a>
                                <div class="app-top-right-link">
                                    Create account for<a class="sidebar-register-link" href="<?php echo BASE_URL() . 'customer/register.php'; ?>">Customer</a> or <a class="sidebar-register-link" href="<?php echo BASE_URL() . 'business/register.php'; ?>">Business</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 col-md-7">
                            <div class="registration">
                                <form>
                                    <h2 class="registration-title">Sign in</h2>
                                    <div class="form-group mt-5">
                                        <label class="form-label">Your Email*</label>
                                        <input class="form-control h_50" type="email" placeholder="Enter your email"
                                            value="">
                                    </div>
                                    <div class="form-group mt-4">
                                        <div class="field-password">
                                            <label class="form-label">Password*</label>
                                            <a class="forgot-pass-link" href="#">Forgot Password?</a>
                                        </div>
                                        <div class="loc-group position-relative">
                                            <input class="form-control h_50" type="password"
                                                placeholder="Enter your password">
                                            <span class="pass-show-eye"><i class="fas fa-eye-slash"></i></span>
                                        </div>
                                    </div>
                                    <button class="main-btn btn-hover w-100 mt-4" type="button" onclick="window.location.href='index.html'">Sign In <i class="fas fa-sign-in-alt ms-2"></i></button>
                                </form>
                                <div class="divider"></div>
                                <div class="social-btns-list" style="padding-top: 15px;">
                                    <a class="social-login-btn" href="<?php echo BASE_URL(); ?>" style="border: none; text-align: center;">Back to homepage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright-footer">
                   Copyright © 2022, All rights reserved. Powered by the sun :)
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
</body>

</html>