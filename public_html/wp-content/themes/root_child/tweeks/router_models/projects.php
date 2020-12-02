<?php
/* Подключаем роутер css_exp router */
add_action('wp_enqueue_scripts','FLEX_BOX');
function FLEX_BOX(){
	if( array_key_exists('FLEX-BOX', $_GET) ){
		get_template_part('FLEX-BOX/systems/index');
		exit;
	}
}




/* Подключаем роутер css_exp router */

add_action('wp_enqueue_scripts','NEW_FLEX_BOX');
function NEW_FLEX_BOX(){	
	
	if( array_key_exists('NEW-FLEX-BOX', $_GET) ){
		get_template_part('NEW-FLEX-BOX/systems/index');	
		exit;	
	}
}


/* Подключаем роутер css_exp router */

add_action('wp_enqueue_scripts','Project_flex_box');
function Project_flex_box(){	
	
	if( array_key_exists('Project_flex_box', $_GET) ){
		
		
		get_template_part('Project_flex_box/systems/index');	
		exit;	
	}
}



/* Подключаем роутер css_exp router */

add_action('wp_enqueue_scripts','Test_scripts');
function Test_scripts(){	
	
	if( array_key_exists('Test_scripts', $_GET) ){
			
		get_template_part('Test_scripts/systems/index');	
		exit;	
	}
}



 

	