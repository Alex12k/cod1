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
 * Template part for displaying page content in page.php.
 *
 * @package Root
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php do_action( 'root_page_before_title' ); ?>
		<?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
		<?php do_action( 'root_page_after_title' ); ?>
	</header><!-- .entry-header -->

	<div class="page-separator"></div>

	<div class="entry-content" itemprop="articleBody">
		<?php
			do_action( 'root_page_before_the_content' );
			the_content();
			do_action( 'root_page_after_the_content' );

			wp_link_pages( array(
				'before'        => '<div class="page-links">' . esc_html__( 'Pages:', 'root' ),
				'after'         => '</div>',
				'link_before'   => '<span class="page-links__item">',
				'link_after'    => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>"/>
<meta itemprop="dateModified" content="<?php the_modified_time('Y-m-d')?>"/>
<meta itemprop="datePublished" content="<?php the_time('c') ?>"/>
<meta itemprop="author" content="<?php the_author() ?>"/>


<?php //get_template_part( 'template-parts/subscribe', 'box' ) ?>
<?php do_action( 'root_page_before_related' ); ?>
<?php get_template_part( 'template-parts/related', 'posts-page' ) ?>
<?php do_action( 'root_page_after_related' ); ?>
