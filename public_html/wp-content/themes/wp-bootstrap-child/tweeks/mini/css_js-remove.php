<?



/*---------------------------------------------------------
/*Отключение Contact-form-7 JS */
/*----------------------------------------------------------*/

//add_action( 'wp_enqueue_scripts', 'deregister_script_cf7', 100 );	
function deregister_script_cf7(){			
			wp_deregister_script( 'contact-form-7' );
			wp_dequeue_script('contact-form-7');
		}


//add_action( 'wp_enqueue_scripts', 'deregister_style_cf7_css', 100 );	
function deregister_style_cf7_css(){			
			wp_deregister_style( 'contact-form-7' );					
		}

/*---------------------------------------------------------
/* END
/*----------------------------------------------------------*/




/* МОДУЛЬ ОТКЛЮЧЕНИЯ ROOT STYLE */
//add_action( 'wp_enqueue_scripts', 'deregister_style_root_style', 100 );
function deregister_style_root_style(){
			wp_deregister_style( 'root-style' );
		}


/* МОДУЛЬ ОТКЛЮЧЕНИЯ ROOT DASHICONS */
//add_action( 'wp_enqueue_scripts', 'deregister_style_dashicons', 100 );	
function deregister_style_dashicons(){			
			wp_deregister_style( 'dashicons' );					
		}

