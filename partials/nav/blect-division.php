<nav class="navbar navbar-blect-division navbar-static-top" role="navigation">
    <div class="container">
        <?php  
        /**
         * mobile Brand
         */
        ?>
        <div class="navbar-header text-center visible-xs-block">
            <a href="#blect-mmenu" class="navbar-toggle pull-left">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar icon-bar-1"></span>
                <span class="icon-bar icon-bar-2"></span>
                <span class="icon-bar icon-bar-3"></span>
            </a>

            <a class="navbar-brand" href="<?php echo home_url(); ?>"><img src="<?php bloginfo( 'template_url' ); ?>/assets/img/logo-vert.png" alt="<?php bloginfo('name'); ?>" width="154" height="30"></a>

            <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".search-collapse">
                <i class="fa fa-search fa-fw fa-2x"></i>
            </button>
        </div>
        <?php  
        /**
         * mobile Brand
         */
        ?>
        <?php if ( ! wp_is_mobile() ) : ?> 
        <div class="row hidden-xs">
            <div class="col-sm-4 col-md-6">
                <div class="brand-wrap">
                    <a class="navbar-brand" href="<?php echo home_url(); ?>"><img src="<?php bloginfo( 'template_url' ); ?>/assets/img/logo-vert.png" alt="<?php bloginfo('name'); ?>" width="256" height="50"></a>
                </div>
            </div>
            <div class="col-sm-8 col-md-6">
                          
                <div class="tagline-wrap">
                    <span class="tagline tagline-1"></span>
                    <span class="tagline tagline-2"></span>
                    <span class="tagline tagline-3"></span>
                    <span class="tagline tagline-4"></span>
                    <span class="tagline tagline-5"></span>
                    <span class="tagline tagline-6"></span>
                    <span class="tagline tagline-7"></span>
                    <span class="tagline tagline-8"></span>
                    <span class="tagline tagline-9"></span>
                    <span class="tagline tagline-10"></span>
                    <span class="tagline tagline-11"></span>
                    <span class="tagline tagline-12"></span>
                    <span class="tagline tagline-13"></span>
                </div>
            
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="collapse navbar-collapse navbar-blect-collapse">
        <?php
        wp_nav_menu( array(
            'theme_location'    => 'main',
            //'depth'             => 2,
            // 'container'         => 'div',
            // 'container_class'   => 'collapse navbar-collapse navbar-blect-collapse',
            'menu_class'        => 'nav navbar-nav',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'walker'            => new wp_bootstrap_navwalker(),
            )
        );
        ?>
        <ul class="nav navbar-nav pull-right ">
            <li> <a class="btn" data-toggle="collapse" data-target=".search-wrap"><i class="fa fa-search fa-lg"></i></a></li>
        </ul>
       
        </div>
    </div>   
</nav>
<?php  
/**
 * mobile search
 */
?>
<div class="container visible-xs">
    <div class="collapse navbar-collapse search-collapse in">
            <?php get_search_form( ); ?>
    </div>
</div>
<?php  
/**
 * Desktop search
 */
?>
<div class="container hidden-xs">
        <div class="search-wrap collapse fade in">
            <a class="btn close-search pull-right text-white hidden-xs" data-toggle="collapse" data-target=".search-wrap"><i class="fa fa-times fa-2x"></i></a>
            <?php get_search_form( ); ?>
        </div>

</div>