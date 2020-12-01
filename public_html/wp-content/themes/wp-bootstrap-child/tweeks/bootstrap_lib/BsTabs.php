<?php

class BsTabs
{
	
	/* Свойства для подсчёта созданных объектов */
	private static $unic = 0;	
	private $label 		= [];
	private $content 	= [];
	
	public function __construct($data, $content){		
		
		// Увеличиваем счетчик при создании объекта:
		$this->unic 		= self::$unic++;	
		
		// Заполняем свойства data и content
		$this->label 		= $data;	
		$this->content 		= $content;			
		
		$this->printTab();
	}
	
	
	private function printTab(){
		
		$tags = ['ul','div'];	
		foreach($tags as $tag){
								
			if($tag == 'ul') {?><ul class='nav nav-pills' id='myTab' role='tablist'><?}
			if($tag == 'div'){?><div class="tab-content" id="myTabContent"><?}		
				
				foreach($this->label as $key => $item){
									
					$n1 = $this->isFirstElement($key);
					$handle = str_replace(' ', '', mb_strtolower($this->label[$key]));
				
					
				if($tag == 'ul'){?>	
				
					<li class="nav-item">			
						<a class="nav-link rounded-pill <?=$n1['active']?>" 																
							id				= "<?=$handle.'-tab'?>"
							href			= "<?='#'.$handle.'-'.self::$unic?>" 
							aria-controls	= "<?=$handle?>" 						
							aria-selected	= "<?=$n1['aria_selected']?>"						
							data-toggle		="tab"	
							role			="tab">													
							<?=$item?>						
						</a>
					</li>
				
				<?}else{?>
					
					<div class="tab-pane fade <?=$n1['show_active']?>" 				
						id="<?=$handle.'-'.self::$unic?>" 
						role="tabpanel" 
						aria-labelledby="<?=$handle.'-tab'?>">
							
							<p><?=$this->content[$key]?></p>				
							<p><a href="#" class="btn btn-pink btn-shadow">Read more</a></p>						
					</div><?
				} //end if
				
			}//end data
			if($tag == 'ul'){?></ul><?}
			if($tag == 'div'){?></div><?}
		
		}//end tags		
	} //end method
	
	
	/* Получение значений атрибутов и классов для первого элемента */		
	private function isFirstElement($key){
							
			if($key == 0){			
				$res['active'] 			= 'active'; 
				$res['aria_selected'] 	= 'true';
				$res['show_active']		= 'show active';			
				return $res;
			}else{
				return $res['aria_selected'] = 'false';
			}
		} //end method
		
}


/*
function bsTabs($arr){
		
		?><ul class="nav nav-tabs" id="myTab" role="tablist"><?		
			foreach($arr['label'] as $key => $item){
	
				$id 			= $arr['id'][$key];
				$href 			= $arr['href'][$key];
				$aria_controls	= $arr['aria_controls'][$key];
				$label 			= $arr['label'][$key];
				$content 		= $arr['content'][$key];
				
				
				if($key == 0){				
					$active = 'active'; 
					$aria_selected = 'true';
					}else{
						unset($active); 
						unset($aria_selected);				
					}
					
			//------------Tabs------------			
				?>			
				<li class="nav-item">
					<a class="nav-link <?=$active?>" id="<?=$id?>" data-toggle="tab" href="<?=$href?>" role="tab" aria-controls="<?=$aria_controls?>" aria-selected="<?=$aria_selected?>"><?=$label?></a>
				</li>
				<?	
			//----------end Tabs----------
					
			}//end foreach	
			?></ul><?
			
			
			
			//---------- Content----------
			?><div class="tab-content" id="myTabContent"><?
												
				foreach($arr['label'] as $key => $item){
						
					$id 			= $arr['id'][$key];			
					$aria_controls	= $arr['aria_controls'][$key];
					$content 		= $arr['content'][$key];
				
					if($key == 0){							
						$show_active = 'show active';		
					}else{unset($show_active); }

					?>
					
					<div class="tab-pane fade <?=$show_active?>" id="<?=$aria_controls?>" role="tabpanel" aria-labelledby="<?=$id?>">
							<p><?=$content?></p>
							<p><a href="#" class="btn btn-pink btn-shadow">Read more</a></p>		
					</div><?
			} //end foreach ?>
				
			</div><!-- /.tab-content -->  
			
			<?}//end function

*/
















