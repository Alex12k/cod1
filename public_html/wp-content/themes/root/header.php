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
 * The header for our theme.
 *
 * @package root
 * @build 4535
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
<?php echo root_get_option( 'code_head' ) ?>
</head>

<body <?php body_class(); ?>>
<?php root_check_license(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'root' ); ?></a>

    <?php do_action( 'root_before_header' ); ?>

	<header id="masthead" class="site-header <?php root_site_header_classes() ?>" itemscope itemtype="http://schema.org/WPHeader">
        <div class="site-header-inner <?php root_site_header_inner_classes() ?>">
		<div class="site-branding">
			<?php
				$root_logotype = root_get_option( 'logotype_image' );
				if ( ! empty( $root_logotype ) ) {
					if ( is_front_page() && is_home() ) {
                        echo '<div class="site-logotype"><img src="' . $root_logotype . '" alt="' . get_bloginfo('name') . '"></div>';
                    } else {
                        echo '<div class="site-logotype"><a href="'. esc_url( home_url( '/' ) ) .'"><img src="' . $root_logotype . '" alt="' . get_bloginfo('name') . '"></a></div>';
                    }
				}
			?>

			<?php if ( root_get_option( 'header_hide_title' ) == 'no' ) { ?>
			<div class="site-branding-container">

                <?php
                    $root_structure_home_h1 = root_get_option( 'structure_home_h1' );
                    if ( ! $root_structure_home_h1 ) $root_structure_home_h1 = '';

                    $site_title_text = get_bloginfo( 'name' );
                    $site_title_tag = 'div';

                    if ( is_front_page() && is_home() ) {

                        if ( empty( $root_structure_home_h1 ) ) {
                            $site_title_tag = 'h1';
                        }

                        if ( is_paged() ) {
                            $site_title_text = '<a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a>';
                        }

                    } else {
                        if ( ! is_front_page() ) {
                            $site_title_text = '<a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
                        }
                    }

                    echo '<'. $site_title_tag .' class="site-title">' . $site_title_text . '</'. $site_title_tag .'>';
                ?>

				<?php

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; ?></p>
				<?php
				endif; ?>

			</div>
			<?php } ?>
		</div><!-- .site-branding -->

		<div class="top-menu">
			<?php
			if ( has_nav_menu( 'top_menu' ) ) {
				wp_nav_menu( array('theme_location' => 'top_menu', 'menu_id' => 'top_menu') );
			}
			?>
		</div>

        <div class="mob-hamburger"><span></span></div>
        </div><!--.site-header-inner-->
	</header><!-- #masthead -->

    <?php do_action( 'root_after_header' ); ?>

    <?php
    /**
     * Check menu exist, if no - add separator
     */
    if ( has_nav_menu( 'header_menu' ) ) { ?>

        <?php do_action( 'root_before_main_navigation' ); ?>

        <nav id="site-navigation" class="main-navigation <?php root_navigation_main_classes() ?>">
            <div class="main-navigation-inner <?php root_navigation_main_inner_classes() ?>">
                <?php wp_nav_menu( array('theme_location' => 'header_menu', 'menu_id' => 'header_menu') ) ?>
            </div><!--.main-navigation-inner-->
        </nav><!-- #site-navigation -->

        <?php do_action( 'root_after_main_navigation' ); ?>

    <?php } else { ?>

        <nav id="site-navigation" class="main-navigation" style="display: none;"><ul id="header_menu"></ul></nav>
        <div class="container header-separator"></div>

    <?php } ?>

    <?php do_action( 'root_before_site_content' ); ?>

	<div id="content" class="site-content <?php root_site_content_classes() ?>">

        <?php
            $ad_options = get_option('root_ad_options');
            $ad_visible = ( ! empty( $ad_options['r_before_site_content_visible'] ) ) ? $ad_options['r_before_site_content_visible'] : array();

            $show_ad = false;
            if ( is_front_page()    && in_array('home', $ad_visible) )      $show_ad = true;
            if ( is_single()        && in_array('post', $ad_visible) )      $show_ad = true;
            if ( is_page()          && in_array('page', $ad_visible) )      $show_ad = true;
            if ( is_archive()       && in_array('archive', $ad_visible) )   $show_ad = true;
            if ( is_search()        && in_array('search', $ad_visible) )    $show_ad = true;

            if ( is_single() && in_array('post', $ad_visible) ) {
                $show_ad = do_show_ad(
                    $post->ID,
                    isset( $ad_options['r_before_site_content_exclude'] ) ? $ad_options['r_before_site_content_exclude'] : array()
                );
            }

            if ( ! wp_is_mobile() && ! empty( $ad_options['r_before_site_content'] ) && $show_ad ) {
                echo '<div class="b-r b-r--before-site-content">' . $ad_options['r_before_site_content'] . '</div>';
            }

            if ( wp_is_mobile() && ! empty( $ad_options['r_before_site_content_mob'] ) && $show_ad ) {
                echo '<div class="b-r b-r--before-site-content">' . $ad_options['r_before_site_content_mob'] . '</div>';
            }
        ?>