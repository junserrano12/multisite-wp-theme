<?php

	/* Autoload Ajax Functions */
	$dir = get_template_directory().'/module/ajax';

	/* Check if the ajax directory exists */
	if(file_exists( $dir ))
	{
		$dir_scan = scandir( $dir );

		/* Loop through the widgets directory */
		foreach($dir_scan as $dir_item)
		{
			if($dir_item!='.'&& $dir_item!='..')
			{
				$filename = $dir .'/'. $dir_item;

				$action_name = explode( '.php', $dir_item );
				$action_name = $action_name[0];

				if( file_exists( $filename ) )
				{
					add_action( 'wp_ajax_'.$action_name, function() use( $filename ){

						include( $filename );

					});
				}

			}
		}

	}