<?php
/* Template Name: home */

get_header();

/* Определение пути до папкис темой */
$theme_path = get_stylesheet_directory_uri(); //te($theme_path, 'путь до темы');

/* Собираем абсолютные адреса шаблонов всех модулей */
$All_php_templates	= get_dirs( __DIR__ .'/modules', 'fold', 1);
$All_index_files	= get_dirs( __DIR__ .'/modules', '*index.php', 2);

//print_arr($All_php_templates, 'собираем имена папками с модулями на странице');
//print_arr($All_index_files, 'собираем имена index фаилов на странице');

/* Массвив имён модулей */
$Modules_array = array_keys($All_php_templates);	//print_arr($Modules_array);

/* Создание структуры модуля */

$i=0;
foreach($All_php_templates as $template_path){		
	
	
	$i++;		
	$empty_folder = glob($template_path.'/*' );	//print_arr($empty_folder);		
	
			
		/* Если каталог только что созданный и следовательно пустой */
		if(!$empty_folder){	
		
			te('Папка с модулем пуста');
			creat_modul_structure($template_path);
		
		
		} //end if empty_folder
		
} //end foreach



/*	Формируем масссив URL пригодных для get_template_part	*/
$Urls_for_get_template = abs2_url_for_get_template_part($All_php_templates);


//print_arr($Urls_for_get_template, 'список url папок модулей для get_template_part');

?>	

<style>
	body{color: white;}
</style>

	<div class="container-fluid right-content-box p-0">	
		<div class="d-flex">						
			<!-- Primary container -->
			<div class="w-100 p-0 wp-bp-content-width">
				<div id="primary" class="content-area">
					<main id="main" class="site-main">											
																 				
					<?php 
					foreach($Urls_for_get_template as $handle => $src){							
						
						$handle = remove_gravity_index($handle);
						$path = $src.'/'.$handle.'-index';			
						get_template_part($path);
				
					}
					?>
					
					
					</main><!-- #main -->
				</div><!-- #primary -->					
			</div>
				<!-- END Primary container -->

										
		</div><!-- /.row -->		
	</div><!-- /.container --><?
	
	

	
	get_footer();
