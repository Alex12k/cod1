<?php


/* Функция проверяет находятся ли на месте все папки со страницами из списка modules_page */
function check_project_page($modules_page){
	
	//print_arr($modules_page);
	/* Если константа определена и не пуста */
	if(defined('__modules_page_folder__'))	{
		$modules_page_folder = '/'.basename(__modules_page_folder__); 
		};
	
	//te($modules_page_folder);
	
	/* Просматриваем тему на наличие в ней этих страниц */
	$pages = array_keys(get_dirs( get_stylesheet_directory().$modules_page_folder, 'fold', '1'));	
	
	//print_arr($pages);
	/* Находим есть ли фаилы в списке modules_page, которых еще нет на сервере */
	$diff = array_diff($modules_page, $pages);
	

	return $reset_key_diff = array_values($diff);
}


/* Функция проверяет существуют ли системные папки и если нет то просит worker создать их */
function creat_system_elements($system_elements){	
	
	//print_arr($system_elements, 'Элементы которые требуются для работы omw');
	
	foreach($system_elements as $name => $src){		
		

		/* Создание папок */	
		if(!isset(pathinfo($src)['extension']) && !is_dir($src) && $name !='loader') {	
			
			te($src);	
			te('вызываю worker и даю задание создать папку $name');
			worker('creat_folder', $src);					
		}//end if
		
		/* Создание фаилов */
		if(isset(pathinfo($src)['extension']) && !is_file($src) && $name !='loader'){

			te("вызываю worker и даю задание создать фаил $name");
			worker('creat_file', $src);					
		}//end if	
	}// end foreach
	
	/* Закачка из банка */

	if($name == 'loader' && !is_file($src)){
		
		
		te("вызываю worker и даю задание скачать фаил $name");	
		worker('find_and_get_from_bank', 
					array(
						'findFolder'	=>	__loaderBankLocation__,
						'filename' 		=>	LastPartUrl($src), 
						'newLocation'	=>	PathParentFolder($src),				
						)						
						);
	}
	

}//end function


/* Где что лежит */
function system_config($current_state_structure=''){
					
	if(empty($current_state_structure)){$current_state_structure = array();}
					
					
	/* Абсолютный путь до директории с темой */
	$theme_path = 	get_stylesheet_directory();		
	$protocol	= 	stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';			
	$domen		=	$_SERVER['HTTP_HOST'];			
		
	define("__cfg__",						$theme_path.'/cfg.txt'				);	 
	define("__min_folder__", 				$theme_path.'/min_files'			);		
	//define("__min_css_file__",			__min_folder__ .'/style_super.min.css');	
	//define("__min_js_file__",				__min_folder__ .'/script_super.min.js');	
	//define("__fjq__", 						__min_folder__ .'/fjq.js'		);	
	define("__class_jsmin_path__",			$theme_path.'/omw/jsmin.php'		);	
	define("__themes_css__",				get_stylesheet_uri() 				);	
	define("__css_stack_folder__",			$theme_path.'/css_stack'			);	
	define("__js_stack_folder__",			$theme_path.'/js_stack'	);	
	define("__last_state_structure_file__",	$theme_path.'/omw/observer/last_state_structure.txt'		);	
	define("__loader_data_file__",			$theme_path.'/load.txt'				);
	define("__loader__",					$theme_path.'/deps_loader.php'		);
	define("__loaderBankLocation__", 		'bank/php/scripts'					);
	define("__modules_page_folder_name__",	'modules_page_folder'				);
	define("__modules_page_folder__",		$theme_path.'/'.__modules_page_folder_name__);
	
	/* Определение названия и путей до папки с опциональными стилями и скриптами */
	define("__options_stack_name__",		'frameworks'									);
	define("__css_stack_frameworks__",		__css_stack_folder__ .'/'.__options_stack_name__);
	define("__js_stack_frameworks__",		__js_stack_folder__	.'/'.__options_stack_name__	);
	

	
	
	$array = array(	
			'generated' => array(			
					/* Папки */
					'min_folder'				=>	__min_folder__					,/*Расположение папки с min фаилами */
					'css_stack_folder'			=>	__css_stack_folder__			,/*Расположение папки css_stack */
					'js_stack_folder'			=>	__js_stack_folder__				,/*Расположение папки js_stack */
					'modules_page_folder'		=>	__modules_page_folder__			,/*Расположение папки modules_page_folder*/
					'css_frameworks'			=>	__css_stack_frameworks__,
					'js_frameworks'				=>	__js_stack_frameworks__,
					
					
					
					/* Фаилы */
					'cfg'						=>	__cfg__, 						/* конфигурация проекта */
					//'min_css_file'				=>	__min_css_file__				,/*Имя min css фаила*/
					//'min_js_file'				=>	__min_js_file__					,/*Имя min js фаила*/	
					'last_state_structure_file'	=>	__last_state_structure_file__	, /* Память observer-a */					
					//'fjq'						=>	__fjq__							,/*Расположение фаила эмулятор загрузки jquery */
					'loader_data_file'			=>	__loader_data_file__			, /* информация о загружаемых элементах */
					'loader'					=>	__loader__						, /* php скрипт загрузчик css/js проекта */			
				
				),//end array 

				'themes' => array('themes_css'	=> __themes_css__),
					
			);//end array				
		//print_arr($array);
	

	re_save($array);
	return $new_array = array_merge($current_state_structure, $array);	
	
}//end function


	


function add_project_item_data_v4($modules_page=''){
	
	/* Если константа с путём до папки модулей установлена и не пуста */
	//print_arr($modules_page);
	
	
	if(defined('__modules_page_folder__'))	{			
		if(!isset($modules_page)){ $modules_page = []; }
		//$modules_page = [];
		foreach($modules_page as $key => $value){		
			// Удаляем старое значение и записываем новое 
			unset(	$modules_page[$key]	);	
			$modules_page[] = basename(__modules_page_folder__).'/'.$value;		
		}
	}
	
	//print_arr($modules_page);
			
	
	$theme_path = get_stylesheet_directory();
		
	$array['theme_path'] = $theme_path;

	/* Опциональные css и js */
	$array['options_css'] = get_dirs($theme_path.'/css_stack/frameworks','.css','', 'simple_array');
	$array['options_js'] = get_dirs($theme_path.'/js_stack/frameworks','.js','', 'simple_array');

	/* Находим глобальные css и js исключая папку frameworks из css_stack */
	$array['css_stack'] =	array_diff(get_dirs($theme_path.'/css_stack','.css','', 'simple_array'), $array['options_css']);
	$array['js_stack']	=	array_diff(get_dirs($theme_path.'/js_stack', '.js', '', 'simple_array'), $array['options_js']);
		
		
	foreach($modules_page as $page_name){ 			
		$array[$page_name]['modules_css']	=	get_dirs( $theme_path.'/'.$page_name.'/modules', '.css','', 'simple_array');
		$array[$page_name]['modules_js']	=	get_dirs( $theme_path.'/'.$page_name.'/modules', '.js', '', 'simple_array');		
		$array[$page_name]['base_css']		=	get_dirs( $theme_path.'/'.$page_name.'/base_css', '.css', '', 'simple_array');					
	} //end foreach
	
	
	/* Modules_page */
	$array['modules_page'] = $modules_page;	
	
	/* пусть до фаила cfg */
	$array['cfg'] = array(__cfg__);
	 
	
	/* Target_folders */
	$target_folders 			= array_merge(array('css_stack', 'js_stack'), $modules_page);
	$array['target_folders']	= $target_folders;	
		
	
	
	/* All_project_folders */	
	foreach($target_folders as $folder){
		
		$all_folders[$folder] = get_dirs( $theme_path.'/'.$folder, 'fold','', 'simple_array');	
	}
	
	//print_arr($all_folders ,'all_folders');
	$array['all_folders'] = $all_folders;
	
	//print_arr($array);			
	re_save($array);
	return $array;
}


	
		

function add_hash($current_state_structure, $modules_page){			
	//print_arr($current_state_structure);		
	$array_key = $current_state_structure['target_folders'];
	foreach($array_key as $item){$array_for_hash[$item] = $current_state_structure[$item];}		
	/* Вычисляем Hash сумму массива  */
	$hash =  md5(serialize($array_for_hash)); 		
	/* Записываем hash сумму в общий массив current */
	$current_state_structure['hash'] = $hash;
	return $current_state_structure;
}






function project_config(){
	
	$content_cfg = file(__cfg__, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);	
	foreach($content_cfg as $item){
			//$res[trim(explode(':',$item)[0])] = explode(',',trim(explode(':',$item)[1]));
			
			$array_key 	= trim(explode(':',$item)[0]);			
			$values 	= trim(explode(':',$item)[1]);
			
			/* представляем значение элемента в виде массивва */
			$element_key  = explode(',',$values);
			
			/* Trim */
			foreach($element_key as $key => $val){$element_key[$key] =  trim($val);}
					
			$res[$array_key] = $element_key;
	}
	

	//print_arr($res);
	
	re_save($array);
	return $res;	
}



function save_data($current_state_structure, $path){	
	file_put_contents($path, serialize($current_state_structure));
}


	/*----------------------------------------------------*/
	/* Специальная функция сохраннеия данных в массивесхожая с append*/
	/*----------------------------------------------------*/
	
	function re_save($array_for_write){
	//print_arr($array_for_write, 'array_for_write');	
	$dir = __DIR__ .'/last_state_structure.txt';	
				
	/* Получаем сохранённый массив */	
	$current_saved_array = unserialize(file_get_contents($dir));  //print_arr($current_saved_array);
	
	/* Если в фаиле пусто или записан не массив, то считаем его пустым массивом */
	if(empty($current_saved_array) || !is_array($current_saved_array) ){$current_saved_array = array();}
		
	foreach($array_for_write as $key => $value){
			
		/* 2. 	Проверим существует ли в памяти элемент с такущим ключом и если да,
				то проверим, совпадают ли значения и если значения по ключу разные, то 
				обновим значение.
		*/
		if(array_key_exists($key, $current_saved_array)){
		
			/* Если элемент с таким ключём уже есть в массиве, 
			то проверим поменялось ли значение по этому ключу, для этого сделаем сверку hash */
			//te('Элемент с таким: ' .$key.' ключем уже есть в массиве');
			
			$hash_old_value = md5(serialize($current_saved_array[$key]));	//print_arr($hash_old_value, "OLD hash: key: $key");
			$hash_new_value	= md5(serialize($array_for_write[$key]));		//print_arr($hash_new_value, "NEW hash: key: $key");
		
			/* Если hash-ы не равны значит у элемента новое значение */	
			if($hash_old_value != $hash_new_value){			
				//te("У элемента с ключём: ($key) новое значение");	
				$current_saved_array[$key]	= $array_for_write[$key];					
				file_put_contents($dir, serialize($current_saved_array));				
			}else{
				//te('нет новых значений');
				}
		
		/*	а если во входящем массиве обнаружен элемент с неизвестным ключём 
			добавми этот элемент в конец массива, в качестве новго элемента
		*/
		}else{
			if(!empty($array_for_write[$key])){
			//te('Элемент не пуст');
			//print_arr($current_saved_array);			
			$add_elem[$key] = $value; 	
			$new_array = $current_saved_array + $add_elem;		
			/* Теперь нужно записать отредактированный массив обратно в фаил */
			file_put_contents($dir, serialize($new_array));	
		
			}//end if	
		} // end else
	}//End foreach	
} //END re_save


/* V2 */
/*----------------------------------------------------------*/
/*	Специальная функция сохраннеия данных в массивесхожая с append	*/
/* 	Где используется вторая версия и чем отличается от первой 		*/
/*----------------------------------------------------------*/
	
	function re_save2($dir, $array_for_write=''){
		
		
		//print_arr($array_for_write, 'массив для записи');
		if(empty	($array_for_write))	{return false;}
		if(is_string($array_for_write))	{return false;}
	
	
	
	/* Получаем сохранённый массив */	
	$current_saved_array = unserialize(file_get_contents($dir));  
	//print_arr($current_saved_array, 'сохранённый в памяти массив');
	
	/* Если в фаиле пусто или записан не массив, то считаем его пустым массивом */
	if(empty($current_saved_array) || !is_array($current_saved_array) ){$current_saved_array = array();}
		
	foreach($array_for_write as $key => $value){
			
		/* 2. 	Проверим существует ли в памяти элемент с такущим ключом и если да,
				то проверим, совпадают ли значения и если значения по ключу разные, то 
				обновим значение.
		*/
		if(array_key_exists($key, $current_saved_array)){
		
						
			/* Если элемент с таким ключём уже есть в массиве, 
			то проверим поменялось ли значение по этому ключу, для этого сделаем сверку hash */
			//te('Элемент ключём: ' .$key.' уже есть в массиве');
			
			$hash_old_value = md5(serialize($current_saved_array[$key]));	//print_arr($hash_old_value, "OLD hash: key: $key");
			$hash_new_value	= md5(serialize($array_for_write[$key]));		//print_arr($hash_new_value, "NEW hash: key: $key");
		
			/* Если hash-ы не равны значит у элемента новое значение */	
			if($hash_old_value != $hash_new_value){			
				//te("У элемента с ключём: ($key) новое значение");	
				$current_saved_array[$key]	= $array_for_write[$key];					
				file_put_contents($dir, serialize($current_saved_array));				
			}else{
				//te('У элемента ' .$key.' прежнее значение');
				}
		
		/*	а если во входящем массиве обнаружен элемент с неизвестным ключём 
			добавми этот элемент в конец массива, в качестве новго элемента
		*/
		}else{
			if(!empty($array_for_write[$key])){
			//te('Элемент не пуст');
			//print_arr($current_saved_array);			
			$add_elem[$key] = $value; 	
			$new_array = $current_saved_array + $add_elem;		
			/* Теперь нужно записать отредактированный массив обратно в фаил */
			file_put_contents($dir, serialize($new_array));	
		
			}//end if	
		} // end else
	}//End foreach	
} //END re_save

/* END V2 */










function read_state(){
	$dir = __DIR__ .'/last_state_structure.txt';	
	return $array = unserialize(file_get_contents($dir));
}


function remove_state_element($key){
	$dir = __DIR__ .'/last_state_structure.txt';	
	$current_saved_array = unserialize(file_get_contents($dir));  //print_arr($current_saved_array);
	unset($current_saved_array[$key]);
	file_put_contents($dir, serialize($current_saved_array));
}



/* 	Функция принимает на вход параметр css или js и 
	делает выборку из массива $current_state_structure.
	Возвращает массив со всеми css или js фаилами
*/
function request_to_array($request){		
		//global $current_state_structure;		
		$current_state_structure = read_state();
		$modules_page = $current_state_structure['modules_page'];					
		
		
		if($request == 'css'){
			$modules_target = array('base_css', 'modules_css');
			$global_folder = 'css_stack';	
			}
		
		if($request == 'js'){
			$modules_target = array('modules_js');
			$global_folder = 'js_stack';	
			}
		
		/* Добавляем в массив фаилы из глобальной css или js */
		$array = $current_state_structure[$global_folder];
		
		
		/* Добавляем в массив фаилы из модулей */
		foreach($modules_page as $page){
			
			foreach($modules_target as $item){		
				foreach($current_state_structure[$page][$item] as $item){				
					$array[] = $item;				
				}	
			}	
		}
		return $array;
	}//end function
	
	
	
	function request_to_array_diff($request){		
				
		$current_state_structure = read_state();	
		$modules_page = $current_state_structure['modules_page'];					
		
		
		if($request == 'css'){
			$modules_target = array('base_css', 'modules_css');
			$global_folder = 'css_stack';	
			$options = 'options_css';
			}
		
		if($request == 'js'){
			$modules_target = array('modules_js');
			$global_folder = 'js_stack';
			$options = 'options_js';		
			}
		
		
		//print_arr($current_state_structure);
		/* Добавляем в массив фаилы из глобальной css или js */
		$array['global_stack'] = $current_state_structure[$global_folder];
		
		//print_arr($current_state_structure);
		$array['options'] = $current_state_structure[$options];
		
		/* Добавляем в массив фаилы из модулей */
		foreach($modules_page as $page){
			
			foreach($modules_target as $item){		
				foreach($current_state_structure[$page][$item] as $item){				
					$array[$page][] = $item;				
				}	
			}	
		}
		
		//print_arr($array);
		return $array;
	}//end function








/* требуеться переделать */
function viewer($path){
		
	?><style>
		#ID_viewer{border-collapse: collapse; margin: 50px auto;}

		#ID_viewer caption{
			font-weight: 600;
			color: #f77a7a;
			letter-spacing: 2px;
			text-transform: uppercase;
			margin-bottom: 1px;	
		}

		#ID_viewer th:first-child, #ID_viewer td:first-child {
			text-align: left;
		}

		#ID_viewer th, #ID_viewer td {
			border-style: solid;
			border-width: 0 1px 1px 0;
			border-color: white;
		}

		#ID_viewer th, #ID_viewer td:first-child {
			background: #AFCDE7;
			color: white;
			padding: 10px 20px;
		}

	#ID_viewer td {
		background: #D8E6F3;
		padding: 10px 20px;
	}
	</style><?
		
			
	
	$info_data = unserialize(file_get_contents($path));
	
	foreach($info_data as $table_name => $table_info){?>
	
		<table id="ID_viewer">
	
			<caption><?=$table_name?></caption>	
			<thead><tr class="table_head"><th>HANDLE</th><th>SRC</th><th>DEPS</th></tr></thead>

			<tbody class="table_body">
		
				<?foreach($table_info as $handle => $attributes){?>	
		
					<tr class = "row <?='handle-'.$handle?>">															
						<td class = "handle">	<?=$handle?></td>
						<td class = "src">		<?=$attributes['src']?></td>
						<td class = "deps">		<?foreach($attributes['deps'] as $item){echo $item.' ';}?></td>			
					</tr>			
		
				<?}//end foreach?> 						
	
			</tbody>
		</table>
	
	<?}//end foreach

}//end function


/*	Дубль viewer(); Скорее всего не используется 
*	Функция принимает на вход ассоциативный массив из observer 
*	и выводит на экран структуру в виде таблицы 
*	Используется в функции observer
*/

function array_viewer_for_observer($array, $filter = ''){
				
	?><style>
		#ID_viewer{border-collapse: collapse; margin: 50px auto;}

		#ID_viewer caption{
			font-weight: 600;
			color: #f77a7a;
			letter-spacing: 2px;
			text-transform: uppercase;
			margin-bottom: 1px;	
		}

		#ID_viewer th:first-child, #ID_viewer td:first-child {
			text-align: left;
		}

		#ID_viewer th, #ID_viewer td {
			border-style: solid;
			border-width: 0 1px 1px 0;
			border-color: white;
		}

		#ID_viewer th, #ID_viewer td:first-child {
			background: #AFCDE7;
			color: white;
			padding: 10px 20px;
		}

	#ID_viewer td {
		background: #D8E6F3;
		padding: 10px 20px;
	}
	</style><?
		
			
	/* Улаляем из визуального вывода элемент hash */
	unset($array['hash']);
	

	
	if($filter){foreach($array as $key => $value){ if($key != $filter){ unset($array[$key]); }}}
		
	
	
	foreach($array as $table_name => $data){?>
					
		<table id="ID_viewer">	
			<caption><?=$table_name?></caption>				
			
			<? //Управление заголовками шапки 
			if($table_name == 'css' || $table_name == 'js')					{$key = 'FILE';		$value = 'PATH';}
			if($table_name == 'fold')										{$key = 'FOLDER';	$value = 'PATH';}
			if($table_name == 'lastMod_css' || $table_name == 'lastMod_js')	{$key = 'FILE';		$value = 'DATE';}			
			?>
			
			
			<thead><tr class="table_head"><th><?=$key?></th><th><?=$value?></th></tr></thead>

			<tbody class="table_body">
					
				
				<?foreach($data as $key => $value){?>												
					<tr class = "row <?='row-'.$key;?>">																				
						<td class = "key">		<?=$key?>	</td>
						<td class = "value">	<?=$value?>	</td>						
					</tr>					
				<?}//end foreach?> 						
	
			</tbody>
		</table>
	
	<?}//end foreach	
}//end function





/*#5
* Получаем время последней модификации фаила из списка фаилов
* Функция отдаст самое последнее время модификации к какому бы фаилу оно не относилось
*/	

//* V2 НЕ ИСПОЛЬЗУЕТСЯ (используется версия 3)
function last_mod_v2 ($Files_url, $mod=''){	
	date_default_timezone_set("Europe/Moscow");	
	
	//print_arr($Files_url);	
	foreach($Files_url as $key => $item){
		
		/* Если приходит разделенный по страницам массив */
		if(is_array($item)){
			$keys[] = $key;}
			}			
		
		/* Если приходит единый поток */
		if($keys==NULL){
			$keys[] = 'stream';	$Files_url[$keys[0]] = $Files_url;
			};
	
	
		//print_arr($keys, 'keys');

	
	
	/* Получаем время*/
	
	foreach($keys as $page_name){
		
		//print_arr($page_name, 'page_name');
					
		foreach($Files_url[$page_name] as $file){									   
			$file_name = basename($file);								
			$filetime = filemtime($file);		
					
			$result_array[$page_name]['files'][$file_name]['time'] = date ("d F Y  H:i:s", $filetime);
			$result_array[$page_name]['files'][$file_name]['path'] = $file;		
			$strem[$page_name][$file_name] = date ("d F Y  H:i:s", $filetime);				
		}	
		
		print_arr($strem[$page_name], "списки фаилов $page_name");
		
		
		$needle 	 = max($strem[$page_name]);
		$haystack 	 = $strem[$page_name];
		
		$maxTimeName = array_search(max($strem[$page_name]), $strem[$page_name]);
			
		$maxTimeTime = max($strem[$page_name]);
		
		
		//te("$maxTimeName - $maxTimeTime");
		
		$result_array[$page_name]['maxTime'][$maxTimeName] = $maxTimeTime;		
		$result_array[$page_name]['maxTime']['path'] = $result_array[$page_name]['files'][$maxTimeName]['path'];
	
	}
	

	
	foreach($result_array as $key => $item){	
		$file_neme = array_keys($item['maxTime'])[0];		
		$file_time = current($item['maxTime']);
		$times[$key][$file_neme] = $file_time;					
		
		$max = max($max, $file_time);
		
	} 


	foreach($times as $key => $value){
		$val = array_values($value)[0];	
		if($val == $max){			
			$maxTime_project[$key]  = $value;
			$maxTime_project[$key]['path'] = $result_array[$page_name]['files'][$maxTimeName]['path'];		
		}
	}
	

	
	if($mod =='all'){
			
		return $result = $result_array;
	}else{	
		
		return $result['maxTime_project'] = $maxTime_project;
	}

}







/*#5
* Получаем время последней модификации фаила из списка фаилов
* Функция отдаст самое последнее время модификации к какому бы фаилу оно не относилось
*/	

function last_mod_v3 ($Files_url, $mod=''){	
	date_default_timezone_set("Europe/Moscow");	
	
	//print_arr($Files_url);	
	
	foreach($Files_url as $key => $item){		
		// Если приходит разделенный по страницам массив 
		if(is_array($item)){$keys[] = $key;}}			
		
		// Если приходит единый поток 
		if($keys==NULL){
			$keys[] = 'stream';	
			$Files_url[$keys[0]] = $Files_url;
			}
		//print_arr($keys, 'keys');
		//print_arr($Files_url, 'File_url');
	
		
	foreach($Files_url as $location => $urls){		
		/* Соберём массивы имён, времени обновления, и путей к фаилам */
		foreach($urls as $url){		
			$fileName = basename($url);
			$fileTime = filemtime($url);							
			$Names[$location]['names'][] = $fileName;
			$Times[$location]['times'][] = $fileTime;
			$Urls [$location]['urls'][] = $url;
		}				
	}
	
	
	
	foreach($Names as $key => $val){		
		$max_time = max($Times[$key]['times']);
		$index = array_search($max_time, $Times[$key]['times']);		
		$max_name = $val['names'][$index];
		$max_url = $Urls[$key]['urls'][$index];		
		//print_arr($max_url);
		$all_data[$key] = $val+$Times[$key]+$Urls[$key]+
					array(
							'max'=>
								array('max_time'=>$max_time)+
								array('max_names'=>$max_name)+
								array('max_urls'=>$max_url)
								);	
						}//end foreach
	
	//print_arr($all_data);
	
	
	/* Найдем самый свежий фаил */
	foreach($all_data as $location => $value){		
		$max_data[] = $value['max']['max_time'];
	}
	
	/* Найдем самое свежее время записи фаила */
	$super_max = max($max_data);
	
	/* Отфильтруем инофомацию о самом свежем фаиле */
	foreach($all_data as $location => $item){	
		if($super_max == $item['max']['max_time']){
			$res[$location] = $item['max'];
		}	
	}
	
	
	/* Подготовим результат для Observer */	
	foreach($res as $location => $item){		
		foreach($item as $elem){			
			$arr[$location][$item['max_names']] = date ("d F Y  H:i:s", $item['max_time']); 
			$arr[$location]['path'] = $item['max_urls'];
		}	
	}
	
	//print_arr($arr);
	return $arr;
	
}

/*---------------------------------------------------------
*	Сбор, запись и просмотр данных о CSS/JS фаилах
*----------------------------------------------------------*/


























