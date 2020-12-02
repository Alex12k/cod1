<?php
require_once __DIR__ .'/observer_skills.php';
require_once __DIR__ .'/merged/merged.php';
require_once __DIR__ .'/plugins_info/plugins_info.php';
//require_once __DIR__ .'/../FTP_lib.php';


	
function observer($message = ''){
	

	
	define(__observer_in_system__, true);		
	$last_state_structure 		= read_state(); //print_arr($last_state_structure);

	
	
	/* PLUGIN CONTROLLER */	
	// $changed_plugins_deps = plugin_controller();	
	//	if($changed_plugins_deps === NULL){
	//	te('plugin_controller выключен');		
	//	unset($last_state_structure['plugins_deps']); 
	//	save_data($last_state_structure, __DIR__ .'/last_state_structure.txt');		
	//}
	/*------END-----*/
		
	
		
	/* Добавим в массив данные о метсторасположении папок и фаилов */
	$current_state_structure = system_config();	
	//print_arr($current_state_structure, 'current_state_structure');
	

	/*------ Чтение настроек из фаила конфига проекта в массив -----*/
	$modules_page = project_config()['modules_page'];  
	//print_arr($modules_page, 'modules_page');

	
	/* Сбор данных о css, js и папках */
	$current_state_structure = add_project_item_data_v4($modules_page);	
	//print_arr($current_state_structure, 'current_state_structure');
	
		


	/*-----создание системных папок и фаилов------*/	
	$system_elements = $last_state_structure['generated']; //print_arr($system_elements);
	creat_system_elements($system_elements);
	/*-----end-----*/


	/*------- Воссоздание структуры страниц проекта--------*/
	$folders_to_create = check_project_page($modules_page); 
	//print_arr($folders_to_create, 'список папок для создания');		
	if($folders_to_create){	
		te('требуется создать папки');				
		worker('creat_project_folders', $folders_to_create);
	}
	/*-----end-----*/


	/* Добавим в массив hash сумму массивов css js и fold в проекте */		
	$current_state_structure = add_hash($current_state_structure, $modules_page);	
	//print_arr($current_state_structure['hash'], 'current_state_structure');	
	
	
	/* hash суммы для фиксации изменений структуры */
	//print_arr($current_state_structure['hash'], 'current_state_hash');
	//print_arr($last_state_structure['hash'], 	'last_state_hash');
	
	
	/* БЛОК ПРОВЕРКИ НА ИЗМЕНЕНИЕ СТРУКТУРЫ */
	if($current_state_structure['hash'] != $last_state_structure['hash']){			
				$change_structure = true; 
				te('зафиксированны изменения в структуре фаилов');			
			}
	
		 
/*-------------------Отслеживаем изменнеия в контенте фаилов --------------------*/
/*	Получаем время последней модификации любого CSS/JS фаила из отслеживаемого проекта 
/*	(возвращается массив [fileName] => [fileTime]) 
/*------------------------------------------------------------------------*/
						
		$all_css 	= request_to_array_diff('css');		//print_arr($all_css, 'all_css');	
		$all_js 	= request_to_array_diff('js');		//print_arr($all_js, 	'all_js');

	
	

	/* Записываем имя последнего модифицированного фаила и время его модификации в общий массив current*/		
	$current_state_structure['lastMod_css'] = last_mod_v3($all_css);
	$current_state_structure['lastMod_js']  = last_mod_v3($all_js);
	
	$current_state_structure['lastMod_cfg']  = last_mod_v3($current_state_structure['cfg']);
	



	
	/* последнее изменние сохраненное в массиве */
	$time_css_inArray		=	$last_state_structure['lastMod_css'];		//print_arr($time_css_inArray, 	"LAST TIME CSS");
	$time_js_inArray		=	$last_state_structure['lastMod_js'];    	//print_arr($time_js_inArray, 	LAST TIME JS);
	$time_cfg				=	$last_state_structure['lastMod_cfg']; 		//print_arr($time_cfg, "LAST TIME CFG");  
		
	
		
	/* Если текущее время изменения в css фаиле не равно сохраненному времени изменения*/	
	if(current($current_state_structure['lastMod_css']) != current($time_css_inArray))	{
			$change_css_content = true; 
			te("Observer: Зафиксированны изменения в контенте CSS, в фаиле: ".key($current_state_structure['lastMod_css']));
			}
		
		

	/* Если текущее время изменения в js фаиле не равно сохраненному времени изменения*/
	if(current($current_state_structure['lastMod_js'])	!= current($time_js_inArray))	{
			$change_js_content = true; 
			te("Observer: Зафиксированны изменения в контенте JS, в фаиле: ".key($current_state_structure['lastMod_js']));
			}
	

	
	/* Если текущее время изменения в js фаиле не равно сохраненному времени изменения*/
	if(current($current_state_structure['lastMod_cfg'])	!= current($time_cfg))	{
			$change_cfg = true; 
			te("Observer: Зафиксированны изменения в CFG фаиле");
			}



	//$change_css_content = true;
	//$change_js_content = true;
	
	$observers_raport = array(		
		'change_structure' 		=> $change_structure,		
		'change_css_content'	=> $change_css_content,
		'change_js_content'		=> $change_js_content,
		'change_cfg'			=> $change_cfg,
		'changed_plugins_deps'	=> $changed_plugins_deps,
		);
		
		
	/* Формирование потока из всех css и js проекта */
	$project_css 	= none_filter(assoc_handle(abs2url(request_to_array('css'))));
	$project_js 	= none_filter(assoc_handle(abs2url(request_to_array('js'))));	
	$stream = array(
		'css'	=>	$project_css,
		'js'	=>	$project_js
	);
		
	
	//print_arr($stream);
	$current_state_structure['stream'] = $stream;
	/*end*/
		
	/* Если в массиве есть хотябы одно значение true, то перезаписываем current_state */
	if(in_array(true, $observers_raport)){		
		re_save2(__last_state_structure_file__, $current_state_structure);
		manager($observers_raport, $current_state_structure);
		}
		
				
	//print_arr($observers_raport, 'Observer_raport');			
	/* Запросим данные о прошлой структуре */		
	//print_arr(read_state(), 'Состояние системы по данным из памяти Observer');					
	


	return $observers_raport;	
}




