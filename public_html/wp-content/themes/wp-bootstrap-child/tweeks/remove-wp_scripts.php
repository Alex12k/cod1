<?php
/* ---------------------------------------------------------------------------
	ОТКЛЮЧЕНИЕ РАЗЛИЧНЫХ ФУНКЦИЙ WORDPRESS ПОТЕНЦИАЛЬНО ЗАМЕДлЯЮЩИХ ЗАГРУЗКУ
* --------------------------------------------------------------------------- */




/* ---------------------------------------------------------------------------
*  Отключаем jQuery migrate 
* --------------------------------------------------------------------------- */
function isa_remove_jquery_migrate( &$scripts ) {
	if( !is_admin() ) {
	$scripts->remove( 'jquery' );
	$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.12.4' );
	}
}
add_filter( 'wp_default_scripts', 'isa_remove_jquery_migrate' );  //Google page speed 85%
/* ---------------------------------------------------------------------------
*  Отключаем jQuery migrate 
* --------------------------------------------------------------------------- */





/* --------------------------------------------------------------------------
*  Отключаем wp_embed
* -------------------------------------------------------------------------- */
function my_deregister_scripts(){
 wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );
/* --------------------------------------------------------------------------
*  Отключаем wp_embed
* -------------------------------------------------------------------------- */






/* --------------------------------------------------------------------------
*  Отключаем wp-json
* -------------------------------------------------------------------------- */
//Удаляем WP-JSON из кода WordPress
//https://bloggood.ru/wordpress/optimizaciya-wordpress-ochen-vazhnaya-statya.html/


// Отключаем сам REST API
add_filter('rest_enabled', '__return_false');

// Отключаем фильтры REST API
remove_action( 'xmlrpc_rsd_apis',            'rest_output_rsd' );
remove_action( 'wp_head',                    'rest_output_link_wp_head', 10, 0 );
remove_action( 'template_redirect',          'rest_output_link_header', 11, 0 );
remove_action( 'auth_cookie_malformed',      'rest_cookie_collect_status' );
remove_action( 'auth_cookie_expired',        'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_username',   'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_hash',       'rest_cookie_collect_status' );
remove_action( 'auth_cookie_valid',          'rest_cookie_collect_status' );
remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );

// Отключаем события REST API (При отключении не корректно работает wpcf7)
//remove_action( 'init',          'rest_api_init' );
//remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
//remove_action( 'parse_request', 'rest_api_loaded' );

// Отключаем Embeds связанные с REST API
remove_action( 'rest_api_init',          'wp_oembed_register_route'              );
remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );

remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
// если собираетесь выводить вставки из других сайтов на своем, то закомментируйте след. строку.
remove_action( 'wp_head',                'wp_oembed_add_host_js'                 );


/* --------------------------------------------------------------------------
*  Отключаем wp-json
* -------------------------------------------------------------------------- */




/* --------------------------------------------------------------------------
 * Отключаем Emoji
 * -------------------------------------------------------------------------- */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );


function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}



function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2.2.1/svg/' );

		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}

	return $urls;
}
//dns-prefetch
add_filter( 'emoji_svg_url', '__return_false' );


/* --------------------------------------------------------------------------
 * Отключаем Emoji
 * -------------------------------------------------------------------------- */



/* --------------------------------------------------------------------------
 * Отключаем все dns-prefetch
 * -------------------------------------------------------------------------- */

remove_action( 'wp_head', 'wp_resource_hints', 2 );

/* --------------------------------------------------------------------------
 * Отключаем все dns-prefetch
 * -------------------------------------------------------------------------- */



/* --------------------------------------------------------------------------
*  Удаляем опасные методы работы XML-RPC Pingback
* -------------------------------------------------------------------------- */
add_filter( 'xmlrpc_methods', 'sheensay_block_xmlrpc_attacks' );
 
function sheensay_block_xmlrpc_attacks( $methods ) {
   unset( $methods['pingback.ping'] );
   unset( $methods['pingback.extensions.getPingbacks'] );
   return $methods;
}
 
add_filter( 'wp_headers', 'sheensay_remove_x_pingback_header' );
 
function sheensay_remove_x_pingback_header( $headers ) {
   unset( $headers['X-Pingback'] );
   return $headers;
}
/* --------------------------------------------------------------------------
*  Удаляем опасные методы работы XML-RPC Pingback
* -------------------------------------------------------------------------- */




/* --------------------------------------------------------------------------
*  Удаляем стили css-класса .recentcomments
* -------------------------------------------------------------------------- */
add_action( 'widgets_init', 'sheensay_remove_recent_comments_style' );
 
function sheensay_remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action( 'wp_head', array( $wp_widget_factory -> widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
/* --------------------------------------------------------------------------
*  Удаляем стили css-класса .recentcomments
* -------------------------------------------------------------------------- */


/*-------------------------------------------------------------------------
*	Удалить ссылку на WLW Manifest По умолчанию WP выводит ссылку на WLW Manifest
*--------------------------------------------------------------------------*/
	remove_action('wp_head', 'wlwmanifest_link');
/*-------------------------------------------------------------------------
*	Удалить ссылку на WLW Manifest По умолчанию WP выводит ссылку на WLW Manifest
*--------------------------------------------------------------------------*/


/*-----------------------------------------
*	Удаление ссылки на RSD
*-----------------------------------------*/
	remove_action('wp_head', 'rsd_link');
/*-----------------------------------------
*	Удаление ссылки на RSD
*-----------------------------------------*/



/*----------------------------------------------
*  	Удаление мета-тега generator
------------------------------------------------*/
	remove_action('wp_head', 'wp_generator');
/*----------------------------------------------
*  	Удаление мета-тега generator
------------------------------------------------*/





