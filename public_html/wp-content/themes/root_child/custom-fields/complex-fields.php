<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;



/* Контейнер для главного слайдера */		
Container::make( 'post_meta', 'FIELDS SLIDER' )
		 ->add_fields( array(
				
				Field::make( 'complex', 'carbon_slider', 'Слайдер на основе Carbon fields' )
						->add_fields( array(
							Field::make( 'textarea', 'title', 'Заголовок' )->set_width( 30 ),							
							Field::make( 'textarea', 'subtitle', 'Под заголовок' )->set_width( 60 ),
							//Field::make('Media_Gallery', 'img', 'Фотографии'),
							Field::make('image', 'img', 'Фотография слайда')->set_width( 10 )
							->set_type('image'),
							 
							 )
							)
							->help_text( 'Данные для слайдера' )
				) );



/* Контейнер для цитатника */
Container::make( 'post_meta', 'Блок с цитатой и предложением' )
		->set_priority('low')
	
		-> add_fields( array(		
			Field::make( 'textarea', 'quote', 'цитата' ),							
			Field::make( 'text', 'author', 'Автор' ),
			Field::make( 'textarea', 'offer', 'Предложение' ),	
		) );
		
		 


/* Контейнер страницы тренеры */		
Container::make( 'post_meta', 'FIELDS INSTRUCTORS' )
		->show_on_page('66') /*id страницы или можно указать путь */
		->add_fields( array(
				
				Field::make( 'complex', 'data_instructors', 'Тренеры:' )
						->add_fields( array(
							Field::make( 'textarea', 'name', 'Имя тренера' )->set_width( 15 ),							
							Field::make( 'rich_text', 'description', 'Описание на странице' )->set_width( 37 ),
							Field::make( 'rich_text', 'read_more', 'Описание (Подробнее)' )->set_width( 37 ),
							//Field::make('Media_Gallery', 'img', 'Фотографии'),
							Field::make('image', 'img', 'Фото')->set_width( 10 )
							->set_type('image'),
							 
							 )
							)
							->help_text( 'Данные для страницы тренеры' )
				) );







	
				
				
				
				
				
				
				
				
				
				