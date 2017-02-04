<?php
/**
 * The template for general page footer
 *
 * @package WordPress
 * @subpackage Vun_Hougkh
 * @since The Starry Night 1.0 with Vun Hougkh 1.0
 */
?>
</div><?php // END: #main-inner ?>
</div><?php // END: #main ?>
<footer id="colophon" class="site-footer dark" role="contentinfo">
    <div id="colophon-inner" class="container">
        <div class="row">
            <div class="col-sm-3">
                <h4 class="margin-top-0">Footer 1 </h4>
                <?php
                wp_nav_menu(array(
                        'theme_location' => 'footer1',
                        'container_class' => 'row',
                        'menu_class' => 'list-unstyled'
                    )
                );
                ?>
            </div>
            <div class="col-sm-3">
                <h4 class="margin-top-0">Footer 2</h4>
                <?php
                wp_nav_menu(array(
                        'theme_location' => 'footer2',
                        'container_class' => 'row',
                        'menu_class' => 'list-unstyled'
                    )
                );
                ?>
            </div>
            <div class="col-sm-3">
                <h4 class="margin-top-0">Footer 3</h4>
                <?php
                wp_nav_menu(array(
                        'theme_location' => 'footer3',
                        'menu_class' => 'list-unstyled list-inline'
                    )
                );
                ?>

            </div>
	        <div class="col-sm-3">
		        <h4 class="margin-top-1x">Footer Column</h4>
	        </div>
        </div>
    </div><?php // END: #colophon-inner ?>
    <hr>
    <div class="container">
        <div class="site-info">
            <?php echo date('Y') ?> &copy; <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
        </div><?php // END: .site-info ?>
    </div>
</footer>
<?php get_template_part('partials/nav/blect', 'mmenu'); ?>
</div><?php // END: #page ?>
<?php wp_footer(); ?>
</body>
</html>
