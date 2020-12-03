<?php
/**
 * Child theme of Root
 * https://docs.wpshop.ru/root-child/
 *
 * @package Root
 */


/**
 * Enqueue child styles
 *
 * НЕ УДАЛЯЙТЕ ДАННЫЙ КОД
 */


//add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', 100);
function enqueue_child_theme_styles() {
    wp_enqueue_style( 'root-style-child', get_stylesheet_uri(), array( 'root-style')  );
}
/**
 * НИЖЕ ВЫ МОЖЕТЕ ДОБАВИТЬ ЛЮБОЙ СВОЙ КОД
 */




/* --------------------------------------------------------------------------
*	Отключить вывод в верхней панели Техническая поддержка
* -------------------------------------------------------------------------- */	
add_action( 'init', 'remove_wp_admin_bar_support' );
function remove_wp_admin_bar_support(){
    remove_action( 'wp_before_admin_bar_render', 'wp_admin_bar_support' );
} 
/* --------------------------------------------------------------------------
*	Отключить вывод в верхней панели Техническая поддержка
* -------------------------------------------------------------------------- */	



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

//add_action( 'carbon_fields_register_fields', 'crb_register_custom_fields' ); // Для версии 2.0 и выше
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






