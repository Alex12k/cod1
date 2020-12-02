<?php


?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<!--<script src="https://api-maps.yandex.ru/2.1/?apikey=1c205ad4-5e75-4d47-a46d-e26fc3a79585=&lang=ru-RU" type="text/javascript"> </script>-->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<?php// echo root_get_option( 'code_head' ) ?>

	
</head>


<? $theme_path = get_stylesheet_directory_uri();?>

<? 
	
	$data_slider = carbon_get_the_post_meta('carbon_slider'); 
	if($data_slider){$is_first_slider = 'page_with_slider';}
	else{$is_first_slider = 'page_no_slider';}
	
?>

<body <?php body_class($is_first_slider); ?>>

	<?php root_check_license(); 	
	$site_title_text 	= get_bloginfo( 'name' );
	$description 		= get_bloginfo( 'description', 'display' );
?>
							
				


<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'root' ); ?></a>

    <?php do_action( 'root_before_header' ); ?>

	
  <?php
	/* Bottom menu */
    /** Check menu exist, if no - add separator */
    if(has_nav_menu('header_menu' )){
		do_action('root_before_main_navigation');
		?>
 
        <nav id="site-navigation" class="main-navigation bottom">           			
			<div class="main-navigation-inner">             	
				<?php wp_nav_menu( array('theme_location' => 'header_menu', 'menu_id' => 'header_menu') ) ?>
            </div><!--.main-navigation-inner-->
        </nav><!-- #site-navigation -->

        <?php do_action( 'root_after_main_navigation' ); ?>

    <?php } else { ?>

        <nav id="site-navigation" class="main-navigation" style="display: none;"><ul id="header_menu"></ul></nav>
        <div class="container header-separator"></div>
    <?php } /* Bottom menu end */?>	
	
<header id="masthead" class="site-header" itemscope itemtype="https://schema.org/WPHeader">	
	
			
	<div class="site-header-inner">
			
		<div class="site-branding">
			<a href = "<?=get_site_url();?>">
					
				<!--<img src="<?=$theme_path.'/img/LOGO-10.png';?>" title="New_theme СТУДИЯ ПИЛАТЕС АННЫ КЛИМЕНКО" alt="New_theme СТУДИЯ ПИЛАТЕС АННЫ КЛИМЕНКО">-->
				<!--
				<div class="site-branding-container">		              								
					<div class="site-title">		<?= $site_title_text?> </div>			
					<p class="site-description">	<?= $description	?>	</p>				
				</div>
				-->
			</a>			
		</div>
		
		
		<div class = "right_head_area">			
			<?php do_action('site-header-inner', $is_first_slider); /* My action */ ?>	
			<!-- .site-branding -->
		
	
			<!-- social info -->
			<?php do_action('after_site_branding'); /* My action */ ?>				
			<!-- end -->
		
			
			<!-- Top Menu -->
			<div class="top-menu">
				<?php	if (has_nav_menu('top_menu')){				
				wp_nav_menu( array('theme_location' => 'top_menu', 'menu_id' => 'top_menu') );
				}
				?>
			</div>

			<!--Mob hamburger-->
			<div class="mob-hamburger"><span></span></div>
	
		</div>
	
	</div><!--end site-header-inner-->	
			
</header><!-- #masthead -->
<?php do_action( 'root_after_header' ); /* My action */?>


	
  
	
	
	
	<?do_action( 'root_before_site_content' );?>
	<!-- LPM MODE-->				
	<? 	global $lpm;
		if(  $lpm == true && is_page('7')  ): ?>
	<!-- LPM MODE ON --->	
	<?	else : ?>
	<!-- STANDARD MODE ON --->
	
	<div id="content" class="site-content <?php root_site_content_classes() ?>">	
	<? endif ?>
	

	
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



