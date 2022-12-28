<nav class="vertical_nav" id="vnav">
    <div class="left_section menu_left" id="js-menu">
        <div class="left_section">
            <ul>
                <li class="menu--item">
                    <a href="<?php echo BASE_URL() . 'customer' ?>"
                        class="menu--link <?php if ($GLOBALS["tabs"] === 'Dashboard') { echo 'active'; } ?>" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard">
                        <i class="fa-solid fa-home menu--icon"></i>
                        <span class="menu--label">Dashboard</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="<?php echo BASE_URL() . 'customer/profile.php' ?>"
                        class="menu--link <?php if ($GLOBALS["tabs"] === 'Profile') { echo 'active'; } ?>" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Contact List">
                        <i class="fa-regular fa-address-card menu--icon"></i>
                        <span class="menu--label">Profile</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>