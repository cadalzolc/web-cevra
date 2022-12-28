<nav class="vertical_nav" id="vnav">
    <div class="left_section menu_left" id="js-menu">
        <div class="left_section">
            <ul>
                <li class="menu--item">
                    <a href="<?php echo BASE_URL() . 'business' ?>" class="menu--link <?php if ($GLOBALS["tabs"] === 'Home') { echo 'active'; } ?>" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard">
                        <i class="fa-solid fa-home menu--icon"></i>
                        <span class="menu--label">Dashboard</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="<?php echo BASE_URL() . 'business/reservations.php' ?>" class="menu--link <?php if ($GLOBALS["tabs"] === 'Reservations') { echo 'active'; } ?>" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Reservations">
                        <i class="fas fa-bookmark menu--icon"></i>
                        <span class="menu--label">Reservations</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="<?php echo BASE_URL() . 'business/listing.php' ?>" class="menu--link <?php if ($GLOBALS["tabs"] === 'Listings') { echo 'active'; } ?>" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Listing">
                        <i class="far fa-images menu--icon"></i>
                        <span class="menu--label">Venues</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="<?php echo BASE_URL() . 'business/reports.php' ?>" class="menu--link <?php if ($GLOBALS["tabs"] === 'Reports') { echo 'active'; } ?>" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Reports">
                        <i class="far fa-folder menu--icon"></i>
                        <span class="menu--label">Reports</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>