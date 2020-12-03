<?php

/* Ссылка на источник: https://webformyself.com/kak-podgotovit-wordpress-temu-k-plaginu-woocommerce/ */ 

/* Список возможностей

#1	Включение поддержки WooCommerce
#2	Отключение всех стилей WooCommerce
#3	Отключение отдельных стилей WooCommerce
#4	Включение в WooCommerce галереи товаров, Zoom и LightBox (v3.0+)
#5	Удаление Title заголовка магазина и Title название категории
#6	Изменение архивного заголовка магазина
#7	Изменение количества товаров, отображаемых на странице магазина
#8	Изменение количества колонок, отображаемых в магазине
#9	Меняем стрелки постраничной навигации (назад, вперед)
#10 Меняем текст бейджа OnSale
#11	Меняем колонки миниатюр в галерее товаров
#12 Меняем количество сопутствующих товаров
#13 Меняем количество колонок для секций сопутствующих товаров и дополнительных продаж
#14	Добавляем динамическую ссылку на корзину и стоимость корзины в меню
#15 Настройки изображений в WOOCOMMERCE
#16	Добавление выбора колличества товаров с витрины магазина для простых товаров
#17 Функция добавления значка рубля.
#18 Функция замены любых стандартных текстов в woocommerce
#19 Функция отключения лишних полей в оформлении заказа
*20 Функция убирающая графу "подитог" при оформлении заказа. (но убирает не везде)
*21 Функция отключения лишних полей на странице оформления заказа
*22 Функция отключения лишних полей на странице оформления заказа
*/




 


//#1 код вкючает поддержку woocommerce
 add_action( 'after_setup_theme', function() {
 add_theme_support( 'woocommerce' );
} );


//#2 Отключение всех стилей WooCommerce
/* add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' ); */
 
//#3 Код позволяющий отключить отдельные стили WooCommerce 
/*
function wpex_remove_woo_styles( $styles ) {
 unset( $styles['woocommerce-general'] );
 unset( $styles['woocommerce-layout'] );
 unset( $styles['woocommerce-smallscreen'] );
 return $styles;
}
add_filter( 'woocommerce_enqueue_styles', 'wpex_remove_woo_styles' ); 
*/
 

//#4 Включаем в WooCommerce галерею товаров, Zoom и LightBox (v3.0+)
add_theme_support( 'wc-product-gallery-slider' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );


//#5 Удаляем заголовок магазина (слово Магазин в начале страницы магазин, или название Категории в категории)
add_filter( 'woocommerce_show_page_title', '__return_false' );



//#6 Меняем архивный заголовок магазина
/*
function wpex_woo_archive_title( $title ) {
 if ( is_shop() && $shop_id = wc_get_page_id( 'shop' ) ) {
 $title = get_the_title( $shop_id );
 }
 return $title;
}
add_filter( 'get_the_archive_title', 'wpex_woo_archive_title' );
*/



//#7 Меняем количество товаров, отображаемых на странице магазина
function wpex_woo_posts_per_page( $cols ) {

	/* Если мы на категории товара то выводим 80 товаров в пагинации */
	if(is_product_category()){return 86;}
		
	/* В остальных случаях (в том числе на главной) выводим 24 товара в пагинации */
	else {return 24;}
 
}
add_filter( 'loop_shop_per_page', 'wpex_woo_posts_per_page' );


/*Регулировка колличества колонок в магазине и добавление правильного класса */

//#8 Меняем количество колонок, отображаемых в магазине
function wpex_woo_shop_columns( $columns ) {
 return 3;
}
add_filter( 'loop_shop_columns', 'wpex_woo_shop_columns' );

// Add correct body class for shop columns
function wpex_woo_shop_columns_body_class( $classes ) {
 if ( is_shop() || is_product_category() || is_product_tag() ) {
  $classes[] = 'columns-3';
 }
 return $classes;
}
add_filter( 'body_class', 'wpex_woo_shop_columns_body_class' );

/* END */


//#9 Меняем стрелки постраничной навигации (назад, вперед)
function wpex_woo_pagination_args( $args ) {
 $args['prev_text'] = '<i class="fa fa-angle-left"></i>';
 $args['next_text'] = '<i class="fa fa-angle-right"></i>';
 return $args;
}
add_filter( 'woocommerce_pagination_args', 'wpex_woo_pagination_args' );



//#10 Меняем текст бейджа OnSale

function wpex_woo_sale_flash() {
 return '<span class="onsale">' . esc_html__( 'Sale', 'woocommerce' ) . '</span>';
}
add_filter( 'woocommerce_sale_flash', 'wpex_woo_sale_flash' );



//#11 Меняем колонки миниатюр в галерее товаров
function wpex_woo_product_thumbnails_columns() {
 return 5;
}
add_action( 'woocommerce_product_thumbnails_columns', 'wpex_woo_product_thumbnails_columns' );



//#12 Меняем количество сопутствующих товаров
function wpex_woo_related_posts_per_page( $args ) {
 $args['posts_per_page'] = 0;
 return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'wpex_woo_related_posts_per_page' );


/* Start */
//#13 Меняем количество колонок для секций сопутствующих товаров и дополнительных продаж

// Filter up-sells columns
function wpex_woo_single_loops_columns( $columns ) {
 return 4;
}
//add_filter( 'woocommerce_up_sells_columns', 'wpex_woo_single_loops_columns' );

// Filter related args
function wpex_woo_related_columns( $args ) {
 $args['columns'] = 4;
 return $args;
}
//add_filter( 'woocommerce_output_related_products_args', 'wpex_woo_related_columns', 10 );

// Filter body classes to add column class
function wpex_woo_single_loops_columns_body_class( $classes ) {
 if ( is_singular( 'product' ) ) {
  $classes[] = 'columns-4';
 }
 return $classes;
}
//add_filter( 'body_class', 'wpex_woo_single_loops_columns_body_class' );

/* END */



//#14 Добавляем динамическую ссылку на корзину и стоимость корзины в меню
/*
	Код ниже добавит корзину WooCommerce в меню, 
	где отображается цена товаров. Также если у вас есть шрифт Font-Awesome, 
	он отобразит маленькую иконку корзины. Важно: эти функции нельзя заворачивать 
	в условие is_admin(), так как они работают с AJAX для обновления стоимости. 
	Необходимо знать, что функции доступны, когда is_admin() возвращает true и false.
*/


/* Start */
// Add the cart link to menu
function wpex_add_menu_cart_item_to_menus( $items, $args ) {

 // Make sure your change 'wpex_main' to your Menu location !!!!
 if ( $args->theme_location === 'wpex_main' ) {

  $css_class = 'menu-item menu-item-type-cart menu-item-type-woocommerce-cart';
 
  if ( is_cart() ) {
 $css_class .= ' current-menu-item';
  }

  $items .= '<li class="' . esc_attr( $css_class ) . '">';

 $items .= wpex_menu_cart_item();

  $items .= '</li>';

 }

 return $items;

}
add_filter( 'wp_nav_menu_items', 'wpex_add_menu_cart_item_to_menus', 10, 2 );

// Function returns the main menu cart link
function wpex_menu_cart_item() {

 $output = '';

 $cart_count = WC()->cart->cart_contents_count;

 $css_class = 'wpex-menu-cart-total wpex-cart-total-'. intval( $cart_count );

 if ( $cart_count ) {
  $url  = WC()->cart->get_cart_url();
 } else {
  $url  = wc_get_page_permalink( 'shop' );
 }

 $html = $cart_extra = WC()->cart->get_cart_total();
 $html = str_replace( 'amount', '', $html );

 $output .= '<a href="'. esc_url( $url ) .'" class="' . esc_attr( $css_class ) . '">';

  $output .= '<span class="fa fa-shopping-bag"></span>';

  $output .= wp_kses_post( $html );

 $output .= '</a>';

 return $output;
}


// Update cart link with AJAX
function wpex_main_menu_cart_link_fragments( $fragments ) {
 $fragments['.wpex-menu-cart-total'] = wpex_menu_cart_item();
 return $fragments;
}
add_filter( 'add_to_cart_fragments', 'wpex_main_menu_cart_link_fragments' );

/* End */


//#15 Настройки изображений в WOOCOMMERCE
/*	Для изображения товара на странице каталога (архив-витрина)	*/

add_filter('woocommerce_get_image_size_thumbnail','add_thumbnail_size',1,10);
function add_thumbnail_size($size){

    $size['width'] = 300;
    $size['height'] = 300;
    $size['crop']   = 1; //0 - не обрезаем, 1 - обрезка
    return $size;
}

/*	Для крупного изображения на странице товара	*/
//add_filter('woocommerce_get_image_size_single','add_single_size',1,10);
function add_single_size($size){

   // $size['width'] = 1024;
   // $size['height'] = 724;
   $size['width'] = 679.59;
   $size['height'] = 679.59;
    $size['crop']   = 0;
    return $size;
}

/* Для миниатюр в галерее товара */
add_filter('woocommerce_get_image_size_gallery_thumbnail','add_gallery_thumbnail_size',1,10);
function add_gallery_thumbnail_size($size){

    $size['width'] = 160.88;
    $size['height'] = 160.88;
    $size['crop']   = 1;
    return $size;
}

/* End */


/*
*	#16	Добавление выбора колличества товаров с витрины магазина для простых товаров
*
*/
function custom_quantity_field_archive() {
    $product = wc_get_product( get_the_ID() );
    if ( ! $product->is_sold_individually() && 'variable' != $product->product_type && $product->is_purchasable() && $product->is_in_stock() ) {
        woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
    }
}
add_action( 'woocommerce_after_shop_loop_item', 'custom_quantity_field_archive', 12 );


function custom_add_to_cart_quantity_handler() {
    wc_enqueue_js( '

        jQuery( ".product-type-simple" ).on( "click", ".quantity input", function() {
            return false;
        });

        jQuery( ".product-type-simple" ).on( "change input", ".quantity .qty", function() {
            var add_to_cart_button = jQuery( this ).parents( ".product" ).find( ".add_to_cart_button" );
            // For AJAX add-to-cart actions
            add_to_cart_button.data( "quantity", jQuery( this ).val() );
            // For non-AJAX add-to-cart actions
            add_to_cart_button.attr( "href", "?add-to-cart=" + add_to_cart_button.attr( "data-product_id" ) + "&quantity=" + jQuery( this ).val() );
        });

    ' );
}
add_action( 'init', 'custom_add_to_cart_quantity_handler' );

/* END Добавление выбора колличества товаров с витрины магазина для простых товаров */



/*
* #17 Функция добавления значка рубля.
*/

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);
function change_existing_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'RUB': $currency_symbol = 'р.'; break;
     }
     return $currency_symbol;
}




/* #18 Функция убирает двойную цену для вариативных товаров 
*
*/

add_filter('woocommerce_variable_price_html', 'custom_variation_price', 10, 2);
function custom_variation_price( $price, $product ) {
	 					
			$price = '';
			$price .= woocommerce_price($product->get_price());		
			return $price;			
			
}


// Функция исправляет БАГ когда при одинаковых ценах на вариации, не показывается цена вариаций (важно!)
add_filter('woocommerce_available_variation', function ($value, $object = null, $variation = null) {
    if ($value['price_html'] == '') {
        $value['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
    }
    return $value;
}, 10, 3);




/* 	Функции проверок страниц WOOCOMMERCE по материалам с сайта: https://mihalica.ru/uslovnye-tegi-woocommerce	*/

/*	#1	Возвратит true для страниц, которые использует шаблоны woocommerce: 
*		например, оформление заказа или корзина являются стандартными страницами WP, 
*		на которые добавлены шорткоды WOOCOMMERCE и следовательно, не будут включены.
*/
//is_woocommerce(); 


/*	#2	возвратит true, когда просматривается страница архива продуктов (главная страница магазина).	*/
//is_shop();


/*	#3	Возвращает TRUE когда просматривается определенная категория продуктов Woocommerce
*		Например: is_product_category('soft') или несколько категорий is_product_category( array( 'soft', 'games' );
*/
//is_product_category('$cat_name');


/*	#4	Возвращает TRUE если присутсвует определенная метка
*		Например: is_product_tag( 'soft' ) или несколько меток is_product_tag( array( 'soft', 'games' ))
*/
//is_product_tag();


/*	#5	Возвратит true если просматривается страница продукта Single-product	*/
//is_product(); 


/*	#6	Возвратит true если просматривается страница корзины покупателя.	*/
//is_cart();
 
 
/*	#7	Возвратит true если просматривается страница оформления заказа woocommerce*/
//is_checkout();


/*	#8	Возвратит true если просматривается страница учётной записи клиента магазина*/
//is_account_page();



/*
* #18 Функция замены любых стандартных текстов в woocommerce
*/

// замена стандартных текстов WOOCOMMERCE
function rog_shop_strings( $translated_text, $text, $domain ) {
	
	if( 'woocommerce' === $domain ) {
	
		switch ( $translated_text ) {
			case 'Выбрать ...' :
			$translated_text = 'Смотреть кухню';
			break;
		}
		
		switch ( $translated_text ) {
			case 'Распродажа' :
			$translated_text = 'Акция';
			break;
		}
		
		
		switch ( $translated_text ) {
			case 'Ваш заказ' :
			$translated_text = 'Стоимость доставки по Москве до подъезда 1500р, подъём на лифте 500р';
			break;
		}
		
		
			switch ( $translated_text ) {
			case 'правила и условия' :
			$translated_text = 'политика конфиденциальности';
			break;
		}
		
			 
	
	}
	
	
	return $translated_text;	

}
add_filter( 'gettext', 'rog_shop_strings', 20, 3 );






/* 
*	Работа с Tab WOOCOMMERCE
*	https://opttour.ru/web/plugins/tabyi-woocommerce/
*
*/

/*  Отключаем табы на странице товара  */
add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 98);
function sb_woo_remove_reviews_tab($tabs) {
 
  //unset( $tabs['description'] ); // Убираем вкладку "Описание"
  //unset( $tabs['reviews'] ); // Убираем вкладку "Отзывы"
	unset( $tabs['additional_information'] ); // Убираем вкладку "Детали"
 
 
return $tabs;
}
/* END */




/* Перемещаем похожие товары в отдельную вкладку */

// Отключаем хук Похожие товары
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
//Подключаем новый хук Похожие товары
//add_action( 'tab_woocommerce_related_products', 'woocommerce_output_related_products', 20 );


// Создаем новую вкладку и помещаем в нее Похожие товары






// Вкладка Краткое описание
function description_product_tab( $tabs ) {
   
    $custom_tab_s = array( 
      		'custom_tab_s' =>  array( 
    							'title' => __('Комплектация','woocommerce'), 
    							'priority' => 90, 
    							'callback' => 'description_product_content' 
    						)
							
													
							
							
    				);
					
										
    return array_merge( $custom_tab_s, $tabs );
}


function description_product_content() {
   
   ?>
   
        <div class = "complect_tab">


		<h4>В стоимость любого модуля полки входят:</h4>
		<ul>
		<li>Корпус: материал ЛДСП</li>
		<li>Фасад: материал МДФ в пленке ПВХ</li>
		<li>Ручки (как на картинке)</li> 
		<li>Петли</li>
		</ul>

	    <p>
		- Верхние модули высотой<strong> 350 и 450</strong> укомплектованы газовыми лифтами<br> 
		- В модули со стеклами <strong>стекла входят в комплект</strong><br> 
		- В шкафах <strong>3ПНЯ600, ПНЯ400, С2К400, С2К600, С2К800, СН600</strong> используются шариковые направляющие<br>
		- В стоимость любого нижнего модуля входит цоколь,<strong> на каждый шкаф отдельно </strong><br>
		- Мебельные петли для дверей шкафов могут быть установлены <strong>слева или справа, по Вашему желанию</strong><br>
		- <strong>Если Вы выбираете кухню по модулям, уточняйте пожалуйста цвет!<strong>
		</p>

		
		</div>

   <?

} 
// Вкладка Краткое описание END




// Вкладка "Докупается отдельно"

function not_complect_tab( $tabs ) {

$custom_tab = array( 
      		'custom_tab' =>  array( 
    							'title' => __('Докупается отдельно','woocommerce'), 
    							'priority' => 95, 
    							'callback' => 'not_complect_content' 
    						)
    				);
    return array_merge( $custom_tab, $tabs );

}

function not_complect_content() {  
   ?>
        <div class = "complect_tab">

		<h4>Не входит в комплект и докупается отдельно:</h4>
		<ul>	
			<a href = "/product-category/kuxonnye-moduli/stoleshnicy/"><li>Столешницы								</li></a>
			<a href = "/category/stenovye-paneli/"><li>		Стеновые панели 					</li></a>		
			<a href = "/product-category/soputstvuyushhie-tovary/sushki/">	<li>	Сушки  		</li></a> 
			<a href = "/product-category/soputstvuyushhie-tovary/plintusa/"><li>	Плинтуса 	</li></a> 
			<a href = "/product-category/soputstvuyushhie-tovary/mojki/">	<li>	Мойки		</li></a>
			<li>Техника</li>
		</ul>

	    <p>
		Данная кухня является модульной. Если необходим другой набор шкафов Вы всегда сможете самостоятельно<br>
		подобрать необходимые шкафчики - см. блок модули или обратиться к менеджеру магазина.<br>
		Вам всегда помогут.
		</p>

		
		</div>

   <?

} 

// Вкладка "Докупается отдельно" END

/* Запускаем табы */
add_filter( 'woocommerce_product_tabs', 'description_product_tab' );
add_filter( 'woocommerce_product_tabs', 'not_complect_tab' );






/*
*	#19 Функция отключения лишних полей на странице оформления заказа
*/

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {
  //unset($fields['billing']['billing_first_name']);		// имя
  //unset($fields['billing']['billing_last_name']);			// фамилия
  unset($fields['billing']['billing_company']); 			// компания
 
 //unset($fields['billing']['billing_address_1']);			//
  unset($fields['billing']['billing_address_2']);			//
  unset($fields['billing']['billing_city']);				//
  unset($fields['billing']['billing_postcode']);			//
  unset($fields['billing']['billing_country']);			//
  unset($fields['billing']['billing_state']);				//
 
  //unset($fields['billing']['billing_phone']);				//
  //unset($fields['order']['order_comments']);				//
  
  //unset($fields['billing']['billing_email']);				//email
  
  //unset($fields['account']['account_username']);
  //unset($fields['account']['account_password']);
  //unset($fields['account']['account_password-2']);

	/* Делаем email не обязательным полем */
	$fields["billing"]["billing_email"]["required"] = false; // email обязателен
	
	
	/* Меняем label в примечании к заказу "детали" */
	/*$fields['order']['order_comments']['label'] = 'При заказе уакжите цвет выбранных модулей и номер стеновой панели';*/
	/* Меняем текст в placeholder примечание к заказу "детали" */
	
	//по материалам с сайта: https://wpincode.com/kak-izmenit-polya-na-stranice-oformleniya-zakaza-v-woocommerce/
	$fields['order']['order_comments']['placeholder'] = 'При заказе укажите цвет выбранных модулей и номер стеновой панели';
	

	
	
	
	return $fields;
}








/*
*	 #20 убираем подытог везде (Убирает но не везде) На странице оформления товара убираем с помощью CSS
*/

add_filter( 'woocommerce_get_order_item_totals', 'adjust_woocommerce_get_order_item_totals' );

function adjust_woocommerce_get_order_item_totals( $totals ) {
  unset($totals['cart_subtotal']  );
  return $totals;
}





/* end убираем подытог везде */


/*
*	#21 Функция отключения лишних полей на странице оформления заказа
*/

// Автоматическое обновлении корзины, при изменении количества товаров
add_action( 'wp_footer', 'cart_update_qty_script' );

function cart_update_qty_script() {
if (is_cart()) :
?>
<script>
jQuery('div.woocommerce').on('change', '.qty', function(){
jQuery("[name='update_cart']").trigger("click");
});
</script>
<?php
endif;
}




/*#22 ФУНКЦИЯ ОПРЕДЕЛЯЕТ КАКИЕ КАТЕГОРИИ НЕ БУДУТ ВЫВОДИТСЯ НА ГЛАВНОЙ СТРАНИЦЕ МАГАЗИНА */

add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

function custom_pre_get_posts_query( $q )	{
 	
	if (!$q->is_main_query() || !is_shop()) return;
	
	if ( ! is_admin() )	{
	
		$q->set( 
		'tax_query', array(array(
		
		'taxonomy' => 'product_cat', 			//Выбрать название таксономии (категории товаров)
		'field' => 'slug',						//Производить выбор по "id" или "slug" (в нашем случае по slug, - по ярлыку)
		'terms' => array('kuxonnye-moduli', 'soputstvuyushhie-tovary', 'fasady', 'stoleshnicy'),	//Указать slug категории, или категорий через запятую.
		'operator' => 'NOT IN',					//Выводить, всё что не является указанной выше рубрикой всё что не кухонные модули)
		
		)));
		
	} //End if is_admin
} //End function (тут не было кавычки)




/* Функция получает terms продукта в отсортированном виде */
function get_orderby_product_cat(){
	
	global $post;
	$terms = wp_get_object_terms(
			$post->ID, 
			'product_cat', 
			array('orderby' => 'term_id', 'order' => 'ASC') ); 
			
	return $terms; 		
}











/* ===END=== */


















