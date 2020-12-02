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

$tag                = root_get_option( 'structure_posts_tag' );
$is_show_excerpt    = 'yes' == root_get_option( 'structure_posts_excerpt' );
$root_skin          = root_get_option( 'skin' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-box'); ?> itemscope itemtype="http://schema.org/BlogPosting">
	<header class="entry-header">
		<?php the_title( '<'.$tag.' class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url"><span itemprop="headline">', '</span></a></'.$tag.'>' ) ?>

        <?php if ( $root_skin != 'skin-1' && $root_skin != 'skin-2' ) get_template_part( 'template-parts/posts/content', 'meta' ); ?>
	</header><!-- .entry-header -->

    <?php $thumb = get_the_post_thumbnail($post->ID, 'thumb-big', array('itemprop'=>'image')); if (!empty($thumb)): ?>
        <div class="entry-image">
            <a href="<?php the_permalink() ?>"><?php echo $thumb ?></a>
        </div>
    <?php endif ?>

    <?php if ( $root_skin == 'skin-1' || $root_skin == 'skin-2' ) get_template_part( 'template-parts/posts/content', 'meta' ); ?>

    <?php if ( $is_show_excerpt ) { ?>
        <div class="post-box__content" itemprop="articleBody">
            <?php the_excerpt(); ?>
        </div><!-- .entry-content -->

        <footer class="post-box__footer">
            <a href="<?php the_permalink() ?>" class="
			__more"><?php _e( 'Read more', 'root' ) ?></a>
        </footer><!-- .entry-footer -->
    <?php } ?>
	<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>"/>
	<meta itemprop="dateModified" content="<?php the_modified_time('Y-m-d')?>"/>

</article><!-- #post-## -->
