<?php
/* Список возможностей

#1	Функция принимает имена атрибутов и возвращает список их значений.	(не применяется)
#2	Функция принимает имена кастомных полей и возращает их значения. 	(применяется)
#3	Функция выводит список товаров по _SKU с помощью шорткода			(не применяется)
#4	Функция выводит список модулей справа от галереи товара				(НЕ применяется)
#5	УЛУЧШЕННАЯ Функция выводит список модулей (TITLE => КОЛЛИЧЕСТВО) справа от галереи товара.  (Применяется)
#6	
#7	
#8	

*/



//add_action('get_complect','get_product_attr_values');
/*	1# 
*	Функция принимает имена атрибутов и возвращает список их значений.
*	Запускается в фаиле content-single-product.php
*
*/

function get_product_attr_values(){
		
		
	$attr_name1 = 'pa_verxnie-moduli';
	$attr_name2 = 'pa_nizhnie-moduli';
	
	$Attr_name_arr = array($attr_name1, $attr_name2);

	foreach($Attr_name_arr as $attr_name){
		
		$Values[] = wc_get_product_terms( $product->id, $attr_name, array( 'fields' => 'names' ) );	

	}

	
	/* Конвертируем многомерный нумерованный массив в стоку */
	$Values_str = convert_multi_array($Values);

	/*Тут мы получили в простом массиве список всех наименований комплекта*/
	global $Complect_modules_simple_arr;
	$Complect_modules_simple_arr = explode(" ", $Values_str);
	

}






/*	#2
*	Функция принимает имена кастомных полей и возращает их значения.
*	Запускается в фаиле content-single-product.php
*/

add_action('get_complect','get_custom_fields_values'); // Функция используется в проекте
function get_custom_fields_values(){

/* ПОЛУЧАЕМ ЗНАЧЕНИЕ КАСТОМНОГО МЕТАПОЛЯ текущего поста $post->ID, по названию метаполя test-field */
	global	$post;	
	global	$Top_modules;
	global	$Bott_modules;
	
	$Top_modules = get_post_meta	( $post->ID, 'top_modules', false);
	$Bott_modules = get_post_meta	( $post->ID, 'bott_modules', false);
		
		
	/*Очистим массив от элементов с пустыми значениями */
	$Top_modules = array_diff($Top_modules[0], array(''));
	$Bott_modules = array_diff($Bott_modules[0], array(''));
	
	
	//print_arr ($Top_modules);
	

	
	
/* Сумируем массив верхних модулей */
$One_arr = array();
$Two_arr = array();
$Free_arr = array();
$Four_arr = array();	
foreach($Top_modules as $key => $value){
		
		$key = strstr($key, '-', true); 
		
		//print_arr($key);
		
		//Если ключ в массиве не существет, записываем его в первый массив
			if(!array_key_exists($key,$One_arr)){
				
				$One_arr[$key]=$value;
			//Если ключ уже существует, записываем его во второй массив дублей
			}else{
				
				if(!array_key_exists($key,$Two_arr)){	
				$Two_arr[$key]=$value;
				}
					else{
						if(!array_key_exists($key,$Free_arr)){
						$Free_arr[$key]=$value;
						}
							else{
								$Four_arr[$key]=$value;
							}
						
					}
				
				
			}							
	}
		
	//print_arr($One_arr);
	//print_arr($Two_arr);
	//print_arr($Free_arr);
	//print_arr($Four_arr);
	
	
// Получаем третий массив , cумируем два массива , складывая значения с одинаковыми ключами 	
$Top_modules = array();  
foreach (array_keys($One_arr + $Two_arr + $Free_arr + $Four_arr) as $c) {
  
  
  $Top_modules_not_redact[$c] =	  (isset($One_arr[$c]) ? $One_arr[$c] : 0) 
							+ (isset($Two_arr) ? $Two_arr[$c] : 0) 
							+ (isset($Free_arr) ? $Free_arr[$c] : 0) 
							+ (isset($Four_arr) ? $Four_arr[$c] : 0);		

						
}

/* Обработка финального массива (удаление пробелов из ключей) */
foreach($Top_modules_not_redact as $key => $value){		
	$key = str_replace(" ","",$key);			
	$Top_modules[$key] = $value;	
}
/* В результате получаем обработанный массив $Top_modules */

//print_arr($Top_modules);	



/* Сумируем массив нижних модулей */
$One_arr = array();
$Two_arr = array();
$Free_arr = array();
$Four_arr = array();	
foreach($Bott_modules as $key => $value){
		
		$key = strstr($key, '-', true); 
		
		//print_arr($key);
		
		//Если ключ в массиве не существет, записываем его в первый массив
			if(!array_key_exists($key,$One_arr)){
				
				$One_arr[$key]=$value;
			//Если ключ уже существует, записываем его во второй массив дублей
			}else{
				
				if(!array_key_exists($key,$Two_arr)){	
				$Two_arr[$key]=$value;
				}
					else{
						if(!array_key_exists($key,$Free_arr)){
						$Free_arr[$key]=$value;
						}
							else{
								$Four_arr[$key]=$value;
							}
						
					}
				
				
			}							
	}
		
	//print_arr($One_arr);
	//print_arr($Two_arr);
	//print_arr($Free_arr);
	//print_arr($Four_arr);
	
	
// Получаем третий массив , cумируем два массива , складывая значения с одинаковыми ключами 	
$Bott_modules = array();  
foreach (array_keys($One_arr + $Two_arr + $Free_arr + $Four_arr) as $c) {
  
  
  $Bott_modules_not_redact[$c] =	  (isset($One_arr[$c]) ? $One_arr[$c] : 0) 
						+ (isset($Two_arr) ? $Two_arr[$c] : 0) 
						+ (isset($Free_arr) ? $Free_arr[$c] : 0) 
						+ (isset($Four_arr) ? $Four_arr[$c] : 0);		

						
}

/* Обработка финального массива (удаление пробелов из ключей) */
foreach($Bott_modules_not_redact as $key => $value){		
	$key = str_replace(" ","",$key);			
	$Bott_modules[$key] = $value;	
}
/* В результате получаем обработанный массив $Bott_modules */

//print_arr($Bott_modules);	


} /* #2 END */





/*	#3
*	Функция выводит список товаров по _SKU с помощью шорткода
*	
*/
function get_product_by_sku(){

		global $Complect_modules_simple_arr;

		
			foreach ($Complect_modules_simple_arr as $item) {
	
			echo do_shortcode("[products skus='$item' orderby='date' order='desc']");
		}
		
}




/*	#4
* 	Функция выводит список модулей справа от галереи товара 
*	(ОТКЛЮЧЕНА,  используется улучшенная 
*/


function spisok_moduley_in_single_product(){
	
	global 	$Top_modules;
	global	$Bott_modules;
	
	
	$all_modules = array_merge($Top_modules,$Bott_modules);
	$vsego_moduley =  array_sum($all_modules);
	
	
	?><div class = "spisok_moduley"><?
	
	?>
	<div class = "item"> 	
	<span class = "name"> Цена указана за данный набор из <span class = "vsego_moduley">(<?=$vsego_moduley?>)</span> шкафов на картинке</span>	
	</div>
	<?
	

	foreach ($Top_modules as $key => $value){		
		?><div class = "item"><span class = "name"> <?=$key?> </span>  <span class = "num"> <?=$value?> </span></div><?
		}	
	
	foreach ($Bott_modules as $key => $value){		
		?><div class = "item"><span class = "name"> <?=$key?> </span>  <span class = "num"> <?=$value?> </span></div><?
		}


	?></div><? /*Список модулей END */ 
}




/*	#5
*	УЛУЧШЕННАЯ Функция выводит список модулей (TITLE => КОЛЛИЧЕСТВО) справа от галереи товара. 
*/

function spisok_moduley_in_single_product_uluchshenaya(){
	
	global	$Top_modules;
	global	$Bott_modules;

		
	/* Получаем terms продукта в отсортированном виде */
	global $post;
	$terms = wp_get_object_terms(
			$post->ID, 
			'product_cat', 
			array('orderby' => 'term_id', 'order' => 'ASC') ); 
	
	
	
	
	$this_cat = $terms[1]->name;	
	/* Делаем первую букву заглавной */
	$this_cat = ucfirst_utf8($this_cat);
		
	
	/*	Соединяем два массива в один общий	*/
	$all_modules = array_merge($Top_modules,$Bott_modules);
	//print_arr($all_modules, 'Объединенный массив');	
		
		
	/* Добавляем название категории */
	foreach($all_modules as $key => $value){			
		$New_all_modules[$key.'-'.$this_cat] = $value;		
		}
	
	
	//print_arr($New_all_modules, 'New_all_modules');
	
	
	/* Складываем значения колличества модулей */
	$Vsego_moduley =  array_sum($New_all_modules);

	//print_arr($Vsego_moduley, 'сумма всех подулей');
	
	/*	Формируем массив _SKU товаров	*/
	$Massiv_sku = array_keys($New_all_modules);
	//print_arr($Massiv_sku, "_SKU");
	
		
	/* Переводим массив _SKU в массив ID */
	foreach ($Massiv_sku as $item){
		$Massiv_id[] = wc_get_product_id_by_sku($item);
		}
		
	//print_arr($Massiv_id, "массив ID");
	
		/* Если массив id пустой то прекращаем выполнение функции */
		if(empty($Massiv_id)){ return; }
	
	/*Делаем запрос выборку из базы*/
	$wpb_all_query = new WP_Query(array(
								'post_type'=>'product',    	//Тип поста
								'posts_per_page'=>30,     	//Сколько постов выводить на странице								
								'post__in'=> $Massiv_id,		//Берём товары из массива ID
								
								)	
							
							
								); 
			
			
		/* Лезем в массив $posts и в цикле достаём оттуда данные по каждому продукту */
		$posts = $wpb_all_query->posts;	

		
		
		foreach($posts as $prod){
					
			
			$id = $prod->ID;				/*Получаем ID продукта*/					
			$Meta = get_post_meta($id);		/*По id лезем в массив мета данных продукта*/	
			$Sku = $Meta[_sku][0];			/*Достаём оттуда значение SKU*/
			
			$my_titles[$Sku] = $prod->post_title; /* Формируем именованный массив SKU => Title */
			
			/* Цены модулей входящих в состав кухни */
			$Prices[$Sku] = $Meta[_regular_price][0];
			
			}
					
			
		//print_arr($my_titles);
		//print_arr($New_all_modules);
		//print_arr($Prices);
			
			
	/* ФОРМИРУЕМ на основе двух массивов , новый массив TITLE => КОЛЛИЧЕСТВО ШТУК */	
	foreach ($my_titles as $key => $value){
		
			//te($value);
		
			$Title_colichestvo[$value] = $New_all_modules[$key];
		}
	
	
	/* Выводим список модулей и их колличество */
	?><div id="crossing"><?
	?><ul class = "spisok_moduley"><?
	
	?>
	<div class = "item"> 	
	<span class = "name"> Цена указана за данный набор из <span class = "vsego_moduley">(<?=$Vsego_moduley?>)</span> шкафов на картинке</span>	
	</div>
	<?
	

	foreach ($Title_colichestvo as $key => $value){		
		?><li class = "item"><span class = "name"> <?=$key?> </span>  <span class = "num"> <?=$value?></span></li><?
		}	
	 
	?> <li id="control">Показать весь список</li> <?
	?></ul><? /*Список модулей END */ 
	?></div><?	
	
	
	// JS СКРИПТ СВОРАЧИВАЮЩИЙ/РАЗВОРАЧИВАЮЩИЙ СПИСОК МОДУЛЕЙ 
	?>
	<script>
	$('#control').click(function(){
    $('#crossing').toggleClass('expand');
	});
	</script>	
	<?
		
	wp_reset_postdata();		
}


/*	#6
	Функция вывода шаблона с модулями
*/
function load_modules(){
			
	/*Получим название родительской  категории */
	global $post;
	$terms = wp_get_object_terms(
			$post->ID, 
			'product_cat', 
			array('orderby' => 'term_id', 'order' => 'ASC') ); 	
	$this_cat = $terms[0]->slug;
	
	
	/* Если товар относится к категории fasady выводим этот блок */
	if($this_cat == 'modulnye-kuxni'){
			
					
			get_template_part('local-project-include-templates/product', 'modules');
			
	}		
}



/* #7 
*	Функция вывода атрибута pa_cvet 
*	(css нахоодится в папках:  Геометрия в variation-checkbox, цвета в variation-colors)
*	add_action в function php
*	
*/
function echo_atribut_in_archive_card(){
	$cvet =  get_the_terms( $product->id, 'pa_cvet');
	
	
	?><ul class = "colors"><?
	foreach ($cvet as $item) {			
		?> <li class = "<?=$item->slug;?>"></li>	 <?
					
	}
	?> </ul> <?
	
}


/* #7 
*	Функция вывода атрибутов Длина и Ширина в карточках товаров
*	add_action в function php
*	
*/

function echo_atribut_dlina_shirina(){
	
	$dlina = get_the_terms( $product->id, 'pa_dlina');
	$shirina = get_the_terms( $product->id, 'pa_shirina');
	
	$visota  = get_the_terms( $product->id, 'pa_vysota');
	
	$glubina  = get_the_terms( $product->id, 'pa_glubina');
	
	$tolshina = get_the_terms( $product->id, 'pa_tolshina');
	

	
	$dlina 		= $dlina[0]->name;
	$shirina	= $shirina[0]->name;
	$visota 	= $visota[0]->name;
	$glubina 	=$glubina[0]->name;
	$tolshina 	= $tolshina[0]->name;
	
	
	
	/*Получим название родительской  категории */
	global $post;
	$terms = wp_get_object_terms(
			$post->ID, 
			'product_cat', 
			array('orderby' => 'term_id', 'order' => 'ASC') ); 	
	$this_cat = $terms[0]->slug;
	
	
	
	if(is_archive() || is_single() ){	
	/* Если товар относится к категории кухонные модули выводим этот блок */
	if($this_cat == 'kuxonnye-moduli'){
		?>
		<div class = "size-block">	
		
			<?if($visota){?>	<p>	Высота: <?=$visota?> cм</p>		<?}?>
			<?if($shirina){?>	<p>	| Ширина: <?=$shirina?> cм</p>	<?}?>	
						
		</div>
		<?		
		}
	}
	
	
	
	
	
	/* Если товар относится к категории modulnye-kuxni выводим этот блок */
	if(is_archive() || is_single() ){	
	
	if($this_cat == 'modulnye-kuxni'){
		?>	
		<div class = "size-block">		
			<?if($dlina){?><p>Длина: <?=$dlina?> м</p><?}?>		
			<?if($shirina){?><p> | Ширина: <?=$shirina?> м</p><?}?>				
		</div>	
	
		<?
		}	
	}
	
	
	
	
	/* Если товар относится к категории столешницы */
	if(is_archive() || is_single() ){	
	
	if($this_cat =='stoleshnicy'){
		?>	
		<div class = "size-block">		
			<?if($tolshina){?>	<p> 	Толщина: 	<?=$tolshina?>	мм</p><?}?>
			<?if($glubina){?>	<p>	|	Глубина: 	<?=$glubina?> 	см</p><?}?>		
			<?if($shirina){?>	<p> 	Ширина: 	<?=$shirina?> 	см</p><?}?>	
			
			
		</div>	
	
		<?
		}	
	}
	
	

}/* end function */





/* Функция вывода категории товара в карточке товара */


function modules_cat_button(){
	
	/* Получаем название (slug) категории в карточке товара */
	global $post;
	$terms = wp_get_object_terms(
			$post->ID, 
			'product_cat', 
			array('orderby' => 'term_id', 'order' => 'ASC') ); 
	
	
	$this_cat = $terms[1]->slug;	


	/* Если это сраница archive или страница single */
	?> <a class="button view-modules-button" href="<?=get_site_url();?>/product-category/kuxonnye-moduli/moduli-dlya-kuxni-<?=$this_cat?>">Все модули </a> <?
	

}


add_action( 'woocommerce_after_shop_loop_item', 'modules_cat_button',15 );








/*===REGISTER WIDGET ARAES===*/

/*	
*	Регистрация новых областей для виджетов, вывод делается через ACTION в function.php
*/

/* Регистрация */
register_sidebar( array(
        'name' => __( 'my-widget-area'),
        'id' => 'my-widget',
        'description' => __( 'Область для моих виджетов'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<span>',
        'after_title' => '<span>',
    ) );

/*Функция вывода*/
function my_sidebar(){
?><div class="my_sidebar"> <?php dynamic_sidebar( 'my-widget' ); ?> </div><?
}



/* Область для виджетов в Header */
add_action( 'widgets_init', 'register_my_widgets' );
function register_my_widgets(){
register_sidebar( array(
        'name' => __( 'header_area'),
        'id' => 'header_shop_info',
        'description' => __( 'Область для вывода инфорормации магазина в Header'),
		'class'         => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => "</div>\n",
        'before_title' => '<p class="widgettitle">',
        'after_title' => "</p>\n",
    ) );
}


/*Функция вывода*/
function header_shop_info(){
	?><div class = "header-shop-info">	<?php dynamic_sidebar( 'header_shop_info' );?> </div><?
}








/* Область в ARCHIVE-PRODUCT */

add_action( 'widgets_init', 'register_archive_top_area' );
function register_archive_top_area(){
register_sidebar( array(
        'name' => __( 'archive_top_area'),
        'id' => 'archive_top',
        'description' => __( 'Область для вывода виджетов на архивом товаров'),
		'class'         => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => "</div>\n",
        'before_title' => '<p class="widgettitle">',
        'after_title' => "</p>\n",
    ) );
}


/*Функция вывода*/
function echo_archive_top_area(){
	?><div class = "archive_top_area">	<?php dynamic_sidebar( 'archive_top' );?> </div><?
}







/* Вывод кнопки обратного звонка */
function call_back_in_single_product(){
	?>	
		<a href="#" class="modal-okno pum-trigger yellow_button" style="cursor: pointer;"> Заказать обратный звонок</a>	
	<?
}




/* Вывод кнопки обратного звонка */
function soputstvuyshie_tovari(){
	?>	
	<ul>
		<li><a href="/product-category/soputstvuyushhie-tovary/mojki/" 		class="mojki" 		style="cursor: pointer;"> Мойки 	</a></li>
		<li><a href="/product-category/soputstvuyushhie-tovary/plintusa/" 	class="plintusa"	style="cursor: pointer;"> Плинтуса	</a></li>
		<li><a href="/product-category/soputstvuyushhie-tovary/sushki/" 	class="sushki" 		style="cursor: pointer;"> Сушки 	</a></li>
		<li><a href="/category/stenovye-paneli/" 							class="stenovie-paneli" 		style="cursor: pointer;"> Стеновые панели </a></li>
		<li><a href="/product-category/kuxonnye-moduli/stoleshnicy/" 		class="Stoleshnici" 			style="cursor: pointer;"> Столешницы </a></li>
			
			
			
	</ul>	
		
	<?
}




/* Функция вывода Банера на Single  */
function esli_vi_ne_nashli_gotovi_variant_single(){
	?>

		<div class = "baner_2">		
			
		<div class = "ofer_2">Если Вы не нашли готовый вариант ?</div>	
        <p>– Мы соберем кухню из модулей под Ваш размер. Выберите необходимые модули самостоятельно или</p>
		<a class = "modal-okno pum-trigger"> обратитесь к нам </a>
							
		</div>	

	
	<?
	
}


/* Функция вывода Банера на Archive  */
function esli_vi_ne_nashli_gotovi_variant_archive(){
	?>

		<div class = "baner_2">		
			
		<p>В нашем интернет - магазине</p>	
		<div class = "ofer_2">Вы можете выбрать готовую композицию,
		или составить собственную из имеющихся модулей!</div>
		<a class = "modal-okno pum-trigger"> обратитесь к нам </a>
							
		</div>	

	
	<?
	
}




/* Функция вывода дополнительного Header-a #  */
add_action('root_before_header','my_top_header');
//add_action('root_after_header','my_top_header');

function my_top_header(){
	?>
	
	<div class = "my_top_header">
		
	<div class = "container">
		<div class = "contact-info">
			
			<div class = "tell-block">
				<div class = "tell">телефон-whatsapp</div>
			
				<div class = "whatsapp"> <a href="tel:8-977-537-21-20"> 8 (977) 537-21-20 </a></div>									
			</div>
			<a class="contact-form-heder"> 
			<div class = "email">	info@kuhnirimma.ru	<i class="fa fa-envelope-o" aria-hidden="true"></i></div>	
			</a>
		</div>
	</div>
			
	</div>
	
	<?
}





/* Функция вывода инфрмации в footer */
add_action('hook_footer_info','footer_site_info');
function footer_site_info(){
	
	?>
	<a class="modal-okno pum-trigger"> 
		<i class="fa fa-comments-o" aria-hidden="true"></i> 
		Остались вопросы? – Звоните/пишите. Искренне и оперативно ответим Вам
	</a><br>
	<a href="http://kuhnirimma.ru/politika-konfidencialnosti/">
	
	<i class="fa fa-info-circle" aria-hidden="true"></i>
	Политика конфиденциальности
	</a>
		
	<!--
	<i class="fa fa-envelope-o" aria-hidden="true"></i> info@yandex.ru<br>
	<i class="fa fa-calendar-check-o" aria-hidden="true"></i> Работаем без выходных
	-->
	
	<?
	
}




// isotope_menu для кухонных модулей //

function isotope_menu_kuxonnye_moduli(){	

	/*Получим название родительской  категории */
	global $post;
	$terms = wp_get_object_terms(
			$post->ID, 
			'product_cat', 
			array('orderby' => 'term_id', 'order' => 'ASC') ); 	
	$this_cat = $terms[0]->slug;
	
	
	/* Если товар относится к категории fasady выводим этот блок */
	if($this_cat == 'kuxonnye-moduli'){
	
	
		?>
		
		<div id="filters">						
														
				<button class="button"	data-filter	=	".product_tag-shkaf-verxnij-700">	Шкафы верхние 70см</button>
				<button class="button"	data-filter	=	".product_tag-shkaf-verxnij-900">	Шкафы верхние 90см</button>
				<button class="button"	data-filter	=	".product_tag-shkaf-nizhnij">		Шкафы нижние	</button>	
				<button class="button"	data-filter	=	".product_tag-penal">				Пеналы			</button>
				<button class="button"	data-filter	=	".product_tag-fasad">				Фасады			</button>					
					
					
			</div>
			
		<?
	}						
			
	
}
add_action('woocommerce_archive_description', 'isotope_menu_kuxonnye_moduli');





// isotope_menu для кухонных модулей //

function isotope_menu_stoleshnicy(){	

	/*Получим название родительской  категории */
	global $post;
	$terms = wp_get_object_terms(
			$post->ID, 
			'product_cat', 
			array('orderby' => 'term_id', 'order' => 'ASC') ); 	
	$this_cat = $terms[0]->slug;
	
	
	/* Если товар относится к категории fasady выводим этот блок */
	if($this_cat == 'stoleshnicy'){
	
	
		?>
		<div style="text-align: center;"> Подбор столешницы по <b>ширине</b>: </div>
		<div id="filters">						
														
				<button class="button"	data-filter	=	".product_tag-shirina_200">			200см</button>
				<button class="button"	data-filter	=	".product_tag-shirina_300">			300см</button>
				<button class="button"	data-filter	=	".product_tag-shirina_400">			400см</button>
				<button class="button"	data-filter	=	".product_tag-shirina_450">			450см</button>
				<button class="button"	data-filter	=	".product_tag-shirina_500">			500см</button>
				<button class="button"	data-filter	=	".product_tag-shirina_600">			600см</button>
				<button class="button"	data-filter	=	".product_tag-shirina_800">			800см</button>
				<button class="button"	data-filter	=	".product_tag-shirina_1000">		1000см</button>
				<button class="button"	data-filter	=	".product_tag-shirina_1050">		1050см</button>
				<button class="button"	data-filter	=	".product_tag-shirina_3000">		3000см</button>
				<button class="button"	data-filter	=	".product_tag-shirina_4100">		4100см</button>
				<button class="button"	data-filter	=	".product_tag-shirina_850">			850см x 850см</button>
				<button class="button"	data-filter	=	"*">								все варианты</button>
				
				
					
					
			</div>
		<?
	}						
			
	
}
add_action('woocommerce_archive_description', 'isotope_menu_stoleshnicy');






/* Не работает как нужно */
function price_complect_modules(){
	
	global	$Top_modules;
	global	$Bott_modules;

		
	/* Получаем terms продукта в отсортированном виде */
	global $post;
	$terms = wp_get_object_terms(
			$post->ID, 
			'product_cat', 
			array('orderby' => 'term_id', 'order' => 'ASC') ); 
	
	
	
	
	$this_cat = $terms[1]->name;	
	/* Делаем первую букву заглавной */
	$this_cat = ucfirst_utf8($this_cat);
		
	
	/*	Соединяем два массива в один общий	*/
	$all_modules = array_merge($Top_modules,$Bott_modules);
	//print_arr($all_modules, 'Объединенный массив');	
		
		
	/* Добавляем название категории */
	foreach($all_modules as $key => $value){			
		$New_all_modules[$key.'-'.$this_cat] = $value;		
		}	
	//print_arr($New_all_modules, 'New_all_modules');
	
	
	/* Складываем значения колличества модулей */
	$Vsego_moduley =  array_sum($New_all_modules);

	//print_arr($Vsego_moduley, 'сумма всех подулей');
	
	/*	Формируем массив _SKU товаров	*/
	$Massiv_sku = array_keys($New_all_modules);
	//print_arr($Massiv_sku, "_SKU");
	
		
	/* Переводим массив _SKU в массив ID */
	foreach ($Massiv_sku as $item){
		$Massiv_id[] = wc_get_product_id_by_sku($item);
		}
		
	//print_arr($Massiv_id, "массив ID");
	
		/* Если массив id пустой то прекращаем выполнение функции */
		if(empty($Massiv_id)){ return; }
	
	/*Делаем запрос выборку из базы*/
	$wpb_all_query = new WP_Query(array(
								'post_type'=>'product',    	//Тип поста
								'posts_per_page'=>30,     	//Сколько постов выводить на странице								
								'post__in'=> $Massiv_id,	//Берём товары из массива ID
								
								)							
								); 
			
			
		/* Лезем в массив $posts и в цикле достаём оттуда данные по каждому продукту */
		$posts = $wpb_all_query->posts;	

			
		foreach($posts as $prod){
							
			$id = $prod->ID;				/*Получаем ID продукта*/					
			$Meta = get_post_meta($id);		/*По id лезем в массив мета данных продукта*/	
			$Sku = $Meta[_sku][0];			/*Достаём оттуда значение SKU*/
			
			
			/* Цены модулей входящих в состав кухни */
			$Prices[$Sku] = $Meta[_regular_price][0];						
			
			$my_titles[$Sku] = $prod->post_title; /* Формируем именованный массив SKU => Title */
			}
								
			
		//print_arr($my_titles);
		//print_arr($New_all_modules);
		
			
	/* ФОРМИРУЕМ на основе двух массивов , новый массив TITLE => КОЛЛИЧЕСТВО ШТУК */	
	foreach ($my_titles as $key => $value){		
			//te($value);	
			$Title_colichestvo[$value] = $New_all_modules[$key];		
		}
	
	
	
	//print_arr($my_titles);	
	//print_arr($New_all_modules);	
	//print_arr($Prices);
	
	
	
	/* ФОРМИРУЕМ на основе двух массивов , новый массив Price => КОЛЛИЧЕСТВО ШТУК */	
	foreach ($Prices as $key => $value){				
			//te($key);	
			//te($value);	
			$Prices_colichestvo[$value] = $New_all_modules[$key];		
		}	
	//print_arr($Prices_colichestvo);
	
	/* Получаем массив где у элементов цена перемножена на колличество */
	foreach($Prices_colichestvo as $key => $value){		
		$Array_price[] = $key*$value;		
	}
	
	/* Сумируем все элементы */
	$Array_price = array_sum($Array_price);
	
	
	te($Array_price);	

	
}
//add_action( 'woocommerce_single_product_summary', 'price_complect_modules', 45 );

/*===END===*/