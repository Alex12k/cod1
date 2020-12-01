<?
//require_once __DIR__ . '/update_fields.php';

function add_foto_slider_fields(){
	
/* CUSTOM FIELDS */
	add_action('add_meta_boxes', 'extra_fields_foto', true);
	function extra_fields_foto(){
		/* Мета поле для постов */
		add_meta_box(
		'extra_fields_foto', 
		'Дополнительные данные:', 
		'extra_fields_box_func_foto', 
		array('post', 'page'), 'normal', 'high');
		
	}
	
	## html код блока для типа записей post
	function extra_fields_box_func_foto($post){?>
	
		<? /* Для верхнего слайдера на постах */ ?>
		<p><label>Данные для фото слайдера сверху:</label></p><textarea name="extra[top_foto_array]" wrap="off" rows="10" style="width:100%; font-size: 25px;"><?php echo get_post_meta($post->ID, 'top_foto_array', true); ?></textarea>		
		<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>">

		<!--
		<?// /* Для нижнего слайдера на постах */ ?>
		<p><label>Список видео, нижний слайдер:</label></p>
		<textarea name="extra[bottom_foto_array]" wrap="off" rows="10" style="width:100%; font-size: 25px;">
		<?php //echo get_post_meta($post->ID, 'bottom_foto_array', true); ?>
		</textarea>
		<input type="hidden" name="extra_fields_nonce" value="<?php// echo wp_create_nonce(__FILE__); ?>">
		-->
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
	
} 	//end function add_foto_slider_fields 
	//(поля добавлены, сохранение работает



/* Получение данных */
function get_my_data_fields($position){
		
		if($position=='top_slider')		{$field_name = 'top_foto_array';	}
		if($position=='bottom_slider')	{$field_name = 'bottom_foto_array';}
		
	 	/* Получение данных из кастомного поля */
		global $post;
		
		$data_str = get_post_meta($post->ID, $field_name, true);		
		
		//print_arr($data_str);
		
		/* PHP_EOL корректный символ конца строки */
		//$data_array =  explode(PHP_EOL, $data_str);
		$data_array =  explode('---', $data_str);		
		//print_arr($data_array);
		
		foreach($data_array as $slide){
				
			$slide = explode(PHP_EOL, trim($slide));				
			$data[] = array_diff($slide, array(0, null));	
		}
	
		/*Если в массиве данных для слайдера есть хотябы один элемент, запускаем слайдер*/
		if($data[0]){
			//big_slider_v2($data);
			
		}
			
				
	
}

//add_foto_slider_fields();		
//add_action('post_before_content', 'get_my_data_fields',10,1);


/* Мы можем сформировать Meta Box и запустить его в какой либо функции */

$options = array(
	array( // первый метабокс
		'id'	=>	'meta1', // ID метабокса, а также префикс названия произвольного поля
		'name'	=>	'Доп. настройки 1', // заголовок метабокса
		'post'	=>	array('post'), // типы постов для которых нужно отобразить метабокс
		'pos'	=>	'normal', // расположение, параметр $context функции add_meta_box()
		'pri'	=>	'high', // приоритет, параметр $priority функции add_meta_box()
		'cap'	=>	'edit_posts', // какие права должны быть у пользователя
		'args'	=>	array(
	
			array(
				'id'			=>	'textfield',
				'title'			=>	'Текстовое поле',
				'type'			=>	'textarea_editor', // большое текстовое поле
				'placeholder'	=>	'сюда тоже можно забацать плейсхолдер',
				'desc'			=>	'пример использования большого текстового поля ввода в метабоксе',
				'cap'			=>	'edit_posts'
			),
	
		)
	),

);
 
foreach ($options as $option) {
	$truemetabox = new trueMetaBox($option);
}


/*------------END------------*/







