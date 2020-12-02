<?php

function add_video_slider_fields(){

	/* CUSTOM FIELDS */
	add_action('add_meta_boxes', 'extra_fields', true);
	function extra_fields(){
		/* Мета поле для постов */
		add_meta_box(
		'extra_fields', 
		'Дополнительные данные:', 
		'extra_fields_box_func', 
		array('post', 'page'), 'normal', 'high');
		
	}
	
	## html код блока для типа записей post
	function extra_fields_box_func($post){?>
	
		<? /* Для верхнего слайдера на постах */ ?>
		<p><label>Список видео, верхний слайдер:</label></p>
		<textarea name="extra[top_video_array]" wrap="off" rows="10" style="width:100%; font-size: 25px;">
		<?php echo get_post_meta($post->ID, 'top_video_array', true); ?>
		</textarea>
		
		<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>">

		<? /* Для нижнего слайдера на постах */ ?>
		<p><label>Список видео, нижний слайдер:</label></p>
		<textarea name="extra[bottom_video_array]" wrap="off" rows="10" style="width:100%; font-size: 25px;"><?php echo get_post_meta($post->ID, 'bottom_video_array', true); ?></textarea>
		<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>">

	<?	}


	// включить обновление полей при сохранении
	add_action('save_post', function( $post_id ){
 
	if (!isset($_POST['extra_fields_nonce'])||!wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__)) return false; // проверка
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return false; // если это автосохранение
	if (!current_user_can('edit_post', $post_id)) return false; // если юзер не имеет право редактировать запись
	if (!isset($_POST['extra'])) return false;
	// теперь, нужно сохранить/удалить данные
	$_POST['extra'] = array_map('trim', $_POST['extra']);
 
	foreach($_POST['extra'] as $key=>$value){
	if(empty($value)){
	delete_post_meta($post_id, $key); // удаляем поле если значение пустое
	continue;
		}
		update_post_meta($post_id, $key, $value); // add_post_meta() работает автоматически
		}
		return $post_id;
	} 
	,0);


	/* END CUSTOM FIELDS */
}//end function add_video_slider_fields




/* Функция принимающая параметр через do_action */
function custom_slider($position){
		
		if($position=='top_slider')		{$field_name = 'top_video_array';	}
		if($position=='bottom_slider')	{$field_name = 'bottom_video_array';}
		
	 	/* Получение данных из кастомного поля */
		global $post;
		
		$video_str = get_post_meta($post->ID, $field_name, true);		
		
		/* PHP_EOL корректный символ конца строки */
		$video_array =  explode(PHP_EOL, $video_str);		
		$video_array_not_empty = array_diff($video_array, array(0, null));
		
				
		foreach($video_array_not_empty as $item){$data[] = explode("=>", $item);}
		
		foreach($data as $key => $item){
									
			$result[] = array(
					'text'=> trim($item[0]),
					'src' => trim(basename($item[1])),
			);	
			
		}//end foreach
	
	
	
	//print_arr($result);
		
	/* Вывод слайдера */
	
	if(!empty($result[0])){
		?><!--<div class = "slider-head"><span>Популярное</span></div>--><?	
		?><div class="carousel carousel-video"><?
			foreach($result as $item){?>
										
				<div class="slide" style="margin: 3px;">	
					<div class="youtube" id="<?=$item['src']?>"></div>
					<div class="text"><?=$item['text']?></div>			
				</div>
	
			<?}//end foreach
		?></div><?
	
	}//End if
		
}//End function



function fields_video_slider_init(){
	
	/* Созданек полей редактирования в Админке*/
	add_video_slider_fields();
	/* end */
	
	
	/* Хуки на шаблоне постов single.php */
	add_action('post_before_content', 'custom_slider',10,1);
	add_action('post_after_content', 'custom_slider',10,1);

	/* Хуки на шаблоне страниц page.php */
	add_action('page_before_content', 'custom_slider',10,1);
	add_action('page_after_content', 'custom_slider',10,1);

}

/* Вызов функции */
//fields_video_slider_init();


























