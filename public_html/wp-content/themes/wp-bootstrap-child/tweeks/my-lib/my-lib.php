<?php

/* #13 Функция конвертации многомерного  массива в строку
*  Принимает на вход многомерный массив и возвращает в строке все его значения.
*/
function convert_multi_array($array) {
	
	$out = implode(" ",array_map(function($a) {return implode("~",$a);},$array));	
	return $out;
}





/* 
*	Функция ищет в каком фаила записана функция
*	Принимает на вход имя функцяии, и выводит на экран адрес фаила,
*	где эта функция записана и строку на которой она находится	
*
*/

function find_function($function_name){
 
	$file_function = new ReflectionFunction($function_name);
	$result = $file_function ->getFileName() . ':' . $file_function ->getStartLine();
	
	echo '<h3>'.$result.'</h3>';
}




/* 	Блокировка доступа по IP адресу 
	Блокирует всех кроме разрешенных ip адресов
*/
function ip_page_lock(){
		
		$ip = $_SERVER['REMOTE_ADDR'];
		$my_ip = '195.91.246.209';
		$jul_ip = '90.154.70.51';
	
	if(($ip != $my_ip && $ip != $jul_ip)){	
		?> <img class = "lock-site" style = "display: block; margin: 0 auto; margin-top: 50px;" src = "<?=get_stylesheet_directory_uri()?>/sut-branding/lock-site.jpg"> </img> <?
		exit();
	}
 
}//End function




/* Функция преобразования первой буквы строки в заглавную 
*/
// функция для utf-8 (кирилицы)
function ucfirst_utf8($str){
    return mb_substr(mb_strtoupper($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr($str, 1, mb_strlen($str)-1, 'utf-8');
}








/*
*	Функция подсветки синтаксиса PHP на основе встроенной функции highlight_string
*	Принимает на вход закоменченный код в виде строки $str
*
*/

function HL_PHP($code){
		
	highlight_string("<?php $code ?>");
		
	echo '<br/>'.'Результат работы кода'.'<br/>';
	eval($code);
				
}



/*
*	Функция подсветки синтаксиса на основе библиотеки hightlight.js
*	Требует установки JS библиотеки, инициализации и подкючения фаила стилей	
*	Принимает на вход закоменченный код в виде строки $str
*
*/
function HL_JS($code){
				
		
	?><pre><code> <?	echo $code;	?></code></pre><?
	//eval($code);

}



/*  Определение мобильного устройства 
	на вход может подаваться список исключений, мобильных устройств
*/
// определение мобильного устройства
function check_mobile_device($unset_array='') { 
    $mobile_agent_array = array('xiaomi', 'ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
    
	if($unset_array != ''){
				
		if(!is_array($unset_array)){$unset_array = array($unset_array);}		
		$result_mobile_array = array_diff($mobile_agent_array, $unset_array);
	}else{
		$result_mobile_array = $mobile_agent_array;
	}
	
	//print_arr($result_mobile_array);
	
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);    
    //var_dump($agent);exit;
	
    foreach ($result_mobile_array as $value) {    
        if (strpos($agent, $value) !== false) return true;   
    }       
    return false; 
}


// пример использования
/*
$is_mobile_device = check_mobile_device('ipad');
if($is_mobile_device){
    echo "Вы зашли с мобильного устройства";
}else{
    echo "Вы зашли с PC";
}
*/




/* Определение мобильного устройства (Такая же функция уже есть встроенная в Wordpress */

/*
// определение мобильного устройства
function check_mobile_device() { 
    $mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);    
    //var_dump($agent);exit;
	
    foreach ($mobile_agent_array as $value) {    
        if (strpos($agent, $value) !== false) return true;   
    }       
    return false; 
}



// пример использования
$is_mobile_device = check_mobile_device();
if($is_mobile_device){
    echo "Вы зашли с мобильного устройства";
}else{
    echo "Вы зашли с PC";
}
*/





/*	Функция модального окна, принимает на вход абсолютную ссылку до фаила.
	Css код в modules base 
*/
function modal_window($dir_content_file='', $open_but_name, $num){?>

	<script> 
		//var num = <? echo json_encode($num);?> 
	</script>
	<div class="button-container"> 		
		<a class="popup-open button btn-white popup-open-<?=$num?>" data-num=<?=$num?> href=""> <?=$open_but_name?> </a>
	</div>
	
	
	
	<div class="popup-fade popup-fade-<?=$num?>">
		<div class="popup">
			<a class="popup-close" href="#">&#9747;</a>							
				<? require $dir_content_file; ?>
			<!--<a class="popup-close-down" href="">Закрыть</a>-->
	
		</div>		
	</div>	
	<?
	
}
	
	
	
	

/* Функция проверки на админа */
function if_user_admin(){
	if(current_user_can('level_10')){	

	return true;
	}
}






/* Функция отслеживания изменния в единичном фаиле по хешу 
*
* Функция принимает путь до проверяемого фаила 
* создает контрольный hash фаил в той же директории что и проверяемый фаил
* и далее сверяет, если hash изменился, то возвращает true
*
*/

function check_update_file($url_file){
	
	$new_hash 		= md5_file($url_file);
	$name_hash_file = pathinfo($url_file)['filename'].'-hash.txt';	
	$url_hash_file 	= dirname($url_file).'/'.$name_hash_file;
	
	
	/* Если фаил hash еще не создан, то создаём его и записываем в него hash */
	if(!file_exists($url_hash_file)){	
		file_put_contents($url_hash_file, $new_hash);	
	}
		
	/* Проверяем если записанный hash отличаеться от текущего hash в serialize фаиле, 
		то перезаписываем hash и возвращаем true */	
		
	$old_hash = file_get_contents($url_hash_file);
	if($new_hash != $old_hash){
		file_put_contents($url_hash_file, $new_hash);
		return true;
	}
					
}





	/*	Функция принимает список разрешенных ip адресов 
		Разрешенные адреса заходят на сайт
		Остальным же показывается картинка,
		сайт в разработке
	*/
	function ip_access($admins_ip=''){

	
		/* если приходит переменная, делаем её массивом  */
		if(!is_array($admins_ip)){$admins_ip_array[] = $admins_ip; } else {			
			$admins_ip_array = $admins_ip;
		}	//end if
		
	
		
		$user_ip =  $_SERVER['REMOTE_ADDR'];				
		
		if(!in_array($user_ip, $admins_ip_array )){				
		?>
			<h1> New_theme.RU </h1>
			<img src = "<?=get_stylesheet_directory_uri()?>/v_razrabotke.png"/>
			
			<p>
			Уважаемый посетитель!<br>
			Наш сайт находится в разработке, приносим свои извинения<br> 
			за временные неудобства.
			</p>
			
			<style>
			img {display: block; margin: 0 auto; width: 100%; max-width: 800px;}
			h1{color: #231f20; text-align: center; margin-bottom: 0px; margin-top: 30px;}
			p{text-align: center; font-size: 33px; color: #231f20; margin:30px;}
		
			</style>
		<?	
		exit();	
		}//end if
	
	}//end func
 
 
function ip_view($admins_ip=''){
			
		
		/* если приходит переменная, делаем её массивом  */
		if(!is_array($admins_ip)){$admins_ip_array[] = $admins_ip; } else {			
			$admins_ip_array = $admins_ip;			
		}	//end if
			
		$user_ip =  $_SERVER['REMOTE_ADDR'];						
				
		if(in_array($user_ip, $admins_ip_array )){return true;}//end if
		
	
	}//end func
 


/* 	Функция принимает: 
	1) массив с картинками .jpg 
	2) адрес папки куда сохранить миниатюры
	3) width миниатюры
	4) height миниатюры
	Функция работает на основе класса classSimpleImage.php 
	и сама его подключает
*/
function image_resizer($images, $save_folder, $width, $height){	//print_arr($images);
	
	$theme_path 	= 	get_stylesheet_directory();  
	$class_path		= $theme_path.'/tweeks/classSimpleImage.php';
			
		
    if(!is_file($class_path)){
		exit (te("класс ".basename($class_path)." не найден"));		
	}	
	require_once $class_path;	
 	
	/* Если папик для сохранения нет, то создаём её */
	if(!is_dir($save_folder)){
			mkdir($save_folder);
		}
	
	foreach($images as $img){
		$thumb_FileName = basename($img);
		$savePath 		= $save_folder.'/thumb-'.$width.'x'.$height.'-'.$thumb_FileName;	
		
		if(!is_file($savePath)){		
			
			$image = new SimpleImage();
			$image->load($img);     		// Может принимать относительный или абсолютный путь до фаила
			$image->resize($width, $height);
			$image->save($savePath);		//Может принимать только абсолютный путь 				
			te('создан фаил:'.basename($savePath));
		
		}//end if
	}//end foreach

}//end image_resizer




function lesh($length='', $lang=''){
	
	if(empty($length)){$length=5000;}
	
	$ru = "Значимость этих проблем настолько очевидна, что новая модель организационной деятельности требуют определения и уточнения позиций, занимаемых участниками в отношении поставленных задач. Таким образом сложившаяся структура организации способствует подготовки и реализации существенных финансовых и административных условий. Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности играет важную роль в формировании модели развития. Разнообразный и богатый опыт начало повседневной работы по формированию позиции влечет за собой процесс внедрения и модернизации форм развития. Задача организации, в особенности же постоянный количественный рост и сфера нашей активности требуют от нас анализа систем массового участия. Равным образом постоянное информационно-пропагандистское обеспечение нашей деятельности обеспечивает широкому кругу (специалистов) участие в формировании систем массового участия. Разнообразный и богатый опыт дальнейшее развитие различных форм деятельности в значительной степени обуславливает создание системы обучения кадров, соответствует насущным потребностям. Товарищи! постоянный количественный рост и сфера нашей активности позволяет оценить значение соответствующий условий активизации. Идейные соображения высшего порядка, а также консультация с широким активом способствует подготовки и реализации направлений прогрессивного развития. Разнообразный и богатый опыт сложившаяся структура организации позволяет оценить значение соответствующий условий активизации.";
	$en = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.";

	if($lang==''){
			$lesh = mb_substr($ru, 0 , $length ,'UTF-8');
	}else{	$lesh = mb_substr($en, 0 , $length ,'UTF-8');}

	echo $lesh;
	
}




/*===ДОБАВЛЕНИЕ своих THEMPLATE NAME в админку======*/

/* по материалам: https://wp-kama.ru/question/kak-dopolnit-mesta-gde-iskat-shablony-stranits */


add_filter('theme_page_templates', 'my_modules_template');	
function my_modules_template( $templates ){	
	$templates_dir = 'modules_page_folder/';
	$templates_files = scandir(locate_template($templates_dir));
		
	foreach ( $templates_files as $file ) {
		if ( $file == '.' || $file == '..') continue;
		$name = explode('.', $file);
		$templates[$templates_dir.$file.'/index.php']= $name[0];
	}
	return $templates; 
};





/* Функция показывает доступные для выбора Themplate_name */
function get_page_templates_123( $post = null, $post_type = 'page' ) {
	return array_flip( wp_get_theme()->get_page_templates( $post, $post_type ) );
}
//print_arr(get_page_templates_123());



/* Фильтр добавления в выбор из админки своего template_name */
//add_filter( 'theme_templates', 'add_my_template_to_list', 10, 4 );
function add_my_template_to_list( $templates, $wp_theme, $post, $post_type ) {
	if ( 'page' === $post_type ) {
		$templates['template/defaults/page.php'] = 'Мой дефолтный шаблон страницы';
	
	}

	return $templates;
}

/*======ENDДОБАВЛЕНИЕ своих THEMPLATE NAME в админку======*/


/*  Функция возвращает template_name установленный для шаблона.
	В том случае если она запущена на странице и страница имеет собственный шаблон
*/	

function get_template_name(){
	if ( is_page() && $current_template = get_page_template_slug( get_queried_object_id() ) ){
		$templates = wp_get_theme()->get_page_templates();
		$template_name = $templates[$current_template];
		return $template_name;
	}	
}

/*--------------END-------------*/




/* Просмотр очереди css */
function view_css_queue(){
	
	add_action('wp_enqueue_scripts', function(){
		global $wp_styles, $wp_scripts;
				
		$queue_items = array(
			'css'	=>	$wp_styles->queue,
			'js'	=>	$wp_scripts->queue
		);		
		print_arr($queue_items['css']);		
	}, 999);	
}
//view_css_queue();
/*---End---*/




/**
 * Класс для измерения времени выполнения скрипта или операций
 */
class Timer
{
    /**
     * @var float время начала выполнения скрипта
     */
    private static $start = .0;

    /**
     * Начало выполнения
     */
    static function start()
    {
        self::$start = microtime(true);
    }

    /**
     * Разница между текущей меткой времени и меткой self::$start
     * @return float
     */
    static function finish()
    {
		
        $result =  microtime(true) - self::$start;
		te($result. ' сек.');
		return $result;
	}
}

//	Timer::start();
//  Тут участок кода или функция
//	Timer::finish();

/* =========== END ==========*/


	/*	
	$string = 'random_name.css';
	Timer::start();	
	while ($num <= 1000000){		
		// Тестируемая в цикле функция 
		$res = ubrat_rashirenie($string);
		
		$num++;
	}
		
	Timer::finish();
	te($res,'результат');
	*/






