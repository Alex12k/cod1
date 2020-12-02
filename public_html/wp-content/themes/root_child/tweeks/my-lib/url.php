<?
/*	1.1	Убирает расширение у любой строки 			
*	1.2	Убирает расширение у любой строки 
*	2.	Убирает расширение у массива строк 			
*	3.	Преобразование абсолютного URL в относительный 
*	4.	Преобразование абсолютный URL в короткую ссылку для get_template_part
*	5.	Преобразование абсолютнго URL в короткую версию которая начинается с /wp_content
*	6.	Получение последней части URL
*	7.	Получающая относительного url от имени домена, до темы wordpress
*	8.	Получаение Handle из ссылки
*	9.	Получение любой части ссылки
*	10.	Функция удаляет цифры и - в начале имени фаила.
*/


/* #1.1 Убрать расширение у 1 фаила
* Функция принимает фаил и вырезает у него раcширение, возвращает handle.
*/

function ubrat_rashirenie($file_name){

//Уберём расширения для формирования $handle
	$handle = preg_replace('/\.\w+$/', '', $file_name); 
	return $handle;
}


/* #1.2 Функция убирающая расширение фаила */
	function remove_rashirenie($file_name){
		return preg_replace('/\.\w+$/', '', $file_name);
	}//END Function




/* #2 Убрать расширение у массива строк
* 	Функция принимает массив и удаляет расширение у каждого элемента массива
*/
function ubrat_rashirenie_in_array($Array_names){
	
	foreach($Array_names as $item){
		$item = preg_replace('/\.\w+$/', '', $item); 
		$Files_handle[] = $item;
		
	}
	return $Files_handle;
}


/* #3 Функция преобразование абсолютнго URL в относительный */
	function abs2url($abs_link){
		return $uri = str_replace (ABSPATH , site_url().'/' , $abs_link );
	
	} //END Function



/*	#4 Функция преобразцет абсолютный URL в короткую ссылку для get_template_part */
	function abs2_url_for_get_template_part($url){		
		$url	=	str_replace (get_stylesheet_directory().'','', $url );	
		return $url	=	preg_replace('/\.\w+$/', '', $url);
	} //END Function




/* #5 Функция преобразование абсолютнго URL в короткую версию которая начинается с /wp_content */
	function abs2_short_url($abs_link){		
		return $url = str_replace (ABSPATH,''.'/' , $abs_link );	
	} //END Function





/*	#6	Функция получающая последнюю часть url */
	function get_last_url_part($url){		
		$last_arr = explode('/', $url);					
		return $file_name = $last_arr[count($last_arr)-1];		
	}//END Function
	
	
/* 	#7	Функция получающая относительный url от имени домена, до темы wordpress */
function theme_path(){
	
		$domen_name = $_SERVER['SERVER_NAME'];
		$theme_path = get_stylesheet_directory();
		$start 	= strpos($theme_path, $domen_name);
return	$res	= substr($theme_path, $start);
}



/* #8	Функция получающая Handle из ссылки */
function get_handle($url){	
	$last_arr 	= explode('/', $url);
	$file_name 	= $last_arr[count($last_arr)-1];
	return preg_replace('/\.\w+$/', '', $file_name);		
}




/*	#9 Функция получающая любую часть ссылки
*  	- принимает на вход URL из которого будем брать какую то часть с конца
*	- принимает на вход параметр какую часть URL надо взять	
*	- Возвращает нужную часть URL
*
*/

function get_part_url($url, $number=''){			
	$url_arr = explode('/', $url);
	return $part = $url_arr[count($url_arr) + $number-1];				
}




/* БОЛЕЕ БЫСТРЫЕ АНАЛОГИ на 10.10.2020 */
	/* Функция возвращает путь до родительской папки *Best Speed*/
	function PathParentFolder($url){				
		return substr($url, 0, strrpos(rtrim($url, '/'), "/"));
	}
	
	
	/* Получает последнюю часть ссылки *Best Speed */
	function LastPartUrl($url){		
		return substr(strrchr(rtrim($url, '/'), "/"), 1);
	}//end








/*	#10	Функция принимает строку, и если в её начале стоят цифры
		а после цифр стоит "-" , то вырезает цифры вместе с "-"
		(важный компонент manager-a)
*/
function remove_gravity_index($data){
			
	if(is_array($data)){		
		$data_is_array = true;
	}else{
		$data_is_array = false;
		$data = array($data);	
		}		
		
	foreach($data as $key => $item){
		
		$pos 	= mb_strpos($item, '-'); 		// Сколько знаков находится до тире
		$number = mb_substr($item, 0, $pos);	//Какие именно это знаки		
		if(	is_numeric($number)	){				//Являються ли эти знаки цифрой или буквами				
			$handle[$key] = str_replace($number.'-', '', $item );	//Если цифры, то вырезаем их вместе с "-"
		}	
		else {$handle[$key] = $item; }								//Если НЕ цифры, то оставляем как есть
	
	}	
	// В зависимости от того пришёл на вход массив или строка, возвращаем массив или строку
	if($data_is_array){return $handle;}else{return $handle[0];}

}


