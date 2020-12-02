<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *
 *   ВНИМАНИЕ!!!!!!!
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   ПРИ ОБНОВЛЕНИИ ТЕМЫ - ВЫ ПОТЕРЯЕТЕ ВСЕ ВАШИ ИЗМЕНЕНИЯ
 *   ИСПОЛЬЗУЙТЕ ДОЧЕРНЮЮ ТЕМУ ИЛИ НАСТРОЙКИ ТЕМЫ В АДМИНКЕ
 *
 *   ПОДБРОБНЕЕ:
 *   https://docs.wpshop.ru/child-themes/
 *
 * *****************************************************************************
 *
 * @package Root
 */

$is_show_arrow = 'yes' == root_get_option( 'structure_arrow' );
?>

	</div><!-- #content -->

    <?php do_action( 'root_after_site_content' ); ?>

    <?php if ( has_nav_menu( 'footer_menu' ) ) {  ?>
	<div class="footer-navigation <?php root_navigation_footer_classes() ?>">
        <div class="main-navigation-inner <?php root_navigation_footer_inner_classes() ?>">
		    <?php wp_nav_menu(array('theme_location' => 'footer_menu', 'menu_id' => 'footer_menu')); ?>
        </div>
	</div>
    <?php } ?>

    <?php do_action( 'root_before_footer' ); ?>

	<footer class="site-footer <?php root_site_footer_classes() ?>" itemscope itemtype="http://schema.org/WPFooter">
        <div class="site-footer-inner <?php root_site_footer_inner_classes() ?>">

            <?php if ( $is_show_arrow ) { ?>
                <button type="button" class="scrolltop js-scrolltop"></button>
            <?php } ?>

            <div class="footer-info">
                <?php
                $footer_copyright = root_get_option( 'footer_copyright' );
                $footer_copyright = str_replace('%year%', date('Y'), $footer_copyright);
                echo $footer_copyright;
                ?>

                <?php
                $footer_text = root_get_option( 'footer_text' );
                if ( ! empty( $footer_text ) ) echo '<div class="footer-text">'. $footer_text .'</div>';
                ?>
            </div><!-- .site-info -->

            <div class="footer-counters">
                <?php echo root_get_option( 'footer_counters' ) ?>
            </div>

        </div><!-- .site-footer-inner -->
	</footer><!-- .site-footer -->

    <?php do_action( 'root_after_footer' ); ?>

</div><!-- #page -->


<?php wp_footer(); ?>
<?php echo root_get_option( 'code_body' ) ?>

</body>
</html>
