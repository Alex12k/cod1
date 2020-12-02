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


function enqueue_plugin_scripts($plugin_array) {
    //enqueue TinyMCE plugin script with its ID.
    $plugin_array["blockquote_button_plugin"] =  get_template_directory_uri() . '/js/tinymce-plugin.js';
    return $plugin_array;
}

add_filter("mce_external_plugins", "enqueue_plugin_scripts");




function register_buttons_editor($buttons)
{
    //register buttons with their id.
    array_push($buttons, /*'col_6', 'col_4',*/ 'blockquote_warning', 'blockquote_info', 'blockquote_danger', 'spoiler_btn', 'mask_link');
    return $buttons;
}

add_filter("mce_buttons_3", "register_buttons_editor");