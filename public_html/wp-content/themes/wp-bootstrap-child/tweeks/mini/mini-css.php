<?php


//=== ОПРЕДЕЛЕНИЕ ОСНОВНЫХ ПЕРЕМЕННЫХ ДЛЯ РАБОТЫ ===/
$theme_path = get_stylesheet_directory();								//Абсолютный путь до темы

$dir_css_stack 	= $theme_path.'/css-stack/';							// Путь до папки css-stack

$dir 			= '/css-stack/stack';									//Путь к папке где лежит комплект CSS фаилов				
$dir_min_folder	= $theme_path.'/css-stack/min/';						//Путь к папке куда будем сохранять min фаил
$name_min_file	= 'super.min.css';										//Название min фаила
$url_min_css 	= $dir_min_folder.$name_min_file;						//Путь к min фаилу

$table_name 	= 'css_disable';										//Имя таблицы со списком фаилов в БД	
$dir_time_log 	= $theme_path.'/tweeks/mini/time_log.txt'; 				//Путь до фаила с временем обнавления таблицы БД

	
//=== END ===/



/*#1
* Получаем данные о фаилах лежащих в папке по пути $dir
*
*/	

//$Files_list = list_folder($dir);		//print_arr($Files_list);

$Files_list = get_dirs($theme_path.$dir);	//print_arr($Files_list);




//Глобализируем массив чтобы он был виден в Function.php (чтобы его мог видеть ispect_scripts.php)
global $Files_name; 

$Files_name 	= (array_keys($Files_list));				//print_arr($Files_name);
$Files_handle 	= ubrat_rashirenie_in_array($Files_name);	//print_arr($Files_handle);
$Files_url		= array_values($Files_list);				//print_arr($Files_url);


//add_action( 'wp_print_styles', 'inspect_styles_queue');





/*#1.2
* Запишем список фаилов в специально созданную таблицу в БД и присвоим кажому фаилу атрибут со значением ON
*
*/	


require_once $theme_path.'/tweeks/mini/sql-list.php';


/* Если в get запрос приходит переменая css-control, загружаем страничку css-control и exit() */
if (isset($_GET['css-control'])) { 
	get_template_part('tweeks/mini/css', 'control');
	exit(); 
};



/* #2
* Получаем время последней модификации фаила min.css
*
*/	
//$lastmodified = 0;
$lastmodified = last_mod ($Files_url);
	



$time_nabor = date ("F d Y H:i:s", $lastmodified);
$time_min = date ("F d Y H:i:s", filemtime($url_min_css));

//te("в последний раз файл фаил из набора был изменен: " . $time_nabor);
//te("в последний раз файл super.min.css был изменен: " . $time_min);
//if( $time_nabor < $time_min ) {te("Фаил из набора модифицировался раньше, чем min.css , значит min.css актуален"); }



/* 
* Если min.css НЕ существует или НЕ актуален или $start = go
*	
*/	

$time_log = date ("F d Y H:i:s", filemtime($dir_time_log));

//te("в последний раз файл super.min.css был изменен: " . $time_min);
//te("в последний раз таблица БД был изменена: " . $time_log);


/* Если $time_log старше чем $time_min , то запускаем скрипт */

$start = '';
if ( !file_exists($url_min_css) || $lastmodified > filemtime($url_min_css) || $time_log > $time_min || $start == 'go' )	{
	
	
	//echo "Фаил не существует , или НЕ актуален или START = GO<br/>";
	info_message("Включаю ПЕРЕЗАПИСЬ <b>MIN.CSS</b> ФАИЛА <br/>");	

/* #3
* Формируем массив разрешенных к загрузке фаилов со статуом ON
*	
*/	
	
	$ON_styles_list = ON_styles_list();
	//print_arr($ON_styles_list);

				
	
/* #4
* Записываем весь контент из списка Handle разрешенных фаилов ($ON_styles_list) в переменную $content
* Функция принимает на вход, список разрешенных имен фаилов и абсолютный путь до папки где они лежат
*/		

	$contents = get_on_file_contents($ON_styles_list, get_stylesheet_directory().$dir);
	
	
		
/* #5
* Удаляем из собранного CSS кода комментарии и пробелы.
*/	
	
	$contents = mini_css($contents);
	




/* #6
* Создаем папку css-stack в которой будем хранить две папки:
*	- stack 	для нарезанных фаилов которые потом минимизируются в min
*	- min 	 	для сжатого фаила и
*	
* 	Создаём папку stack
*	Создаём папку min
*/

	//$dir_min_folder = Путь к папке где будут храниться сжатые фаилы		
	//print_arr($dir_min_folder);	
	creat_folder($dir_css_stack);
	creat_folder($theme_path.$dir);
	creat_folder($dir_min_folder);
	
	
/*
* Записываем min фаил в папку
*/		
					
			$dir_file = $dir_min_folder.$name_min_file;
			
		file_put_contents($dir_file, $contents); // EEEEEEEEEEEE!!!!!!!!!!!!!!
	
} 
else { 
	//echo "Фаил существует и актуален, всё в порядке, ничего не делаем. <br/>"; 
}/* END ELSE */	




//  Теперь зарегистрируем min.css и далее поставим его в очередь.

		//Возьмем путь до папки где лежит min.css			
		$dir_file = get_stylesheet_directory_uri().'/css-stack/min/'.$name_min_file;
		
	
		
		//Уберём расширения для формирования $handle
		$handle = preg_replace('/\.\w+$/', '', $name_min_file);
		 
		
		//Зарегистрируем фаил и сформируем очередность загрузки.

		/*
		$Ochered = array(	
							'dashicons', 
							'admin-bar', 
							'wp-block-library', 
							'woocommerce-layout', 
							'woocommerce-smallscreen', 
							'woocommerce-general', 
							'woocommerce-inline', 
							'google-fonts',
							'berocket_aapf_widget-style',
							'font-awesome',							
							'root-style', 
							'root-style-child',
							);
		
		*/
		
		
		$Ochered = array(
			'dashicons',
			'admin-bar',
			'google-fonts',
			'root-style',
			'root-style-child'	
		);
	
		

		
		wp_register_style( $handle, $dir_file, $Ochered );  //В array указываем стили которые хотим подключить до данного стиля
		
		//Поставим фаил в очередь
		wp_enqueue_style( $handle,'','','',true );			
			
			







/* Задачи на продолжение работы:

	1. Прибраться в фаилах, подумать о логике распределения кодоа о областях видимостии названиях переменных
	2. Добавить функцию перезаписи min.css фаила в случае если фаил из папки Stack был удален
*/




