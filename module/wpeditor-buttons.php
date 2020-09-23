<?php

/* Wpeditor Button Class */
$wpeditor_button_class_dir = get_template_directory().'/module/core/class.wpeditorbuttons.php';
if(file_exists( $wpeditor_button_class_dir )) require_once( $wpeditor_button_class_dir );
$DWH_WpeditorButtons = new DWH_WpeditorButtons();  


/* Autoload Wpeditor Buttons */
$wpeditor_button_dir = get_template_directory().'/module/wpeditor-buttons';

/* Check if the Wpeditor Buttons directory exists */
if(file_exists( $wpeditor_button_dir ))
{
	$wpeditor_button_dir = scandir( $wpeditor_button_dir );
	$button_sets = array();
	$button_config_arr = array();

	/* Loop through the Wpeditor Buttons directory */
	foreach( $wpeditor_button_dir as $wpeditor_buttons )
	{		
		if($wpeditor_buttons!='.'&& $wpeditor_buttons!='..')
		{	
			
			/* get config */
			$button_config = $DWH_WpeditorButtons->get_button_config( $wpeditor_buttons );
			if( $button_config ){
				array_push( $button_config_arr, $button_config );
			}
			
			/* add new button */
			add_action('init', function() use( $DWH_WpeditorButtons , $wpeditor_buttons ){
				$DWH_WpeditorButtons->add_button( $wpeditor_buttons );
			});
			
			/* push to button sets array */
			array_push( $button_sets, $wpeditor_buttons );
		}
	}
	
	
	/* print scripts to admin head */
	if( $button_config_arr ){
	
		add_action('admin_print_scripts', function() use( $DWH_WpeditorButtons, $button_config_arr ){
			echo "<script type='text/javascript'>\n";
				foreach( $button_config_arr as $key => $val ){
					echo $DWH_WpeditorButtons->load_script_config( $val, $val['id'] );
				}
			echo "\n</script>";
		});
	}
	
	
	/* register button */
	add_action('init', function() use( $DWH_WpeditorButtons, $button_sets ){
		$DWH_WpeditorButtons->register_button( $button_sets );
	});

}

/* End of wpeditor-buttons.php */
	
?>