<?php

class Helper
{
	
	
	// Определяет тип страницы
	public static function PageType()
	{
		//te('Вызов PageType');
		
		if(is_page() && !$template_name){	$template_name 	= 'page';		}
		if(is_single())					{	$template_name 	= 'post';		}	
		if(get_template_name())			{	$template_name 	= get_template_name();	}
		/* Временное решение, главную страницу будем считать как 'page' */
		if(is_home()){$template_name 	= 'page';}	
		return $template_name;		
	}
		
				
	// Берёт информацию из конфига
	public static function ReadCfg()
	{		
		//te('вызов ReadCfg');
		return read_settings('/cfg.txt');		
	}
	
	
	// Берёт информацию из Load.txt
	public function ReadLoadData()
	{
		//te('вызов ReadLoadData');
		return unserialize(file_get_contents(get_stylesheet_directory().'/load.txt'));			
	}
	
	// Переставляет jQuery на первое место 
	public static function jQueryFirst($jsStack)
	{	
		//te('Вызов jQueryFirst');
		$jsKey = '0-jquery-core';
		if(array_key_exists($jsKey, $jsStack)){
				$jq[$jsKey] = $jsStack[$jsKey];				
				return array_merge($jq, $jsStack);		
		}else{return $jsStack;}
		
	}
	
	// Проверяет тип страницы
	public static function isCustomPage()
	{	
		//te('isCustomPage');
		if(get_template_name()){return true;}	
	}
	
	
	// Формирует ключ массиву данных для страницы
	public static function PageKey($PageType, $isCustomPage)
	{		
		//te('PageType');
		if($isCustomPage){
			$pageKey = __modules_page_folder_name__ .'/'.$PageType;
		}else{$pageKey = $PageType;}
		return $pageKey;
	}



	
	
	
	public function getSet()
	{
		$arr = [
				'loadData' 		=> Helper::ReadLoadData(),
				'cfg'	   		=> Helper::ReadCfg(),
				'pageType' 		=> Helper::PageType(),
				'isCustomPage' 	=> Helper::isCustomPage(),
		];		
		$arr = array_merge($arr, ['pageKey'=>Helper::PageKey($arr['pageType'], $arr['isCustomPage'])]);		
		return $arr;		
	}
	
	
	
}