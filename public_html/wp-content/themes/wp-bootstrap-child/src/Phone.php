<?php

class Phone
{
	private $phones = [];
	
	
	public function __construct(){			
		$this->phones = $this->getData();	
	}
	
	
	
	
	private function number($phone){

			$subject = $phone;
			$search  = [' ', '-', '(', ')'];
			$replace = '';	
			return str_replace($search, $replace, $subject);		
	}
	
	
	
	private function phone(){
		return "<div id='header-phone' class='phone'></div>";	
	}
	
	private function script(){
		
		$phones  = $this->phones;
				
		foreach($phones as $phone){			
			$mobile_str .= "<p><a href='tel:{$this->number(phone)}'>{$phone}</a></p>";	
			$pc_str 	.= "<p><span>{$phone}</span></p>";
			}
					
		return
		"<script>
			
			if( /Android|webOS|iPhone|xiaomi|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
				document.getElementById('header-phone').innerHTML = `{$mobile_str}`			
				}else{
				document.getElementById('header-phone').innerHTML = `{$pc_str}`;
						}
		</script>";
			
	}
	
	
	private function getData(){		
		$data = carbon_get_theme_option('site_phones');
		
		if($data){
			foreach($data as $item){
				$phones[] = $item['phone'];							
			}
			return $phones;} else { return false; }		
	}
	
	
	public function __toString(){		
		
		if($this->getData()){		
			return $this->phone() . $this->script();	
		}else{return '';}		
	}
	
	
}