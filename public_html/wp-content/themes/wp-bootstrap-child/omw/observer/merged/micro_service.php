<?php 

/* Функция подразумевает вызов по add_action, в нужном месте для получения списка dependacy */
function get_queue(){
	global $wp_styles, $wp_scripts;
	
	$queue_items = array(
		'css'	=>	$wp_styles->queue,
		'js'	=>	$wp_scripts->queue
	);
	//print_arr($queue_items['css']);
	return $queue_items;	
}


/* Функция срабатывает в футере, гарантированно собирая весь список dependacy */
function get_queue_v2(){
	
	add_action('wp_footer', function(){
		
		global $wp_styles, $wp_scripts;
		$queue_items = array(
			'css'	=>	$wp_styles->queue,
			'js'	=>	$wp_scripts->queue
		);

		//print_arr($queue_items);
		return $queue_items;	
	
	}, 9999);
}


function get_queue_v3(){
	add_action('wp_enqueue_scripts', function(){
		global $wp_styles, $wp_scripts, $queue_items;
		$queue_items = array(
			'css'	=>	$wp_styles->queue,
			'js'	=>	$wp_scripts->queue
		);	
	}, 999);	
}





function save($queue_styles, $dir=''){	

	file_put_contents(__DIR__ .'/'. $dir, serialize($queue_styles));
}


function append($array, $dir){	

	//print_arr($array, 'пришел новый элемент');
	
	/* Достаём содержимое фаила vip.txt */
	$old_array  = unserialize(file_get_contents(__DIR__ .'/'. $dir));	//print_arr($old_array, ' содержимое фаила vip.txt');
		
	
	/* Если пришли css */
	if($array['css']){					
		/* Если в vip ранее уже существовали css фаилы, то добавляем к ним, else записываем то что пришло*/
		if($old_array['css']){		
			$new_array['css'] = array_merge($old_array['css'], $array['css']);				
		}else {	$new_array['css'] = $array['css'];	}
	}	
		
				
	/* Если пришли JS */
	if($array['js']){		
		/* Если в vip ранее уже существовали js фаилы, то добавляем к ним, else записываем то что пришло */
		if($old_array['js']){
			$new_array['js'] = array_merge($old_array['js'], $array['js']);
		}else {	$new_array['js'] = $array['js'];	}
	}
	
	//print_arr($new_array, 'новый массив для перезаписи');	
	file_put_contents(__DIR__ .'/'. $dir, serialize($new_array));	

}// end append




function remove($array, $dir){
			
	/* Достаём значения из списка vip */
	$old_array  = unserialize(file_get_contents(__DIR__ .'/'. $dir));
		
		
		/* удаляем из vip имена перечисленные в массиве array */
		foreach($array['css'] as $item){
			 unset($old_array['css'][$item]);
		}
			
		/* удаляем из vip имена перечисленные в массиве array */
		foreach($array['js'] as $item){
			unset($old_array['js'][$item]);
		}	


	/* Записываем получившийся новый массив обратно в vip.txt */
	$new_array = $old_array;
	file_put_contents(__DIR__ .'/'. $dir, serialize($new_array));
	
}//end remove


function read($dir=''){		
	return $arr = unserialize(file_get_contents(__DIR__ .'/'.$dir));
} //end read




function kto_prishel($queue, $spisok){	
	
	//print_arr($queue, 'очередь');
	//print_arr($spisok, 'список');
	
	/* array_values() - делает сброс ключей в массиве */
	$data = array(
		'css' => array_values(array_diff(	$queue['css'], $spisok['css'])),
		'js'  => array_values(array_diff(	$queue['js'],  $spisok['js']))
	);
	
	return $data;
} //end kto_prishel



function kto_vishel($queue, $spisok){	
	
	/* array_values() - делает сброс ключей в массиве */
	$data = array(
		'css' =>	array_values( array_diff(	$spisok['css'], $queue['css'] )	),
		'js'  =>	array_values( array_diff(	$spisok['js'],  $queue['js'] 	))	
	);
	
	return $data;
} //end kto_vishel




function different($queue_styles, $spisok){
	
	$Plus = array_diff($queue_styles, $spisok); 			
	return $result = array(
		'Пришёл в очередь' 	=>  $Plus,
		'Ушёл из очереди'	=> 	$Minus,
	);
		
}














