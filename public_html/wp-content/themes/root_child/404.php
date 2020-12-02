<?
$theme_path = get_stylesheet_directory_uri();

$url= get_site_url();

?>
<link href="<?=$theme_path?>/css_stack/frameworks/404.css" rel="stylesheet" type="text/css">

<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>404</h1>
				<h2>СТРАНИЦА НЕ НАЙДЕНА</h2>
			</div>
			<a href="<?=$url?>">НА ГЛАВНУЮ</a>
		</div>
</div>


