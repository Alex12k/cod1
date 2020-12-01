<?php

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
		
		
		//$current_state_structure['modules_page'] = array_values($current_state_structure['modules_page']);	
		$option_elements = array_merge($current_state_structure['modules_page'] ,array('post', 'page'));
	
		//print_arr($option_elements);
		
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
				
				worker('get_file_from_bank', 
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
		
		//print_arr($pages_and_posts, 'pages_and_posts');
		
		//print_arr($pages_and_posts, 'pages_and_posts');
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
