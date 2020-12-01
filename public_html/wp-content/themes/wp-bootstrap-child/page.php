<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WP_Bootstrap_4
 */


get_header(); ?>

<!----НАЧАЛО----->

<?php

$type = 'tweek';
//$type = 'orign';



if($type == 'orign'){
//ORIGINAL
	$container = 'container';
	$row = 'row';
	$primary = 'col-md-8';
	$sidebar = 'col-md-4';
	
	
}
 
if($type == 'tweek'){
// BS TWEEK
	$container = 'container-fluid right-content-box p-0';
	$row = 'd-flex';
	$primary = 'w-100 p-0';
	$sidebar = 'p-0';
	
}




		
?>


<?php
	$default_sidebar_position = get_theme_mod( 'default_sidebar_position', 'right' );	
	if($default_sidebar_position === 'left'){$sidebar_position = 'order-md-first';}
	if( $default_sidebar_position === 'no'){$primary = 'col-md-12 p-0';}
?>

	<div class="<?=$container?>">	
		<div class="<?=$row?>">
		
				<!-- Primary container -->
				<div class="<?=$primary?> wp-bp-content-width">

						<div id="primary" class="content-area">
							<main id="main" class="site-main">											
								
								
											
				<?				
				//echo new Bs_slider_lazay('carousel_id_111', true, true);			
				//echo new Jumbotron;			
				?>
																								
						<?php
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>
																				
							</main><!-- #main -->
						</div><!-- #primary -->
						
				</div>
				<!-- END Primary container -->

			
				<!--Siderbar container-->
				
				<?php if( $default_sidebar_position != 'no'){?>
				<div class="<?=$sidebar.' '.$sidebar_position?> wp-bp-sidebar-width">
					<?php get_sidebar(); ?>		
				</div>
				<?}?>
				
			<!-- END Siderbar container-->
					
		</div><!-- /.row -->		
	</div><!-- /.container --><?
	
	

	
	get_footer();
	
	
