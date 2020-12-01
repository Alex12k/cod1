<?php
/* Использует класс tag helper */


class Modal_v2
{
	private static $count = 1;
	private $id;
	private $helper;	
	private $btnText;
	private $content;
	
	
	

public function __construct($btnText='', $content=''){	 
		
	$this->helper 	= 	new TagHelper;	 
	$this->id 		= 	'modal-window-'.self::$count++;
	$this->btnText	=	$btnText;
	$this->content	=	$content;
	$this->css();

	
	$this->modal_button();	
	add_action(	'wp_footer',	function(){ $this->modal_window();  	});
	
}

	
private function modal_button(){
				
		?><!-- Button trigger modal -->
		<div class="btn-container">
			<button type="button" class="btn btn-modal" data-toggle="modal" data-target="#<?=$this->id?>">
			<?=$this->btnText;?>
			</button>
		</div>
		<?
	
	}
	
	
private function modal_window(){
				
		$helper = $this->helper;
					
		$AttrModal = $helper->getAttrsStr([
									'id'				=>	$this->id,
									'tabindex'  		=>  '-1',
									'role'				=>	'dialog',
									'aria-labelledby'	=>	$this->id . '-Label',
									'aria-hidden'		=>	'true'									
									]);		

		?>
		

		<div class = "modal fade"  <?=$AttrModal?>>		
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
     
		<!-- Всплывающее окно -->
			<?	
			$this->modal_header();	
			$this->modal_body();		  
			//$this->modal_footer();	
			?>  
		<!-- Всплывающее end -->
	 
				</div>
			</div>
		</div>
		<?
	}

	
	private function modal_header(){
		
		?>
			<div class="modal-header">
				<h5 class="modal-title" id="<?=$this->id?>-Label">	Написать нам:	</h5>     	   
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?
	}


	private function modal_body(){
		?><div class="modal-body"><?=$this->content?></div><?
	}


	private function modal_footer(){
		?>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
				<!--<button type="button" class="btn btn-primary">Save changes</button>-->
			</div>
		<?
	}
	
	
	
	private function isFirstObject(){
		if(self::$count-1 == 1){return true;}
	}
	
	
	private function css(){						
		if($this->isFirstObject()){?>				
			<style>
				@media screen and (min-width: 960px){html{overflow: auto; margin-left: calc(100vw - 100% -17px); margin-right: 0;}}
			</style><?}			
	}



}









