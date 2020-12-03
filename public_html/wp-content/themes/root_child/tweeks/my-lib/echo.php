<?php
/* 
*	1.	Функция вывода массива в читабельной форме
* 	2.	Функция вывода команды echo с табами
* 	3.	Функция вывода информационного текстового сообщения
*	4.	Функция вывода информационного текстового сообщения
*/


/*
* 1. Функция вывода массива в читабельной форме
*/	
function print_arr($arr, $title_arr = ''){
	
	//if(ip_view(array('195.91.246.209', '46.242.8.148'))){ 
	
		$bt = debug_backtrace();			 
		$caller = array_shift($bt); 
		$caller_func = $bt[0]['function'];
		$file =  pathinfo($caller['file'])['filename'];
		$str  =  $caller['line']; 
	
	
	
		echo '<div class = "print_arr">';
			echo '<p><b> Просмотр массива: </b>'. '('.$file.' line '.$str.') <b><span style = "color: red;">'.$title_arr.'</span></b></p>';
			echo '<pre><code>'; print_r($arr);  echo '</code></pre>'; 	
		echo '</div>';
	
		?><style>
	
		.print_arr		{margin-bottom: 20px; color: black;}
		.print_arr p	{margin: 10px 15px 5px; color: black;}
		.print_arr pre	{font-size:16px; margin: 0px 15px 30px; color: black;}
	
		</style><?
	
		}//end if IP
	
	//}
	
	
/*
* 2. Функция вывода команды echo с табами
*/
function te($subject, $title = ''){	

	//if(ip_view(array('195.91.246.209', '46.242.8.148'))){ 

	$bt = debug_backtrace();			
	$caller = array_shift($bt); 
	$caller_func = $bt[0]['function'];
	$file =  pathinfo($caller['file'])['filename'];
	$str  =  $caller['line']; 
				
	echo "<h4 style='text-align: center;'> <div style='font-size:16px'>($file line $str)</div> <span style='color: #3e73ef'>$title</span> <span style='color: blue; font-size: 25px;'> $subject </span> </h4>";	
	
	//}//end IF IP

}

/*
*	3. 	Функция вывода простого массива или строки в форме таблицы, 
*		может обрабатывать элементы масссива функцией
* 		htmlspecialchars для вывода на экран html кода
*/
function print_table($arr, $chars=''){
				
		$bt = debug_backtrace();			 
		$caller = array_shift($bt); 
		$caller_func = $bt[0]['function'];
		$file =  pathinfo($caller['file'])['filename'];
		$str  =  $caller['line'];	
		
		
		
	if(!is_array($arr)){$arr = array('строка'=>$arr);}
		
	?>	
	<table class="zebra">
		<caption>
			<div><span style="color:black;">фаил: </span><?=$file?></div> 
			<div><span style="color:black;">строка: </span><?=$str?></div>
		</caption>
	<?
	foreach($arr as $key => $value){
	
		if($chars=='html'){
			$key 	=	htmlspecialchars($key);
			$value	 =	htmlspecialchars($value);
		}
		
		?>	
				<tr>				
					<td> <? echo $key;	?>	</td>
					<td style="white-space: pre;"><? echo $value;	?>	</td>			
				</tr>
			 	
		<?}?>
		</table><?
} //end function



/*
* 4. Функция вывода информационного текстового сообщения
*/
function info_message($text) {
	
	?>	<div class = "info-message"> <b> <?=$text?> </b> </div> <br/>	<?
	
}


