<?
/*--------------------------*/
/* Полноэкранный слайдер image */
/*--------------------------*/
function big_slider_image(){		
		
		/* deps bank: func_big_slider_image.css*/
		
		
		$data = carbon_get_the_post_meta('carbon_slider');
		//print_arr($data);
	
		if($data){
		foreach($data as $item){		
			$result[] = array(			
				'title'		=> 	$item['title'],
				'subtitle'	=> 	$item['subtitle'],					
				'img'		=>	wp_get_attachment_image_src($item['img'], 'full')[0],
				);		
			}			
		//print_arr($result, 'result');				
	?>
	

	<div class = "carousel carousel-image"><? 
						 
		foreach($result as $item){?>
						
				<div class="carousel-cell">
							
					<div class="image_wrap">
						<img class="carousel-cell-image" 
						data-flickity-lazyload="<?=$item['img']?>" />
					</div>
						
						
						<div class = "big-slider-banner">						
							<div class = "banner-content">
							
								<h2><?=$item['title']?></h2>
								<p class = "subtitle"><?=$item['subtitle']?></p>
							
							</div>
						</div>
						
				</div>
					
	<?}//end foreach?>
	</div>
	
<?}//end if data
} //end function
/*--------------------------------*/
/* -------------END --------------*/
/*--------------------------------*/





/*--------------------------------*/
/* Полноэкранный слайдер background  */
/*--------------------------------*/
function big_slider_background(){

		/* deps bank: func_big_slider_background.css */

		 $is_mobile = check_mobile_device();
		if($is_mobile){
			$img_size = 'large';}else{
			$img_size = 'full';
		}
	
		$data = carbon_get_the_post_meta('carbon_slider');
	
		if($data){
		foreach($data as $item){		
			$result[] = array(			
				'title'		=> 	$item['title'],
				'subtitle'	=> 	$item['subtitle'],					
				'img'		=>	wp_get_attachment_image_src($item['img'], $img_size)[0],
				);		
			}		
			//print_arr($result, 'result');				
			?>

		<div class="carousel v3">
			<?foreach($result as $item){?>
		
				<div class="carousel-cell-v3" 
						data-flickity-bg-lazyload="<?=$item['img']?>">
																
					<div class = "banner-content-v3 flickity-tweek">
							
						<h2><?=$item['title']?></h2>
						<p class = "subtitle"><?=$item['subtitle']?></p>
							
					</div>
									
				</div>		
			<?}?>
		
		</div>
	<?	
		}//end if
	}//end function

/*--------------------------------*/
/* -------------END --------------*/
/*--------------------------------*/






function vidio_slaider_home(){ 
$vidio = array(
		
		//''						=>	'H81hQ9ffWBo',
		''						=>	'6YbZoVrjoDE',
);

  
    ?><div class="carousel carousel-youtube"><?
	

		foreach($vidio as $key=>$id){?>
						
			<div class="slide" style="margin: 3px;">	
				<div class="youtube" id="<?=$id?>"></div>
			    <div class="text"><?=$key?></div>			
			</div>
	
		<?}//end foreach
	?></div><?
	

}//end vidio_slaider


/*-------------------------------*/
/*		END VIDEO  SLIDER       */
/*----------------------------- */





/*---------------------------------*/
/*			ABOUT SCROLL			*/
/*--------------------------------*/
function modul_about_scroll(){
 	
	/* Получение данные */
	$content = array(
		'quote'	=> carbon_get_the_post_meta('quote'),
		'author'=> carbon_get_the_post_meta('author'),
		'offer'	=> carbon_get_the_post_meta('offer'),
	);

if($content['quote']){?>	
	
	
	<div class="scroll-total-container">
		
		<div class="tonirovka">
			
			<div class="total-wrap">
			
			<div class="total-wrap-2">
					
					<div class = "quote-box">
						
						<div class = "text"><?=$content['quote']; ?>	</div>		
						<div class="ps"><?=$content['author']?>			</div>
						
					</div>
					
					<h2> <?=$content['offer']?>						</h2>

				<div class = "total-btn">
					<!--<a class="button btn-white-on-black" href="#">Подробнее</a>-->			
					<? modal_window(get_stylesheet_directory().'/inc/modal_templates/reg_olnine.php', 'Запись online', 'registration_online');?>
					<? //modal_window(get_stylesheet_directory().'/inc/modal_templates/call_back_me.php', 'Перезвоните мне', 'call-back'); ?>
				</div>	
				
		  </div>
		  
			</div>
			
		</div>
	</div>
<?}}//end function
/*--------------------------------*/
/* -------------END --------------*/
/*--------------------------------*/




function column_block(){?>
	
	<div class="first-container entry-content">
									
						
			<div class="container-element">
				<h3 class="column-title" style="color: #bc955a;">
					CADILLAC
					<img src="/wp-content/uploads/2020/04/IMG_5525.jpg"></img>
				</h3>
			
			<p class="subtitle">			
				
			<ul>
				
				<li>
					Уникальный тренажер, позволяющий формировать 
					различные программы для восстановления позвоночника
					(при грыжах, протрузиях, сколиозе и др. проблемах)
				</li>
			
				<li>
					Высокие горизонтальные перекладины, образующие брусья, дают возможность выполнять
					упражнения в висах, которые укрепляют грудную клетку и дыхательную мускулатуру, а
					также улучшают экскурсию диафрагмы <br> 
					(незаменимы в программах для астматиков) 
				</li>
				
				<li>
					Пружинные механизмы позволяют варьировать нагрузку
				</li>
			</ul>		
			</p>	  
			
			</div>	
				
						
			<div class="container-element">
			
			<h3 class="column-title" style="color: #bc955a;">
				Allegro tower of Power System
			<img src="https://New_theme.ru/wp-content/uploads/2020/04/IMG_6096.jpg"></img>
			</h3>
			
			<p class="subtitle">	
				
				<ul>
					
					<li>
					Один из самых функциональных тренажеров для занятий Пилатес,
					позволяет выполнять более 500 различных упражнений
					</li>
				
					<li>
					Подвижная платформа способствует развитию баланса и усиливает мышечно-связочную
					систему позвоночника
					</li>
				
					<li>
					Пружинные механизмы позволяют варьировать нагрузку и осуществлять
					"тонкие настройки" в соответсвии с индивидуальными особенностями занимающегося
					</li>		
				</ul>
			</p>		
			</div>	
			

			<p>
			Стройная фигура — это лишь одно из преимуществ, 
				которое дадут Вам занятия Пилатес на реформерах, 
				и оно далеко не на первом месте!<br> 
				Результатом занятий будет здоровый позвоночник, правильная осанка 
				и высокое качество жизни!
			</p>		
						

	</div>
	
	
<?	
}
/*--------------------------------*/
/* -------------END --------------*/
/*--------------------------------*/




function mobile_social_block(){?>

	<div class = "header-info">
			<? $Icons = abs2url(get_dirs(get_stylesheet_directory() . '/img/social_icons', '.png')); 
				
			?>				
			<div id="header-phone" class="phone"></div> 					
				<script>
					if( /Android|webOS|xiaomi|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
					document.getElementById("header-phone").innerHTML = '<span><a href="tel:+74994440578 ">+7 (499) 444-05-78</a></span>';
					}else{
					document.getElementById("header-phone").innerHTML = '<span>+7(499)444-05-78</span> ';
						}
				</script>								
				<?
			?><div class="icons"><?
				foreach($Icons as $icon){?><img src="<?=$icon?>"></img><?}?>
			</div>
				
				
		
		
		</div>	
<?
};
/*--------------------------------*/
/* -------------END --------------*/
/*--------------------------------*/





function mobile_icons_and_telephone(){
	?>	
		<div id="header-phone" class="phone"></div>
		<script>
			if( /Android|webOS|iPhone|xiaomi|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
				document.getElementById("header-phone").innerHTML = '<div class="icons-container"><i class="fa fa-facebook-official" aria-hidden="true"></i><i class="fa fa-instagram" aria-hidden="true"></i><i class="fa fa-youtube-square" aria-hidden="true"></i><a href="tel:+74994440578"><i class="fa fa-phone" aria-hidden="true"></i></a></i></div>';
				}else{
				document.getElementById("header-phone").innerHTML = '<span>+7(499)444-05-78</span><div class="icons-container"><i class="fa fa-facebook-official" aria-hidden="true"></i><i class="fa fa-instagram" aria-hidden="true"></i>	<i class="fa fa-youtube-square" aria-hidden="true"></i></div>';
						}
		</script>
	<?
	
}
/*--------------------------------*/
/* -------------END --------------*/
/*--------------------------------*/






	
	
function mobile_icons_and_telephone_v2($page_type){
	
	$is_mobile = check_mobile_device();
	
	/* Выбор типа иконок */	
	if($page_type=='page_with_slider')	{$slider = true; }
	if($page_type=='page_no_slider')	{$slider = false;}

	if(!$slider){$type = 'gold_white';}
	if($slider)	{$type = 'gold_black';}

		
	if(check_mobile_device()){
		$whatsapp='https://api.whatsapp.com/send?phone=79629102885';}
		else{
		$whatsapp='https://web.whatsapp.com/send?phone=79629102885&text=&source=&data=';}


	$icons_url = array(
		'facebook'	=>	'https://www.facebook.com/New_theme.ru',
		'instagram'	=>	'https://www.instagram.com/New_theme.ru',
		'whatsapp'	=>	$whatsapp,		
		'youtube'	=>	'https://www.youtube.com/channel/UCRT7rk65SPuand5HJlU-eKQ',
	);


	
	/* Получение нужного комплекта иконок */	
	$icons = abs2url(get_dirs(get_stylesheet_directory()."/img/social_icons/$type", ".png"));	
			
	foreach($icons as $handle => $src){													
			/*	2. Если в src будет найден "none-", то удалим его из массива */											
			if(strpos($src, 'none-')){unset($icons[$handle]);} //end if
	}//end foreach
	
	?>	
		<div id="header-phone" class="phone">
			
			
			
			<!--<div class="phone-mobile"></div>-->
			<!--
			<div class="icons-container">
				<i class="fa fa-facebook-official" aria-hidden="true">	</i>
				<i class="fa fa-instagram" aria-hidden="true">			</i>
				<i class="fa fa-youtube-square" aria-hidden="true">		</i>
				<a class="phone-mobile" href="tel:+74994440578"><i class="fa fa-phone" aria-hidden="true"></i></a>
			</div>		
			-->
			
			<?//if($page_type=='page_no_slider'){?>
				<div class="phone-pc">+7 (499) 444-05-78</div>
			<?//}?>
		
			<div class="icons-container">
			
			
				<? foreach($icons as $name => $scr){					
					$handle = get_handle($name);
					//te($handle);
					
					?><a href="<?=$icons_url[$handle]?>" target="_blank">
							<img src = "<?=$scr?>">
					</a>		
					<?					
					
				}?>
				
				<a class="phone-mobile" href="tel:+74994440578"><i class="fa fa-phone" aria-hidden="true"></i></a>
						
			</div>	
			
		<?//if($page_type=='page_with_slider'){?>
			<div class="header-phone-icon">
				
				<img src="<?=get_stylesheet_directory_uri().'/img/phone.png'?>">
			
			
			
		
			</div>		
		</div>
		<?//}?>

		
		<!--<script>
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
				document.getElementById("header-phone").innerHTML = '';
				}else{
				document.getElementById("header-phone").innerHTML = '<span>+7(499)444-05-78</span><div class="icons-container"><i class="fa fa-facebook-official" aria-hidden="true"></i><i class="fa fa-instagram" aria-hidden="true"></i>	<i class="fa fa-youtube-square" aria-hidden="true"></i></div>';
						}
		</script>
		-->
	<?
	
}
/*--------------------------------*/
/* -------------END --------------*/
/*--------------------------------*/



/* Функция вызова модального окна с обратным звонком */
function call_back_me(){	
	modal_window(get_stylesheet_directory().'/inc/modal_templates/call_back_me.php', 'Перезвоните мне', 'call-back');
	?>
	
<?
}



/* Функция вызова значка с набором номера тел для моб версий*/
function mobile_dial(){?>
			
	<div id="button-container" class="dial">
		<a class="dial" href="tel:+74994440578">+7(499)444-05-78</a>	
	</div>
	

	
<?	
}








function nav_video_slider($var){

	if($var=='reemala'){

		$video = array(	
			'Hh5jd9V7xSE',
			'hw8Gk3w6xyg',
			'6YbZoVrjoDE',
			'F26RNWSlLfA',		
			'wkF0W2LwGAY',
		);
	}


	if($var=='New_theme'){
		$video = array(	
			'B85JRdMkxWY',
			'fFinlH5ckn0',	
			'PP0Ge7vRNxs',
			'qw0eTwmKcJU',
			'8fksVfDE3k4'		
		);
	}
	
	
	
	?>
	<div class = "nav-slider-container">
				
		<div class = "carousel carousel-nav-video" data-flickity='{			
				"asNavFor": ".main_<?=$var?>",
				"contain": true,
				wrapAround: true,
				"pageDots": false,
				"prevNextButtons": false			
			}'>
		
			<?php foreach($video as $id){?>										
				<div class="poster" id="<?=$id?>"></div>				
			<?}//end foreach?>	
	</div>	
	
		
	
    <div class="carousel carousel-main-video <?='main_'.$var?>" 	
		data-flickity='{ 
				"pageDots": false,
				"imagesLoaded": true,
				"prevNextButtons": true		
		}'>
	
	<?foreach($video as $id){?>				
			<div class="slide" style="margin: 3px;">	
				<div class="youtube" id="<?=$id?>"></div>
			    <div class="text"><?=$key?></div>			
			</div>
	
		<?}//end foreach
	?>
		</div>
	</div>
	



<?}
/*--------------------------------*/
/* -------------END --------------*/
/*--------------------------------*/



function single_video(){
	global $post;
	
	if($post->post_name =='pilates-na-reformerax'){?>	
	<h2 class="small">УЗНАЙТЕ, КАК МЫ ТРЕНИРУЕМ, ЗА 60 СЕКУНД</h2>	
	
	<div class ="box single_video_container">
		<div class="poster"></div>		
		<div class="youtube" id="Hh5jd9V7xSE"></div>			 			
	</div>
	<?	
	
	}//end if
	
	if($post->post_name =='glavnaya' ){?>
	<div class ="box single_video_container">
		<div class="poster"></div>		
		<div class="youtube" id="Hh5jd9V7xSE"></div>			 			
	</div>	
	
	<?}	
}



function single_video_v2($id){
	
	/*	DEPS css: 
			youtube.css 
			func_single_video.css		
	*/
	?>
	
	<div class ="single_video_container">
		<div class="poster" id="<?=$id?>"></div>
		<div class="youtube" id="<?=$id?>"></div>			 			
	</div>	

<?}

















/*--------------------------------*/
/* -------------END --------------*/
/*--------------------------------*/





/* Функция видео слайдера с адаптивностью через css переменные и media запросы */
function adaptiv_video_slider($video, $name){


	/* Ширина слайдов определяется через css */
	?>
	
	<div class = "nav-slider-container container_<?=$name?> adaptiv_video_slider ">
				
		<div class = "carousel carousel-nav-video" data-flickity='{			
				"asNavFor": ".main_<?=$name?>",
				"imagesLoaded": true,
				"contain": true,
				"wrapAround": true,
				"pageDots": false,
				"prevNextButtons": true,
				"groupCells": 2,
				"autoPlay": 2750,
				"pauseAutoPlayOnHover": false,
				"selectedAttraction": 0.005,
				"friction": 0.128				
			}'>
		
			<?php foreach($video as $id){?>										
				<div class="poster" id="<?=$id?>"></div>				
			<?}//end foreach?>	
		</div>	
	
		
	
		<div class="carousel carousel-main-video <?='main_'.$name?>" 	
			data-flickity='{
				"imagesLoaded": true,
				"contain": true,
				"wrapAround": true,
				"pageDots": false,
				"imagesLoaded": true,
				"prevNextButtons": false		
			}'>
	

		
		<?foreach($video as $id){?>
		
				<div class="slide" style="margin: 3px;">	
					<div class="youtube" id="<?=$id?>"></div>
							
				</div>
	
			<?}//end foreach
		?>
		</div>
	</div>
	
<?}
/*--------------------------------*/
/* -------------END --------------*/
/*--------------------------------*/




/* Функция видео слайдера с адаптивностью через css переменные и media запросы */
function adaptiv_video_slider_single_mod($video, $name){


	/* Ширина слайдов определяется через css */
	?>
	
	<div class = "nav-slider-container container_<?=$name?> adaptiv_video_slider ">
				
		

			
		<?foreach($video as $id){?>
		
				
				<div class="slide" style="margin: 3px;">	
					<div class="poster" id="<?=$id?>"></div>
					<div class="youtube" id="<?=$id?>"></div>
							
				</div>
	
			<?}//end foreach
		?>
	
	</div>
	
<?}
/*--------------------------------*/
/* -------------END --------------*/
/*--------------------------------*/












