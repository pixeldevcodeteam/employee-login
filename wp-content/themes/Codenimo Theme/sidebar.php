<nav>
  <ul class="sidebar">
    <li class="menu-item">
        <div class="headerLogo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="/Codenimo-login/wp-content/uploads/2024/10/Codenimo-Logo-for-Employee-1.png" alt="Site Logo"></a>
        </div>
    </li>
    <li class="menu-item">
        <a href="<?php echo home_url(); ?>">
            <span class="icon">
                <i class="fa fa-solid fa-house"></i>
            </span>
            <span class="label">Dashboard</span>
        </a>
    </li>
    <li class="menu-item profilemenu">
        <a href="<?php echo home_url(); ?>/edit-profile/">
            <span class="icon">
                <i class="fa fa-solid fa-user"></i>
            </span>
            <span class="label">Profile</span>
        </a>
    </li>
    <li class="menu-item logoutmenu">
        <a href="<?php echo wp_logout_url(); ?>">
            <span class="icon">
                <i class="fas fa-sign-out"></i>
            </span>
            <span class="label">Logout</span>
        </a>
    </li>
  </ul>
</nav>