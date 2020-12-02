<?php


	/* Перекачка с Main на Main */
//	$ftp 	  			= 	new myFtp( ftp_config('main') );	
//	$remoteFolder 		=	'alff.ru/public_html/wp-content/themes/omw2.0b-2/bootstrap_html_templates';
//	$newLocation 		= get_stylesheet_directory().'/download_test';

	
	
//	/* Перекачка с Metall на Main */
//	$ftp 	 		= 	new myFtp( ftp_config('metall') );	
//	$remoteFolder 	=	'/metallist.moskva/public_html/wp-content/themes/clean-root-child/test';
//	$remoteFile 	=	'/metallist.moskva/public_html/wp-content/themes/clean-root-child/test/test-1.css';	
//	$newLocation 	= 	get_stylesheet_directory().'/download_test/';


function timer($iteracion){
	
		Timer::start();	
			
			while ($num <= $iteracion-1){		
			// Тестируемая в цикле функция 
			
			te('!');
			//$ftp -> copyFolder($remoteFolder, $newLocation, 'ftp_get');
			//$ftp -> copyFolder($remoteFolder, $newLocation, 'put_contents');
	
	
			//print_arr($ftp->getLog());
			$num++;
		}		
	Timer::finish();	
}	
	
//timer(1);	
	
	
	
/* ТЕСТ Download File */

/*
$ftp->downloadFile($newLocation, $remoteFile);
$log = $ftp->getLog();
print_arr($log);
*/
	
	
	


	
		
	//$res = LastPartUrl($remoteFolder);
	//te($res);
	
	//$ftp -> copyFolder_v2($remoteFolder, $newLocation);

	//$res = $ftp ->listFolder($remoteFolder);
	//$res = $ftp ->listFile($remoteFolder);
	//print_arr($res);
	
	//$res = $ftp ->listDetailed_v2($remoteFolder);
	






























