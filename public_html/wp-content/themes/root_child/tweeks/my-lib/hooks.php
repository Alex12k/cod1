<?php
/* Просмотр функций привязанных к хуку 
* Функция принимает в качестве параметра имя хука (do_acction)
*/

function print_filters_for( $hook = '' ) {
    global $wp_filter;
    if( empty( $hook ) || !isset( $wp_filter[$hook] ) )
        return;
 
    print '<pre>';
    print_r( $wp_filter[$hook] );
    print '</pre>';
}