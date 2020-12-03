<?php

/* 	Функция удаляет из массива элементы если в одной из папок их пути найден none-
	Либо если none- задан в начале имени фаила
*/
function none_filter($array_stack){										
			$theme_path = get_stylesheet_directory();										
				//print_arr($array_stack);					
				
				foreach($array_stack as $handle => $src){													
					/*	1. Удалим из него theme_path */
							$src = str_replace($theme_path,'',$src);									
					/*	2. Если в src будет найден "none-", то удалим его из стека */											
					if(strpos($src, '/none-') ){unset($array_stack[$handle]);} //end if																					
				}//end foreach
					
				//print_arr($array_stack, 'стек после none- фильтрации');
				return $array_stack;
}//end function 






/* Функция принимат простой нумерованный массив и возвращает ассоциативный массив
	делая в качестве ключа элемента, порядковый номер + имя фаила */
function assoc_handle($simple_array){	
	foreach($simple_array as $key => $src){										
				$handle = remove_gravity_index(pathinfo($src)['filename']);														
				$new_array[$key.'-'.$handle] = $src;						
				}
				
	
	return $new_array;
}


/* 	Функция получает стили css в виде массива
	где отдельно есть списки стилей для модулей и отдельно global stack
*/
function get_diff_style($current_state_structure){
	
		/* Вытаскиваем из current_state css модулей */
		$modules_page = $current_state_structure['modules_page'];			
		foreach($modules_page as $item){			
			$modules_css[$item] = $current_state_structure[$item];							
			$strem_modules_css[$item] = assoc_handle(abs2url(none_filter(array_merge($modules_css[$item]['base_css'], $modules_css[$item]['modules_css']))));					
				
			$min_files['min_files'][$item] = abs2url(__min_folder__ .'/'. basename($item).'.min.css');
		}

		//print_arr($min_files);
		//print_arr($strem_modules_css,'strem_modules_css');
	
			
		$global_stak['global_css'] = assoc_handle(abs2url(none_filter($current_state_structure['css_stack'])));
		$result_diff_modules = array_merge($global_stak, $strem_modules_css, $min_files);
	
		//print_arr($result_diff_modules);
		return $result_diff_modules;
	
}



function where_css_changed($current_state_structure){
	
		
		/* Путь до фаила в котором произошли изменения */
		$path 			= $current_state_structure['lastMod_css']['path']; //print_arr($path, 'в каком фаиле были изменния');		
		/* Получаем из общего массива список модулей */
		$modules_page 	= $current_state_structure['modules_page'];
	

		if(strpos($path, __css_stack_folder__) !== false){$where = 'global_stack';}
		else{								
		/* Определяем имя страницы в которой произошли изменнения в css */
		foreach($modules_page as $item){			
			if(strpos($path, $item)){$page_name = basename($item);};		
				}//end foreach
				$where = $page_name;
	
		}//end else
			
		
		return $where;
}


/* Определяем расположение всех min фаилов */

function set_min_css_path($modules_page, $type){
	
		$modules_page 	= array_values($modules_page); //print_arr($modules_page);
		$all_page 		= array_merge($modules_page, ['post', 'page']);	
		
		//print_arr($all_page, 'all_page');
		
		foreach($all_page as $item){								
			$min_path_file[basename($item)] = __min_folder__ .'/'.basename($item).'.min'.'.'.$type;
			//$page_names[] = basename($item); 				
			}	
		
		//print_arr($min_path_file);
		return $min_path_file;
		
}




/* 	
	Принимает на вход список имён элементов массива CFG
	в которых хранятся опциональные css и js:
	-	список модульных страниц
	- 	post
	-	page

	Достаёт из конфига опциональные настройки css или js из
	указанных в списке элементов.

	В зависимости от параметра $type, возвращает css или js
 */
function get_options_css_v2($page_list, $type){

		$cfg 			= read_settings('/cfg.txt');  	
		//print_arr($cfg, 'config');		
		//print_arr($page_list, 'page_list');
			
		foreach($page_list as $page_name){			
			$page_name = get_part_url($page_name);
			
			//print_arr($page_name);
			/* Если настройка для страницы существует */
			
			
			if($cfg[$page_name]){
				$cfg_settings[$page_name] = $cfg[$page_name][$type];		
			} 
			
			//end if
		
		}//end foreach	
		
		//print_arr($cfg_settings, "cfg_settings для $type");
		
	return $cfg_settings;
}




/* 	Функция принимает массив diff_dep 
	(стили из папок модулных страниц разделенные по страницам)
	и
	список нужных стилей их конфига
	
	Возвращает список найденных и не найденных фаилов
*/
	
function found_libs_v4($diff_dep, $cfg_settings){

		//print_arr($diff_dep, "стили из папок модульных страниц");
		//print_arr($cfg_settings, "конфиг");

		/* Требуемые библиотеки*/
		foreach($cfg_settings as $element){			
			//print_arr($element);
			if(is_string($element)){$element = array($element);} 
			//end if
			
					
			foreach($element as $item){
				if(!empty(trim($item))){
					$request_libs[] = $item;			
					}				
				}//end foreach							
			}//end foreach
		
		//print_arr($request_libs, "требуемые библиотеки");
		
			
		/* Блок проверки есть ли данный dep в папке options (frameworks) */
		$items_avaible = 
		remove_gravity_index(
			array_flip(
				assoc_handle(
					abs2url(
						none_filter(
							$diff_dep['options'])
							)
						)
					)
				);
		if(empty($items_avaible)){$items_avaible=array();}
			
		//print_arr($items_avaible, "items_avaible");	
		
		$found_libs		 	= array_intersect($request_libs, $items_avaible); 
		$not_found_libs 	= array_diff($request_libs, $items_avaible);	
		
		
		if($found_libs){foreach($found_libs as $lib){$res_found[$lib] = array_search($lib, $items_avaible);}}
		
	
		$result = array('found'=>$res_found,'not_found'=>array_values($not_found_libs));
		
		//print_arr($result, "Найденные и не найденные deps");		
		return $result;		
}//end function


/* Подключение фаила с функцией refresh_deps */
require_once __DIR__ . '/func_refresh_deps.php';





