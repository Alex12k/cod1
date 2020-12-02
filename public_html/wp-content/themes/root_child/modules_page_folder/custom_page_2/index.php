<?php
/* Template Name: custom_page_2 */


get_header();

/* Определение пути до папкис темой */
$theme_path = get_stylesheet_directory_uri();


//*===================Подключение php шаблонов======================*//

/* Собираем абсолютные адреса шаблонов всех модулей */
$All_php_templates	= get_dirs( __DIR__ .'/modules', 'fold', 1);
$All_index_files	= get_dirs( __DIR__ .'/modules', '*index.php', 2);

/* Массвив модулей равен существующим в директории modules папкам с модулями */
$Modules_array = array_keys($All_php_templates);


$i=0;
foreach($Modules_array as $modul_name){		
	$i++;		
	$empty_folder = glob( __DIR__ .'/modules/'.$modul_name.'/*' );	
				
	/* Если каталог только что созданный и следовательно пустой */
	if(!$empty_folder){
					
		info_message("Структура модуля $modul_name создана");
				
		$pos 	= mb_strpos($modul_name, '-'); 						// Сколько знако находится до тире
		$number = mb_substr($modul_name, 0, $pos);					//Какие именно это знаки
		
		if(	is_numeric($number)	){									//Являються ли эти знаки цифрой или буквами				
			$handle = str_replace($number.'-', '', $modul_name );	//Если цифры, то вырезаем их вместе с "-"
		}
		else {$handle = $modul_name; }								//Если НЕ цифры, то оставляем как есть
			
		$modul_folder 			= __DIR__ .'/modules/'.$modul_name;
			
			
		$css_folder		=	$modul_folder.'/css';
		$css_file 		=	$css_folder.'/'.$handle.'-style.css';
			
		$js_folder		= 	$modul_folder.'/js';
		$js_file 		=	$js_folder.'/'.$handle.'-script.js';
			
		$img_folder		=	$modul_folder.'/img';
			
		
		mkdir($modul_folder);			
		mkdir($css_folder);
		
				
		file_put_contents($css_file, "/*=== $modul_name Style ===*/", FILE_APPEND);
		
		mkdir($js_folder);
		file_put_contents($js_file, "/*=== $modul_name Script ===*/", FILE_APPEND);
		
		mkdir(__DIR__ .'/modules/'.$modul_name.'/'.'img');
		
			
		$file_name = __DIR__ .'/modules/'.$modul_name.'/'.$handle.'-'.'index'.'.php';
		
		file_put_contents($file_name, "<h1> Модуль $modul_name </h1><?", FILE_APPEND);
		
		}
		
} //end foreach

/*	Формируем масссив URL пригодных для get_template_part	*/
$Urls_for_get_template = abs2_url_for_get_template_part($All_php_templates);



?>	<div id="primary-home-page" class="site-content lpm container">
	<main id="main" class="site-main">	<?

	foreach($Urls_for_get_template as $file_name => $template_path) {
						
		$handle = remove_rashirenie($file_name);
				
		/* Формируем $handle текущего модуля */						
		/* Если первые 4 символа в имени папки модуля не равны none*/
		if (substr($handle, 0, 4) != 'none' ){
						
			$pos 	= mb_strpos($handle, '-'); 						// Сколько знако находится до тире
			$number = mb_substr($handle, 0, $pos);					//Какие именно это знаки
		
			if(	is_numeric($number)	){								//Являються ли эти знаки цифрой или буквами				
				$handle = str_replace($number.'-', '', $handle );	//Если цифры, то вырезаем их вместе с "-"
			}
			else {$handle = $handle; }	
		
		
		?><div class="<?='wrap-'.$handle. ' wrap-modul'?>">
		
		<?if($lpm == true):?>
		<div id="content" class="<?='content-'.$handle ?> content-modul">
		<?endif?>
		
		<?get_template_part($template_path.'/'.$handle.'-index');?> 
		
		<?if($lpm == true):?>
		</div><!--content# -->
		<?endif?>
		
		
		</div><!-- wrap# --><?		
		} #end IF
	}#end foreach								
	
?>	
	</main><!-- #main -->
</div><!-- #primary -->
	
<?
//*===================END Подключение php шаблонов======================*//
get_footer();

