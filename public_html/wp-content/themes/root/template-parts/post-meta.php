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

$is_show_date       = 'yes' == root_get_option( 'structure_single_date' );
$is_show_category   = 'yes' == root_get_option( 'structure_single_category' );
$is_show_author     = 'yes' == root_get_option( 'structure_single_author' );
$is_show_social     = 'yes' == root_get_option( 'structure_single_social' );

if ( $is_show_date ) {
    echo '<span class="entry-date"><time itemprop="datePublished" datetime="' . get_the_time('Y-m-d') . '">' . get_the_time('d.m.Y') . '</time></span>';
}
if ( $is_show_category ) {
    echo '<span class="entry-category"><span class="hidden-xs">'. __( 'Category', 'root' ) .':</span> ' . root_category() . '</span>';
}
if ( $is_show_author ) {
    echo '<span class="entry-author"><span class="hidden-xs">' . __( 'Author', 'root' ) . ':</span> <span itemprop="author">' . get_the_author() . '</span></span>';
}

if ( $is_show_social ) {
    echo '<span class="b-share b-share--small">';
    get_template_part( 'template-parts/social', 'buttons' );
    echo '</span>';
}