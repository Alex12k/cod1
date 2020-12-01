<?
/* Подключение стилей */



//function my_csripts() {
	
/*	
	$deps = array(
					'super.min',
					'wp-block-library',
					'google-fonts',
					'root-style',
					'root-style-child'
				);
*/


/* Как поставить стиль в очередь */

			/*
				$handle = 'TEST-STYLE';
				
				$dir_file = get_stylesheet_directory().'/test-style.css';			
				
				$deps	=	'';
				
				$ver = '';
				$in_footer = false;
				
				
				wp_register_style($handle, $dir_file, $deps, $ver, $in_footer);		
				wp_enqueue_style($handle);
			*/
		//}    
		
	
		
		//add_action( 'wp_enqueue_scripts', 'my_csripts', 1 ); 	










//================================================================================================
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//Для стилей, а также скриптов предусмотрен специальный захват действия Wordpress. 
//Эти крючки будут запускаться после каждого script или стиля в очереди:




/* Просмотр JS скриптов в очереди*/
function inspect_registered_scripts() {
    global $wp_scripts;
	$scripts = $wp_scripts->registered;

	print_arr($scripts);

}
//add_action( 'wp_print_scripts', 'inspect_registered_scripts' );


/* Просмотр JS скриптов в очереди*/
function inspect_queue_scripts() {
    global $wp_scripts;
	$scripts = $wp_scripts->queue;

	print_arr($scripts);

}
//add_action( 'wp_print_scripts', 'inspect_queue_scripts' );








function inspect_styles() {
    global $wp_styles;
	$styles = $wp_styles->queue;
	
	print_arr($styles);

}
//add_action( 'wp_print_styles', 'inspect_styles' );






//=================================================================================================	
	


// ПОЛУЧЕНИЕ МАССИВА ДАННЫХ CSS INFO

//add_action( 'wp_enqueue_scripts', 'show_footer_deps', 9999);
function show_footer_deps(){

	global $wp_styles;
	global $wp_scripts;


	// Страница на которой удаляются стили
	$action_page = 85;
	
	// Массив разрешенных к загрузке стилей
	$True_style = array(
			 
			//'wp-block-library'
	);
	
	
	// Массив разрешенных к загрузке скриптов
	$True_script = array(
			 
			//'jquery'
	);
   	
		
	/*Список всех зарегистрированных стилей. По материалам */
	/* https://coderun.ru/prostye-otvety/poluchit-spisok-zaregistrirovannykh-skriptov-i-stilejj-v-wordpress/ */	
	$Styles_registered = $wp_styles->registered; //Список зарегистрированных скриптов
	//foreach($Styles_registered as $key => $value){ $i++ te($key);}
	
	
	
	$Styles_queue = $wp_styles->queue; 		//Очередь handle подключенных стилей
	$Scripts_queue = $wp_scripts->queue; 	//Очередь handle подключенных скриптов	
		
		
	//print_arr($wp_styles);
	
	//print_arr($Scripts_queue);
		
		
	if(is_page($action_page)){
		
		foreach($Styles_queue as $style) {			
			if(!in_array($style, $True_style)){wp_deregister_style($style);}				
		}
	
	
	
		foreach($Scripts_queue as $script) {	
			if(!in_array($script, $True_script)){wp_deregister_script($script);}	
			
		}
		
	}

}
























