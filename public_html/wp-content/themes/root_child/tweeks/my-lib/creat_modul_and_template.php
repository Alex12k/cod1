<?php
	
	function creat_modul_structure($template_path){
				
		te($template_path, 'template_path');
		$modul_folder = LastPartUrl($template_path); 	te($modul_folder, 'modul_folder');
		$handle = remove_gravity_index($modul_folder);	te($handle, 'handle');
		
		
		te("Структура модуля $handle создана");

			
		/* ОПРЕДЕЛЕНИЕ ПУТЕЙ ПАПОК И ФАИЛОВ */					
		/* путь до папки css модуля и основного css фаила */
		$css_folder		=	$template_path.'/css'; 					print_arr($css_folder, 'путь до папки css');
		$css_file 		=	$css_folder.'/'.$handle.'-style.css'; 	print_arr($css_file, 'путь до папки css');
		
	
		
		/* путь до папки js модуля и основного js фаила */		
		$js_folder		= 	$template_path.'/js';  
		$js_file 		=	$js_folder.'/'.$handle.'-script.js';
			
		/* Путь до папки с картинками для модуля */	
		$img_folder		=	$template_path.'/img';
			
		/* END */	
		
		/* СОЗДАНИЕ ПАПОК И ФАИЛОВ И ЗАПИСЬ КОНТЕНТА */
		
//		mkdir($template_path);	//Создание папки модуля		
		mkdir($css_folder);		//Создание папки для css модуля
		
		/* Запись комментария в css фаил модуля */		
		file_put_contents($css_file, "/*=== $modul_name Style ===*/", FILE_APPEND);
		
		mkdir($js_folder); //Создание папки для js модуля
		
		/* Запись комментария в js фаил модуля */
		file_put_contents($js_file, "/*=== $modul_name Script ===*/", FILE_APPEND);
		
		/* Создание папки img для модуля */
		mkdir($img_folder);
		
		/* Создание основного php фаила модуля */
		$file_name = $template_path.'/'.$handle.'-'.'index'.'.php';
		
		/* Запись контента в основной php фаил модуля */
		file_put_contents($file_name, "<h1> Модуль $modul_name </h1><?", FILE_APPEND);
		
		/* END */
		
	} // end function



function modul_template_standard($handle, $template_path, $lpm){
		
		/* Путь до фаила index */
		$index_path = $template_path.'/'.$handle.'-index';
			
			
			
		?><div class="<?="wrap-$handle wrap-modul"?>"><?		
			
			if($lpm){?>
									
				<div id="content" class="<?="content-$handle"?> content-modul">		
					<?get_template_part($index_path);?> 			
				</div><!--#content -->	
				
			<?}
		else{
			get_template_part($index_path);	 
			}
			
		?></div><!--.wrap--><?	
			
	}//end function
	
	
	
	
	function modul_template_standard_bs($handle, $template_path, $lpm){
		
	
			
	}//end function
	
	
	
	
	
	
	
	
	