<?php


// Определение какой тип старины загружается 
	if(is_page() && !$template_name){	$template_name 	= 'page';		}
	if(is_single())					{	$template_name 	= 'post';		}	
	if(get_template_name())			{	$template_name 	= get_template_name();	}	
	/* Потом это потребует переработки */
	if(is_home()){$template_name 	= 'page';}
	


//Чтение данных и настроект 	
	$cfg 	= 	read_settings('/cfg.txt');
	$data 	= unserialize(file_get_contents(get_stylesheet_directory().'/load.txt'));
	
	$min_mode		=	$cfg['min_mode'];
	$noCache		=	$cfg['no_cache'];
	$root_style		=	$cfg['root_style'];	

	

	if($noCache){$ver = rand();}
	if(get_template_name()){$isCustomPage =  true;}
	
	if($isCustomPage){
			$pageKey = __modules_page_folder_name__ .'/'.$template_name;
		}else{$pageKey = $template_name;}
		

	
	foreach(['css','js'] as $type){	
	
				$dataPage[$type] = array_merge(
						array('global' => 	$data[$type.'_stack']['global_stack'] ),
						array('options' => 	$data[$type.'_stack'][$pageKey]['options'] ),
						array('page' =>		$data[$type.'_stack'][$pageKey]['page_'.$type] ),
						array('min'=>		$data[$type.'_min_files'][$template_name])
					);							
			}
		
	//print_arr($dataPage, 'dataPage');
	
	foreach(['css','js'] as $type){	
			$stream[$type]  = array_merge($dataPage[$type]['global'], $dataPage[$type]['options'], $dataPage[$type]['page']);			
		}	

	//print_arr($stream, 'pageStream');

	




/* Оперделение нужного min фаила */

if($min_mode){/* if min mode */
	//te('min_mode_active');		
	wp_enqueue_style('min_css', $dataPage['css']['min'], $deps, $ver, $in_footer);
	
	$in_footer = true;
	wp_enqueue_script('min_js', $dataPage['js']['min'], $deps, $ver, $in_footer);
	
}else{
	//te('stack_mode_active');	
	foreach($stream['css'] as $handle => $dir_file){							
		wp_enqueue_style($handle, $dir_file, $deps, $ver, $in_footer);}
	
	foreach($stream['js'] as $handle => $dir_file){							
		wp_enqueue_script($handle, $dir_file, $deps, $ver, true);}
		
}//End else
	


/* Получаем slug текущей страницы */
/*
global $post;
$post_slug	=	$post->post_name;
print_arr($post_slug);
*/

if(!$root_style){										
		add_action('wp_enqueue_scripts', function(){wp_dequeue_style(array('root-style'));},100);		
}//end if
								

			
													
// Отключение  Google Fons и WP-Block-library 
wp_dequeue_style(array(
		'google-fonts', 
		'wp-block-library',
		'contact-form-7'	
	));



