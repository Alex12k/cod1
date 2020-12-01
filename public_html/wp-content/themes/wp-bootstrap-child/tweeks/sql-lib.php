<?php
/*		Список функций:
*
* 1.	Функция создания табдицы в БД если она ранее не была создана 				**LOCAL CSS MINI**
* 2.	Функция добаляющаа имена фаилов в БД в случае если этого имени там еще нет 	**LOCAL CSS MINI**
* 3.	Функция удаляет запись о фаиле из БД если фаил физически удалён из папки 	**LOCAL CSS MINI**
* 4.	Функция проверяет существование таблицы по имени 							**GLOBAL**
* 5.	Функция проверяет существует ли запись о фаиле в таблице 					**LOCAL CSS MINI**
* 6.	Функция удаления таблицы из базы данных										**GLOBAL**
*
*/



/* #1 CREAT table 
*	LOCAL FUNCTION **CSS MINI***
*	Функция создания табдицы в БД если она ранее не была создана
*
*/



function creat_table_styles_list($table_name){
	
	global $wpdb;
	
	// тут мы добавляем таблицу в базу данных
		
		$sql = "CREATE TABLE " . $table_name . " (
			id INT NOT NULL AUTO_INCREMENT,
			handle VARCHAR(55) NOT NULL,
			status VARCHAR(55) NOT NULL,
			
			PRIMARY KEY (`id`),
			UNIQUE KEY (`handle`)
			
			
			);";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

	info_message("ШАГ 0:  Таблица {$table_name} была создана в БД ");	
}




/* #2 add_files_in_table_if_not_exist
* LOCAL FUNCTION **CSS MINI***
*
* 	Добавляем данные о именах всех фаилов из папки css-stack в таблицу БД, если такого 
*	фаила еще нет в таблице и присваиваем им значение ON
* 	Функция принимает массив с именами фаилов и имя таблицы куда их нужно записать.			
*
*/				
function add_files_in_table_if_not_exist($Files_name, $table_name){
	
		global $wpdb;
		
		/*получаем список имен фаилов из поля handle из таблицы $table_name*/
		$Name_list_in_db = $wpdb->get_col("SELECT handle FROM $table_name");
		
		
		foreach ($Files_name as $item ) {	
			
			/*уберем расширение*/
			$item = preg_replace('/\.\w+$/', '', $item);
			
			/* проверяем есть уже такой фаил в таблице БД */
			if (!in_array($item, $Name_list_in_db)) {
			
			$wpdb->REPLACE(
					/*Название таблицы*/ 					$table_name,
					/*Вносим данные (поле=>значение)*/		array( 'handle' => $item, 'status' => 'ON' ),
					/*Формат данных (%s-строка)		*/		array( '%s', '%s' )
				);	

			info_message("Данные о фаиле {$item} были добавлены в таблицу БД");	
	
			} /*END IF*/
		}/*END FOREACH*/
		
}




/* #3 del_files_in_table_if_not_exist
* LOCAL FUNCTION **CSS MINI***
*
* Функция удаляет запись о фаиле из таблицы $table_name если фаил физически удалён из папки css-stack
* 		
*/	

function del_files_in_table_if_not_exist($Files_handle, $table_name){
	
	global $wpdb;
	// Удаляем фаил из базы данных в том случае если его нет в папке css-stack	
	$Name_list_in_db = $wpdb->get_col("SELECT handle FROM $table_name");

	//Берем список фаилов из ТАБЛИЦЫ БД
	foreach ($Name_list_in_db as $item ) {
			
			
			/*И проверяем каждый ли из существующих в нем фаилов есть в папке css_stack*/
			
			if (!in_array($item, $Files_handle))	{ //Если фаила из БД не обнаруживается в css-stack, то удаляем запись о нём из БД
			
				
				/*Удаляем строку из базы данных если данного фаила нет в папке css-stack*/
			
			
				$wpdb->delete( $table_name, array( 'handle' => $item ) );				
				info_message ("Данные о фаиле {$item} были удалёны из таблицы БД");				

			}			
	}	
	
}





/* #4 ФУНКЦИЯ ПРОВЕРКИ СУЩЕСТВОВАНИЯ ТАБЛИЦЫ
* GLOBAL FUNCTION
*Функция принимает на вход имя таблицы, если такая таблица сществует в БД то функция вернёт TRUE, если не существет FALSE
*
*/


function table_exist($table_name){
	global $wpdb;
	
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {				
				
					return TRUE;	
			} else {return FALSE;}

}


/* #5
* ФУНКЦИЯ ПРОВЕРЯЕТ СУЩЕСТВОАНИЕ ЗАПИСИ О ФАИЛЕ $name В ТАБЛИЦЕ $table_name **LOCAL MINI CSS**
*
*/


function file_in_table_exist($name, $table_name){
	global $wpdb;
	$Name_list = $wpdb->get_col("SELECT handle FROM $table_name");
	
	if (in_array($name, $Name_list)){return TRUE;}	
										else {return FALSE;}

	
}


/* #6 Обновление данных в таблице из массива $_POST **LOCAL MINI CSS**
*	Функция забирает из массива $_POST значения Status и записывает их в БД
*/


function set_status_in_post_array($table_name) {

	
	$Post_handle = array_keys($_POST);
			
		foreach ($_POST as $status) {
				
				$handle = $Post_handle[$i++];
				$wpdb->query("UPDATE $table_name SET status = '$status' WHERE handle = '$handle'");					
		}	
	
}



/* #7
*
*
*/

function update_css_status($table_name){


	echo '<h1> Функция UPDATE запущаена </h1>';
	global $wpdb;
	
	foreach ($_POST as $status) {		
					
				/*Название таблицы*/ 			$table_name = 'css_disable';
				/*Поле и новое значение*/		$data  = array( 'status' => 'OFF' );
				/*Идентифицируем строку*/		$where = array( 'handle' => '1-start' );
		
				$wpdb->update( $table_name, $data, $where);		
				
	}
}
	
 


/* #8 drop_table
*	GLOBAL FUNCTION
*	Функция удаления таблицы из базы данных
*
*/

function drop_table($table_name){
	global $wpdb;
	$wpdb->query("DROP TABLE $table_name");
}


