<?php
/* Функция хранит данные для ftp соединений и отдаёт их по запросу */
function ftp_config($request){	
		
	$main = array(
		'user'=> 'igpsya3i',
		'pass'=> 'nagval1477',
		'host'=> 'igpsya3i.beget.tech',	
		'port'=> '21',
		);
		
	$metall = array(
		'user'=> 'metall24',
		'pass'=> 'CKlXtZhc',
		'host'=>'metall24.beget.tech',	
		'port'=> '21',
	);
	
	$pilates = array(
		'user'=> 'pilates19',
		'pass'=> 'VqQvFGFQ',
		'host'=>'pilates19.beget.tech',	
		'port'=> '21',
	);

	$orange = array(
		'user'=> 'u362160',
		'pass'=> 'ester4isher',
		'host'=>'u362160.ftp.masterhost.ru',	
		'port'=> '21',
	);
	
	
	$dsc_colors = array(
		'user'=> 'h14679-2_ftp',
		'pass'=> 'fK9Jd:Kw',
		'host'=> 'ftp.h14679-2.r01host.ru',	
		'port'=> '21',
	);
	


	if($request == 'main')	{$cfg = $main;}
	if($request == 'metall'){$cfg = $metall;}
	if($request == 'pilates'){$cfg = $pilates;}
	if($request == 'orange'){$cfg = $orange;}
	if($request == 'dsc_colors'){$cfg = $dsc_colors;}
	return $cfg;
}
//print_arr(ftp_config('pilates'), ' f t p ');


/* 	Функция принимает ftp конфиг для входа и адрес фаила, 
*	содержимое которого требуется скопировать с ftp 
*/
function ftp_get_contents($cfg, $target_file ){			
	
	/* Динамически назначаем переменные */
	foreach($cfg as $key => $value){ $$key = $value;}	
	
	
	$contents = file_get_contents("ftp://$user:$pass@$host/$target_file", FILE_IGNORE_NEW_LINES);	
	
	//print_arr($contents,  "contents $target_file");
	
	if(!empty($contents)){return $contents;}
	else{
		return false;
		}
	
}


/* Функция принимает на вход cfg_name и возвращает conn_id */
function ftp_connect_id($cfg_name){
	/* Получение FTP конфига из функции */
	$cfg = ftp_config($cfg_name);
		
	$host	=	$cfg['host']; 	//print_arr($host);
	$user	=	$cfg['user'];	//print_arr($user);		
	$pass	=	$cfg['pass'];	//print_arr($pass);
	
	
	/* Установка соединения */
	$conn_id 		= ftp_connect($cfg['host'], "21", "30"); // Создаём идентификатор соединения (адрес хоста, порт, таймаут)
	$login_result 	= ftp_login($conn_id, $cfg['user'], $cfg['pass']); // Авторизуемся на FTP-сервере	
	if($login_result){
		te('соединение установленно');
		}
		else{exit("Ошибка подключения");}
		
	/* Пассивный режим соединенния (без него не работает) */
	ftp_set_option($conn_id, FTP_USEPASVADDRESS, false); // set ftp option
	ftp_pasv($conn_id, true); //make connection to passive mode
	
	return $conn_id;
	
}



/* Функция проверяет является ли последний элемент ссылки, фаилом с одним из популярных разрешений */
function have_extension($item){
	/* Если существует расширение */	
				$extension = pathinfo($item)['extension'];				
				/* И оно принадлежит к группе известных расширений */
				$array_ext = array('php','css','js','html','txt','json','otf','eot','ttf','woff','woff2', 'svg', 'jpg', 'jpeg', 'png');
				
				if($extension && in_array($extension, $array_ext)){
					return true;
				}else{return false;}
}




/* 
*	Функция принимает на вход путь до директории на другом сервере 
*	и ID соединения с сервером.
*	Рекурсивно проходит всё дерево каталогов и возвращает полный список фаилов
*	
*	По материалам: https://coderoad.ru/36310247/PHP-FTP-рекурсивный-список-каталогов
*/
function ftp_list_files_recursive($ftp_stream, $path){
		
    $lines = ftp_rawlist($ftp_stream, $path); //print_arr($lines);
    $result = array();

    foreach ($lines as $line){
  
		$tokens = explode(" ", $line);  			//print_arr($tokens, 'tokens');     		
		$name = $tokens[count($tokens) - 1];		//print_arr($name, 'name'); 
        $type = $tokens[0][0];						//print_arr($type, 'type');					
        $filepath = $path . "/" . $name;			//print_arr($filepath, 'filepath');

		/* Если директория */
        if ($type == 'd'){
            $result = array_merge($result, ftp_list_files_recursive($ftp_stream, $filepath));
        }else{
            $result[] = $filepath;
        }//end else
    }//end foreach
    return $result;
}//end function


/* Интерфейс */
//$ftp_stream 	= ftp_connect_id('metall');
//$path			='metallist.moskva/public_html/wp-content/themes/clean-root-child/modules_g5v2';


//$RES = ftp_list_files_recursive($ftp_stream, $path);
//print_arr($RES);
/* end */ 



/* 	Функция рекурсивного создания папки
*  	принимает на вход абсолютный путь и создаёт папку 
*	вместе со всей вложенной структурой дерева
*/
function makedirs($dirpath, $mode=0777) { 
	return is_dir($dirpath) || mkdir($dirpath, $mode, true); 	
	}



/* 	Функция принимает абсолютный путь до папки и рекурсивно 
	удаляет её вместо со всеми каталогами и фаилами 
*/
function RemoveDir($path){

	if(file_exists($path) && is_dir($path)){ 
		$dirHandle = opendir($path);
		while (false !== ($file = readdir($dirHandle))){
		if ($file!='.' && $file!='..'){
		$tmpPath=$path.'/'.$file;
		chmod($tmpPath, 0777);

		if(is_dir($tmpPath)){  // если папка
			RemoveDir($tmpPath);
		}else{ 
			if(file_exists($tmpPath)){
			unlink($tmpPath);}
			}
		}
	}
	closedir($dirHandle);
		if(file_exists($path)){
			rmdir($path);}
				}else{echo "Папка не найдена";}
} //end function


/*------------------------------------------*/

/* 	Функция принимает серверный путь до папки которую надо скопировать
*	код ftp конфига
*	и путь до папки куда будем копировать
*
* 	functions support
*		-	ftp_connect_id
*		-	ftp_list_files_recursive
*		-	ftp_get_contents
*		-	makedirs
*/

function copy_folder($path, $cfg_name, $new_location){
	//te($path); te($new_location); te($cfg_name);
	$remote_catalog_neme =  pathinfo($path)['basename']; 
	//print_arr($remote_catalog_neme);
	
	$conn_id = ftp_connect_id($cfg_name);
	$files = ftp_list_files_recursive($conn_id, $path);  
	
	print_arr($files);
	
	
	foreach($files as $file){ 
		
			
		/* File - путь к фаилу на удалённом сервере */
		$path = pathinfo($file)['dirname']; 		te($path , 'путь');
		/* Имя фаила */
		$file = pathinfo($file)['basename'];		te($file, 'имя фаила');
		
		$content_file = ftp_get_contents(ftp_config('main'), $path.'/'.$file);
				
		/* На этом этапе можно произвести replace_content */
			//print_arr(htmlspecialchars($content_file));
		/*--------------------------------------------*/
		
		
		/* Получим часть пути начиная с названия сканируемой папки */
		$start 	= strpos($path, $remote_catalog_neme);  
		$directory_tree	= substr($path, $start);	//te($directory_tree, 'directory_tree');			
					
		$new_path = $new_location.'/'.$directory_tree;	//print_arr($new_path, 'new_path');
		
		
		makedirs($new_path);
		file_put_contents($new_path.'/'.$file, $content_file);
		
		}//end foreach		
}


//$path 		=	'bank/omw';
//$new_location = get_stylesheet_directory().'/download';

//copy_folder($path, 'main', $new_location);










/* Загрузка и удаление OMW */
/*
	$cfg_name 		=	'main';
	$bank_path 		=	'bank/omw';

	$omw_download_location 	= 	get_stylesheet_directory();
	$omw_theme_location		= 	get_stylesheet_directory().'/omw';

	

	$user_name  =	wp_get_current_user()->data->user_login;
	$user_roles =	wp_get_current_user()->roles[0];
	$user_level	=	current_user_can('level_10');

	//print_arr($user_name);
	//print_arr($user_roles);
	//print_arr($user_level);
		
	
	if($user_name == 'Alex12k' && $user_roles == 'administrator' && $user_level){
		if(!is_dir($omw_theme_location)){			
			//te('Login Level 10 and папка OMW не существует Копируем');
			//copy_folder($bank_path, $cfg_name, $omw_download_location);
		}
			
		}else{		
			// Удалить OMW из темы
			if(is_dir($omw_theme_location)){
				//RemoveDir($omw_theme_location);
			}
		}
*/


/* END Загрузка и удаление OMW */

// Скачаь OMW из банка
//copy_folder($bank_path, $cfg_name, $omw_download_location);

// Удалить OMW из темы
//RemoveDir($omw_theme_location);


/*------------------------------------------*/
	
//$path			=	'metallist.moskva/public_html/wp-content/themes/clean-root-child/modules_g5v2';
//$new_location = get_stylesheet_directory().'/download';
//$cfg_name 		=	'metall';

//$path =	'bank/css_frameworks';
//$cfg_name 		=	'main';