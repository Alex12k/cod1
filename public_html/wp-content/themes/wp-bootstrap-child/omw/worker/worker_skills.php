<?php

/* Функция регистрации скриптов и стилей */
function item_registered($data){
	
	global $Files_stack_list;
	$Files_stack_list = $data;
	
	
	/* регистрации items */
	function registred_stack() {		
		global $Files_stack_list;
		
		//print_arr($Files_stack_list);
	
			foreach($Files_stack_list as $key => $value){
								
				$type =  pathinfo(array_values($value)[0])['extension'];						
				foreach($value as $fileName => $dir){
						
			
				$handle		= get_handle($fileName);
				$dir_file	= abs2url($dir);
				$deps = '';
				$ver = rand();
			
				if($type == 'css'){				
					$in_footer	= false;					
					wp_register_style($handle, $dir_file, $deps, $ver, $in_footer);}
		
		
				if($type == 'js'){							
					$in_footer	= true;			
					wp_register_script($handle, $dir_file, $deps, $ver, $in_footer);}

			
				} //end foreach				
			} //end foreach	
		} //end function



	/* Функция инициализации items */
	function enqueue_stack() {	
		global $Files_stack_list;
		
				foreach($Files_stack_list as $key => $value){
				
					$type =  pathinfo( array_values($value)[0])['extension'];
					foreach($value as $fileName => $dir){
			
						$handle		= get_handle($fileName);
						
				if($type == 'css'){	wp_enqueue_style($handle);	}
				if($type == 'js') {	wp_enqueue_script($handle);	}
		
				} //end foreach	
			} //end foreach
	} //end functtion

/*=============END STACK==============*/
	
/* Инициализация фаилов стилей и выбор режима */
	/* подключается после observer */
	add_action( 'wp_enqueue_scripts', 'registred_stack', 100 );
	add_action( 'wp_enqueue_scripts', 'enqueue_stack',100 );

}




function dequeue_style_manager(){	
 
	//te('(worker_skils): сработала функция dequeue_style_manager');
	
	global $plugin_items;
		
		
	$path = '/home/i/igpsya3i/109r.ru/public_html/wp-content/themes/subaru_transmission_v2/modules_g5v2/systems/observer/plugins_items.txt';
	$plugin_items = unserialize(file_get_contents($path));
	
	$css = $plugin_items;
	
	//print_arr($css, '(worker_skils): Из фаила plugin_current_state.txt получен список для отключения CSS');
	
	
	/* Если приходит переменная то делаем её массивом */
	if(!is_array($css)){$styleNames = array($css);}
	
	$css = array_keys($plugin_items);
	foreach($css as $item){	
		$handles[] = pathinfo($item)['filename'];	
	}
			
	wp_dequeue_style( $handles );
								
}






/* 	Функция принимает текстовый контент, ищет в нём некоторую неизвестную строку,
*	у которой известны начало и конец.
*	Поиск начинается с позиции start и заканчивая позицией end
*	Далее эта строка заменяется на строку замены $str_replace
*/
function content_replace($contents, $start, $end, $str_replace){
			
	/*Поиск и замена строки Template Name*/
	// Сколько знаков находится до начала первой строки
	$pos1 	= mb_stripos($contents, $start); 			//te($pos1);				
	
	// Сколько знаков находится до начала второй строки
	$pos2 	= mb_stripos($contents, $end); 				//te($pos2);			
	
	//Длинна искомой строки
	$length = $pos2-$pos1;  							//te($length);
		
	// Получаем строку начинающуюся с pos1 и заканчивающюуся на окончаннии pos2
	
	$string = mb_substr($contents, $pos1, ($pos2-$pos1) + mb_strlen($end));		//te($string);		

	$contents = str_replace($string, $str_replace, $contents);

	return $contents;
	
}
/* Functions END */



function custom_page_creator($modules_page){ 	
	
	print_arr($modules_page);

/* Если такие фаилы есть то создаём структуру папок */
	foreach($modules_page as $item){			
		
		/* 1. Создаём корневую папку проекта */
		te('создаём корневую папку проекта');
		
		/* Если константа существует и не пуста */
		if(defined('__modules_page_folder__'))	{
			$modules_page_folder = '/'.basename(__modules_page_folder__); 
		};
		$page_folder = get_stylesheet_directory().$modules_page_folder.'/'.$item;
				
				
		mkdir($page_folder);	te('создана папка по адресу:'.$page_folder);					
			
			
		/* 2. Переносим из банка фаил index.php и изменям его Template Name*/
		
		/* ftp конфиг */
		$cfg 			= ftp_config('main');
		/* Адрес до фаила с кодом в банке */
		$target_file 	= 'bank/php/modules/index.php';
		/* Контент фаила из банка */
		$content 		= ftp_get_contents($cfg, $target_file);
		
		/* Замена заголовка Template Name */
		$Template_Name	= $item; 
		$str_replace 	= "/* Template Name: {$Template_Name} */";	
		$start 			=	'/*';
		$end   			=	'*/';		
		
		$content_after_replace = content_replace($content, $start, $end, $str_replace);
				
		/* Создаём фаил index */
		file_put_contents($page_folder.'/index.php', $content_after_replace);		
		/* ------- END -------- */	
			
			
		/* 3. Создаём папку Modules */
		mkdir($page_folder.'/modules');

		
		/* 4. Создаём папку base_css и фаил base.css */
		mkdir($page_folder.'/base_css');
		file_put_contents($page_folder.'/base_css/base.css', '/* Базовые стили для всех модулей */');
	
	
	}//end foreach
}//end function




/* Функция забирает указанный subject из банка и помещает в указанное место */

function get_from_bank($target_file, $project_folder, $file_name){
	
		/* ftp конфиг */
		$cfg = ftp_config('main');
	
		/* Контент фаила из банка */
		$content 		= ftp_get_contents($cfg, $target_file);
		if($content){
			
			$project_path = $project_folder.'/'.$file_name;
		
			/* Создаём папку $project_folder если не создана */
			mkdir($project_folder);
		
			/* Создаём фаил index */
			file_put_contents($project_path, $content);
				
			//print_arr($project_path, 'путь для записи фаила');
			//print_arr($content, 'контент');
			
			
		}else{	
			
			echo "<h1 style='color:red; text-align: center;'>
					WORKER-ALERT: Фаил $file_name НЕ НАЙДЕН В BANK ИЛИ НАЙДЕН НО ПУСТ
				</h1>";
			echo "<script>alert(`Фаил $file_name НЕ НАЙДЕН В BANK ИЛИ НАЙДЕН НО ПУСТ`);</script>";
						
		}
		
		
	
	
}


/* Функция создаёт post или page
	можно назначить кастомный шаблон
	либо оставить поле пустым, тогда назначится default шаблон
*/

function creat_page_or_post($data){
	
	//print_arr($data, 'data');
	
	if(defined('__modules_page_folder__'))	{
			$modules_page_folder = basename(__modules_page_folder__); 
	};
	
	$theme_path = get_stylesheet_directory();		
	//te(__modules_page_folder__);	
		
	foreach($data as $page_name){
		
		$custom_template_path = $modules_page_folder.'/'.$page_name.'/index.php';
		//print_arr($custom_template_path);

    //не меняйте код ниже, если вы не знаете, что делаете
	$page_check = get_page_by_title($new_page_title);
    $new_page = array(
        'post_type' => 'page',
        'post_title' => $page_name,
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => 1,
    );
	
	
    if(!isset($page_check->ID)){
        $new_page_id = wp_insert_post($new_page);
        
		if(!empty($custom_template_path)){			
			update_post_meta($new_page_id, '_wp_page_template', $custom_template_path);			
			}//end if	

		}//end if
	}//end foreach	
} //end function




/* 
* 	Функция удаляет из текста коментарии и пробелы и возвращает min контент
*	используется в worker
*/	
function mini_css($contents){
	
	//Remove comments
		$contents = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $contents);	
	// Remove tabs, spaces, newlines, etc...
		$contents = str_replace(array("\r", "\n", "\t", '  ', '   '), '', $contents);

	return $contents;
}


















