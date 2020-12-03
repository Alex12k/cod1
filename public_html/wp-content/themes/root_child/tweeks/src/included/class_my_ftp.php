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
	
		
			
	// Протестировано
	public function rawList($directory, $subject='') {
       
	   
	   
		$directory = $this->themePath($directory);
		
		
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
	
	
	// Протестировано
	public function listFile($path){	return $this->rawList($path, 'f'); 	}
	
	// Протестировано
	public function listFolder($path){	return $this->rawList($path, 'd');	}
	
	
	
	public function findFile($fileName, $findFolder){		
		if(!pathinfo($fileName)['extension']){te('Не указано расширение фаилы');return false;}
		return $this->_find($fileName, $findFolder, 'listFile');
	}
	
	
	public function findFolder($fileName, $findFolder){		
		if(pathinfo($fileName)['extension']){te('ссылка ведет на фаил');return false;}
		return $this->_find($fileName, $findFolder, 'listFolder');
	}
	

	
	
	
	
	/* Cоздать директорию */  //private или public ?
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
	
	
	
	
	/*  Скачивает фаил с удалённого сервера в указанную директорию, при условии.
		что одноименного фаила там нет  ftp_get() 
		Путь к localfile должен заканчиваться именем фаила под которым фаил будет скопирован
	*/
		
	public function downloadFile($localFile, $remoteFile){
		
		//te($localFile, 'local'); te($remoteFile, 'remote');
		
		/* Берём имя фаила, такое же как у фаила на удалённом сервере */
		$fileName = $this->LastPartUrl($remoteFile); //te($fileName);
		
		
		
		/* Собираем путь к фаилу на локальном севере */		
		$localFile = $localFile.'/'.$fileName;		//te($localFile);
		
	
			
		/* Проверяем нет ли такого фаила, если нет то скачаем если есть то прекращаем выполнение функции */
		if(file_exists($localFile)){
			$this->writeMessage('Фаил с таким именем уже существует');					
				return;							
		}
			
			
			
			
		$TransferMethod = $this->isTransferMethod($remoteFile);	
		//te($TransferMethod, 'transferMethod');
		
		te($localFile,	'localFile');
		te($remoteFile,	'remoteFile');
		
		$upload = ftp_get($this->connID, $localFile ,$remoteFile, $TransferMethod);
						
			if(!$upload){$this->writeMessage('Не удалось скачать файл!');}
			else{$this->writeMessage('Скачан фаил "'.$remoteFile.'" как "'.$fileName.'"');}							
	} //end
	
	
	
	
	/*  Скачивает фаил с удалённого сервера в указанную директорию, при условии.
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
			
	public function copyFolder($remoteFolder, $newLocation, $mode=''){
	
		//te($remoteFolder); te($newLocation);
		
		$remote_catalog_neme =  $this->LastPartUrl($remoteFolder); //print_arr($remote_catalog_neme);	
		$items = $this->rawList($remoteFolder);  //print_arr($files, 'Список фаилов');
		
		$folders = $this->folderFilter($items);
		$files	 = $this->filesFilter($items);
	
		/* Создание папок */	
		foreach($folders as $folder){ 							
				$path = $folder['path'];			
				$newPath = $this->newPath($path, $remote_catalog_neme, $newLocation);			
				$this->recursive_makedirs($newPath);										
		}//end foreach
		
		
		/* Закачка фаилов */		
		foreach($files as $file){
			
				$remotePath 		= $file['path'];			
				$newPath 			= $this->newPath($remotePath, $remote_catalog_neme, $newLocation);			
				
				if($mode=='ftp_get'){
					$FileParentFolder 	= PathParentFolder($newPath);
					$this->downloadFile($FileParentFolder , $remotePath);
				}
				
				if($mode=='put_contents'){	
					$content = $this->ftp_get_contents($remotePath); //print_arr($content); 				
					$res = file_put_contents($newPath, $content);	
					
					if($res){
						$this->writeMessage('Скачан фаил '.$remotePath);
					}
					
				}									
		}//end foreach
		
			
	} //end	
	
	
	/* 	Функция принимает ftp конфиг для входа и адрес фаила, 
	*	содержимое которого требуется скопировать с ftp 
	*/
	public function ftp_get_contents($target_file){				
		$cfg = $this->ftpData;	
		$contents = file_get_contents("ftp://$cfg[user]:$cfg[pass]@$cfg[host]/$target_file", FILE_IGNORE_NEW_LINES);	
		if(!empty($contents)){return $contents;}else{return false;}		
	}
	
	
	
	/* 
	*	Метод ищет фаил по имени в заданной директории, а затем скачивает его в укащанную папку 
	*/	
	public function findAndDownloadFile($targetFolder, $targetFile, $newLoacation){
		
		$targetFileInfo = $this->findFile($targetFile, $targetFolder);
		
		if(count($targetFileInfo)!=0){					
			
			if(count($targetFileInfo) < 2){
				$this->writeMessage('Найден нужный фаил');						
				$this->downloadFile($newLoacation, $targetFileInfo[0]['path']);
				
		
			}else{			
				$this->writeMessage(
					'Найдены более одного фаила с одинаковыми названиями, 
					требуется уточнить директорию нужного фаила'
					);
			}
		
			}else{			
				$this->writeMessage("В каталоге $targetFolder не найдено ни одного фаила с именем $targetFile");
			}
		
		
	}
	

	
	/*---------------------------------------*/
	/*=============== PRIVATE ===============*/
	/*---------------------------------------*/
	
	
	// Преобразование main path (для rawList)
	// Удаляет из ссылки первую часть серверного пути
	private	function themePath($absPath){			//te($absPath, 'absPath');	
		$domen_name = $_SERVER['SERVER_NAME']; 	 	//te($domen_name, 'domenName');
		$start 	= strpos($absPath, $domen_name); 	//te($start);		
		$res   =  substr($absPath, $start); 		//te($res);
		
		//te('themePath ACTIVATED');
		return $res;		
		}	
	
	
	
	
	/* Метод ищет папку или фаил в папке и во вложенных папках по имени и если находит, то возвращает его адрес */
	private function _find($fileName, $findFolder, $funcName){			
		
		$urlList = $this->$funcName($findFolder);						
		//print_arr($urlList, 'urlList');	
		
		foreach($urlList as $key => $url){
			//te($key); print_arr($url);
					
			$last_arr 	 = explode('/', $url['path']);			
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
		$asciiArray = array('txt', 'csv', 'php', 'html', 'htm', 'xml', 'doc', 'docx', 'css', 'js', 'json');   	
		$extension = end(explode('.', $remoteFile));		
		if (in_array($extension, $asciiArray)){$mode = FTP_ASCII;}else{$mode = FTP_BINARY;}	
		return $mode;
	}//end
	
	

	
	
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
		
	
			private function newPath($path, $remote_catalog_neme, $newLocation){
				/* Получим часть пути начиная с названия сканируемой папки */
				$start 	= strpos($path, $remote_catalog_neme);			//te($start);
				$directory_tree	= substr($path, $start);				//te($directory_tree, 'directory_tree');				
				$newPath = $newLocation.'/'.$directory_tree;			//print_arr($newPath, 'newPath');
				return $newPath;
			}


		


		// запись и показ всех статусов и действий с FTP
		private function writeMessage($message = false){
			if($message != false){$this->messageArray[] = $message;} 
				else{return $this->messageArray;}
			}//end
		
	
	
		
	}//END CLASS


	/*----------------------------------------*/
	/*============== Возможности ==============*/
	/*---------------------------------------*/

	#1 Показать список фаилов
	#2 Показать список директорий
	#3 Создать директорию
	#4 Найти фаил-(ы) в директории и вернуть его адрес
	#5 Найти папку-(и) в директории и вернуть его адрес



	//$themeFtpPath 	= '/109r.online/public_html/wp-content/themes/omw2.0b-2/download_test';
	//$metallFtp 		= 'metallist.moskva/public_html/wp-content/themes/clean-root-child//modules_g5v2/10-slider/';
	
	//$remoteFile = "metallist.moskva/public_html/wp-content/themes/clean-root-child//modules_g5v2/10-slider/settings.php";
	//$localFile = $themeFtpPath.'/file.txt';

	

	
	/* Main */
			
		//$server = 'main';
		//$findFolder = '/109r.online/public_html/wp-content/themes/omw2.0b-2/download_test';
		//$findFolder = get_stylesheet_directory().'/download_test';
		
	

		
		
		////$server = 'metall';	
		//$findFolder = '/metallist.moskva/public_html/wp-content/themes/clean-root-child/download_test';
		
		
		//$ftp 	  = 	new myFtp( ftp_config($server) );
		
		


		/*--------------method rawList------------------*/	
		//Находит все папки с заданым именем в указанной папке и всех её под каталогах
				
		// Может искать отдельно папки либо фаилы , принимая вторым параметром
		//'d' или 'f';
		// Является прородителем listFile и listFolder
		
		 
		//Папка в которой ищем $findFolder;
		
		//$res = $ftp->rawList($findFolder, 'd');
		//print_arr($res, 'результат поиска фаила');
	
		
		
		/*--------------method listFolder ------------------*/		
		//$list = $ftp->listFile($findFolder);	
		//print_arr($list , 'тест метода listFile возвращает список фаилов');
		
		
		
		/*--------------method listFile ------------------*/		
		//$list = $ftp->listFolder($findFolder);	
		//print_arr($list , 'тест метода listFolder возвращает список папок');
	
	
	
	
		/*--------------method findFile------------------*/		
		//Находит все фаилы с заданым именем в указанной папке и всех её под каталогах

		
		//имя искомого фаила
		//$fileName 	= 'test1.css';
		
		//Папка в которой ищем $findFolder;
		
		//$res = $ftp->findFile($fileName, $findFolder);
		//print_arr($res, 'результат поиска фаила');
	
		
		/*--------------method findFolder------------------*/	
		//Находит все папки с заданым именем в указанной папке и всех её под каталогах

		
		//имя искомого фаила
		//$fileName 	= 'folder1'; 
		
		//Папка в которой ищем $findFolder;
		
		//$res = $ftp->findFolder($fileName, $findFolder);
		//print_arr($res, 'результат поиска фаила');
	
		/* --------------Метод downloadFile-------------- */
		
	
//		$ftp = new myFtp( ftp_config('main') );
				
//		/* Где ищем */				$targetFolder 	= 'bank/php/scripts';			
//		/* Имя фаила который ищем*/ 	$targetFile		= 'deps_loader.php';		
//		/* Куда будем копировать */		$newLocation 	= get_stylesheet_directory().'/test';
		
//		/* Вызываем метод findAndDownload	*/	
//		$ftp->findAndDownloadFile($targetFolder, $targetFile, $newLocation);
		
//		print_arr($ftp->getLog(), 'log');

		
		
		  
	  
		/*--------------method copyFolder------------------*/
		//из main Bank в main Themes
//		$cfg 	  =		ftp_config('main');
//		$ftp 	  = 	new myFtp($cfg);
		
//		$remoteFolder 		=	'bank/php';
//		$newLocation = get_stylesheet_directory().'/test';
		
//		$mode = 'ftp_get';
		
		//$mode = 'put_contents';
		/*  В mode put_contents метод не скачивает пустые фаилы,
			и так же не скачивает фаилы из папок где изначально нет ни одной вложенной папки
		*/
				
//		$ftp -> copyFolder($remoteFolder, $newLocation, $mode);
//		print_arr(	$ftp->getLog()	);
	
	
	
	
	
	
		/*--------------method copyFolder (с удаленного сервера)---------------*/
		//из main Bank в main Themes
		//$cfg 	  =		ftp_config('metall');
		//$ftp 	  = 	new myFtp($cfg);
		
		//$remoteFolder 		=	'/metallist.moskva/public_html/wp-content/themes/clean-root-child/fonts';
		//$newLocation = get_stylesheet_directory().'/download';
		
		//$mode = 'ftp_get';	
		//$mode = 'put_contents';
		/*  В mode put_contents метод не скачивает пустые фаилы,
			и так же не скачивает фаилы из папок где изначально нет ни одной вложенной папки
		*/				
		//$ftp -> copyFolder($remoteFolder, $newLocation, $mode);
		//print_arr(	$ftp->getLog()	);			
		/*-------*/

	
	
	
	/*Metall*/
	
	/*
	$ftp 	  = 	new myFtp( ftp_config('main') );
	
	$targetFile = "/metallist.moskva/public_html/wp-content/themes/clean-root-child/modules_g5v2/10-slider/settings.php";
	
	
	$remoteFolder 		=	'bank/omw';
	$newLocation = get_stylesheet_directory().'/download';
	
	
		
	$string = 'random_name.css';
	Timer::start();	
	while ($num <= 0){		
		
		// Тестируемая в цикле функция 
		$ftp -> copyFolder($remoteFolder, $newLocation, 'ftp_get');
		
		
		$num++;
	}
		
	Timer::finish();	
	print_arr($ftp->getLog());
	
	
	
	
	






	
	
	
	








