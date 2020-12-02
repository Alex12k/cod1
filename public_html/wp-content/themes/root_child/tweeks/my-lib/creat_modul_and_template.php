<?php
	
	function creat_modul_structure($modul_name, $modul_folder){
				
				
		te("Структура модуля $modul_name создана");
			

			
		/* ОПРЕДЕЛЕНИЕ ПУТЕЙ ПАПОК И ФАИЛОВ */
		
		/* Убираем порядковый номер модуля */
		$handle = remove_gravity_index($modul_name);
		//te($handle);
		
					
		/* путь до папки css модуля и основного css фаила */
		$css_folder		=	$modul_folder.'/css';
		$css_file 		=	$css_folder.'/'.$handle.'-style.css';
		
		/* путь до папки js модуля и основного js фаила */		
		$js_folder		= 	$modul_folder.'/js';
		$js_file 		=	$js_folder.'/'.$handle.'-script.js';
			
		/* Путь до папки с картинками для модуля */	
		$img_folder		=	$modul_folder.'/img';
			
		/* END */	
		
		/* СОЗДАНИЕ ПАПОК И ФАИЛОВ И ЗАПИСЬ КОНТЕНТА */
		
		mkdir($modul_folder);	//Создание папки модуля		
		mkdir($css_folder);		//Создание папки для css модуля
		
		/* Запись комментария в css фаил модуля */		
		file_put_contents($css_file, "/*=== $modul_name Style ===*/", FILE_APPEND);
		
		mkdir($js_folder); //Создание папки для js модуля
		
		/* Запись комментария в js фаил модуля */
		file_put_contents($js_file, "/*=== $modul_name Script ===*/", FILE_APPEND);
		
		/* Создание папки img для модуля */
		mkdir($img_folder);
		
		/* Создание основного php фаила модуля */
		$file_name = $modul_folder.'/'.$handle.'-'.'index'.'.php';
		
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