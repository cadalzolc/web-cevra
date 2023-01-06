<?php 

$cid =  $_SESSION['C-ID'];
$name = $_SESSION['C-NAME'];
$sql_user = "SELECT * FROM accounts WHERE id = $cid ";

$db = new Server();
$res_user = $db->DbQuery($sql_user);
$row_cur_user = mysqli_fetch_array($res_user);

?>

<header class="header">
    <div class="header-inner">
        <nav class="navbar navbar-expand-lg bg-barren barren-head navbar fixed-top justify-content-sm-start pt-0 pb-0 ps-lg-0 pe-2">
            <div class="container-fluid ps-0">
                <button type="button" id="toggleMenu" class="toggle_menu">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <button id="collapse_menu" class="collapse_menu me-4" onclick="OnVerticalNavClick()">
                    <i class="fa-solid fa-bars collapse_menu--icon "></i>
                    <span class="collapse_menu--label"></span>
                </button>
                <button class="navbar-toggler order-3 ms-2 pe-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon">
                        <i class="fa-solid fa-bars"></i>
                    </span>
                </button>
                <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-2 me-auto" href="<?php echo BASE_URL() . 'customer/' ?>">
                    <div class="res-main-logo">
                        <img src="<?php echo BASE_URL() . 'assets/base/img/logo-1-small.png' ?> " alt="">
                    </div>
                    <div class="main-logo">
                       <b>CUSTOMER PORTAL</b>
                    </div>
                </a>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <div class="offcanvas-logo" id="offcanvasNavbarLabel">
                            <img src="<?php echo BASE_URL() . 'assets/base/img/logo-1-small.png' ?> " alt="">
                        </div>
                        <button type="button" class="close-btn" data-bs-dismiss="offcanvas" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="offcanvas-body">
                        <?php 
                            if ($row_cur_user['email_valid'] == 0){
                                ?>
                                 <div class="navbar-nav justify-content-end flex-grow-1 pe_5" >
                                    <div class="alert alert-danger" role="alert" style="margin: 5px;">
                                        <span>Please verify your email <?php echo $row_cur_user['email']; ?>. or 
                                        <a href="#" onclick="SendVerification(this)" data-url="<?php echo BASE_URL() . '/customer/process/send-verification.php'; ?>">Resend Verification</a></span>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                    <div class="offcanvas-footer"></div>
                </div>
                <div class="right-header order-2">
                    <ul class="align-self-stretch">
                        <li>
                            <a href="<?php echo BASE_URL() . 'venues.php' ?>" class="create-btn btn-hover"> <i class="fa-solid fa-calendar-days"></i>
                                <span>Explore Venues</span>
                            </a>
                        </li>
                        <li class="dropdown account-dropdown">
                            <a href="#" class="account-link" role="button" id="accountClick" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo BASE_URL() . 'assets/uploads/photo/'. IIF($row_cur_user['photo'], "", "default.png") ?>" alt="">
                                <i class="fas fa-caret-down arrow-icon"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-account dropdown-menu-end"  aria-labelledby="accountClick">
                                <li>
                                    <div class="dropdown-account-header">
                                        <div class="account-holder-avatar">
                                            <img src="<?php echo BASE_URL() . 'assets/uploads/photo/'. IIF($row_cur_user['photo'], "", "default.png") ?>" alt="">
                                        </div>
                                        <h5><?php echo $name; ?></h5>
                                    </div>
                                </li>
                                <li class="profile-link">
                                    <a href="<?php echo BASE_URL() . 'customer/profile.php' ?>" class="link-item">My Profile</a>
                                    <a href="#" class="link-item" onclick="Logout()">Sign out</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div class="night_mode_switch__btn">
                                <div id="night-mode" class="fas fa-moon fa-sun"></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="overlay"></div>
    </div>
</header>