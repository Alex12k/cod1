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

class wpshopbizTopCommentatorsWidget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'top_commentators',
            'ТОП комментаторов',
            array( 'description' => 'ТОП комментаторов' )
        );
    }

    /*
     * фронтэнд виджета
     */
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] ); // к заголовку применяем фильтр (необязательно)

        echo $args['before_widget'];

        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

        sp_top_commentator();

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Заголовок</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}

function wpshopbiz_top_commentators_widget_load() {
    register_widget( 'wpshopbizTopCommentatorsWidget' );
}
add_action( 'widgets_init', 'wpshopbiz_top_commentators_widget_load' );











class wpshopbizSubscribeWidget2 extends WP_Widget {

    function __construct() {
        parent::__construct(
            'wpshopbiz_subscribe',
            'Подписка',
            array( 'description' => 'Форма подписки на обновления' )
        );
    }

    /*
     * фронтэнд виджета
     */
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] ); // к заголовку применяем фильтр (необязательно)

        echo $args['before_widget'];

        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

        ?>


        <!-- код формы подписки -->
        <div class="widget-subscribe">
            <div class="widget-subscribe__i">

                <a href="<?php bloginfo('rss2_url') ?>" class="widget-subscribe__rss">
                    RSS-подписка
                </a>
            </div>
        </div>
        <!-- код формы подписки -->



        <?php

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Заголовок</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
       
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}

function wpshopbiz_subscribe_widget_load2() {
    register_widget( 'wpshopbizSubscribeWidget2' );
}
//add_action( 'widgets_init', 'wpshopbiz_subscribe_widget_load2' );










class wpshopbizArticlesWidget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'wpshop_articles',
            'Вывод статей',
            array( 'description' => 'Вывод статей' )
        );
    }

    /*
     * фронтэнд виджета
     */
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] ); // к заголовку применяем фильтр (необязательно)

        echo $args['before_widget'];

        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

        // ID постов
        if ( isset($instance['post_ids']) && ! empty($instance['post_ids']) ) {
            $post_ids = trim($instance['post_ids']);
        } else {
            $post_ids = '';
        }

        // Сортировка
        if ( isset($instance['posts_orderby']) && ! empty($instance['posts_orderby']) ) {
            $posts_orderby = trim($instance['posts_orderby']);
        } else {
            $posts_orderby = 'rand';
        }

        // Количество постов
        if ( isset($instance['post_limit']) && ! empty($instance['post_limit']) ) {
            $post_limit = trim($instance['post_limit']);
        } else {
            $post_limit = '';
        }
		
		// Внешний вид
        $articles_view = ! empty( $instance['articles_view'] ) ? $instance['articles_view'] : '';
		
		// Ссылка в новом окне
        $link_target   = ! empty( $instance['link_target'] ) ? $instance['link_target'] : '';

        // default values
        $get_posts_args = array(
            'orderby'           => 'rand',
            'numberposts'       => $post_limit,
        );

        // сортировка
        if ( $posts_orderby == 'rand' ) {
            $get_posts_args = array(
                'orderby'           => 'rand',
                'numberposts'       => $post_limit,
            );
        }
        if ( $posts_orderby == 'views' ) {
            $get_posts_args = array(
                'meta_key'          => 'views',
                'orderby'           => 'meta_value_num',
                'order'             => 'DESC',
                'numberposts'       => $post_limit,
            );
        }
        if ( $posts_orderby == 'comments' ) {
            $get_posts_args = array(
                'orderby'           => 'comment_count',
                'order'             => 'DESC',
                'numberposts'       => $post_limit,
            );
        }
        if ( $posts_orderby == 'new' ) {
            $get_posts_args = array(
                'orderby'           => 'date',
                'order'             => 'DESC',
                'numberposts'       => $post_limit,
            );
        }



        if ( ! empty($post_ids) ) {

            $post_ids_exp = explode(',', $instance['post_ids']);

            if (is_array($post_ids_exp)) {
                $post_ids = array_map('trim', $post_ids_exp);
            } else {
                $post_ids = array($instance['post_ids']);
            }

            $get_posts_args['post__in'] = $post_ids;

        }

        $posts = get_posts( $get_posts_args );
        foreach($posts as $single_post){
            ?>


            <?php if ( $articles_view == 'normal' ): ?>

                <div class="widget-article">
                    <div class="widget-article__image">
						<a href="<?php echo get_permalink($single_post->ID) ?>"<?php echo ( $link_target == true ) ? ' target="_blank"' : ''; ?>>
                        <?php $thumb = get_the_post_thumbnail($single_post->ID, 'thumb-wide'); if (!empty($thumb)): ?>
                            <?php echo $thumb ?>
                        <?php endif ?>
                        </a>
                    </div>
                    <div class="widget-article__body">
                        <div class="widget-article__title"><a href="<?php echo get_permalink($single_post->ID) ?>"<?php echo ( $link_target == true ) ? ' target="_blank"' : ''; ?>><?php echo get_the_title($single_post->ID) ?></a></div>
                    </div>
                </div>

            <?php else: ?>

                <div class="widget-article widget-article--compact">
                    <div class="widget-article__image">
						<a href="<?php echo get_permalink($single_post->ID) ?>"<?php echo ( $link_target == true ) ? ' target="_blank"' : ''; ?>>
                        <?php $thumb = get_the_post_thumbnail($single_post->ID, 'thumbnail'); if (!empty($thumb)): ?>
                            <?php echo $thumb ?>
                        <?php endif ?>
                        </a>
                    </div>
                    <div class="widget-article__body">
                        <div class="widget-article__title"><a href="<?php echo get_permalink($single_post->ID) ?>"<?php echo ( $link_target == true ) ? ' target="_blank"' : ''; ?>><?php echo get_the_title($single_post->ID) ?></a></div>
                        <div class="widget-article__category">
                            <?php echo root_category( $single_post->ID, '', false ) ?>
                        </div>
                    </div>
                </div>

            <?php endif; ?>



            <?php
        }


        echo $args['after_widget'];
    }

    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        } else {
            $title = '';
        }
        if ( isset( $instance[ 'post_ids' ] ) ) {
            $post_ids = $instance[ 'post_ids' ];
        } else {
            $post_ids = '';
        }
        if ( isset( $instance[ 'posts_orderby' ] ) ) {
            $posts_orderby = $instance[ 'posts_orderby' ];
        } else {
            $posts_orderby = 'rand';
        }
        if ( isset( $instance[ 'articles_view' ] ) ) {
            $posts_articles_view = $instance[ 'articles_view' ];
        } else {
            $posts_articles_view = 'normal';
        }
        if ( isset( $instance[ 'post_limit' ] ) ) {
            $post_limit = $instance[ 'post_limit' ];
        } else {
            $post_limit = '';
        }
		$link_target = ! empty( $instance['link_target'] ) ? $instance['link_target'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Заголовок</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'posts_orderby' ); ?>">Сортировка</label><br>
            <select name="<?php echo $this->get_field_name( 'posts_orderby' ); ?>" id="<?php echo $this->get_field_id( 'posts_orderby' ); ?>">
                <option value="rand" <?php selected($posts_orderby, 'rand') ?>>Случайно</option>
                <option value="views" <?php selected($posts_orderby, 'views') ?>>По просмотрам (views)</option>
                <option value="comments" <?php selected($posts_orderby, 'comments') ?>>По комментариям</option>
                <option value="new" <?php selected($posts_orderby, 'new') ?>>Новые сверху</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'post_ids' ); ?>">ID постов через запятую, если нужно вывести определенные посты</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'post_ids' ); ?>" name="<?php echo $this->get_field_name( 'post_ids' ); ?>" type="text" value="<?php echo esc_attr( $post_ids ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'post_limit' ); ?>">Количество постов</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'post_limit' ); ?>" name="<?php echo $this->get_field_name( 'post_limit' ); ?>" type="number" min="1" step="1" value="<?php echo esc_attr( $post_limit ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'articles_view' ); ?>">Вывод</label><br>
            <select name="<?php echo $this->get_field_name( 'articles_view' ); ?>" id="<?php echo $this->get_field_id( 'articles_view' ); ?>">
                <option value="normal" <?php selected($posts_articles_view, 'normal') ?>>Обычный</option>
                <option value="compact" <?php selected($posts_articles_view, 'compact') ?>>Компактно</option>
            </select>
        </p>
		<p>
            <input type="checkbox" id="<?php echo $this->get_field_id('link_target'); ?>" name="<?php echo $this->get_field_name('link_target'); ?>" value="1" <?php checked( $link_target ); ?>>
			<label for="<?php echo $this->get_field_id( 'link_target' ); ?>">Открывать ссылку в новом окне</label>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['post_ids'] = ( ! empty( $new_instance['post_ids'] ) ) ? strip_tags( $new_instance['post_ids'] ) : '';
        $instance['posts_orderby'] = ( ! empty( $new_instance['posts_orderby'] ) ) ? strip_tags( $new_instance['posts_orderby'] ) : '';
        $instance['post_limit'] = ( ! empty( $new_instance['post_limit'] ) ) ? strip_tags( $new_instance['post_limit'] ) : '';
        $instance['articles_view'] = ( ! empty( $new_instance['articles_view'] ) ) ? strip_tags( $new_instance['articles_view'] ) : '';
		$instance['link_target'] = ! empty( $new_instance['link_target'] ) ? true : false;
        return $instance;
    }
}

function wpshopbiz_articles_widget_load() {
    register_widget( 'wpshopbizArticlesWidget' );
}
add_action( 'widgets_init', 'wpshopbiz_articles_widget_load' );




















