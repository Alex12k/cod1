<?php
/* PLUGIN CONTROLLER (Основная функкция обёртка) */			
	function plugin_controller(){		

		$plugins_event = plugins_event_controller();	
		//print_arr($plugins_event, 'plugins_event: result');
			
		/* Если нет фаила db, то в переменной будет TRUE */	
		$is_not_file_db = !is_file(__DIR__ .'/data_base.txt');	
				
		/* Механизм обнаружения активных плагинов с зависимостями */
		$active_plugins 			= show_active_site_plugins();
		$data_base 					= array_keys(unserialize(file_get_contents(__DIR__ .'/data_base.txt')));
		$active_plugins_with_deps 	= array_intersect($active_plugins, $data_base);	
		/* end */
		
		//print_arr($active_plugins,'active_plugins');
		//print_arr($data_base,'data_base ');
		//print_arr($active_plugins_with_deps,'active_plugins_with_deps');
		
		
		/* В переменной будет TRUE если обсервер ничего не знает о plugins_deps */
		$obs_data = read_state()['plugins_deps'];
		$not_isset_observer_data 	= !isset($obs_data);
		if(	empty($obs_data['css']) && empty($obs_data['js'])){	$empty_observer_data = true;}
		
		
					
		if(
		(!empty($active_plugins_with_deps) && $not_isset_observer_data) ||
		(!empty($active_plugins_with_deps) && $empty_observer_data)		|| 
		$is_not_file_db){			
			//te('Есть плагины с зависимостями и элемент массивва с данными в obs отсутсвует');
			//te('Есть плагины с зависимостями и но элемент массива в obs пуст');
			//te('Или отсутсвует фаил data_base.txt');
			$need_start = true;			
		}
		
		
			
		/* Если плагин добавился или убавился */
		if($plugins_event || $need_start){
					
			/* Получаем информацию о dependancy активных плагинов */
			/* Функция сопоставляет информацию о плагинах в Data_base с новым активированным или деативированным плагином */
			$plugins_data 		= active_plugins_deps_info(); 	//print_arr($plugins_data, 'active_plugins_with_dep');
		
		
			/* Добавляем информацию о плагине в DB если у плагина есть Deps*/
			add_action('wp_footer','plugin_dependency_information');
				
			/* объединяем информацию в единый поток css или js фаилов и собираем информацию в массив $plugins_deps */
			$plugins_deps = array(	'css' 	=> 	request_to_array_deps($plugins_data, 'css'),
									'js'	=>	request_to_array_deps($plugins_data, 'js')
								);
		
			//print_arr($plugins_deps, 'plugins deps');
			
			/* Сбор css и js плагинов */			
			$array['plugins_deps'] = $plugins_deps;
			re_save($array);
			/* Выставляем переменную сообщающую об изменнении в dependacy плагинов в позицию true */
			return $changed_plugins_deps = true;
		
		}//End if
		else{
			return false;
			}
	}//end function
	/* End Функкция обёртка */
	
/*--------------------------------------------------*/
/*-------------Вспомогательные функции------------------*/
/*-------------------------------------------------*/


/* Функция возвращает массив со списком активных плагинов */
function show_active_site_plugins() {
    $all_plugs = get_option('active_plugins'); 
	
    foreach($all_plugs as $key => $value) {
         $string = explode('/',$value);  
         $names[] = $string[0];
     }	 
	 return $names;
}



/* 	Функция сохраняет список активных плагинов 
	и выдаёт информацию если плагины подключаются 
	или отключаются
	deps: show_active_site_plugins(); (observer_skils
*/
function plugins_event_controller(){
	
	$spisok_dir = __DIR__ . '/active_plugins.txt';
	
	/* Если фаил список не существует, создаём его и записываем в него пустой массив */
	if(!is_file($spisok_dir) || filesize($spisok_dir) == 0){file_put_contents($spisok_dir, serialize(	array()	));}
	
	$active_plugins_list = show_active_site_plugins(); 
	if(!isset($active_plugins_list)){$active_plugins_list = array();}
	
	//print_arr($active_plugins_list, 'Активные плагины');
		
	$seved_active_plugins = unserialize(file_get_contents($spisok_dir));  //print_arr($seved_active_plugins, 'Список активных плагинов');
	
	/* вычисляем расхожденяи массивов plus и minus */
	$diff_plus_plugin  = array_diff($active_plugins_list, $seved_active_plugins); 	//print_arr($diff_plus_plugin, 'Активировались плагины');
	$diff_minus_plugin = array_diff($seved_active_plugins, $active_plugins_list); 	//print_arr($diff_minus_plugin,'Деактивировались плагины');
	
	
	/* Если $diff_plus_plugin не пуст значит добавились новые плагины */
	if(!empty($diff_plus_plugin) || !empty($diff_minus_plugin)){				
		file_put_contents($spisok_dir, serialize($active_plugins_list));			
	}else {return false;}
		
	
	return $plugins_event = array(
		'plugins_plus'=>	array_values($diff_plus_plugin), 
		'plugins_minus'=>	array_values($diff_minus_plugin)
		);
		
				
}//end function



/* 	Задача функции собирать и хранить информацию об подключаемых плагинами css и js фаилах.
	Для гарантированного сбора всех данных функция срабатывает в футере.
	Если плагин был хоть раз активирован на сайте, функция соберёт данные 
	о подключаемы им css и js скриптах
*/
function plugin_dependency_information(){
	/* фаил будет хранить все когда либо попадающие в него данные о плагинах с dependancy */
	$data_base_dir = __DIR__ . '/data_base.txt';	
	
	/* Получаем список активированных плагинов */
	$active_plugins_list = show_active_site_plugins(); 
	//print_arr($active_plugins_list, 'Активные плагины');
	
		
	/* Получаем протокол и домменноя имя сайта */
	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	$domen = $_SERVER['HTTP_HOST'];
	

	
	/* Получаем списки загруженных в данный момент на сайт css и js */		
	$queue_css = get_src_by_handle_css(get_queue()['css']); 	//print_arr($queue_css, 'загруженные css');
	$queue_js  = get_src_by_handle_js(get_queue()['js']);		//print_arr($queue_js, 'загруженные js');
	
	
	/* Удалим из списка css протокол и доменное имя */
	foreach($queue_css as $handle => $src){
		$src = str_replace($protocol.$domen, '', $src);
		$queue_css[$handle] = $src;
	}
	
	/* Удалим из списка js протокол и доменное имя */
	foreach($queue_js as $handle => $src){
		$src = str_replace($protocol.$domen, '', $src);
		$queue_js[$handle] = $src;
	}
	
	//print_arr($queue_css, 'загруженные css без доменного имени');
	//print_arr($queue_js, 'загруженные js без доменного имени');

	
	/*	Находим в списке активных плагинов, плагины с dependancy
	* 	В цикле разложим спиок имён активных плагинов, на отдельные имена
	* 	затем в цикле разложим очередь css и js на отдельные элементы.
	* 	и будем искать в адерсной ссылке, имя плагина.
	* 	Если оно находится, то записываем его в массив.
	*/
	
	foreach($active_plugins_list as $plugin_name){
		foreach($queue_css as $handle => $src){			
				if(strpos($src, $plugin_name)){		
					$data[$plugin_name]['css'][$handle] =  $src;			
					}			
			}//end foreach		
		
		foreach($queue_js as $handle => $src){			
				if(strpos($src, $plugin_name)){			
					$data[$plugin_name]['js'][$handle] =  $src;			
				}			
			}//end foreach						
	}//end foreach
	/* end */
	
	
	
	/* Добавление данных в базу */
	
	/* Посмотрим какие данные уже есть в базе */
	$read_data_base = unserialize(file_get_contents($data_base_dir));	//print_arr(array_keys($read_data_base), 'Имена плагинов в базе');
	
	
	/* 	Проверим есть ли в активных плагинах, что то чего нет в data_base 
		и если есть не известные то добавим их в data_base	*/
		
	//print_arr($data, 'выборка активных плагинов обладающих dependency');	
	
	foreach(array_keys($data) as $plugin_name){
		if(!in_array($plugin_name,	array_keys($read_data_base))){		
			
			te($plugin_name.'В базу были добавлены данные о новом плагине');		
			$read_data_base[$plugin_name] = $data[$plugin_name];	

		}	
	}// end foreach
	
	
	//print_arr($read_data_base, 'База данных плагинов');
	/* Записываем данные в базу */
	file_put_contents($data_base_dir, serialize($read_data_base));		
} //end function


/* Функция подготоавливает данные для передачи manager */

function active_plugins_deps_info(){
	/* Путь до фаила data_base плагинов */
	$data_base_dir = __DIR__ . '/data_base.txt';	
	
	/* Получаем список активных на сайте плагинов */
	$active_plugins_list = show_active_site_plugins(); 	//print_arr($active_plugins_list, 'Активные плагины');

	/* Получаем список из data_base плагинов */
	$read_data_base = unserialize(file_get_contents($data_base_dir));	//print_arr($read_data_base, 'Имена плагинов в базе');
	$data_base_keys = array_keys($read_data_base);
	
	
	/*	Отфильтровываем среди активных плагинов имена тех которые входят в базу data_base, 
		то есть обладают dependancy */
	$plugins_with_dep = array_intersect($active_plugins_list, $data_base_keys); 	//print_arr($plugins_with_dep);
	
	/* Составляем массив в котором именнам активных плагинов присвоены их depandnacy */
	foreach($plugins_with_dep as $plugin_name){				
		$active_plugins_with_dep[$plugin_name] = $read_data_base[$plugin_name];
	}
	
	//print_arr($active_plugins_with_dep);
	return $active_plugins_with_dep;	
}



/* 	Функция делает выборку из массива (active_plugins_deps) 
	по запросу, выбирая все CSS или все JS фаилы 
*/
function request_to_array_deps($array, $request){	//print_arr($array);

		$keys = array_keys($array);				
		$data = array();
		foreach($keys as $plugin_name){$data = $data + $array[$plugin_name][$request];}		
		return $data;
}//end function




/*	Функция принимает на вход массив имен handles (имя стиля),
	а возвращает src (адрес где он находится)	*/
function get_src_by_handle_css($handles){	
	global $wp_styles;
	//print_arr($handles, 'get_src_by_handle_css получил данные');	
	/* Если handles это НЕ массив, то делаем $handles массивом с единственным элементом */
	if(	!is_array($handles)){$handles = array($handles);}		
		
	foreach($handles as $handle){							
			$src = $wp_styles->registered[$handle]->src;			
			/*если у стиля есть src адрес, записываем его в массив $data */
			if($src){$data[$handle] = $src;}						
			} //end foreach				
		return $data;	
}


/*	Функция принимает на вход массив имен handles (имя скрипта),
	а возвращает src (адрес где он находится)	*/
function get_src_by_handle_js($handles){
	global $wp_scripts;	
	//print_arr($handles, 'get_src_by_handle_js получил данные');	
	/* Если handles это НЕ массив, то делаем $handles массивом с единственным элементом */
	if(!is_array($handles)){$handles = array($handles);}		
		
	foreach($handles as $handle){										
			$src = $wp_scripts->registered[$handle]->src;						
			/*если у стиля есть src адрес, записываем его в массив $data */
			if($src){$data[$handle] = $src;}					
			} //end foreach			
		return $data;
}


/*---------------------------------------------------*/
/*-------------END Вспомогательные функции---------------*/
/*--------------------------------------------------*/





