<?php
#	https://codyshop.ru/kak-dinamicheski-obedinit-vse-faylyi-javascript-v-odin/

require_once __DIR__ .'/micro_service.php';





function merge_all_scripts() {	

	
//================================== Алгоритм действий скрипта =================================//	

//Запись алгоритма на человеческом языке



//Посмотри на очередь имен файлов                                             			
$queue = get_queue(); 	print_arr($queue, 'Актуальная очередь');                 					 		
	
$removed = array_keys(read('removed_css.txt')); print_arr($removed, 'removed');

if($removed != array()){
		
	foreach($removed as $item){	
		$queue['css'][] = $item;		
	}
	

	print_arr($queue['css']);
}
	
	
//Посмотри на очередь имен файлов в списке <list.txt>				                  
$spisok = read('list.txt');		//print_arr($spisok, 'Сохранённая очередь');							            					 

// Если список пуст то записываем в него очередь
//if(!$spisok){save($queue, 'list.txt');}


	
//Сравни очередь и список, найди кто пришел в очередь                                  	
$те_кто_пришёл_в_очередь = kto_prishel($queue, $spisok);	//print_arr($те_кто_пришёл_в_очередь, 'кто пришёл в очередь');


//Сравни очередь и список, найди кто вышел из очереди                    					
$те_кто_вышел_из_очереди = kto_vishel($queue, $spisok);		//print_arr($те_кто_вышел_из_очереди, 'кто вышел из очереди');		      
	

	
// Если кто то пришёл в очередь или вышел из очереди	
if(in_array(true, $те_кто_пришёл_в_очередь) || in_array(true, $те_кто_вышел_из_очереди)){

	
	//Сохрани данные очереди в <list.txt>                        		   				

	save($queue, 'list.txt');      					//print_arr($queue, 'list.txt');



	//print_arr($те_кто_пришёл_в_очередь, 'в очередь пришли');	

/* Если пришли новые элементы */
if(in_array(true, $те_кто_пришёл_в_очередь)){
	
		/* Если пришли новые css */
		if($те_кто_пришёл_в_очередь['css']){
			$change_css = true;
			$append_data['css'] = get_src_by_handle_css($те_кто_пришёл_в_очередь['css']);			//print_arr($data, 'Это наша функция которая должна вернуть массив SRC');			
		}
		
		/* Если пришли новые js */
		if($те_кто_пришёл_в_очередь['js']){
			$change_js = true;
			$append_data['js'] = get_src_by_handle_js($те_кто_пришёл_в_очередь['js']);			//print_arr($data, 'Это наша функция которая должна вернуть массив SRC');				
		}

	append($append_data, 'vip.txt');
}
		
		
		
		
	if(in_array(true, $те_кто_вышел_из_очереди)){	
		
		if($те_кто_вышел_из_очереди['css']){
			$change_css = true;
			$remove_data['css'] = $те_кто_вышел_из_очереди['css'];
			}
			
		if($те_кто_вышел_из_очереди['js']){
			$change_js = true;
			$remove_data['js'] = $те_кто_вышел_из_очереди['js'];
		}
	
		remove($remove_data, 'vip.txt');
	}//end
	

}


                       
$data = array(	'vip' 			=> read('vip.txt'), 		
				'change_css'	=> $change_css,
				'change_js'		=> $change_js
				);
				
/* Если vip пуст, то его элементы css и js объявим пустыми массивами */
if(	empty($data['vip'])	){		
	$data['vip']['css'] = $data['vip']['js'] = array();	
}


//print_arr($data, 'Отчёт от Merged для Observer');
return $data;	

}
	

//===================================     STOP!     ===================================//		
	
	