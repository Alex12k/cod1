<?php

class Loader extends DLBuilder
{

		
	public function load()	
	{	
		if($this->settings['cfg']['no_cache']){$ver = rand();}				
		
		if($this->settings['cfg']['min_mode'])
		{	
			$this->loadMinCss($this->dataPage['css']['min'], $ver);
			$this->loadMinJs ($this->dataPage['js']['min'],  $ver);	
		}else{
			
			$this->loadStackCss($this->pageStream['css'],$ver);
			$this->loadStackJs ($this->pageStream['js'], $ver);			
		}
	
	}
	
}