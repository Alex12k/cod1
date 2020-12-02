<?php


/*	Фаил должен получать данные об имеющихся в бд именах фаилов.
*	После этого генерировать выводить список фаилов из базы данных с возможностью присвоения статуса ON/OFF	
*	Далее ле нажатия кнопки Обновить , отправлять значения в массив $_POST и перезаписывать в БД значения status
*	После чего записывать в time-log.txt фаил, время последнего нажатия кнопки обновить.
*
*	При этом фаил аработает не зависимо.
*/
header('Content-Type: text/html; charset= utf-8');
$table_name = 'css_disable';
$dir_time_log = get_stylesheet_directory().'/tweeks/mini/time_log.txt';

?>
<a href = "/"> На главную </a>
<h1> Включение и отключение CSS стилей </h1>



<?php


if(isset($_POST['update'])) {
	
	foreach ($_POST as $val_handle => $val_status) {				
			
			
				/*Название таблицы*/ 			$table = "$table_name";
				/*Поле и новое значение*/		$data  = array( "status" => $val_status );
				/*Идентифицируем строку*/		$where = array( "handle" => $val_handle );
		
				$wpdb->update( $table, $data, $where);		

	}
	
	
	
	$time = date ("d F Y H:i:s", filemtime($dir_time_log));
	$time = "Время последнего редактирования SQL таблицы $table_name: " .$time;
	file_put_contents($dir_time_log, $time);
}



/* Блок получения данных */

	/* Выберем столбец (поле) handle из таблицы базы данных */
	//$Db_handle = $wpdb->get_col("SELECT handle FROM $table_name");
	
	/* Выберем значение настройки status из таблиыцы базы данных */
	//$Db_status = $wpdb->get_col("SELECT status FROM $table_name");

/* Выберем все данные из таблицы */
	$db_all = $wpdb->get_results( "SELECT handle, status FROM $table_name;", ARRAY_A);
	
?>


<form class = "css-control" method = "POST"> 
 
<p><b> Данные о фаилах из базы данных </b></p>


<input type="submit" name = "update" value="UPDATE" />

<?php foreach ($db_all as $item) {?>
	  

	<p> <span class = "handle"> <?=$item[handle]?> </span>
		
		<span class = "radio-group">
			<label> ON <input	type = "radio" name = "<?=$item['handle']?>" value = "ON"	<? if($item[status]=='ON') echo 'checked';?> /> </label>				
			<label> OFF	<input	type = "radio" name = "<?=$item['handle']?>" value = "OFF"<? if($item[status]=='OFF') echo 'checked';?> /></label>	
		</span>	
	</p> 		
		
 <?}?>

</form>	


<?








