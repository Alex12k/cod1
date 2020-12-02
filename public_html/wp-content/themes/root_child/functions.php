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



//===================================================================================================================
/* Переменные*/
$lpm = true;
$mark_file_path = false; /* значение переменной TRUE включает отображение абсолютного пути, у промаркированных фаилов */
//===================================================================================================================





/* --------------------------------------------------------------------------
*	Подключаем свежую версию JQ 2.2.4 при этом отключаем старую версию 
*	и делаем это только на сайте в обход админки
* -------------------------------------------------------------------------- */	
	if( !is_admin()){
		
		/* Отключаем старую jQuery */
		function deregister_old_jQuery(){
			wp_deregister_script( 'jquery-core' );
		}
		
		/* Подключаем fjq */
		function my_jquery() {
				
				$handle = 'jquery-core';
				/* Преобразую абсолютный путь в относительный */
				$dir_file = get_stylesheet_directory_uri().'/js_stack/fjq.js';		
				$deps = '';
				$ver = '';
				$in_footer = false;
				
				wp_register_script($handle, $dir_file, $deps, $ver, $in_footer);		
				wp_enqueue_script($handle);	
		
		}    
		
		add_action( 'wp_enqueue_scripts', 'deregister_old_jQuery' );			
		//add_action( 'wp_enqueue_scripts', 'my_jquery' );  	
	}
/* --------------------------------------------------------------------------
*	Подключаем свежую версию JQ 2.2.4 при этом отключаем старую версию 
*	и делаем это только на сайте в обход админки
* -------------------------------------------------------------------------- */	

	/* Отключаем старую JS скрипт cf-7 */
	function deregister_cf7(){
		wp_deregister_script( 'contact-form-7' );
	}
	add_action( 'wp_enqueue_scripts', 'deregister_cf7',999);
		





/* --------------------------------------------------------------------------
*	Подключаем font-awesome по CDN
* -------------------------------------------------------------------------- */
function enqueue_font_awesome() {
    
	$dir_file = 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
	//$dir_file = get_stylesheet_directory_uri().'/font-awesome.min.css';
	
	
	wp_enqueue_style( 'font-awesome', $dir_file, array( 'root-style' )  );
}
//add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome', 100);
/* --------------------------------------------------------------------------
*	Подключаем font-awesome по CDN
* -------------------------------------------------------------------------- */






/*============== INCLUDE LIBS ================== */

/* 3
* Подключение основной библиотеки моих функций
*/

/* Библиотека служебных сообщений te(), print_arr() и т.д. */
	get_template_part('tweeks/my-lib/echo');

/* Библиотека по работе со строками */
	get_template_part('tweeks/my-lib/url');


/* Функции по работе с очередями скриптов и стилей в WP */
	get_template_part('tweeks/my-lib/wp_deps');

/* Функции по работе с очередями скриптов и стилей в WP */
	get_template_part('tweeks/my-lib/ftp');


/* my-lib */
	get_template_part('tweeks/my', 'lib'); 
	

/* injector */
	get_template_part('tweeks/my-lib/ijector'); 


/* injector */
	get_template_part('tweeks/my-lib/sport'); 


/* content_replace */
	get_template_part('tweeks/my-lib/content_replace');
	
	
/* header_lib */
	get_template_part('tweeks/my-lib/header_lib');	


/* creat_modul_and_template */
	get_template_part('tweeks/my-lib/creat_modul_and_template');


/* Подключение класса bsTabs */
	get_template_part('tweeks/bootstrap_lib/BsTabs');


/* Подключение класса bsTabs */
	get_template_part('tweeks/header_functions');


/* Подключение класса для работы с FTP */
	//get_template_part('tweeks/my-lib/class_ftp');


/* Подключение класса для работы с FTP */
	get_template_part('tweeks/my-lib/class_my_ftp');


/* Подключение класса для работы с FTP */
/* Выдаёт детальную информацию и имеет форматы csv, html, xls, но работает медленно */
//	get_template_part('tweeks/my-lib/ftpcrawler');


/* Тестирование классов */
//	get_template_part('tweeks/my-lib/test_class');



/* Допуск на сайт по ip */

//$user_ip =  $_SERVER['REMOTE_ADDR'];
//echo $user_ip;

//$admins = array('195.91.246.209', '46.242.9.148','46.242.9.171');
//ip_access($admins);





get_template_part('tweeks/my-lib/get_dirs');  //Ломается сайт при отключении




/* 4
	Подключение библиотеки для sql запросов (требует пересмотра, для превращения её в CRUD) или заменые её на ORM
	CRUD C - Creat, R - Read, U - Update, D - Delete 
*/
//get_template_part('tweeks/sql', 'lib');



/*
* Подклбчение моделей по схеме роутинга (типа flex-box проекта)
*
*/
get_template_part('tweeks/router_models/projects');  



/* Скрипты сборки CSS и JS STACK */
	

		
	/* Удаление не нужных wp скриптов */
	get_template_part('tweeks/remove', 'wp_scripts');
	
		
	/* Контроль стилей и скриптов */
	//get_template_part('tweeks/mini/scripts', 'control');
	
	/* Удаление выбранных стилей и скриптов */
	//get_template_part('tweeks/mini/css_js', 'remove');





/* ==============END ===============/





/*	Библиотека поддержки Woocommerce (включается автоматически при активации woocommerce) 	
*	Добавляем новую константу, которая будет возвращать true, если WooCommerce включен		
*/

define( 'WPEX_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
if ( WPEX_WOOCOMMERCE_ACTIVE ) {
		
	/* 	Подключение поддержки и твиков woocommerce */
	get_template_part('tweeks/woocommerce', 'tweeks');


	/* Подклбючение библиотеки с проекта Кухни */
	//get_template_part('tweeks/special-project', 'lib');	
}	

/*============= END INCLUDE LIBS =============== */

/* Подклбючение action для проекта */
get_template_part('tweeks/project', 'actions');
get_template_part('tweeks/project', 'functions');
get_template_part('tests');



/* Подключение fields video slider */
get_template_part('tweeks/fields_Sliders/video_slider');
get_template_part('tweeks/fields_Sliders/foto_slider');


/* OMW INIT */


		
		$omw_path = __DIR__ .'/omw';
		include_once  $omw_path.'/observer/observer.php';
		include_once  $omw_path.'/manager/manager.php';
		include_once  $omw_path.'/worker/worker.php';
		add_action( 'wp_enqueue_scripts', 'observer', 99);		







/* Подключение загрузчика стилей и скриптов */
//add_action( 'wp_enqueue_scripts', function(){
//	include  get_stylesheet_directory().'/deps_loader.php';}, 99 );


//add_action( 'wp_enqueue_scripts', function(){
//	include  get_stylesheet_directory().'/deps_loader_oop_v2.php';}, 99 );



//add_action( 'wp_enqueue_scripts', function(){
//	include  get_stylesheet_directory().'/deps_loader_oop_v3.php';}, 99 );



add_action( 'wp_enqueue_scripts', function(){
		include  get_stylesheet_directory().'/deps_loader_oop_v4.php';
	}, 
	99);
	
	
	
/* Автозагрузка */
	$themePath = get_stylesheet_directory();
	$res = get_dirs($themePath.'/autoload');
	$res = abs2_url_for_get_template_part($res);

	foreach($res as $item){
		get_template_part($item);
	}

	
	
	
/*-----------*/

/* Загружаем фаил int, который грузит скрипты из load.txt в том случае если omw нет в системе */
//add_action( 'wp_enqueue_scripts', 'omw_check', 99);
//function omw_check(){	
//	if(__observer_in_system__ !== true){	
//		require_once  get_stylesheet_directory().'/int.php';		
//	}
//}



//require_once  __DIR__ . '/ftp_get_content.php';




/**
 * Изменить размеры миниатюр в похожих записях и в маленьких карточках постов
 */
add_filter( 'root_thumb_wide_sizes', 'root_thumb_wide_sizes_function' );
function root_thumb_wide_sizes_function() {
    return array( 300, 200, true );
}









/* По материалам:
https://dwweb.ru/page/php/function/015_php_zamenit_perenos_stroki_na_br.html#paragraph_1
*/

/* Определение пробела в коде */
	function EOL_detect(){
	
	
		$content_cfg = file_get_contents(get_stylesheet_directory().'/y_cfg.txt');		
		//print_arr($content_cfg, 'исходный контент в виде строки');	
		
		
		/* Удалим пустые строки в начале и в конце строки */
		$content_cfg = trim($content_cfg);		
		
		/* Удалим пробелы и табы */
		$content_cfg = str_replace(array(" ","	"), "", $content_cfg);
		
						
		$string = str_replace(array("\r\n", "\r", "\n"), "@@@", $content_cfg);
		echo htmlspecialchars($string);
			
	}	
	//EOL_detect();
/* End */












function read_json_settings($path){
	
	$file_path = get_stylesheet_directory().$path;
	
$array = Array(
		
		'modules_page' => Array(
				'page_1',
				'page_2', 
				'page_3' 
			),
				

			

);

print_arr($array);

/* Конвертация массиав в json формат */
$json = json_encode($array);

//file_put_contents($file_path, $json);

print_arr($json, 'json');


$content_cfg 	= json_decode(file_get_contents($file_path),true);
		
print_arr($content_cfg);
}

//read_json_settings('/json_cfg.json');



/*==============================================*/


/* 	Функция переписывающая cfg в json формат 
	берёт данные из cfg и создает фаил cfg_json в корне темы	
*/

function convert_cfg_to_json(){
	
	$cfg_array			= read_settings('/cfg.txt');  	
	print_arr($cfg_array);	
	
	$json = json_encode($cfg_array, JSON_PRETTY_PRINT);
	$filename = get_stylesheet_directory() .'/cfg_json.txt';
	
	file_put_contents ($filename, $json);

}





/* Подключаем фаил meta_field.php */
require __DIR__ . '/inc/project-functions.php';



/* END */


/* КЛАСС ДОБАВЛЕНИЯ МЕТА БОКСА */
/* по материалам: https://misha.blog/wordpress/meta-boxes.html */
class trueMetaBox {
	function __construct($options) {
		$this->options = $options;
		$this->prefix = $this->options['id'] .'_';
		add_action( 'add_meta_boxes', array( &$this, 'create' ) );
		add_action( 'save_post', array( &$this, 'save' ), 1, 2 );
	}
	function create() {
		foreach ($this->options['post'] as $post_type) {
			if (current_user_can( $this->options['cap'])) {
				add_meta_box($this->options['id'], $this->options['name'], array(&$this, 'fill'), $post_type, $this->options['pos'], $this->options['pri']);
			}
		}
	}
	function fill(){
		global $post; $p_i_d = $post->ID;
		wp_nonce_field( $this->options['id'], $this->options['id'].'_wpnonce', false, true );
		?>
		<table class="form-table"><tbody><?php
		foreach ( $this->options['args'] as $param ) {
			if (current_user_can( $param['cap'])) {
			?><tr><?php
				if(!$value = get_post_meta($post->ID, $this->prefix .$param['id'] , true)) $value = $param['std'];
				switch ( $param['type'] ) {
					case 'text':{ ?>
						<th scope="row"><label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label></th>
						<td>
							<input name="<?php echo $this->prefix .$param['id'] ?>" type="<?php echo $param['type'] ?>" id="<?php echo $this->prefix .$param['id'] ?>" value="<?php echo $value ?>" placeholder="<?php echo $param['placeholder'] ?>" class="regular-text" /><br />
							<span class="description"><?php echo $param['desc'] ?></span>
						</td>
						<?php
						break;							
					}
					case 'textarea':{ ?>
						<th scope="row"><label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label></th>
						<td>
							<textarea name="<?php echo $this->prefix .$param['id'] ?>" type="<?php echo $param['type'] ?>" id="<?php echo $this->prefix .$param['id'] ?>" value="<?php echo $value ?>" placeholder="<?php echo $param['placeholder'] ?>" class="large-text" /><?php echo $value ?></textarea><br />
							<span class="description"><?php echo $param['desc'] ?></span>
						</td>
						<?php
						break;							
					}										
					case 'textarea_big':{ ?>
						<th scope="row">
						<label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label>
						</th>
						<td>
							<textarea  wrap="off" rows="10" style="width:100%; font-size: 25px;" name="<?php echo $this->prefix .$param['id'] ?>" type="<?php echo $param['type'] ?>" id="<?php echo $this->prefix .$param['id'] ?>" value="<?php echo $value ?>" placeholder="<?php echo $param['placeholder'] ?>" class="large-text" /><?php echo $value ?></textarea><br />
							<span class="description"><?php echo $param['desc'] ?></span>
						</td>
						<?php
						break;							
					}					
					case 'checkbox':{ ?>
						<th scope="row"><label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label></th>
						<td>
							<label for="<?php echo $this->prefix .$param['id'] ?>"><input name="<?php echo $this->prefix .$param['id'] ?>" type="<?php echo $param['type'] ?>" id="<?php echo $this->prefix .$param['id'] ?>"<?php echo ($value=='on') ? ' checked="checked"' : '' ?> />
							<?php echo $param['desc'] ?></label>
						</td>
						<?php
						break;							
					}
					case 'select':{ ?>
						<th scope="row"><label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label></th>
						<td>
							<label for="<?php echo $this->prefix .$param['id'] ?>">
							<select name="<?php echo $this->prefix .$param['id'] ?>" id="<?php echo $this->prefix .$param['id'] ?>"><option>...</option><?php
								foreach($param['args'] as $val=>$name){
									?><option value="<?php echo $val ?>"<?php echo ( $value == $val ) ? ' selected="selected"' : '' ?>><?php echo $name ?></option><?php
								}
							?></select></label><br />
							<span class="description"><?php echo $param['desc'] ?></span>
						</td>
						<?php
						break;							
					}
					
					case 'textarea_editor':{  
							$args = array( 'wpautop' => 1  
								,'media_buttons' => 1  
								,'textarea_name' =>  $this->prefix.$param['id']//нужно указывать!  
								,'textarea_rows' => 15
								,'teeny ' => 1
								,'tinymce' =>  array('theme_advanced_buttons1' => '')
								,'quicktags' => array('buttons' => ' ')
							);  
							wp_editor( $value, $this->prefix.$param['id'] , $args );	
							echo '<br /><span class="description">'.$param['desc'].'</span>';
						break;}
					

				} 
			?></tr><?php
			}
		}
		?></tbody></table><?php
	}
	function save($post_id, $post){
		if ( !wp_verify_nonce( $_POST[ $this->options['id'].'_wpnonce' ], $this->options['id'] ) ) return;
		if ( !current_user_can( 'edit_post', $post_id ) ) return;
		if ( !in_array($post->post_type, $this->options['post'])) return;
		foreach ( $this->options['args'] as $param ) {
			if ( current_user_can( $param['cap'] ) ) {
				if ( isset( $_POST[ $this->prefix . $param['id'] ] ) && trim( $_POST[ $this->prefix . $param['id'] ] ) ) {
					update_post_meta( $post_id, $this->prefix . $param['id'], trim($_POST[ $this->prefix . $param['id'] ]) );
				} else {
					delete_post_meta( $post_id, $this->prefix . $param['id'] );
				}
			}
		}
	}
}




/* Подключение плагина carbon_fields */
require_once get_stylesheet_directory() .'/inc/carbon-fields/carbon-fields-plugin.php';

/* Подключение пользовательского фаила */
/* По материалам https://wp-kama.ru/plugin/carbon-fields */

add_action( 'carbon_fields_register_fields', 'crb_register_custom_fields' ); // Для версии 2.0 и выше
function crb_register_custom_fields(){
	// путь к пользовательскому файлу определения поля (полей), измените под себя

	require_once get_stylesheet_directory() . '/inc/custom-fields/complex-fields.php';	
}


//require_once get_stylesheet_directory() .'/yaml_test.php';

	

//подключить Yaml parser
require_once(get_stylesheet_directory() .'/inc/parserYaml/parserYaml.php');
	

	




//$new_page_id = 217;
//$custom_template_path = 'modules_page_folder/test_page_1/index.php';
//update_post_meta($new_page_id, '_wp_page_template', $custom_template_path);			
	
	
	

// Подключение bootstrap navwlker
if ( ! file_exists( get_stylesheet_directory() . '/tweeks/wp-bootstrap-navwalker.php' ) ) {
  // file does not exist... return an error.
 return new WP_Error( 'wp-bootstrap-navwalker-missing', __( 'It appears the wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
}else{
	
  // file exists... require it.
    require_once get_stylesheet_directory() . '/tweeks/wp-bootstrap-navwalker.php';
}




/* ФУНКЦИИ ДЛЯ УПРОЗЕНИЯ СБОРКИ КАРТОЧЕК ПОСТОВ */

function entry_meta_true($is_show_category, $is_show_comments, $is_show_views){
	
	
}



