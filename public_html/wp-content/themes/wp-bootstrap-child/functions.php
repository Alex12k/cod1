<?php


/**
 * Enqueue scripts and styles.
 */
function wp_bootstrap_4_deps() {
	
	$parentThemePath 	= get_template_directory_uri();
	$childCssPath		= get_stylesheet_uri();

	
	wp_enqueue_style( 'open-iconic-bootstrap', 		$parentThemePath.'/assets/css/open-iconic-bootstrap.css', array(), 'v4.0.0', 'all' );	
	wp_enqueue_style( 'bootstrap-4', 				$parentThemePath.'/assets/css/bootstrap.css', array(), 'v4.0.0', 'all' );	
	wp_enqueue_style( 'wp-bootstrap-4-style', 		$parentThemePath.'/style.css', 	array(), '1.0.2', 'all' );		
	wp_enqueue_style( 'wp-bootstrap-4-child-style', $childCss, 						array(), '1.0.2', 'all' );	
	
	
	wp_enqueue_script( 'bootstrap-4-js', $parentThemePath.'/assets/js/bootstrap.js', array('jquery'), 'v4.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'wp_bootstrap_4_deps' );




/* Отключение стилей и скриптов темы */
function deregister_themes_deps(){
			
			$styles = [
				'wp-block-library',
				'open-iconic-bootstrap',
				'bootstrap-4',
				'wp-bootstrap-4-style',
				'wp-bootstrap-4-child-style'
			];			
			wp_deregister_style($styles);
		
			$scripts = [
						'bootstrap-4-js', 
						'wp-embed',
						];						
			wp_deregister_script($scripts); 
				
		}		
add_action( 'wp_enqueue_scripts', 'deregister_themes_deps', 100 );	
/*---- end ----*/



/**
 * НИЖЕ ВЫ МОЖЕТЕ ДОБАВИТЬ ЛЮБОЙ СВОЙ КОД
 */
 
/*=========================================*/




/*----------------------*/
/* Удаление всякой всячины  */
/*---------------------*/
get_template_part('tweeks/remove-wp_scripts');

/*--------------------------*/
/* Удаление всякой всячины END  */
/*------------------------*/




/*============== INCLUDE LIBS ================== */

/* 3
* Подключение основной библиотеки моих функций
*/

$libNames = [
			'get_dirs',
			'echo', 			//Библиотека служебных сообщений te(), print_arr() и т.д.
			'url',				//Библиотека по работе со строками
			'wp_deps', 			//Функции по работе с очередями скриптов и стилей в WP
			'ftp',				//Функции по работе с ftp
			'ijector',
			'sport',
			'content_replace',
			'header_lib',
			'creat_modul_and_template',
			'BsTabs', 			//Подключение класса bsTabs
			'header_functions',
			'my-lib'			//Требует расформирования по фаилам
		];	
	
foreach($libNames as $name){	
	get_template_part('tweeks/my-lib/'.$name);		
}	






/* OMW INIT */	
		$omw_path = __DIR__ .'/omw';
		include_once  $omw_path.'/observer/observer.php';
		include_once  $omw_path.'/manager/manager.php';
		include_once  $omw_path.'/worker/worker.php';
		add_action( 'wp_enqueue_scripts', 'observer', 99);	



/* Подключение класса для работы с FTP */
	get_template_part('tweeks/src/included/ftp');
	get_template_part('tweeks/src/included/class_my_ftp');
	



/* Deps Loader */
add_action( 'wp_enqueue_scripts', function(){
		include  get_stylesheet_directory().'/deps_loader.php';
	}, 
	99);





/* Подключение плагина carbon_fields */
require_once get_stylesheet_directory() .'/tweeks/src/included/carbon-fields/carbon-fields-plugin.php';

/* Подключение пользовательского фаила */
/* По материалам https://wp-kama.ru/plugin/carbon-fields */

add_action( 'carbon_fields_register_fields', 'crb_register_custom_fields' ); // Для версии 2.0 и выше
function crb_register_custom_fields(){
	// путь к пользовательскому файлу определения поля (полей), измените под себя

	require_once get_stylesheet_directory() . '/custom-fields/complex-fields.php';	
}




/*	Библиотека поддержки Woocommerce (включается автоматически при активации woocommerce) 	
*	Добавляем новую константу, которая будет возвращать true, если WooCommerce включен		
*/
define( 'WPEX_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
if ( WPEX_WOOCOMMERCE_ACTIVE ) {
		
	/* 	Подключение поддержки и твиков woocommerce */
	get_template_part('tweeks/woocommerce', 'tweeks');

}	


/* Подключение классов из папки src (позже сделать функцию автозагрузки)*/	
	$dirs = get_dirs(__DIR__ .'/src', '*.php');
	foreach($dirs as $file){	
		$path = abs2_url_for_get_template_part($file);
		get_template_part($path);
	}





