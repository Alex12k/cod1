<?php
/*
class Bs_slider_lazay
{
	private $dataIMG = [];
	private $carulesID;
	private $fade;
	private $lazy;
	
	public function __construct($carulesID, $fade='', $lazy = true){	
				
		if(is_array($carulesID)){$carulesID = $carulesID[0];}
		
		$this->dataIMG 		= $this->getData();
		$this->carulesID 	= $carulesID;
		$this->fade			= $fade;
		$this->lazy			= $lazy;
		
		
		
		
		//$this->iterator();
	}
	
	
	
	private function sliderWrap($imageItems)
	{
		if($this->fade){$fade = 'carousel-fade';}
		if($this->lazy){$lazy = 'lazy';}
		
		return "<div id='{$this->carulesID}' class='carousel slide {$lazy} {$fade}' data-ride='carousel'>"				
					.$imageItems.				
				"</div>";
	}
	
	

	
	private function isActive($key){
		if($key==0){return "active";}
	}
	
	
	

	
	private function sliderImages(){			
		
		if($this->lazy){$lazyLoad = 'lazy-load';}
		
		
		$res .= "<div class='carousel-inner'>";			
			
			
			foreach($this->dataIMG as $key => $item){			
			
				
				$res .= "<div class='carousel-item {$this->isActive($key)}'>
							<img class='d-block w-100 {$lazyLoad}' {$this->isSrc($key, $item)} alt=''>
						</div>";			
			}

			
			
		//$res .= $this->iterator();	
		$res .= "</div>";	

	
		
		
		
		
		return $res.$count;		
	}//end method
	
	
	
	
	private function isSrc($key, $item){		
		$img = $item['img'];				
		if($this->lazy){
			if($key==0){$src = "src='{$img}'";}else{$src = "data-src='{$img}'";}
		}else{$src = "src='{$img}'";}			
		return $src;
	}
	
	
	// Итератор и темплейт 
	public function itemTemplate($slide, $isActive, $attrSrc)
	{		
	
		$res = "<div class='carousel-item {$isActive}'>						
						<img class='d-block w-100 lazy-load' {$attrSrc} = '{$slide['img']}'  alt=''>
					</div>";			
		
		return $res;	
	}
	
	
	private function iterator(){							
			
		
			
		foreach($this->dataIMG as $key => $slide){
			
			$isActive 	= $key == 0 ? 'active' : '';								
			$attrSrc 	= $key == 0 ? 'src'	: 'data-src';			
			//$src 		= $key == 0 ? "src='{$slide['img']}'" : "data-src='{$slide['img']}'";	
			
		
			$res .= $this->itemTemplate($slide, $isActive, $attrSrc);
		}	
		
		//te(htmlspecialchars($res));
		return $res;		
	
	}
	
	// end 
	
	
	
	
	
	
	private function baner(){
		
		$data = carbon_get_the_post_meta('carbon_slider_static_baner');	
		if($data){
			return '<div class="baner">'.$data.'</div>';
		}
	}
	
	private function indicators(){				
		
	
		$res .= '<ol class="carousel-indicators">';						
		foreach($this->dataIMG as $key => $img){
			
			$res .= "<li data-target='#{$this->carulesID}' data-slide-to='{$key}' class='{$this->isActive($key)}'></li>";			
		}					
		$res .= "</ol>";
		
		return $res;
	}//end method
	
	
	private function prevNext(){
				
		$prev = "<a class='carousel-control-prev' href='#{$this->carulesID}' role='button' data-slide='prev'>
					<span class='carousel-control-prev-icon' aria-hidden='true'></span>
					<span class='sr-only'>Previous</span>
				</a>";
  
		
		$next = "<a class='carousel-control-next' href='#{$this->carulesID}' role='button' data-slide='next'>
					<span class='carousel-control-next-icon' aria-hidden='true'></span>
					<span class='sr-only'>Next</span>
				</a>";

	
		
		return $prev.$next;
	}
	
	
	private function countSlides(){
		
			$count =     "<div class='numberSlider'>
							<span class='sliderTo'></span>/<span class='sliderLength'></span>
						 </div>";
			
		
			return $count;	
	}
	
	

	private function isData(){		
		$data = carbon_get_the_post_meta('carbon_slider');	
		if($data){return true;}	
		
	}
	
	private function getData(){
							
		foreach(carbon_get_the_post_meta('carbon_slider') as $item){		
			$result[] = array(			
				'title'		=> 	$item['title'],
				'subtitle'	=> 	$item['subtitle'],					
				'img'		=>	wp_get_attachment_image_src($item['img'], 'full')[0],
				);		
			}			
		return $result;					
	}
	
	
	public static function shortCode($id){		
		return new Bs_slider_lazay($id, false, true);		
	}
	
	private function __toString(){
			
		if($this->isData()){		
			return $this->sliderWrap(
							$this->indicators().
							
							$this->baner().
							$this->sliderImages().
							$this->prevNext().
							$this->countSlides()							
						);
		}else{
			return '';
			}	
			
			
	}//end method
	
	
}



//Регистрация шорткода 
//function test_shortcode(){	
//	return new Bs_slider_lazay('carousel_id_111', true, true);
//}

//add_shortcode( 'test', 'test_shortcode');	
add_shortcode( 'test', [ 'Bs_slider_lazay', 'shortCode' ] );

// ПРИМЕР 


function footag_func_new( $atts ){
	 //return "foo = ". $atts['foo'];

}


add_shortcode('footag', 'footag_func');

// результат: 
// шоткод [footag foo="bar"] в тексте будет заменен на "foo = bar"



