<?php
           
function root_add_options(){
	
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
			
	} //end function	
	
	
	
	
	function bs_menu($location){
           
		   wp_nav_menu( array(
                'theme_location'  => $location,
                'menu_id'         => $location,
                'depth'           => 2,
                'container'       => false,
                'menu_class'      => 'navbar-nav mr-auto',
                'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                'walker'          => new WP_Bootstrap_Navwalker()
            ) );
	}
	
	
	
	
	
	
	
	
	
	
	
	
