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
 * Template part for displaying posts.
 *
 * @package Root
 */

$tag                = root_get_option( 'structure_posts_tag' );

$is_show_category   = 'yes' == root_get_option( 'structure_posts_category' );
$is_show_excerpt    = 'yes' == root_get_option( 'structure_posts_excerpt' );
$is_show_comments   = 'yes' == root_get_option( 'structure_posts_comments' );
$is_show_views      = 'yes' == root_get_option( 'structure_posts_views' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-card-one'); ?> itemscope itemtype="http://schema.org/BlogPosting">

    <div class="post-card-one__image">
        <a href="<?php the_permalink() ?>">
            <?php $thumb = get_the_post_thumbnail($post->ID, 'thumb-wide', array('itemprop'=>'image')); if (!empty($thumb)): ?>
                <?php echo $thumb ?>
            <?php endif ?>
        </a>
    </div>

    <div class="post-card-one__content">

        <header class="entry-header">
            <?php the_title( '<'.$tag.' class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url"><span itemprop="headline">', '</span></a></'.$tag.'>' ) ?>
        </header><!-- .entry-header -->


        <?php if ( $is_show_excerpt ) { ?>
        <div class="post-card-one__text" itemprop="articleBody">
            <?php echo do_excerpt( get_the_excerpt(), 14 ); ?>
        </div><!-- .entry-content -->
        <?php } ?>


        <?php if ( 'post' === get_post_type() && ( $is_show_category || $is_show_comments || $is_show_views ) ) : ?>
            <div class="entry-meta">

                <?php if ( $is_show_category ) { ?>
                <?php echo '<span class="entry-category">' . root_category( $post->ID, '', true ) . '</span>' ?>
                <?php } ?>

                <span class="entry-meta__info">
                    <?php if ( $is_show_comments ) { ?>
                        <span class="entry-meta__comments" title="<?php _e( 'Comments', 'root' ) ?>"><span class="fa fa-comment-o"></span> <?php echo get_comments_number() ?></span>
                    <?php } ?>

                    <?php if ( $is_show_views ) { ?>
                        <?php if ( function_exists('the_views') ) { ?><span class="entry-meta__views" title="<?php _e( 'Views', 'root' ) ?>"><span class="fa fa-eye"></span> <?php the_views() ?></span><?php } ?>
                    <?php } ?>
                </span>
            </div><!-- .entry-meta -->
        <?php endif; ?>


    </div>

</article><!-- #post-## -->