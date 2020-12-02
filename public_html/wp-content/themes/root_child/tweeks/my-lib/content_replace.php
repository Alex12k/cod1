<?php


/* Функция принимает на вход строку, 
	искомую в ней под строку и строку замены
	и заменяет все вхождения

*/
	


			
	
function file_content_replace($needle, $replace, $template_path, $old_file, $new_file){
	
	
	/* Исходный контент фаила */
	$file_content	= file_get_contents($template_path.'/html/'.$old_file);	
	//print_arr(htmlspecialchars($file_content), "OLD");	


	$after_replace = str_replace($needle, $replace, $file_content);
	
	
	//print_arr(htmlspecialchars($after_replace), "NEW");	
	
	$new_location = $template_path.'/'.$new_file;
	file_put_contents($new_location, $after_replace);
}


$template_path	= get_stylesheet_directory().'/pixel';
$html_path = $template_path.'/htnl';
$old_file = 'index.html';
$new_file = 'index.php';



$template_path_uri = abs2url($template_path);

/* Массив того что меняем */
$needle = array(
				'href="style.css',
				'src="js/',
				'href="img/',
				'src="img/',
				'style="background-image: url(img',
				'<a href="index.html',
				'<a href="about',
				'<a href="services',
				'<a href="portfolio',
				'<a href="contact',
				'<a href="elements',
				
				
				);
		

/* Массив того на что меняем */		
$replace = array(
				"href=\"$template_path_uri/style.css\"",
				"src=\"$template_path_uri/js/",
				"href=\"$template_path_uri/img/",
				"src=\"$template_path_uri/img/",
				"style=\"background-image: url($template_path_uri/img",
				"<a href=\"http://alff.ru/pixel",
				"<a href=\"$template_path_uri/about",
				"<a href=\"$template_path_uri/services",
				"<a href=\"$template_path_uri/portfolio",
				"<a href=\"$template_path_uri/contact",
				"<a href=\"$template_path_uri/elements",
				);


//file_content_replace($needle, $replace, $template_path, $old_file, $new_file);






