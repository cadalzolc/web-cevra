<nav class="vertical_nav" id="vnav">
    <div class="left_section menu_left" id="js-menu">
        <div class="left_section">
            <ul>
                <li class="menu--item">
                    <a href="<?php echo BASE_URL() . 'admin' ?>" class="menu--link <?php if ($GLOBALS["tabs"] === 'Home') { echo 'active'; } ?>" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard">
                        <i class="fa-solid fa-home menu--icon"></i>
                        <span class="menu--label">Dashboard</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="<?php echo BASE_URL() . 'admin/clients.php' ?>" class="menu--link <?php if ($GLOBALS["tabs"] === 'Clients') { echo 'active'; } ?>" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Clients">
                        <i class="fa-solid fa-rectangle-ad menu--icon"></i>
                        <span class="menu--label">Clients</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="<?php echo BASE_URL() . 'admin/business.php' ?>" class="menu--link <?php if ($GLOBALS["tabs"] === 'Business') { echo 'active'; } ?>" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Business">
                        <i class="fa-solid fa-rectangle-ad menu--icon"></i>
                        <span class="menu--label">Business</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>