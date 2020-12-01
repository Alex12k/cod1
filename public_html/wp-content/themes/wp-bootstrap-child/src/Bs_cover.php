<?php

class Jumbotron
{
	private $background;
	private $data = [];

	
	public function __construct(){			
		$this->background = $this->getBackground();			
		if($this->background){
			$this->data = $this->getData();
			}	
	}
	
	
	
	private function getBackground(){
		return wp_get_attachment_image_src(carbon_get_the_post_meta('jumbotron-img'), 'full')[0];		
	}
	
	private function getData(){	
			
		return $content = array(
				'h1'		=> carbon_get_the_post_meta('jumbotron-zagolovok'),
				'p'			=> carbon_get_the_post_meta('jumbotron-paragraf'),
				'btn-text' 	=> carbon_get_the_post_meta('jumbotron-button-text'),
				'btn-url' 	=> carbon_get_the_post_meta('jumbotron-button-text'),
			);	
	}
	
	
	
	private function content(){				
			if($this->data['h1']){$h1 = $this->h1();}
			if($this->data['p']) {$p = $this->p();  }			
			if($this->data['btn-url'] and $this->data['btn-text']) {$a = $this->a();}					
			return $h1.$p.$a;		
	}
	
	
	
	/* Контейнер модуля */
	private function section($content)
	{
		$bg = $this->background;		
		$style = "style='background-image:url({$bg});'";
		
		return "<section class='jumbotron text-center wp-bs-4-jumbotron-me border-bottom text-white' {$style}>
					<div class='wp-bp-jumbo-overlay'>
						<div class='container'>
							{$content}
						</div>
					</div>
				</section>";		
	}
	


	private function h1(){
		return "<h1 class='jumbotron-heading'>{$this->data['h1']}</h1>";
	}
	
	private function p(){
		return "<p class='lead mb-4'>{$this->data['p']}</p>";
	}
	
	private function a(){
		return "<a href='{$this->data['btn-url']}' class='btn btn-primary btn-lg'>{$this->data['btn-text']}</a>";
	}



	

		
	private function __toString(){
			
		if($this->background){
			return $this->section($this->content());
		}else{return '';}
					
	}//end method
	
	
}




