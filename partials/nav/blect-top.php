<nav class="navbar navbar-blect-top navbar-static-top hidden-xs" role="navigation">
    <div class="container-fluidx">
        <?php
        wp_nav_menu( array(
            'theme_location'    => 'top',
            'depth'             => 1,
            'container'         => 'div',
            'container_class'   => 'collapse navbar-collapse navbar-blect  pull-left',
            'menu_class'        => 'nav navbar-nav',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'walker'            => new wp_bootstrap_navwalker(),
            )
        );
        ?>

        <div class="collapse navbar-collapse navbar-blect ">
            <ul class="nav navbar-nav pull-right">
                <li><a href="#"><i class="fa fa-fw fa-lg fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-fw fa-lg fa-rss"></i></a></li>
                <li><a href="#"><i class="fa fa-fw fa-lg fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-fw fa-lg fa-youtube"></i></a></li>
            </ul>
        </div>
    </div>
</nav>