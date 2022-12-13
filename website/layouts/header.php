<header class="header">
    <div class="header-inner">
        <nav class="navbar navbar-expand-lg bg-barren barren-head navbar fixed-top justify-content-sm-start pt-0 pb-0">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon">
                        <i class="fa-solid fa-bars"></i>
                    </span>
                </button>
                <a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-2 me-auto" href="<?php echo BASE_URL() ?>">
                    <div class="res-main-logo">
                        <img src="<?php echo BASE_URL() . 'assets/base/img/logo-1-small.png' ?>" alt="">
                    </div>
                    <div class="main-logo" id="logo">
                        <img src="<?php echo BASE_URL() . 'assets/base/img/logo-1-small.png' ?>" alt="">
                        <img class="logo-inverse" src="<?php echo BASE_URL() . 'assets/base/img/logo-1-small.png' ?>" alt="">
                    </div>
                </a>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <div class="offcanvas-logo" id="offcanvasNavbarLabel">
                            <img src="<?php echo BASE_URL() . 'assets/base/img/logo-1-small.png' ?>" alt="">
                        </div>
                        <button type="button" class="close-btn" data-bs-dismiss="offcanvas" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="offcanvas-top-area">
                            <div class="create-bg">
                                <a href="<?php echo BASE_URL() . 'venues.php' ?>" class="offcanvas-create-btn">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    <span>Explore Venue</span>
                                </a>
                            </div>
                        </div>
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe_5">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL() ?>">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL() . 'about.php' ?>">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"href="<?php echo BASE_URL() . 'contact.php' ?>">Contact Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL() . 'policy.php' ?>">Policy</a>
                            </li>
                        </ul>
                    </div>
                    <div class="offcanvas-footer">
                        <div class="offcanvas-social">
                            <h5>Follow Us</h5>
                            <ul class="social-links">
                                <li>
                                    <a href="#" class="social-link"><i class="fab fa-facebook-square"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
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
                                <img src="<?php echo BASE_URL() . 'assets/base/img/who.png' ?>" alt="">
                                <i class="fas fa-caret-down arrow-icon"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-account dropdown-menu-end"  aria-labelledby="accountClick">
                                <li class="profile-link">
                                    <a href="<?php echo BASE_URL() . 'customer/register.php' ?>" class="link-item">Customer Registration</a>
                                    <a href="<?php echo BASE_URL() . 'business/register.php' ?>" class="link-item">Business Registration</a>
                                    <a href="<?php echo BASE_URL() . 'signin.php' ?>" class="link-item">Sign In</a>
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