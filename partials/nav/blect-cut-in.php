<nav class="navbar navbar-blect-default navbar-static-top" role="navigation">
    <div class="container text-center">
        <a class="" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
    </div>
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-blect-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse navbar-blect-collapse">
            <div class="nav navbar-nav">
            <?php
            $menuParameters = array(
                'theme_location'    => 'main',
                'depth'             => 1,
                'container'         => false,
                'menu_class'        => 'nav navbar-nav',
                'echo'            => false,
                'items_wrap'      => '%3$s',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker(),
            );

            echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' );
            ?>
            </div>
        </div>
    </div>
</nav>