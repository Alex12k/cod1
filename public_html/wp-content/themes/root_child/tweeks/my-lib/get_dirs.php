<?php

/* НОВЫЕ ФУНКЦИИ */

/* #1
* Функция принимает 4 параметра ($path (абсолютный путь к директории) и $type (тип того что ищем), 
*	и deep (на какой глубине будем искать)
*	если deep = 1 	ищем в текущей директории
*	если deep = 2 	ищём только в следующей директории
*	если deep = 3	ищём только в директории третьего уровня
*	если deep = all ищём во всех директориях до третьего уровня	
*	если deep не указан, то по умолчанию он равен All   
*
*	Если в Type указано расиширение фаила , .css или .php или люое другое. То будут искаться только фаилы с этим расширением
*	Если указан параметр " fold " то будут искаться только папки
*	Если ничего не указано, то будут выведены все папки и все фаилы
*/

function get_dirs( $path = '.', $type = '', $deep='', $type_array = ''){
	
	
	/* Если директория по указанному не существует, то вернуть пустой массив */
	if(!is_dir($path)){return array();}
	
	
	if($deep==''){$deep='all';};
	
	if($type=='fold'){
		$type =  '';
		$subject = GLOB_ONLYDIR;
			}


if($deep == 1) {	
	/* Сканируем до первого уровня вложенности (только текущий каталог) */
	$result = glob( 
		'{' . 	
		$path . "/*$type," .			# Текущий каталог			
		'}', GLOB_BRACE + $subject );  	#Возвращать только папки
}


if($deep == 2) {
	/* сканируем только каталог второго уровня */
	$result = glob( 
		'{' . 			
		$path . "/*/*$type," .			# На Один Уровень Ниже				
		'}', GLOB_BRACE + $subject );  	#Возвращать только папки
}


if($deep == 3) {
	/* сканируем только каталог третьего уровня */
	$result = glob( 
		'{' . 		
		$path . "/*/*/*$type" .			# На два уровня ниже		
		'}', GLOB_BRACE + $subject );  	#Возвращать только папки
}


if($deep == 4) {
	/* сканируем только каталог третьего уровня */
	$result = glob( 
		'{' . 		
		$path . "/*/*/*/*$type" .			# На три уровня ниже		
		'}', GLOB_BRACE + $subject );  	#Возвращать только папки
}


if($deep == 5) {
	/* сканируем только каталог третьего уровня */
	$result = glob( 
		'{' . 		
		$path . "/*/*/*/*/*$type" .		# На четыре уровня ниже		
		'}', GLOB_BRACE + $subject );  	#Возвращать только папки
}

if($deep == 6) {
	/* сканируем только каталог третьего уровня */
	$result = glob( 
		'{' . 		
		$path . "/*/*/*/*/*/*$type" .	# На пять уровней ниже		
		'}', GLOB_BRACE + $subject );  	#Возвращать только папки
}




if($deep == 'all') {
	/* сканируем все каталоги до третьего уровня */
	$result = glob( 
		'{' . 	
		$path . "/*$type," .				# Текущий каталог		
		$path . "/*/*$type," .		   		# На Один Уровень Ниже		
		$path . "/*/*/*$type," .			# На два уровня ниже
		$path . "/*/*/*/*$type," .			# На три уровня ниже
		$path . "/*/*/*/*/*$type," .		# На четыре уровня ниже
		$path . "/*/*/*/*/*/*$type" .		# На пять уровней ниже	
		'}', GLOB_BRACE + $subject );		#Возвращать только папки
}


/* Если переменная $result не была определена, то делаем её пустым массивом */
if(!isset($result)){$res = array();}

/* Если $type_array = simple_array то возвращаем простой индексированный массив */
if($type_array == 'simple_array'){ return $result; }



/* Переведем $result в индексированный массив, где key-название фаила, а $val - url фаила */
foreach ($result as $item){	
				
		$item_arr = explode('/', $item);							
		$last_part = $item_arr[count($item_arr)-1];
				
		//$modul_name = $item_arr[count($item_arr)-3];	
		$res[$last_part] = $item;
}

/* Если переменная $res не была определена, то делаем её пустым массивом */
if(!isset($res)){$res = array();}

return $res;

}//end function




/* 	#2 Функция предшественник get_dirs (возможно нигде не используется)
*	Функция list_folder принимает в качестве параметра относительный url папки вида '/wp-content/themes/root_child/js', 
*	возвращает в виде двумерного массива список фаилов находящихся в папке и список абсолютных URL адресов к этим фаилам.
*   Доступ к данным:
*	$list_folder[name]	=> список именов
*	$list_folder[url]	=> список абсолютных url
*/
function list_folder($dir) {

	//global $Files_list;
	
	//$ABSPATH =  $_SERVER['DOCUMENT_ROOT'];  // Путь до папки public_html
	$dir =  get_stylesheet_directory().$dir;				// Путь до папки в которой будем искать стили	
	$skip = array('.', '..');
	$files = scandir($dir);	
	natsort($files);		
	
	foreach($files as $file) {	
		if(!in_array($file, $skip))        
						
			$Files_list['name'][] = $file;
				
		} 
		
		
	foreach($files as $file) {	
		if(!in_array($file, $skip))   
		
		$Files_list['url'][] = $dir.$file;
	}
		
		return $Files_list;

	}





/* ----------------------------*/

/* 	Схожие функции которые не используется в текущей реализации OMW 
* 	Уточнить
* 	Вспомогательная функция, вызывыющаяся при определении элементов финального массива 
*	в функции get_structure_project 
*  	Получает на вход, массив с URL-адресами
*	и возвращает массив с вложенными в них в папками и фаилами
*/	
	function get_child($child_url){
			
		if(is_string($child_url)){$child_url=array($child_url);}
		
		foreach($child_url as $item){			
			
			$template_name = get_part_url($item);					
			$result[$template_name] = get_dirs($item);			
			
			
			
			}; //end foreach	
			return $result;	
	}//end function



/* 	Функция принимает абсолютный путь $path к папке, структура которой будет изучаться 
*	Возвращает массив со структурой катологов и фаилов
*/
function get_structure_project($path){
		
	/* 
		1. Определение корневой папки с моделями 
			- Массив с папками на первом уровне вложенности по пути $path
		
		2. Определение самих моделей, они же пункты LI в выпадающем меню ($model_name)
			-Дай мне второую папку после папки models
			
		3.  Определение данных о php фаилах моделей
			
		4.  Сборка финального массива со структурой		
	*/

	
	/* Получаем массив url корневых папок */
	$project_urls = get_dirs($path,'fold',1);

	


	/* Сборка финального массива */	
	foreach($project_urls as $parent_url){
						
		$result_array[get_handle($parent_url)] = array( 	
											"URL" 				=> $parent_url,																					
											"child_file"		=> get_dirs($parent_url,'.*',1),											
											"child_folder" 		=> get_child( get_dirs($parent_url,'fold',1) ),		
										);	
	};
	
	
	return $result_array;

} //end function















