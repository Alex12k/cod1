<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

/* Подключается в function php на строке 276 */


class Phone_v2
{
	private $phones = [];
	private static $count = 1;
	
	public function __construct(){	
			
		$this->count 	= self::$count++;	
			
		$this->isCarbonFields();		
			
		/* Регистрируем при создании первого объекта */	
		if($this->isFirstObject()){ 
			add_action('carbon_fields_register_fields', function(){$this->creatfields();
			});
		}
		
		
		add_action('carbon_fields_register_fields', function(){	
			$this->phones = $this->getData();	
		});
		
		add_action('header', function(){$this->show();});
	
		
	}
	
	
	/* Мониторинг зависимостей */
	private function isCarbonFields(){	
		if(class_exists('Carbon_Fields\Carbon_Fields')){
			return true;
		}else{
			die('Требуется подключить плагин Carbon Fields');
		}
	}
	
	
	/* Создание полей */
	private function creatFields(){	
				
			Container::make('theme_options', 'Телефоны')
			->set_icon('dashicons-phone')
			->add_fields( array(
		
			Field::make( 'complex', 'site_phones', 'Контактные телефоны' )
				->add_fields( array(
					Field::make( 'text', 'phone', 'Контактный телефон'),
						))));
		
	}
	
	
	
	private function number($phone){

			$subject = $phone;
			$search  = [' ', '-', '(', ')'];
			$replace = '';	
			return str_replace($search, $replace, $subject);		
	}
	
	
	private function whatsApp($number){
		
		$themePath = get_stylesheet_directory_uri();		
		$open_tags_a = array(
			"pc" 	=> "<a class='navigation-tel-whatsapp' href='https://web.whatsapp.com/send?phone={$number}&amp;text=&amp;source=&amp;data=' target='_blank'>",
			"mobile"=>"<a  class='navigation-tel-whatsapp' href='https://api.whatsapp.com/send?phone={$number}' target='_blank'>"
		);	
	
		foreach($open_tags_a as $key => $a){		
			$res[$key]	= "{$a}<img src='{$themePath}/whatsapp-menu.svg' alt=''>WhatsApp</a>";		
		}
	
		return $res;		
	}
	
	
	private function phone(){
		return "<div id='header-phone' class='phone'></div>";	
	}
	
	private function script(){
		
		$phones  = $this->phones;
					
		foreach($phones as $phone){	
				
			$whatsApp = $this->whatsApp( $this->number($phone) );							
			$mobile_str .= "<p><a href='tel:{$this->number($phone)}'>{$phone}</a><span>{$whatsApp['mobile']}</span></p>";				
			$pc_str 	.= "<p><span>{$phone}</span><span>{$whatsApp['pc']}</span></p>";			
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
	
	
	private function isFirstObject(){
	
		if(self::$count-1 == 1){return true;}
	
	}
	
	private function show(){
		if($this->getData()){		
			echo $this->phone() . $this->script();	
		}else{return '';}		
	}
	
	
}