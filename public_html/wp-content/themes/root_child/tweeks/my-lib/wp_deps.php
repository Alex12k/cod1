<?php

/*
* 1.   Посмотреть стили в очереди
* 2.   Посмотреть зарегистрированные стили
* 3.	  Посмотреть скрипты в очереди	
* 4.	  Посмотреть зарегистрированные скрипты
*/

/* Посмотреть стили в очереди */
function inspect_styles_queue() {
    
	global $wp_styles;
	$result = $wp_styles->queue;	

	print_arr($result);

}
//add_action( 'wp_print_styles', 'inspect_styles_queue');

	
/* Посмотреть зарегистрированные стили */
function inspect_styles_registered() {
    
	global $wp_styles;
	$result = $wp_styles->registered;
	
	print_arr($result);

}
//add_action( 'wp_print_styles', 'inspect_styles_registered');



/*  Посмотреть скрипты в очереди */
function inspect_scripts_queue() {
    global $wp_scripts;
	$result = $wp_scripts->queue;
	
	print_arr($result);

}
//add_action( 'wp_print_styles', 'inspect_scripts_queue' );



/*  Посмотреть зарегистрированные скрипты */
function inspect_scripts_registered() {
    global $wp_scripts;
	$result = $wp_scripts->registered;
	
	print_arr($result);

}
//add_action( 'wp_print_styles', 'inspect_scripts_registered' );