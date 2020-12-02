<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *
 *   ВНИМАНИЕ!!!!!!!
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   ПРИ ОБНОВЛЕНИИ ТЕМЫ - ВЫ ПОТЕРЯЕТЕ ВСЕ ВАШИ ИЗМЕНЕНИЯ
 *   ИСПОЛЬЗУЙТЕ ДОЧЕРНЮЮ ТЕМУ ИЛИ НАСТРОЙКИ ТЕМЫ В АДМИНКЕ
 *
 *   ПОДБРОБНЕЕ:
 *   https://docs.wpshop.ru/child-themes/
 *
 * *****************************************************************************
 *
 * @package Root
 */
	
get_header('clean');



$is_show_thumb = ( 'yes' == root_get_option( 'structure_single_thumb' ) ? true : false );
?>

<?php while ( have_posts() ) : the_post(); ?>

<div itemscope itemtype="https://schema.org/Article">

    <?php
        $big_thumbnail_image = false;

        if ( 'checked' == get_post_meta( $post->ID, 'big_thumbnail_image', true ) ) {
            $big_thumbnail_image = true;
        }
    ?>

    <?php if ( $big_thumbnail_image ): ?>

        <?php $thumb = get_the_post_thumbnail( $post->ID, 'full', array('itemprop'=>'image') ); if (!empty($thumb) && $is_show_thumb): ?>
            <div class="entry-image entry-image--big">
                <?php echo $thumb ?>

                <div class="entry-image__title">
                    <?php if ( function_exists('yoast_breadcrumb') ) {
                        yoast_breadcrumb('<div class="breadcrumb" id="breadcrumbs">','</div>');
                    } ?>

                    <?php do_action( 'root_single_before_title' ); ?>
                    <h1 itemprop="headline"><?php the_title() ?></h1>
                    <?php do_action( 'root_single_after_title' ); ?>

                    <?php if ( 'post' === get_post_type() ) : ?>
                        <div class="entry-meta">
                            <?php get_template_part( 'template-parts/post', 'meta' ) ?>
                        </div><!-- .entry-meta -->
                    <?php endif; ?>
                </div>
            </div>
        <?php else : ?>
            <div class="entry-image entry-image--big entry-image--no-thumb">

                <div class="entry-image__title">
                    <?php if ( function_exists('yoast_breadcrumb') ) {
                        yoast_breadcrumb('<div class="breadcrumb" id="breadcrumbs">','</div>');
                    } ?>

                    <?php do_action( 'root_single_before_title' ); ?>
                    <h1 itemprop="headline"><?php the_title() ?></h1>
                    <?php do_action( 'root_single_after_title' ); ?>

                    <?php if ( 'post' === get_post_type() ) : ?>
                        <div class="entry-meta">
                            <?php get_template_part( 'template-parts/post', 'meta' ) ?>
                        </div><!-- .entry-meta -->
                    <?php endif; ?>
                </div>
            </div>
        <?php endif;?>

    <?php endif;?>
	
	
	
	
	
	<div class = "top_action"><?
		$position = 'top_slider';
		do_action('post_before_content', $position);
	?></div>
	
	
	<? 
	
	
	/* Получение ID поста */
	//echo $post->ID; 
	?>
	
	<? 
	//Тест
	//echo get_post_meta($post->ID, 'meta1_textfield', true); 
	
	

	?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php if ( function_exists('yoast_breadcrumb') && ! $big_thumbnail_image ) {
				yoast_breadcrumb('<div class="breadcrumb" id="breadcrumbs">','</div>');
			} ?>

			<?php

				get_template_part( 'template-parts/content', 'single' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( root_get_option( 'structure_single_comments' ) == 'yes' ) {
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				}

			/* Временная вставка */
			if($post->post_name =='pilates-na-reformerax'){
			column_block();	
			}
			/* end */
			?>			
		</main><!-- #main -->
	</div><!-- #primary -->
	
	


	<div class = "bottom_action"><? 		
	//print_arr($items_array);
		/* Хук принимающий параметр метаполей видео для нижней части страницы */
		$position = 'bottom_slider';
		do_action('post_after_content', $position);
	?></div>



</div><!-- micro -->

<?php endwhile; ?>

<?php
if ( root_get_option( 'structure_single_sidebar' ) != 'none' && 'checked' != get_post_meta( $post->ID, 'sidebar_hide', true ) ) {
    get_sidebar();
}

	
		
	
get_footer();
