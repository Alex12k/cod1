<?php
class DLBuilder
{
	
	public $settings;
	public $dataPage;
	public $pageStream;
	
		
	public function __construct()
	{				
		$this->settings 	= Helper::getSet();	
		$this->dataPage 	= $this->dataPage();
		$this->pageStream 	= $this->dataPageStream();		
	}
	
	

	//Сборка массива с данными 
	private function dataPage()
	{				
							
			$loadData = $this->settings['loadData'];
			$pageKey  = $this->settings['pageKey'];				
			$pageType = $this->settings['pageType'];
			
			
			foreach(['css','js'] as $type){												
					$arr[$type] = array_merge(
						array('global' => 	$loadData[$type.'_stack']['global_stack'] ),
						array('options' => 	$loadData[$type.'_stack'][$pageKey]['options'] ),
						array('page' =>		$loadData[$type.'_stack'][$pageKey]['page_'.$type] ),
						array('min'=>		$loadData[$type.'_min_files'][$pageType])
					);						
			}
			
	
			//print_arr($arr);				
			return $arr;		
	}
	
	
	
	//Сборка массива с данными 
	private function dataPageStream()
	{			
		$data = $this->dataPage;	
		foreach(['css','js'] as $type){	
			$res[$type]  = array_merge($data[$type]['global'], $data[$type]['options'], $data[$type]['page']);
		}	
		//print_arr($res);
		return $res;
	}
	
	
	
	/* Методы для загрузчкика */	
	//Загрузка CSS стека
	public function loadStackCss($stack, $ver)
	{
		//te('загрузка css стека');	
		foreach($stack as $handle => $dir_file){							
			wp_enqueue_style($handle, $dir_file, $deps, $ver, $in_footer);				
		}
		
	}
	
	//Загрузка JS стека
	public function loadStackJs($stack, $ver)
	{	
		//te('загрузка js стека');
		$in_footer = true;   
		foreach($stack as $handle => $dir_file){									
			wp_enqueue_script($handle, $dir_file, $deps, $ver, $in_footer);					
		}
				
	}
	
	//Загрузка CSS min
	public function loadMinCss($minFile, $ver)
	{
		//te('загрузка css min фаила');
		wp_enqueue_style('min_css', $minFile, $deps, $ver, $in_footer);
			
	}
	
	//Загрузка JS min
	public function loadMinJs($minFile, $ver)
	{
		//te('загрузка js min фаила');
		$in_footer = true;
		wp_enqueue_script('min_js', $minFile, $deps, $ver, $in_footer);
			
	}	
	/* Методы загрузчика end */
		
}// end class