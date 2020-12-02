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



/* Функция забирает из CFG настройки опционально подключаемы css стилей */

function get_options_css($current_state_structure){

		$cfg 			= read_settings('/cfg.txt');  	
		//print_arr($cfg, 'config');		
		
		/* Блок получения списка опциональных css из конфига */
		$page_list = $current_state_structure['modules_page'];			
				
		/* Так же будем достававть настройки по ключам post и page*/
		$page_list = $page_list + array('post', 'page');
			
		//print_arr($page_list, 'page_list');
		
		
		foreach($page_list as $page_name){			
			$page_name = get_part_url($page_name);
			
			/* Если настройка для страницы существует */
			if($cfg[$page_name]){
				$cfg_settings[$page_name] = $cfg[$page_name];		
			}
		}		
		//print_arr($cfg_settings, 'cfg_settings');
		
	return $cfg_settings;
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
		
		//print_arr($cfg_settings, 'cfg_settings');
		
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


/* 	Огромноая комплексная функция перезаписывающая 
	CSS и JS фаилы а так же их min версии для с распределением 
	по страницам 
*/
function refreash_deps($type, $current_state_structure){
		 		
				
	/* СБОР ДАННЫХ О ТОМ ЧТО НАДО БУДЕТ ПОДКЛЮЧИТЬ */

	/*Получаем все стили из GLOBAL, СТРАНИЦ и их МОДУЛЕЙ */		
		$diff_deps 		= request_to_array_diff($type);	
		//print_arr($diff_deps, 'diff_deps');	
		
	/*-----END-----*/
		
	/* Получаем из КОНФИГА все ОПЦИОНАЛЬНЫЕ СТИЛИ */						
		$option_elements = $current_state_structure['modules_page']
		+ array('post', 'page');
	
		$cfg_settings 	= get_options_css_v2($option_elements, $type); 
		//print_arr($cfg_settings, 'Требуемые опциии из CFG');
	
	/* END */
		
		
				
	/* ПОИСК И ЗАГРУЗКА ОТСУСТВУЮЩИХ СТИЛЕЙ */
		
		$found_libs_res = found_libs_v4($diff_deps, $cfg_settings);
		//print_arr($found_libs_res, 'найденные библиотеки');
		
		/* Если библиотека не найдена просим worker загрузить её из банка */
		$not_found = $found_libs_res['not_found'];
		
		
		if($not_found){						
			foreach($not_found as $item){			
				//te("не найдена библиотека $type - $item");
				
				worker('get_css_file_from_bank', 
					array(
						'filename' 		=>	$item, 
						'type'			=>	$type,				
						)						
						);
				
			}//end foreach
		
		}//end if
	
	/* END */
	




	/* ФОРМИРОВАНИ МАССИВА ДЛЯ ОТПРАВКИ В LOADER */

		/* Определим какая из найденных библиотек к какой странице относится */
		
		//print_arr($found_libs_res['found'], 'найденые либы');
		//print_arr($cfg_settings, 'настройки из конфига');
		
		
		foreach($found_libs_res['found'] as $name => $src){									
			
			
			foreach($cfg_settings as $page_name => $settings){								
								
				if(isset($settings)){			
					if(is_string($settings)){$settings = array($settings);};																				
						$res = array_search($name, $settings);									
						if($res !== false){						
							$page_options[$page_name][$type][$name] = $src;						
							}			
						}							
				} //end foreach									
				
		}// end foreach
	
		//print_arr($page_options, 'Распределенные по страницам Опции');
				
			
		
		/* Добавление в массивы страниц стили из их дочерних папок */
		
		/* Название папки с модульными страницами */
		$modules_page_folder = get_part_url(__modules_page_folder__);
		
				
		/* Добавляем в массив пустые элементы для post и page */
		$diff_deps = $diff_deps+array('post'=>array(),'page'=> array());	
		
		//print_arr($diff_deps, 'diff_deps');
		
		
		//print_arr($option_elements, 'options_element');
		//print_arr($diff_deps);
		
		/* Оставляем в массиве только модульные страницы page и post */
		foreach($option_elements as $key){
			$pages_and_posts[$key] = $diff_deps[$key];
		}	
		
		
		//print_arr($pages_and_posts);
		foreach($pages_and_posts as $page_name => $files){

			//te($page_name);
			//print_arr($files);
	
									
			/* смотрим есть ли какие то опции для текущей в цикле страницы */
			//print_arr($page_options, 'options');
			
			$page_name	= get_part_url($page_name);  //te($page_name, 'page_name');
			$options	= $page_options[$page_name][$type];				
			
			
			if(!$options){$options = array();}																	
					
			if($page_name != 'post' && $page_name != 'page'){	
					$options_and_folder_deps[$modules_page_folder.'/'.$page_name] = array_merge(	
									array(	'options'	=>abs2url(none_filter($options))), 							
									array(	'page_'.$type	=>assoc_handle(abs2url(none_filter($files))))																	
									);
				}else{
					
					
					/* В случае если это простая страница или простой пост */
					$options_and_folder_deps[$page_name] = array_merge(	
									array(	'options'	  =>abs2url(none_filter($options))),
									array(	'page_'.$type => [] ),
									);					
				}//end else		
					
		
				
		}//end foreach
		//print_arr($options_and_folder_deps,'OPTION + стили из дочерних папок');	



		/* Добавляем в массив Global STACK, но исключаем из Global Stack папку frameworks */

			
		$global_stack['global_stack'] = assoc_handle(abs2url(none_filter($diff_deps['global_stack'])));						
		if(!$global_stack['global_stack']){$global_stack['global_stack'] = [];}
		//print_arr($global_stack, 'global_stack');
		
		$replace_global_stack 	= array_replace($diff_deps, $global_stack);		
		//print_arr($replace_global_stack, 'replace_global_stack');
		
		$new_data 				= array_replace($replace_global_stack, $options_and_folder_deps);		
		//print_arr($new_data, 'new_data');
		
		unset($new_data['options']);
	
	
		//print_arr($new_data, 'данные для отправки в loader.Php');				
		
		
			
		/* Определяем пути для всех min фаилов и добаляем в массив для отправки в loader*/
		$min_path_array = set_min_css_path($current_state_structure['modules_page'], $type);  
		//print_arr($min_path_array, 'set_min_css_path');
				
		$data_for_loader = array(	$type.'_stack'		=>	$new_data,
									$type.'_min_files'	=>	abs2url($min_path_array)								
									);
				
		//print_arr($data_for_loader, '+ min_path');
			
			
		/* Сохраняем */	
		re_save2(__loader_data_file__, $data_for_loader); 
		
		
		
		/* На этом моменте, loader располагает информацией о всех подключаемых стилях
		их последовательностях и путях для их min фаилов */
		/*====== END Блок записи в load.txt =====*/
	



	
	/* ОПРЕДЕЛЕНИЕ КАКИЕ MIN ФАИЛЫ НУЖНО ПЕРЕЗАПИСЫВАТЬ */
		
		//print_arr($current_state_structure);
		$where 		= key($current_state_structure['lastMod_'.$type]);
		$file_name	= key(current($current_state_structure['lastMod_'.$type]));
		//print_arr($file_name);
		
		
		//print_arr($where, "где были изменения");
		
		
		/* Если изменения в глобальном стеке то перезаписываем все min фаилы*/	
		if($where=='global_stack'){				
			/* Определяем пути для всех min фаилов */
			$min_path_file = $min_path_array;			//print_arr($min_path_array, 'пути к мин фаилам');			
			$page_names = array_keys($min_path_file);	//print_arr($page_names,'имена страниц');					
		}	
		
		
		/*  Если изменения в options то перезаписываем
			min фаилы тех страниц к которым они подключены
		*/			
		if($where=='options'){				
			/* Определяем пути для всех min фаилов */
			te('------');
			//print_arr(get_handle($file_name), "Имя измененного фаила");
			
			
			/* 
			Нужно узнать список страниц к которым подключен мин фаил с данным именем
			*/				
			foreach($cfg_settings as $key => $array_deps){
				if(is_string($array_deps)){$array_deps = array($array_deps);}//end if
					
				foreach($array_deps as $name){
					if($name == get_handle($file_name)){$pages[] = $key;}				
				}//end foreach			
			}//end foreach
				
			//print_arr($pages, 'имена страниц требующи обновления min');
			/*end список страниц в переменной pages */
			
			
			/* Сформируем массив путей и имён фаило требующих обновления min */
			foreach($pages as $name){				
				$min_path_file[$name] = $min_path_array[$name];				
			}
													
			$page_names = array_keys($min_path_file);	
							
		}	
			

					
		/* Если изменения в папках мудльных страниц
		то перезаписываем min фаил конкретной страницы */
			
		if($where!='global_stack' && $where != 'options'){			
			$min_path_file[basename($where)] = __min_folder__ .'/'.basename($where).'.min.css';		
			$page_names[] = basename($where);
		
		}
		
		//print_arr($min_path_file, 'пути к мин фаилам требующим обновления min');
		//print_arr($page_names,'имена страниц');	
		
	
		/* END определение перезаписываемых MIN */

		
		
		/* МОДУЛЬ ПЕРЕЗАПИСИ MIN ФАИЛОВ */
		
			$global_deps  		= $new_data['global_stack']; 
			//print_arr($global_deps,  'GLOBAL_DEPS');
			//print_arr($page_options, "page_options для $page_name");
		 
		/* page_name массив страниц требующих обновления min */
		foreach($page_names as $page_name){
					
			$page_deps			= $new_data['modules_page_folder/'.$page_name]['page_'.$type];	
			//print_arr($page_deps, "DEPS для $page_name");		

						
			if($page_name != 'post' && $page_name != 'page'){				
				$page_options 		= $new_data['modules_page_folder/'.$page_name]['options'];
				if($page_options==NULL){$page_options = array();}
				//print_arr($page_options, "page_options для $page_name");								
				$modul_data_deps[$page_name] 	= array_merge($page_options, $global_deps, $page_deps);		
			}else{
				/* В случае если это простая страница или простой пост */
				$page_options 		= $new_data[$page_name]['options'];
				if($page_options==NULL){$page_options = array();}
				//print_arr($page_options, "page_options для $page_name");
				$modul_data_deps[$page_name] 	= array_merge($page_options, $global_deps);		
			}
		
		}//end foreach
			
		
	if($type == 'js'){
		/* Пересобираем массив таким образом, чтобы jQuery была на первом месте */		
		foreach($modul_data_deps as $key_1 => $value){				
			
			foreach($value as $key => $item){				
				if($key != '0-jquery-core'){
						$array[$key]=$item;				
					}else{
						$arrayJQ[$key]=$item;
					}
				}// end foreach			
			$jq_n1_array[$key_1] = array_merge($arrayJQ, $array);
		}//end foreach
				
		/* end */		
		unset($modul_data_deps);
		$modul_data_deps = $jq_n1_array;	
		//print_arr($modul_data_deps, "ОБЪЕДИНЕННЫЙ СТЕК ПЕРСОНАЛЬНЫЙ ДЛЯ СТРАНИЦЫ ".$where);
		/* end */
	} // end if

		
		$data = array(
			'path' 	=> $min_path_file,
			'files' => $modul_data_deps,
			'class_jsmin_path'		=>	__class_jsmin_path__
		);		
		//print_arr($data, 'Данные на минимизацию');		
				
		if($type =='css'){$command = 'update_css_content';}
		if($type =='js') {$command = 'update_js_content';}		
		worker($command, $data);

}// END FUNCTTION REFRESH DEPS




