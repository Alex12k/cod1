<?php

class TagHelper
	{
	
		

		public function show($name, $attrs = [], $text){
			
			return $this->open($name, $attrs) .$text .$this->close($name);
			
		}
	
		/* Метод открывающего тега */
		public function open($name, $attrs = [])
		{
			$attrsStr = $this->getAttrsStr($attrs);
			return "<$name$attrsStr>";
		}
		
		/* Метод закрывающего тега */
		public function close($name)
		{
			return "</$name>";
		}
		
		
		/* Метод формирующий строку с атрибутами: */
		public function getAttrsStr($attrs)
		{
			if (!empty($attrs)) {
				$result = '';
				
				foreach ($attrs as $name => $value) {
					if ($value === true) {
						$result .= " $name";
					} else {
						$result .= " $name=\"$value\"";
					}
				}
				
				return $result;
			} else {
				return '';
			}
		} //end method
	
	}//end class