<?php



/* Формируем списки main стилей и скриптов */
function get_project_items($current_state_structure){

	/* Все стили проекта */
	$project_styles = $current_state_structure['base_css'] +$current_state_structure['modules_css']; 		
	
	/* Все скрипты проекта */
	$project_scripts = $current_state_structure['js_stack']+$current_state_structure['modules_js'];  
	
	
	$project_items = array(
		'css' =>  $project_styles,
		'js'  =>  $project_scripts
	);	
	//print_arr($project_items, '(micro_func) стили и скрипты проекта');
	
	return $project_items;
}


/*  Сбор данных о подключенных скриптах плагинов  */
function get_done_items($wp_styles, $wp_scripts){
		
		
	te('Функцуция работает');

	
	/* Оперделяем списки зарегистрированных и выведенных стилей */
	$registered_styles 	= $wp_styles->registered; 	//print_arr($registered_styles, ' registered css' );
	$done_styles 		= $wp_styles->done; 		//print_arr($done_styles, ' done css');	
		
	$registered_scripts = $wp_scripts->registered;	//print_arr($registered_scripts, ' registered js');
	$queue_scripts 		= $wp_scripts->queue;		//print_arr($queue_scripts, ' queue js');


	
	
	/* И формируем из них два масссива выведенных стилей вида fileName => src */
	
	foreach($done_styles as $key => $value){
		unset($done_styles[$key]);
		$done_styles[$value.'.css'] = $registered_styles[$value]->src;		
		} 	
	
	foreach($queue_scripts as $key => $value){			
		unset($queue_scripts[$key]);
		$queue_scripts[$value.'.js'] = $registered_scripts[$value]->src;	
		} 	

	
	$done_items = array(
		'css' =>  $done_styles,
		'js'  =>  $queue_scripts
	);	

	return $done_items;
}




function get_plugin_items($done_items, $project_items){
	

	$done_styles 		= 	$done_items['css'];
	$project_styles 	=	$project_items['css'];
		
	$queue_scripts 		=	$done_items['js'];
	$project_scripts	= 	$project_items['js'];
	

	$pugin_styles  	= array_diff_key($done_styles, $project_styles);			//print_arr($w_styles);
	$plugin_scripts = array_diff_key($queue_scripts, $project_scripts);			//print_arr($w_scripts);
	
	
	$plugin_items = array(
	
		'css' =>  $pugin_styles,
		'js'  =>  $plugin_scripts,
		
	);	
	
	//print_arr($plugin_items, '(micro_func): скрипты и стили подключенных плагинов' );

	return $plugin_items;
}



function if_changed($plugin_items){
	
	/* посчитали hash */
	$current_hash 	= md5(serialize($plugin_items['css']+$plugin_items['js']));	//print_arr($curent_hash, 'hash текущего массива');
	//te($current_hash, '(function if_changed) - current_hash:');
		
	$old_hash = file_get_contents(__DIR__ .'/plugins_hash.txt');
	//te($old_hash,  '(function if_changed) - old_hash:');
		
	if($current_hash != $old_hash){
		/* сохраняем hash */
		file_put_contents(__DIR__ .'/plugins_hash.txt', $current_hash);
		
		return true;
	}

};










