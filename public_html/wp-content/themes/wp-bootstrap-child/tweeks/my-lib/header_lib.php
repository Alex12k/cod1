<?php
	
	function root_header($site_title_text, $description){?>
		
	<header id="masthead" class="site-header" itemscope itemtype="https://schema.org/WPHeader">	
	
	<div class="site-header-inner">
		
		<div class="site-branding">					
			<div class="site-branding-container">		              					
				<div class="site-title">		<?= $site_title_text?> </div>			
				<p class="site-description">	<?= $description	?>	</p>		
			</div>					
		</div><!-- .site-branding -->
		
		<?php do_action('after_site_branding'); /* My action */ ?>
		
		
		<!-- Top Menu -->
		<div class="top-menu">
			<?php	
			if(has_nav_menu('top_menu')){
				wp_nav_menu( array('theme_location' => 'top_menu', 'menu_id' => 'top_menu') 						);
				}//end if
			?>
		</div>

		<!--Mob hamburger-->
        <div class="mob-hamburger"><span></span></div>
	
	</div><!--end site-header-inner-->	
				
</header><!-- #masthead -->
		
	<?}
	
	
	
	
	
	
function header_bootstrap($site_title_text, $description){?>
	
	
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
   
	<a class="navbar-brand" href="#">Navbar</a>
  
		<button class="navbar-toggler" type="button" 
			data-toggle="collapse" 
			data-target="#navbarSupportedContent" 
			aria-controls="navbarSupportedContent" 
			aria-expanded="false" 
			aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
   
   
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
      
		<ul class="navbar-nav mr-auto">
         
		<li class="nav-item active">
			<a class="nav-link" href="#">Home 
				<span class="sr-only">(current)</span>
			</a>
		</li>
         
		<li class="nav-item">
			<a class="nav-link" href="#">Link</a>
		</li>
         
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Dropdown
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" href="#">Action</a>
				<a class="dropdown-item" href="#">Another action</a>
					
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#">Something else here</a>
			</div>
		</li>
		 
		 
		<li class="nav-item">
			<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">
				Disabled
			</a>
		</li>
      
	  </ul>
	  
	  <!--Поиск -->
	  <!--
      <form class="form-inline my-2 my-lg-0">
         <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
         <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
	  -->
	  
   </div>
</nav>
	
	
		
	<?}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	