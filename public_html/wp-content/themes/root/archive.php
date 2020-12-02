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

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb('<div class="breadcrumb" id="breadcrumbs">','</div>');
			} ?>

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
                    <?php do_action( 'root_archive_before_title' ); ?>
					<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
                    <?php do_action( 'root_archive_after_title' ); ?>
					
					<?php if ( 'top' == root_get_option( 'structure_archive_description' ) && ! is_paged() ) the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
				</header><!-- .page-header -->

                <?php do_action( 'root_archive_before_posts' ); ?>
				<?php get_template_part('template-parts/layout/archive', root_get_option( 'structure_archive_posts' )); ?>
                <?php do_action( 'root_archive_after_posts' ); ?>

				<?php the_posts_pagination(); ?>
				
				<?php if ( 'bottom' == root_get_option( 'structure_archive_description' ) && ! is_paged() ) the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
				
			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

if ( root_get_option( 'structure_archive_sidebar' ) != 'none' ) get_sidebar();

get_footer();
