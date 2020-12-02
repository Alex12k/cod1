<?php


/* Функция принимает путь до фаила с конфигом */
/* Улучшенная версия v2 */

function read_settings($path){
	

		/* Чтение фаила */
		$content_cfg = file(get_stylesheet_directory().$path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);	
		
		//print_arr($content_cfg);
		
		/* Удаляем пустые строки и табы*/
		foreach($content_cfg as $key=>$val){				
			
			$val = str_replace(' ', '', $val);
			$val = str_replace('	', '', $val);						
			if(strlen($val) != 0){$content_not_space[$key] = $val;}									
		}/* End */	
		
		
			
		//print_arr($content_not_space, 'not_space');
		
			
		/* Преобразование текста фаила в массив */		
		$i = 0;
		foreach($content_not_space as $n_string => $item){
					
				
			$str_with_key 	= strpos($item,':');		
			$last_simbol 	= substr($item, -1);
			
			/* Если в строке присутсвует key массива */
			if($str_with_key !== false){$key = explode(':',$item)[0];}
			
				
			
			$parent_arr		= explode('/',$key)[0]; //te($parent_arr);
			$child_arr		= explode('/',$key)[1]; //te($child_arr);
					
			$val			= explode(':',$item)[1];						
			
							
			/* Берём строку значения val и раскладываем на под масссив */
			$value 			= explode(',', $val);
			if($value[0]==='true'){$value[0]  = true;}
			if($value[0]==='false'){$value[0] = false;}

											
			/* Если есть дочерний массив */				
			if($child_arr){				
							
				if(count($value)==1){					
						$res[$parent_arr][$child_arr] = $value[0];				
					}else{
						$res[$parent_arr][$child_arr] = $value;
					}
				
			}
			/* если нет дочернего массива */
			else{																	
				if(count($value)==1){									
					$res[$key] = $value[0];
					}else{						
						$res[$key] = $value;					
					}//end else 1
															
			}//end else 2
														
		$i++;								
		} // end foreach
		
		//print_arr($res,'новый массив');
		
		return $res;
	}//end function	
	
/* end read settings */


function write_settings($data, $path_cfg){
		
			
	$path_cfg = get_stylesheet_directory().'/'.$path_cfg;
	//print_arr($data, 'данные полученые из функции');
	/* Чтение cfg */
	$content_cfg = file($path_cfg, FILE_IGNORE_NEW_LINES);	
	//print_arr($content_cfg, 'конфиг из листа');
		
				
	foreach($data as $where => $add_values){
			
						
		/* Уберём из массива все повторябщиеся значения */	
		$add_values = array_unique($add_values);	
			
		/* Если массив не пуст */	
		if(!empty($add_values[0])){				
						
			foreach($content_cfg as $n_string => $item){				
				
			$key			= 	trim(explode(':',$item)[0]);	
			$value			=	explode(':',$item)[1];
				
					
			/* Определяем строки где будем вносить правки */
			if($key == $where){
				
				$i = 0;
				foreach($add_values as $new_value){
				
				
				/*	Если значение в строке массива было пусто 
					и при записи идет не первая итерация */			
				if(empty(trim($value)) && $i == 0){$simbol = ' ';}
				else{$simbol = ', ';}
				$i++;
						
				//te($new_value);						
				/* Ищем элемент new_value в строке и если его нет добавляем его */
					if(strpos($value, $new_value) == NULL){
						//print_arr($new_value, 'добавляемы элемент');
						$item = $item.$simbol.$new_value;											
					}//end if				
				}//end foreach_3
				
				$content_cfg[$n_string] = $item;
				
			}//end if (строки где вносятся изменения)					
		
		} //end foreach_2	
	} //end if на пустой массив				
	
}//end foreach_1
	
	
	/* 	Получили массив $content_cfg с добавленными новыми элементоми
	*	Преобразуем его в строку с добавлением "\n" и перезапишем конфиг
	*/	
	foreach($content_cfg as $str){$string .= $str."\n";	}
	file_put_contents($path_cfg, $string);
	
	}//end function	
	
/* end read settings */



/* Название ключа массива в который будем добавлять элемент */
$where= 'omw_page_2/css';

/* Добавляемый элемент */
$new_element = array('element_1', 'element_2');



$content_cfg = file(get_stylesheet_directory().'/cfg_test.txt', FILE_IGNORE_NEW_LINES);	
//print_arr($content_cfg);





function injector($css='', $js=''){	
	
		/* Удаляем лишние пробелы */
		$css = preg_replace('/\s+/', '', $css);
		$js = preg_replace('/\s+/', '', $js);


		/* Определение какой тип страницы загружается */
		if(is_page() && !$template_name){	$template_name 	= 'page';		}
		if(is_single())					{	$template_name 	= 'post';		}	
		if(get_template_name())			{	$template_name 	= get_template_name();	}	
	
				
		$data = array(					
					$template_name.'/css' 	=>	explode(',',$css),
					$template_name.'/js'	=>	explode(',',$js)
					);
		
		//print_arr($data);		
		write_settings($data, 'cfg_test.txt');
				
}

	
function draft_1(){
	
	/*	Механизм подключение css и js фаилов через конфиг
	*	первым параметром принимает список стилей css,
	*	вторым параметром список стилей js
	*/	
	//injector('new_style', 'new_script');
		
	
}

//add_action('omw_page_2_modul_1', 'draft_1');
//add_action('wp_head', 'draft_1');
//add_action('yaml_parser', 'draft_1');



/* ЭКСПЕРИМЕНТ ПО КОДИРОВАНИЮ МАССИВА */

function read_settings_special($path){
	

		/* Чтение фаила */
		$content_cfg = file(get_stylesheet_directory().$path, FILE_IGNORE_NEW_LINES);	
		
		//print_arr($content_cfg, 'чтение фаила');
		

		
		function return_value($first_key, $value){
			
			//te("$first_key ## $value");
			
			/* Если в ключе нет знака "/" */		
			if(strpos($first_key,'/') == NULL){
						
					if(strpos($value,',') != NULL){
							$val = explode(',',$value);
						}else{return $value;}
						
						//print_arr($val);
						return $val;
						}
					
			if(strpos($first_key,'/') != NULL){				
						
					$key 	= 	explode('/',$first_key)[1];
					
					if(strpos($value,',') != NULL){
						$value 	=	explode(',',$value);}
						
					$val =  array($key	=> $value);
					//print_arr($val, 'если есть знак /');
					return $val;
				}
						
			//te($value);
			/* Если в значении нет запятых */
			//if(	strpos($value,',') == NULL){return $value;}
							
			}
			
			
		function return_key($first_key){
			if(	strpos($first_key,'/') == NULL){return $first_key;}
			else{				
				
				return  explode('/',$first_key)[0];									
			}
		}	
			
		/* Преобразование текста фаила в массив */		

		foreach($content_cfg as $n_string => $item){
										
			$first_key  = trim(explode(':',$item)[0]);
			$value		= trim(explode(':',$item)[1]);
					
			$array[$n_string+1] = array(													
					return_key($first_key) => return_value($first_key, $value),								
					);
					
			//$array_2[return_key($first_key)] = return_value($first_key, $value);
					
																										
		} // end foreach
		
	
		//print_arr($array,'новый массив');
		
		foreach($array as $nstr => $item){
						
			$key = key($item);			
			if(empty($key)){
				$key = 'eol-'.$nstr; 
				$item = array('nstr' =>$nstr);
				}else{					
					$item = $item+array('nstr' =>$nstr);
				}
					
							
			//print_arr($item, 'item');
				
			$arr[$key] = $item;		
			//print_arr($arr);		
		}
				
		//print_arr($arr,'новый массив');
		
		
		return $res;
	}//end function	
	
/* end read settings */



function config_encode(){
	
	$data = read_settings_special('/cfg_test.txt');
	
	print_arr($data);
}

//config_encode();

	
/*====================================*/











