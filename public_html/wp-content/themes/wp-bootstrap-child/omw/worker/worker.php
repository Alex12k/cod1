<?php
require_once __DIR__ .'/worker_skills.php';

function worker($command, $data=''){


	
	/* ---------------------------------------------------*/
	/*	 Создать новую модульную страницу 					*/
	/* --------------------------------------------------*/
	if($command == 'creat_project_folders'){
		
		te('Worker собирается создать модульную страницу');
		
		/* Создание структуры папок и фаилов */
		custom_page_creator($data);
			
		/* Создание страницы wordpress и назначение шаблона */
		creat_page_or_post($data);
		
	}

	

	/* ---------------------------------------------------*/
	/*	Создать папку									*/
	/* --------------------------------------------------*/
	if($command == 'creat_folder'){	
		te('Worker принял задание на создание');
		mkdir($data, 0777, true);
			
	}
	
	
	/* -------------------------------------------------*/
	/*	Создать фаил										*/
	/* -------------------------------------------------*/
	if($command == 'creat_file'){
		$file_neme = basename($data);		
		te("Worker принял задание на создание фаила $file_neme");					
		print_arr($data, "Данные для выполнения $command");				
		file_put_contents($data, '');	
	}

	/* -------------------------------------------------*/
	/*	Получение фаила из банка										*/
	/* -------------------------------------------------*/
	if($command == 'get_file_from_bank'){
			
			te("Worker принял задание перенести в проект фаил $file.$type");
			print_arr($data, 'data для get_file_from_bank');	
			
			$ftp = new myFtp( ftp_config('main') );	
		
					
			$file 			= 	$data['filename'];	te($file, 'file');
			$type 			=	$data['type'];		te($type, 'type');
			
			
			
			$findFolder 	= 	'bank/'.$type.'_frameworks/';
			$filename   	=	$file.'.'.$type;
			if($type == 'css')	{$newLocation	=	__css_stack_frameworks__;}
			if($type == 'js')	{$newLocation	=	__js_stack_frameworks__;}
			
			
			/* Вызываем метод findAndDownload	*/	
			$ftp->findAndDownloadFile($findFolder, $filename, $newLocation);
		
			print_arr($ftp->getLog(), 'log');
			
			
			
		
	
	}


	/* -------------------------------------------------*/
	/*	Получение фаила из банка										*/
	/* -------------------------------------------------*/
	if($command == 'find_and_get_from_bank'){
				
		
		print_arr($data, 'data для get_file_from_bank');
		
		$ftp = new myFtp( ftp_config('main') );
				
		/* Где ищем */				$findFolder  = $data['findFolder']; 			
		/* Имя фаила который ищем*/ 	$filename    = $data['filename'];				
		/* Куда будем копировать */		$newLocation = $data['newLocation'];	
		
		/* Вызываем метод findAndDownload	*/	
		$ftp->findAndDownloadFile($findFolder, $filename, $newLocation);
		
		print_arr($ftp->getLog(), 'log');
			
			
					
		
	
	}

	
	
	
	
	
	/* -------------------------------------------------*/
	/*	Получить массив из фаила								*/
	/* -------------------------------------------------*/
	if($command == 'give_data'){
		/*Достаём данные из last_state_structure */
		$last_state_structure = unserialize(file_get_contents($data));			
		return $last_state_structure;
	}
	
	
	
	
	
	
	/* -------------------------------------------------*/
	/*	Действия при смене названий папок и фаилов				*/
	/* -------------------------------------------------*/
	
	if($command == 'change_structure'){		
		te("Worker: Воркер получил задание на обновление структуры фаилов");		
	}
	
	
	
	
	
	
	/* -------------------------------------------------*/
	/*	Обновление CSS min фаила						*/
	/* -------------------------------------------------*/
	
	if($command == 'update_css_content'){		
		te("Worker: Воркер получил задание на обновление css фаилов");		
	
		/* Данные от manager успешно получены 
			Теперь задача минимизировать css фаилы. (обновить min.stack)
			И подключить их к WP  */
		
		//print_arr($data, 'data_worker');
		
		/* .= Добавляем данные со всех фаилов в переменную */
		foreach($data['files'] as $key => $value){
					
			foreach($value as $style){				
				$contents[$key] .= mini_css(file_get_contents($style));				
				//$contents[$key] .= file_get_contents($style);
				}			
			
			};		
		
	
		//print_arr($contents, 'min_контент');	
		//print_arr($data['path'], 'путь к min фаилам');
			
		/*Записываем контент в мин фаил*/		
		foreach($data['path'] as $page_name => $min_path){
				
				//print_arr($min_path);
				//print_arr($contents[$page_name]);
			file_put_contents($min_path, $contents[$page_name]);	
		}
	
		
	} //end command
	

	
	
	
	
	
	/* -------------------------------------------------*/
	/*	Обнавление JS min фаила							*/
	/* -------------------------------------------------*/
	 
	
	if($command == 'update_js_content'){		
		te("Worker: Воркер получил задание на обновление js фаилов");		
		
		//$contents[$key] .= JSMin::minify(file_get_contents($script));		
			
			/* Данные от manager успешно получены 
			Теперь задача минимизировать css фаилы. (обновить min.stack)
			И подключить их к WP  */
		
		//print_arr($data, 'data_worker');
		
		require_once $data['class_jsmin_path'];
		
		
		/* .= Добавляем данные со всех фаилов в переменную */
		foreach($data['files'] as $key => $value){
					
			foreach($value as $style){				
				$contents[$key] .= JSMin::minify(file_get_contents($style));				
				
				/* Вариант без минимизации */
				//$contents[$key] .= file_get_contents($style);	
				}			
			
			};		
		
	
		//print_arr($contents, 'min_контент');	
		//print_arr($data['path'], 'путь к min фаилам');
			
		/*Записываем контент в мин фаил*/		
		foreach($data['path'] as $page_name => $min_path){
				
				//print_arr($min_path);
				//print_arr($contents[$page_name]);
			file_put_contents($min_path, $contents[$page_name]);	
		}
			

		
	}// end command


	/* -------------------------------------------------------------*/
	/* Отключение стилей CSS плагинов из очереди	(при включенном min_mod)  */
	/* -------------------------------------------------------------*/

	if($command == 'dequue_css'){
	
			print_arr($data, 'worker получил данные для отключения из очереди CSS');								
				add_action('wp_enqueue_scripts', 'remove_alien_styles', 100);
				add_action('wp_footer', 'remove_alien_styles');
		
				function remove_alien_styles($data){									
					$data = array_keys(read_state()['plugins_deps']['css']);
					wp_dequeue_style($data);										
				}
								
		/* Отключение  Google Fons и WP-Block-library */
		/* В перспективе перенести под управление manager */
		wp_dequeue_style(array('google-fonts', 'wp-block-library'));
		
						
}
	


	
	


	
	/* -------------------------------------------------------------*/
	/* Отключение скриптов ОЫ плагинов из очереди	(при включенном min_mod)  */
	/* -------------------------------------------------------------*/	
	if($command == 'dequue_js'){
	
		//Отключить JS из очереди
		$data = array_keys(read_state()['plugins_deps']['js']);
		//print_arr($data, 'worker получил данные для отключения из очереди JS');
		
		//wp_dequeue_script($handles);
				
	}
	

	
	
	

	
	/* -------------------------------------------------*/
	/* 		Загрузка стека 	ВЫКЛЮЧЕН							*/
	/* -------------------------------------------------*/
	if($command == 'load_stack'){
				
		/* Эта часть вероятна должна быть в manager */
		/* Если существует фаил data(память воркера) и он не пустой , то берём данные из него */			
		if(is_file(__last_state_structure_file__)){																
			if(filesize(__last_state_structure_file__) !== 0){	
			
	
				$request = unserialize(file_get_contents(__last_state_structure_file__));				
				
				//print_arr($request);
				$data = array(	'css_stak' => $request['stream']['css'],
								'js_stack'=>$request['stream']['js'],
								'min_css_file'	=>$request['min_folder'].'/'.$request['min_css_name'],
								'min_js_file'	=>$request['min_folder'].'/'.$request['min_js_name'],
								);
				
				
				
				//print_arr($data, "Данные которые принял worker из фаила");
			}; //endif		
		};//endif	
						
		
			
		/* Если нет фаила или он пуст запрашиваем данные у manager*/	
		if(empty($data)){			
			//te('Воркер не получил данных для загрузки стека');
			manager(array('message' => 'need_data'));	
		
		}
		/* Else надо обдумать ! */
		else{			
			//te('Воркер успешно получил данные для load_stack');			
			
			//print_arr($data, 'память воркера');
			
			item_registered($data);
			re_save2(__memory_worker__, $data);			
		}
	} //End command
	

	
}




