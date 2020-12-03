<?php 
require_once __DIR__ .'/manager_skills.php';

/* 	Задача Manager-a принять данные от Observer-a и проанализирвоать что нужно делать.
*	Что подключать, а что отключать. 
*	Проанализировать маркировки none-
*	Принять решение о создании новых структур модулей
*	И передать задания Worker-у
*/


/*	Список возможностей:
	- Включение режима min_mode
	- Не зависимое включение режима min css плагинов
	- Не зависимое включение режима min js плагинов
	- Отключение Root_style.css
	- Отключение CSS и JS находящихся в папке с префиксом "none-"
	- Отключение отдельных CSS и JS фаилов с префиком "none-"
	- Поддержка актуальной версии min фаила css
	- Поддержка актальной версии min фаила js
	- Поддержка загрузки стилей и скриптов на страницу (в завимимотси от выбранного режима min true/false
*/



function manager($raport='', $current_state_structure=''){	
	
	//te("(manager): вызов manager-a");
	
	//print_arr($raport);	
	//print_arr($current_state_structure);
	
	
	
	if($raport['change_structure']){
		//te('Manager: Поменялась структура проекта, вызываю Worker-a и выдаю задание');
		worker('update_structure_project');
		}
	 
	
	
	/* Перезапись Min CSS фаила */
	if($raport['change_css_content'] || $raport['change_cfg'] || $raport['changed_plugins_deps'] || $raport['change_structure']){	
		te('Manager: Зафиксированны изменения в контенте CSS, вызываю Worker-a и выдаю задание');		
	
	
		$type = 'css';	
		refreash_deps($type, $current_state_structure);
		//print_arr($current_state_structure);
	} // END WORKER COMMAND CHANGE
	
	

		


	/* JS LOADER AND MIN */
	if($raport['change_js_content'] || $raport['change_cfg'] || $raport['changed_plugins_deps']){ 	
		te('Manager: Зафиксированны изменения в контенте JS, вызываю Worker-a и выдаю задание');

		$type = 'js';		
		refreash_deps($type, $current_state_structure);

		} // END change_js_content
	
				
				
				
				
				
				
				
				
				
				
		/* Запрос от worker*/
		if($raport['message'] == 'need_data'){$raport['load_stack'] = true;}
		//print_arr($raport);
	
		
	
		/* ЧАСТЬ КОДА НЕ УЧАВСТВУЕТ В ВЫВОДЕ СТЕКА, 
		*	так как worker получает данные в собственную память
		*	требуется пересмотреть её применнение в omw, обдумать такой функционал 
		*	none-filter !!!!!!!!!!!!!!!!
		*/ 
		
		/* Загрузка CSS/JS стека */	
		if($raport['load_stack']){//print_arr($current_state_structure);
	
			/* сформируем данные для worker (данные беруться из last фаила)*/
			$data_stack = array(				
				'css_stack' 	=> none_filter(assoc_handle(request_to_array('css'))),
				'js_stack'  	=> none_filter(assoc_handle(request_to_array('js'))),				
				); 
	
					
													
			$data_min = array(				
				'css_min' => 	array($current_state_structure['min_css_name']	=> $current_state_structure['min_folder'].'/'.$current_state_structure['min_css_name']),				
				'js_min'  =>	array($current_state_structure['min_js_name']	=> $current_state_structure['min_folder'].'/'.$current_state_structure['min_js_name'])+array('jquery-core' =>$current_state_structure['fjq'])		
			);	//print_arr($data_min);
						
					
			/* Если min mod=true, передаём $data_min. Else передаём $data_stack */			
			if($min_mode){$data = $data_min;}else{$data = $data_stack;}			
		
			//print_arr($data, 'Список Stack на загрузку');			
			//worker('load_stack', $data);			
						
		}
		
	 
} // End manager