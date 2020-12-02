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

function do_show_ad($post_id, $exclude_ids) {
    $exclude_ids = is_string($exclude_ids) ? explode(',', $exclude_ids) : $exclude_ids;
    return !in_array($post_id, $exclude_ids);
}

add_filter( 'the_content', 'the_content_add_ad' );

function the_content_add_ad( $content ) {

    global $post;

    if( ! is_single() )
        return $content;

    $ad_options = get_option('root_ad_options');
    $offset = (int) time() - (int) strtotime($GLOBALS['post']->post_date);

    $out = '';

    /**
     * Перед статьей
     */
    $days   = (int) $ad_options['r_before_article_days'];

    $show_ad = do_show_ad(
        $post->ID,
        isset($ad_options['r_before_article_exclude']) ? $ad_options['r_before_article_exclude'] : array()
    );
    
    if ( ( $offset < (60 * 60 * 24 * $days) ) ) $show_ad = false;

    if ( ! wp_is_mobile() && isset( $ad_options['r_before_article'] ) && ! empty( $ad_options['r_before_article'] ) && $show_ad ) {
        $out .= '<div class="b-r b-r--before-article">' . $ad_options['r_before_article'] . '</div>';
    }

    if ( wp_is_mobile() && isset( $ad_options['r_before_article_mob'] ) && ! empty( $ad_options['r_before_article_mob'] ) && $show_ad ) {
        $out .= '<div class="b-r b-r--before-article">' . $ad_options['r_before_article_mob'] . '</div>';
    }

    
    //$out .= $content;





    /**
     * По середине статьи
     * После абзаца
     */
    $r_after_p_num   = (int) $ad_options['r_after_p_num'];
    $r_after_p_2_num = (int) $ad_options['r_after_p_2_num'];
    $r_after_p_3_num = (int) $ad_options['r_after_p_3_num'];

    $content_exp = explode ( "</p>", $content );
    for ( $i = 0; $i < count ( $content_exp ); $i ++ ) {

        /**
         * После абзаца 1
         */
        if ( ! empty($r_after_p_num) ) {
            if ( $i == $r_after_p_num && ( $i != ( count ( $content_exp )-1 ) ) ) {

                $days   = (int) $ad_options['r_after_p_days'];

                $show_ad = do_show_ad(
                    $post->ID,
                    isset($ad_options['r_after_p_exclude']) ? $ad_options['r_after_p_exclude'] : array()
                );
                
                if ( ( $offset < (60 * 60 * 24 * $days) ) ) $show_ad = false;

                if ( ! wp_is_mobile() && isset( $ad_options['r_after_p'] ) && ! empty( $ad_options['r_after_p'] ) && $show_ad ) {
                    $out .= '<div class="b-r b-r--after-p">' . $ad_options['r_after_p'] . '</div>';
                }

                if ( wp_is_mobile() && isset( $ad_options['r_after_p_mob'] ) && ! empty( $ad_options['r_after_p_mob'] ) && $show_ad ) {
                    $out .= '<div class="b-r b-r--after-p">' . $ad_options['r_after_p_mob'] . '</div>';
                }

            }
        }
        
        
        /**
         * После абзаца 2
         */
        if ( ! empty($r_after_p_2_num) ) {
            if ( $i == $r_after_p_2_num && ( $i != ( count ( $content_exp )-1 ) ) ) {

                $days   = (int) $ad_options['r_after_p_2_days'];

                $show_ad = do_show_ad(
                    $post->ID,
                    isset($ad_options['r_after_p_2_exclude']) ? $ad_options['r_after_p_2_exclude'] : array()
                );
                
                if ( ( $offset < (60 * 60 * 24 * $days) ) ) $show_ad = false;

                if ( ! wp_is_mobile() && isset( $ad_options['r_after_p_2'] ) && ! empty( $ad_options['r_after_p_2'] ) && $show_ad ) {
                    $out .= '<div class="b-r b-r--after-p">' . $ad_options['r_after_p_2'] . '</div>';
                }

                if ( wp_is_mobile() && isset( $ad_options['r_after_p_2_mob'] ) && ! empty( $ad_options['r_after_p_2_mob'] ) && $show_ad ) {
                    $out .= '<div class="b-r b-r--after-p">' . $ad_options['r_after_p_2_mob'] . '</div>';
                }

            }
        }
        
        /**
         * После абзаца 3
         */
        if ( ! empty($r_after_p_3_num) ) {
            if ( $i == $r_after_p_3_num && ( $i != ( count ( $content_exp )-1 ) ) ) {

                $days   = (int) $ad_options['r_after_p_3_days'];

                $show_ad = do_show_ad(
                    $post->ID,
                    isset($ad_options['r_after_p_3_exclude']) ? $ad_options['r_after_p_3_exclude'] : array()
                );
                
                if ( ( $offset < (60 * 60 * 24 * $days) ) ) $show_ad = false;

                if ( ! wp_is_mobile() && isset( $ad_options['r_after_p_3'] ) && ! empty( $ad_options['r_after_p_3'] ) && $show_ad ) {
                    $out .= '<div class="b-r b-r--after-p">' . $ad_options['r_after_p_3'] . '</div>';
                }

                if ( wp_is_mobile() && isset( $ad_options['r_after_p_3_mob'] ) && ! empty( $ad_options['r_after_p_3_mob'] ) && $show_ad ) {
                    $out .= '<div class="b-r b-r--after-p">' . $ad_options['r_after_p_3_mob'] . '</div>';
                }

            }
        }

        
        

        /**
         * По середине
         */
        if ( $i == round(count ( $content_exp )/2 )-1) {

            $days   = (int) $ad_options['r_middle_article_days'];

            $show_ad = do_show_ad(
                $post->ID,
                isset($ad_options['r_middle_article_exclude']) ? $ad_options['r_middle_article_exclude'] : array()
            );
            
            if ( ( $offset < (60 * 60 * 24 * $days) ) ) $show_ad = false;

            if ( ! wp_is_mobile() && isset( $ad_options['r_middle_article'] ) && ! empty( $ad_options['r_middle_article'] ) && $show_ad ) {
                $out .= '<div class="b-r b-r--after-p">' . $ad_options['r_middle_article'] . '</div>';
            }

            if ( wp_is_mobile() && isset( $ad_options['r_middle_article_mob'] ) && ! empty( $ad_options['r_middle_article_mob'] ) && $show_ad ) {
                $out .= '<div class="b-r b-r--after-p">' . $ad_options['r_middle_article_mob'] . '</div>';
            }
            
        }
        $out .= $content_exp[$i] . "</p>";
    }






    /**
     * После статьи
     */
    $days   = (int) $ad_options['r_after_article_days'];

    $show_ad = do_show_ad(
        $post->ID,
        isset($ad_options['r_after_article_exclude']) ? $ad_options['r_after_article_exclude'] : array()
    );
    
    if ( ( $offset < (60 * 60 * 24 * $days) ) ) $show_ad = false;

    if ( ! wp_is_mobile() && isset( $ad_options['r_after_article'] ) && ! empty( $ad_options['r_after_article'] ) && $show_ad ) {
        $out .= '<div class="b-r b-r--after-article">' . $ad_options['r_after_article'] . '</div>';
    }

    if ( wp_is_mobile() && isset( $ad_options['r_after_article_mob'] ) && ! empty( $ad_options['r_after_article_mob'] ) && $show_ad ) {
        $out .= '<div class="b-r b-r--after-article">' . $ad_options['r_after_article_mob'] . '</div>';
    }
    


    return $out;
}


/**
 * Для excerpt чтобы не выводилась реклама
 *
 * @param $content
 * @return mixed
 */
function remove_the_content_add_ad_filter($content) {
    if ( has_filter( 'the_content', 'the_content_add_ad' ) ) {
        remove_filter( 'the_content', 'the_content_add_ad' );
    }
    return $content;
}
function add_the_content_add_ad_filter($content) {
    add_filter( 'the_content', 'the_content_add_ad' );
    return $content;
}



/**
 * Создаем страницу настроек рекламы
 */
add_action('admin_menu', 'root_admin_menu_ad');
function root_admin_menu_ad(){
    add_submenu_page( 'themes.php', 'Реклама', 'Реклама', 'manage_options', 'root_ad', 'root_admin_display' );
}

function root_admin_display(){
    ?>
    <div class="wrap">
        <h2><?php echo get_admin_page_title() ?></h2>

        <p>
            У каждого блока есть возможность отображать рекламу по прошествии определенного количества дней.<br>
            Например, чтобы не раздражать рекламой постоянных посетителей, можно установить срок 7 дней.<br>
            Тогда Ваша реклама будет показываться в статьях только по прошествии 7 дней после публикации.<br>
            Установите 0 - если хотите, чтобы реклама показывалась сразу после публикации.
        </p>

        <p>
            Например, Вы можете задать<br>
            – код перед статьей (после 7 дней),<br>
            – после 5 абзацев (после 7 дней),<br>
            – после 10 абзацев (после 7 дней, будет для длинных статей),<br>
            – после 15 абзацев (после 7 дней, будет для еще более длинных статей),<br>
            – код после статьи (выводим сразу).
        </p>

        <hr>

        <form action="options.php" method="POST">
            <?php
            settings_fields( 'option_group_ad' );     // скрытые защитные поля
            do_settings_sections( 'revelation_page_ad' ); // секции с настройками (опциями). У нас она всего одна 'section_id'
            submit_button();
            ?>
        </form>
    </div>
    <?php
}



/**
 * Регистрируем настройки.
 * Настройки будут храниться в массиве, а не одна настройка = одна опция.
 */
add_action('admin_init', 'root_ad_settings');
function root_ad_settings(){
    register_setting( 'option_group_ad', 'root_ad_options', 'sanitize_callback_ad' );

    add_settings_section( 'section_r', 'Реклама', '', 'revelation_page_ad' );

    add_settings_field('field_r_before_site_content', 'После шапки и меню (на всю ширину сайта)', 'field_r_before_site_content_display', 'revelation_page_ad', 'section_r' );

    add_settings_field('field_r_before_the_content', 'Перед статьей', 'field_r_before_the_content_display', 'revelation_page_ad', 'section_r' );
    add_settings_field('field_r_middle_the_content',  'По середине статьи',  'field_r_middle_the_content_display',  'revelation_page_ad', 'section_r' );
    add_settings_field('field_r_after_the_content',  'После статьи',  'field_r_after_the_content_display',  'revelation_page_ad', 'section_r' );
    
    add_settings_field('field_r_after_p',    'После абзаца #1',  'field_r_after_p_display',  'revelation_page_ad', 'section_r', array('name' => 'r_after_p') );
    add_settings_field('field_r_after_p_2',  'После абзаца #2',  'field_r_after_p_display',  'revelation_page_ad', 'section_r', array('name' => 'r_after_p_2') );
    add_settings_field('field_r_after_p_3',  'После абзаца #3',  'field_r_after_p_display',  'revelation_page_ad', 'section_r', array('name' => 'r_after_p_3') );
}




function field_r_before_site_content_display() {
    $val = get_option('root_ad_options');

    if ( isset($val['r_before_site_content']) ) {
        $r_pc = $val['r_before_site_content'];
    } else {
        $r_pc = '';
    }

    if ( isset($val['r_before_site_content_mob']) ) {
        $r_mob = $val['r_before_site_content_mob'];
    } else {
        $r_mob = '';
    }

    if ( isset($val['r_before_site_content_visible']) ) {
        $r_visible = $val['r_before_site_content_visible'];
    } else {
        $r_visible = array();
    }
    
    if ( isset($val['r_before_site_content_exclude']) ) {
        $r_before_site_content_exclude = $val['r_before_site_content_exclude'];
    } else {
        $r_before_site_content_exclude = '';
    }
    ?>

    <div class="clear cleafix">
        <div style="float:left; width: 48%; margin-right:2%;">
            <p>Десктоп версия:</p>
            <textarea name="root_ad_options[r_before_site_content]" class="large-text" rows="4"><?php echo esc_attr( $r_pc ) ?></textarea>
        </div>
        <div style="float:left; width: 48%;">
            <p>Мобильная версия</p>
            <textarea name="root_ad_options[r_before_site_content_mob]" class="large-text" rows="4"><?php echo esc_attr( $r_mob ) ?></textarea>
        </div>
    </div>
    <div style="margin-bottom: 25px;"> Выводить: &nbsp;
        <label style="margin-right: 15px;"><input type="checkbox" name="root_ad_options[r_before_site_content_visible][]" value="home"<?php echo ( in_array('home', $r_visible) ) ? ' checked' : '' ?>> на главной</label>
        <label style="margin-right: 15px;"><input type="checkbox" name="root_ad_options[r_before_site_content_visible][]" value="post"<?php echo ( in_array('post', $r_visible) ) ? ' checked' : '' ?>> в записях</label>
        <label style="margin-right: 15px;"><input type="checkbox" name="root_ad_options[r_before_site_content_visible][]" value="page"<?php echo ( in_array('page', $r_visible) ) ? ' checked' : '' ?>> на страницах</label>
        <label style="margin-right: 15px;"><input type="checkbox" name="root_ad_options[r_before_site_content_visible][]" value="archive"<?php echo ( in_array('archive', $r_visible) ) ? ' checked' : '' ?>> в архивах</label>
        <label style="margin-right: 15px;"><input type="checkbox" name="root_ad_options[r_before_site_content_visible][]" value="search"<?php echo ( in_array('search', $r_visible) ) ? ' checked' : '' ?>> в поиске</label>
    </div>
    <div style="margin-bottom: 25px;">Укажите ID записей через запятую, в которых не показывать рекламу <input name="root_ad_options[r_before_site_content_exclude]" type="text" value="<?php echo $r_before_site_content_exclude ?>" style="width: 97%"></div>
    
    <?php
}



function field_r_before_the_content_display() {
    $val = get_option('root_ad_options');

    if ( isset($val['r_before_article']) ) {
        $r_before_article = $val['r_before_article'];
    } else {
        $r_before_article = '';
    }

    if ( isset($val['r_before_article_mob']) ) {
        $r_before_article_mob = $val['r_before_article_mob'];
    } else {
        $r_before_article_mob = '';
    }

    if ( isset($val['r_before_article_days']) ) {
        $r_before_article_days = $val['r_before_article_days'];
    } else {
        $r_before_article_days = 0;
    }
    
    if ( isset($val['r_before_article_exclude']) ) {
        $r_before_article_exclude = $val['r_before_article_exclude'];
    } else {
        $r_before_article_exclude = '';
    }
    ?>

    <div class="clear cleafix">
        <div style="float:left; width: 48%; margin-right:2%;">
            <p>Десктоп версия:</p>
            <textarea name="root_ad_options[r_before_article]" class="large-text" rows="4"><?php echo esc_attr( $r_before_article ) ?></textarea>
        </div>
        <div style="float:left; width: 48%;">
            <p>Мобильная версия</p>
            <textarea name="root_ad_options[r_before_article_mob]" class="large-text" rows="4"><?php echo esc_attr( $r_before_article_mob ) ?></textarea>
        </div>
    </div>
    <div style="margin-bottom: 25px;">Показывать через <input name="root_ad_options[r_before_article_days]" type="number" value="<?php echo $r_before_article_days ?>" style="width: 50px"> дней после публикации записи. 0 — показывать сразу</div>
    <div style="margin-bottom: 25px;">Укажите ID записей через запятую, в которых не показывать рекламу <input name="root_ad_options[r_before_article_exclude]" type="text" value="<?php echo $r_before_article_exclude ?>" style="width: 97%"></div>
    
    <?php
}




function field_r_after_p_display( $args ) {
    extract( $args );
    $val = get_option('root_ad_options');

    if ( isset($val[$name]) ) {
        $r_after_p = $val[$name];
    } else {
        $r_after_p = '';
    }

    if ( isset($val[$name . '_mob']) ) {
        $r_after_p_mob = $val[$name . '_mob'];
    } else {
        $r_after_p_mob = '';
    }

    if ( isset($val[$name . '_days']) ) {
        $r_after_p_days = $val[$name . '_days'];
    } else {
        $r_after_p_days = 0;
    }

    if ( isset($val[$name . '_num']) ) {
        $r_after_p_num = $val[$name . '_num'];
    } else {
        $r_after_p_num = 0;
    }
    
    if ( isset($val[$name . '_exclude']) ) {
        $r_after_p_exclude = $val[$name . '_exclude'];
    } else {
        $r_after_p_exclude = '';
    }
    ?>

    <div style="margin-bottom: 5px;">Показывать после <input name="root_ad_options[<?php echo $name ?>_num]" type="number" value="<?php echo $r_after_p_num ?>" style="width: 50px"> абзаца. Если задано 0 — не показывается.</div>
    <div class="clear cleafix">
        <div style="float:left; width: 48%; margin-right:2%;">
            <p>Десктоп версия:</p>
            <textarea name="root_ad_options[<?php echo $name ?>]" class="large-text" rows="4"><?php echo esc_attr( $r_after_p ) ?></textarea>
        </div>
        <div style="float:left; width: 48%;">
            <p>Мобильная версия</p>
            <textarea name="root_ad_options[<?php echo $name ?>_mob]" class="large-text" rows="4"><?php echo esc_attr( $r_after_p_mob ) ?></textarea>
        </div>
    </div>
    <div style="margin-bottom: 25px;">Показывать через <input name="root_ad_options[<?php echo $name ?>_days]" type="number" value="<?php echo $r_after_p_days ?>" style="width: 50px"> дней после публикации записи. 0 — показывать сразу</div>
    <div style="margin-bottom: 25px;">Укажите ID записей через запятую, в которых не показывать рекламу <input name="root_ad_options[<?php echo $name ?>_exclude]" type="text" value="<?php echo $r_after_p_exclude ?>" style="width: 97%"></div>
    
    <?php
}


function field_r_middle_the_content_display() {
    $val = get_option('root_ad_options');

    if ( isset($val['r_middle_article']) ) {
        $r_middle_article = $val['r_middle_article'];
    } else {
        $r_middle_article = '';
    }

    if ( isset($val['r_middle_article_mob']) ) {
        $r_middle_article_mob = $val['r_middle_article_mob'];
    } else {
        $r_middle_article_mob = '';
    }

    if ( isset($val['r_middle_article_days']) ) {
        $r_middle_article_days = $val['r_middle_article_days'];
    } else {
        $r_middle_article_days = 0;
    }
    
    if ( isset($val['r_middle_article_exclude']) ) {
        $r_middle_article_exclude = $val['r_middle_article_exclude'];
    } else {
        $r_middle_article_exclude = '';
    }
    ?>

    <div class="clear cleafix">
        <div style="float:left; width: 48%; margin-right:2%;">
            <p>Десктоп версия:</p>
            <textarea name="root_ad_options[r_middle_article]" class="large-text" rows="4"><?php echo esc_attr( $r_middle_article ) ?></textarea>
        </div>
        <div style="float:left; width: 48%;">
            <p>Мобильная версия</p>
            <textarea name="root_ad_options[r_middle_article_mob]" class="large-text" rows="4"><?php echo esc_attr( $r_middle_article_mob ) ?></textarea>
        </div>
    </div>
    <div style="margin-bottom: 25px;">Показывать через <input name="root_ad_options[r_middle_article_days]" type="number" value="<?php echo $r_middle_article_days ?>" style="width: 50px"> дней после публикации записи. 0 — показывать сразу</div>
    <div style="margin-bottom: 25px;">Укажите ID записей через запятую, в которых не показывать рекламу <input name="root_ad_options[r_middle_article_exclude]" type="text" value="<?php echo $r_middle_article_exclude ?>" style="width: 97%"></div>
    
    <?php
}



function field_r_after_the_content_display() {
    $val = get_option('root_ad_options');

    if ( isset($val['r_after_article']) ) {
        $r_after_article = $val['r_after_article'];
    } else {
        $r_after_article = '';
    }

    if ( isset($val['r_after_article_mob']) ) {
        $r_after_article_mob = $val['r_after_article_mob'];
    } else {
        $r_after_article_mob = '';
    }

    if ( isset($val['r_after_article_days']) ) {
        $r_after_article_days = $val['r_after_article_days'];
    } else {
        $r_after_article_days = 0;
    }
    
    if ( isset($val['r_after_article_exclude']) ) {
        $r_after_article_exclude = $val['r_after_article_exclude'];
    } else {
        $r_after_article_exclude = '';
    }
    ?>

    <div class="clear cleafix">
        <div style="float:left; width: 48%; margin-right:2%;">
            <p>Десктоп версия:</p>
            <textarea name="root_ad_options[r_after_article]" class="large-text" rows="4"><?php echo esc_attr( $r_after_article ) ?></textarea>
        </div>
        <div style="float:left; width: 48%;">
            <p>Мобильная версия</p>
            <textarea name="root_ad_options[r_after_article_mob]" class="large-text" rows="4"><?php echo esc_attr( $r_after_article_mob ) ?></textarea>
        </div>
    </div>
    <div style="margin-bottom: 25px;">Показывать через <input name="root_ad_options[r_after_article_days]" type="number" value="<?php echo $r_after_article_days ?>" style="width: 50px"> дней после публикации записи. 0 — показывать сразу</div>
    <div style="margin-bottom: 25px;">Укажите ID записей через запятую, в которых не показывать рекламу <input name="root_ad_options[r_after_article_exclude]" type="text" value="<?php echo $r_after_article_exclude ?>" style="width: 97%"></div>
    
    <?php
}



## Очистка данных
function sanitize_callback_ad( $options ){

    foreach( $options as $name => & $val ){

    }

    return $options;
}
