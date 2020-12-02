<?php 

class myFtp
{
	
	private $ftpData = [];
	private $connID;
	private $messageArray = array();

	
	
	public function __construct($ftpData){		
		$this->ftpData = $ftpData;
		$this->connID  = $this->connID();	
	
		$this->login();
	
	}
		
		
	public function getLog(){return $this->messageArray;}	
	
			
	
	
	
	
	public function findFolder($fileName, $findFolder){		
		if(pathinfo($fileName)['extension']){te('ссылка ведет на фаил');return false;}
		return $this->_find($fileName, $findFolder, 'listFolder');
	}
	
	public function findFile($fileName, $findFolder){		
		if(!pathinfo($fileName)['extension']){te('Не указано расширение фаилы');return false;}
		return $this->_find($fileName, $findFolder, 'listFile');
	}
	
	
	
	
	/* Cоздать директорию */
	public function makeDir($dir) {		
		$res = ftp_mkdir($this->connID, $dir); 		
		if($res){te("Директория ". get_last_url_part($dir). " успешно создана");}else{te("Не удалось создать директорию ".get_last_url_part($dir));}
	}
	
	
/* 	Функция рекурсивного создания папки
*  	принимает на вход абсолютный путь и создаёт папку 
*	вместе со всей вложенной структурой дерева
*/
private function recursive_makedirs($dirpath, $mode=0777){	
	if(!file_exists($dirpath)){
		return is_dir($dirpath) || mkdir($dirpath, $mode, true);
	}else{return false;}	
}
	
	
	
	
	/*  Скачивает фаил в с удалённого сервера в указанную директорию, при условии.
		что одноименного фаила там нет  ftp_get() */
		
	public function downloadFile($localFile, $remoteFile){
		
		//te($localFile, 'local'); te($remoteFile, 'remote');
		
		/* Берём имя фаила, такое же как у фаила на удалённом сервере */
		$fileName = $this->LastPartUrl($remoteFile);
		
	
		/* Собираем путь к фаилу на локальном севере */
		//$localFile = $localFile.'/'.$fileName;
		
		
		/* Проверяем нет ли такого фаила, если нет то скачаем если есть то прекращаем выполнение функции */
		if(file_exists($localFile)){
			$this->writeMessage('Фаил с таким именем уже существует');	
			return;
			}
			
		$TransferMethod = $this->isTransferMethod($remoteFile);			
		$upload = ftp_get($this->connID, $localFile ,$remoteFile, $TransferMethod);
						
			if(!$upload){$this->writeMessage('Не удалось скачать файл!');}
			else{$this->writeMessage('Скачан фаил "'.$remoteFile.'" как "'.$fileName.'"');}							
	} //end
	
	
	
	
	/*  Скачивает фаил в с удалённого сервера в указанную директорию, при условии.
			что одноименного фаила там нет  ftp_fget() */
			
	public function downloadFileFopen($localFile, $remoteFile){
		
		/* Берём имя фаила, такое же как у фаила на удалённом сервере */
		$fileNmae = $this->LastPartUrl($remoteFile);		
		/* Собираем путь к фаилу на локальном севере */
		$localFile = $localFile.'/'.$fileNmae;
		
		/* Проверяем нет ли такого фаила, если нет то скачаем если есть то прекращаем выполнение функции */
		if(file_exists($localFile)){
			$this->writeMessage('Фаил с таким именем уже существует');	
			return;}
		
					
		$handle = fopen($localFile, 'w');		
		$TransferMethod = $this->isTransferMethod($remoteFile);	
		$upload = ftp_fget ($this->connID, $handle ,$remoteFile, $TransferMethod);
			
			
			if(!$upload){$this->writeMessage('Не удалось скачать файл!');}
			else{$this->writeMessage('Скачан фаил "'.$remoteFile.'" как "'.$fileNmae.'"');}		
	} //end
	
	
	
	
	

	
	/*---------------------------------------*/
	/*=============== PRIVATE ===============*/
	/*---------------------------------------*/
	
	/* Метод ищет папку или фаил в папке и во вложенных папках по имени и если находит, то возвращает его адрес */
	private function _find($fileName, $findFolder, $funcName){			
		
		$urlList = $this->$funcName($findFolder);						
		//print_arr($urlList, 'urlList');	
		foreach($urlList as $key => $url){
					
			$last_arr 	 = explode('/', $url);					
			$file  = $last_arr[count($last_arr)-1];									
			
			if($file == $fileName){			
				$res[] = $urlList[$key];
			}			
		} //end foreach
		
		return $res;
	}//end method
	
	
	
	/* Базовая функция для listFolder и listFile */
	private function _list($path, $subject=''){			
	
		/* Удалим "/" в конце path,	если он есть */
		if(substr($path, -1) == "/"){
			$path = substr($path, 0, -1);
			}
		
		$lines = ftp_rawlist($this->connID, $path, true);	
		
		//print_arr($lines);
		
		foreach ($lines as $line){
				
			/* Определим пути до папок и удалим ":" в конце  */
			if(substr($line, -1) == ":"){
				$path = substr($line, 0, -1);
				}
			


			$tokens = explode(" ", $line);  			//print_arr($tokens, 'tokens');     		
			$name = $tokens[count($tokens) - 1];		//print_arr($name, 'name'); 	
			$type = $tokens[0][0];						//print_arr($type, 'type');						
			$filepath = $path . "/" . $name;			//print_arr($filepath, 'filepath');
			
			
			//Если директория 
			if($type == $subject){			
				$folders[] = $filepath;					
				}
			
				
		}//end foreach

		//print_arr($folders);
		return $folders;			
	
	}//end
	
	
	
	public function listFile($path){	return $this->rawList($path, 'f'); 	}
	
	public function listFolder($path){	return $this->rawList($path, 'd');	}
	
	
	public function rawList($directory, $subject='') {
       
		
		$children = ftp_rawlist($this->connID, $directory, true);	
		//print_arr($children);
		
		$children = array_filter($children);
			
		if(is_array($children)){
    	
		    $items = array();
            foreach($children as $key => $child) {
		
			/* Определим пути до папок и удалим ":" в конце  */
			if(substr($child, -1) == ":"){$path = rtrim($child, ':');}
				
			/* Разбивает строку и возвращает массив */
		   $chunks = preg_split("/\s+/", $child);
			
			if($chunks[1]){	
	
				list($item['rights'], $item['number'], $item['user'], $item['group'], $item['size'], $item['month'], $item['day'], $item['time'], $item['name']) = $chunks;
				if($chunks[0][0] == 'd'){$item['type'] = 'd';}else{$item['type'] = 'f';}				   							
				$item['path'] = $path.'/'.$item['name'];							
					

				
				//te($subject);
				
				if(!$subject){
		
					$items[$key] = $item;					
				}else{			
					if($item['type'] === $subject){						
						$items[$key] = $item;
					}					
				}
											
				}						
            }
            return array_values($items);
        }
        // Throw exception or return false < up to you
    }
	
	
	
	

	
	
	

	
	
	/* Получение connID */
	private function connID(){
		
		// Создаём идентификатор соединения (адрес хоста, порт, таймаут)
		$connID 		= ftp_connect($this->ftpData['host'], "21", "30"); 
		//te($connID, 'идентификатор соединения');				
		return $connID;
		}//end
	
	
	private function login(){				
		// Авторизуемся на FTP-сервере
		$login_result 	= ftp_login($this->connID, $this->ftpData['user'], $this->ftpData['pass']	);
		/* Активация пассивного режима соединения */
		$this->passiveMode();											
		if($login_result){te('Соединение установленно');}	
		}//end
	
		
	/* Пассивный режим */
	private function passiveMode(){
			/* Пассивный режим соединенния (без него не работает) */
			ftp_set_option($this->connID, FTP_USEPASVADDRESS, false); // set ftp option
			ftp_pasv($this->connID, true); //make connection to passive mode			
		}		
	
	
	
	/* Получает последнюю часть ссылки */
	private function LastPartUrl($url){		
		return substr(strrchr(rtrim($url, '/'), "/"), 1);
	}//end
	
	
	/* Метод возвращает путь до родительской папки *Best Speed*/
	private function PathParentFolder($url){				
			$res = substr($url, 0, strrpos(rtrim($url, '/'), "/"));
			return $res;
		
		}
	
	
	private function isTransferMethod($remoteFile){		
		//метод передачи. Обычно, для текстовых - FTP_ASCII, а картинок - FTP_BINARY
		$asciiArray = array('txt', 'csv', 'php', 'html', 'htm', 'xml', 'doc', 'docx', 'css', 'js');   	
		$extension = end(explode('.', $remoteFile));		
		if (in_array($extension, $asciiArray)){$mode = FTP_ASCII;}else{$mode = FTP_BINARY;}	
		return $mode;
	}//end
	
	
		
	// запись и показ всех статусов и действий с FTP
	private function writeMessage($message = false){
		if($message != false){$this->messageArray[] = $message;} 
				else{return $this->messageArray;}
			}//end
		

	/* 	Функция принимает ftp конфиг для входа и адрес фаила, 
	*	содержимое которого требуется скопировать с ftp 
	*/
	public function ftp_get_contents($target_file){				
		$cfg = $this->ftpData;	
		$contents = file_get_contents("ftp://$cfg[user]:$cfg[pass]@$cfg[host]/$target_file", FILE_IGNORE_NEW_LINES);	
		if(!empty($contents)){return $contents;}else{return false;}		
	}
	
	
	
/* 	Метод принимает серверный путь до папки которую надо скопировать
*	код ftp конфига
*	и путь до папки куда будем копировать
*
* 	functions support
*		-	ftp_connect_id
*		-	ftp_list_files_recursive
*		-	ftp_get_contents
*		-	makedirs
*/
	
	public function copyFolder($remoteFolder, $newLocation){
	
		//te($remoteFolder); te($newLocation);
		
		$remote_catalog_neme =  $this->LastPartUrl($remoteFolder); //print_arr($remote_catalog_neme);	
		
		if(file_exists($newLocation.'/'.$remote_catalog_neme)){
			$this->writeMessage('Каталог с таким именем уже существует');
			//return false;
			}	
			
		$files = $this->listFile($remoteFolder); print_arr($files, 'Список фаилов');
	
		foreach($files as $key=>$file){ if($key==1){
			//break;
			}
							
			$arr  		= explode('/', $file); 									
			$fileName 	= array_pop($arr);		//te($file, 'Имя фаила');	
			$remoteFold = implode($arr, '/');	//te($remoteFold, 'путь до папки');
				
			$content_file = $this->ftp_get_contents($file);	
			//print_arr(htmlspecialchars($content_file));
		
		/* На этом этапе можно произвести replace_content 	*/		
		/* 		Text paresing and replacement();    	*/
		/*---------------------------------------------*/
		
		
		/* Получим часть пути начиная с названия сканируемой папки */
		$start 	= strpos($remoteFold, $remote_catalog_neme);	//te($start);
		$directory_tree	= substr($remoteFold, $start);			//te($directory_tree, 'directory_tree');				
		$newPath = $newLocation.'/'.$directory_tree;			//print_arr($newPath, 'newPath');
		
		/* Создание директорий */
		$this->recursive_makedirs($newPath);
		
		/* Запись фаилов с контентом */
		file_put_contents($newPath.'/'.$fileName, $content_file);
		
		}//end foreach
		
	}
		
	
	/* Работает в 200 раз быстрее чем copyFolder, но не может обрабатывать контент */
	public function copyFolder_v2($remoteFolder, $newLocation){
	
			//te($remoteFolder); te($newLocation);	
			$remote_catalog_neme =  $this->LastPartUrl($remoteFolder); //print_arr($remote_catalog_neme);		
			
					
			$items = $this->rawList($remoteFolder); 
			//print_arr($items, 'Список элементов');
			
			$folders = $this->folderFilter($items);
			$files	 = $this->filesFilter($items);
			//print_arr($folders);
			//print_arr($files);
			
			
			/* Создание папок */	
			foreach($folders as $folder){ 							
				$path = $folder['path'];			
				$newPath = $this->newPath($path, $remote_catalog_neme, $newLocation);			
				$this->recursive_makedirs($newPath);										
			}//end foreach
			
			
			/* Закачка фаилов */		
			foreach($files as $file){ 							
				$path = $file['path'];			
				$newPath = $this->newPath($path, $remote_catalog_neme, $newLocation);			
				
				//print_arr($path);
				//print_arr($newPath);
				$this->downloadFile($newPath, $path);										
			}//end foreach
			
			
			
		
}// end method


			private function newPath($path, $remote_catalog_neme, $newLocation){
				/* Получим часть пути начиная с названия сканируемой папки */
				$start 	= strpos($path, $remote_catalog_neme);			//te($start);
				$directory_tree	= substr($path, $start);				//te($directory_tree, 'directory_tree');				
				$newPath = $newLocation.'/'.$directory_tree;			//print_arr($newPath, 'newPath');
				return $newPath;
			}


			private function folderFilter($items){								
				foreach($items as $item){
					if($item['type'] == 'd'){$folders[] = $item;}					
				}
				return $folders;				
			}

			private function filesFilter($items){							
				foreach($items as $item){
					if($item['type'] == 'f'){$files[] = $item;}					
				}
				return $files;				
			}					




		
		
	
		
	}//END CLASS


	/*----------------------------------------*/
	/*============== Возможности ==============*/
	/*---------------------------------------*/

	#1 Показать список фаилов
	#2 Показать список директорий
	#3 Создать директорию
	#4 Найти фаил-(ы) в директории и вернуть его адрес
	#5 Найти папку-(и) в директории и вернуть его адрес



//	$themeFtpPath 	= 'alff.ru/public_html/wp-content/themes/omw2.0b-2/download_test';
//	$metallFtp 		= 'metallist.moskva/public_html/wp-content/themes/clean-root-child//modules_g5v2/10-slider/';
	
//	$remoteFile = "metallist.moskva/public_html/wp-content/themes/clean-root-child//modules_g5v2/10-slider/settings.php";
//	$localFile = $themeFtpPath.'/file.txt';

	
	/* Main */
//	$ftp 	  = 	new myFtp( ftp_config('main') );
	//$list = $ftp->listFile($themeFtpPath);
	
	
	/*Metall*/
	
	/*
	$ftp 	  = 	new myFtp( ftp_config('main') );
	
	$targetFile = "/metallist.moskva/public_html/wp-content/themes/clean-root-child/modules_g5v2/10-slider/settings.php";
	
	
	$remoteFolder 		=	'bank/omw';
	$newLocation = get_stylesheet_directory().'/download_test';
	
	
		
	$string = 'random_name.css';
	Timer::start();	
	while ($num <= 0){		
		
		// Тестируемая в цикле функция 
		//$ftp -> copyFolder($remoteFolder, $newLocation);
		
		
		$num++;
	}
		
	Timer::finish();	
	print_arr($ftp->getLog());
	
	
	*/
	
	






// открываем файл для записи
//$handle = fopen($local_file, 'w');
//var_dump($handle);


// установка соединения
//$conn_id = ftp_connect($ftp_server);

// вход с именем пользователя и паролем
//$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// пытаемся скачать файл и сохранить его в $handle
//if (ftp_fget($conn_id, $handle, $remote_file, FTP_ASCII, 0)) {
// echo "Произведена запись в $local_file\n";
//} else {
// echo "При скачивании $remote_file в $local_file произошла проблема\n";
//}



	//$url = $ftp->findFolder($folderName, $findFolder);
	//print_arr($url, 'найденная папка');

	//$res1 = $ftp->listFolder($findFolder);	/* 0.8 сек */
	//$res2 = $ftp->listFile($findFolder);  	/* 2 сек */

	//print_arr($res1, 'Папки' );
	//print_arr($res2, 'Фаилы');

	
	
	
	








