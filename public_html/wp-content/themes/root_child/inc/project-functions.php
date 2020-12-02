<?

	
function image_loaded(){
	
	?>
	<style>
	.carousel {background: #EEE;}

		.carousel img {display: block; height: 400px;}
	</style>
	
	<h1>Flickity - imagesLoaded</h1>
	<!-- Flickity HTML init -->
	<div class="carousel"
		data-flickity='{ "imagesLoaded": true }'>
		<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/orange-tree.jpg" alt="orange tree" />
		<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/submerged.jpg" alt="submerged" />
		<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/look-out.jpg" alt="look-out" />
		<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/one-world-trade.jpg" alt="One World Trade" />
		<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/drizzle.jpg" alt="drizzle" />
		<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/cat-nose.jpg" alt="cat nose" />
	</div>
	<?
	
}
	






function big_slider_image_with_brand_block(){ global $post;
			
			
		$data = carbon_get_the_post_meta('carbon_slider');		
		$site_title_text 	= get_bloginfo( 'name' );
		$description 		= get_bloginfo( 'description', 'display' );
		
	
	
		if($data && $post->post_name =='video'){
		foreach($data as $item){		
			$result[] = array(			
				'title'		=> 	$item['title'],
				'subtitle'	=> 	$item['subtitle'],					
				'img'		=>	wp_get_attachment_image_src($item['img'], 'full')[0],
				);		
			}	
		
			
		//print_arr($result, 'result');				
	?>
	
	
	
	
	<header id="masthead" class="site-header on-slider" itemscope itemtype="https://schema.org/WPHeader">	
				
	<div class="site-header-inner container">
			
		<div class="site-branding">
			<a href = "<?=get_site_url();?>">
				<div class="site-branding-container">		              								
					<div class="site-title">		<?= $site_title_text?> </div>			
					<p class="site-description">	<?= $description	?>	</p>				
				</div>
			</a>			
		</div>
		
		<?php do_action('site-header-inner');?>	

		
			
		<!-- Top Menu -->
		<div class="top-menu">
			<?php	if (has_nav_menu('top_menu')){				
			 wp_nav_menu( array('theme_location' => 'top_menu', 'menu_id' => 'top_menu') );
			}
			?>
		</div>

		<!--Mob hamburger-->
        <div class="mob-hamburger"><span></span></div>
	
	</div><!--end site-header-inner-->	
						
</header><!-- #masthead -->

		
		
	
	<div class = "carousel carousel-image carousel-with-header">
			
		<?	foreach($result as $item){?>
						
			<div class="carousel-cell">
				<img class="carousel-cell-image" data-flickity-lazyload="<?=$item['img']?>"/>
				
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
} 










