<?php

if ( !function_exists( 'dwh_wponetheme_font_migration_upload' ) )
{
    function dwh_wponetheme_font_migration_upload()
    {

        $dir = get_template_directory().'/fonts';

        dwh_wponetheme_create_db_table_fonts();
        $font_names = dwh_wponetheme_fonts_file_directories( $dir );

        dwh_wponetheme_font_migrate( $font_names );

    }
}

if ( !function_exists( 'dwh_wponetheme_font_migrate' ) )
{
    function dwh_wponetheme_font_migrate( $array )
    {
        global $wpdb;
        $dwh_font_table = 'dwh_fonts';
        $internal_font  = get_option( 'dwh_fonts_internal' );
        $onetheme_fonts_migrated = get_option( 'onetheme_fonts_migrated' );

        if ( !$onetheme_fonts_migrated ) {

            for ( $x=0; $x<count( $array ); $x++ ) {

                $font = $array[$x];
                $fontname = trim( preg_replace( "/[^a-zA-Z0-9]/", " ", $font ) );
                $fontname = preg_replace( "/\s+/", "-", $fontname );

                $value_exist = $wpdb->get_row( "SELECT * FROM $dwh_font_table WHERE font_title = '$fontname' AND type = 'internal'", ARRAY_A );

                if ( null === $value_exist ) {

                    $fontname = sanitize_text_field( $fontname );
                    $wpdb->insert( $dwh_font_table, array( 'font_title' => $fontname,'type'=>'internal') );

                }
            }
        }

        update_option( 'onetheme_fonts_migrated', true );
    }
}

if ( !function_exists( 'dwh_wponetheme_fonts_file_directories' ) )
{
    function dwh_wponetheme_fonts_file_directories( $dir )
    {
        $array = array();
        if ( is_dir($dir) ){
            if ( $mydir = opendir($dir) ) {
                while ( ( $filedirectory = readdir( $mydir ) ) !== FALSE ) {
                    if ( count( glob( $dir."/$filedirectory/*" ) ) !== 0 && $filedirectory != '..' && $filedirectory != '.' ) {/*exclude empty folder*/
                        $array[] = trim( $filedirectory );
                    }
                }
                closedir($mydir);
            }
        }

        return $array;
    }
}

if ( !function_exists( 'dwh_wponetheme_create_db_table_fonts' ) )
{
    function dwh_wponetheme_create_db_table_fonts()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = 'dwh_fonts';
        if ( $wpdb->get_var( 'SHOW TABLES LIKE '.$table_name ) != $table_name ) {

            $sql = "CREATE TABLE $table_name (
                       font_id int(11) NOT NULL auto_increment,
                       font_title varchar(255) NOT NULL,
                       type ENUM('internal','external') NULL,
                       hotel_ids varchar(500) NULL,
                       date_created timestamp NOT NULL,
                       PRIMARY KEY  (font_id)
                    )";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );

        }
    }
}


/* get the css file inside the font upload directory */
if( !function_exists('dwh_get_internal_css_file') )
{
	function dwh_get_internal_css_file( $font_dir )
	{
		$dir = scandir($font_dir);
		$css_file = array();

		if( is_array($dir) ){
			foreach( $dir as $key=>$value ){
				$info = pathinfo($value);
				if( $info['extension'] == 'css' ){ /* get uploaded css file */
					$css_file[] = $value;
				}
			}
		}

		return $css_file;
	}

}


/* prepare internal fonts to be enqueue*/
if ( !function_exists( 'dwh_get_internal_fonts_style' ) )
{
	function dwh_get_internal_fonts_style()
	{
		$saved_fonts       = dwh_font_type_details('internal'); /* get the font saved from the options table */
		$hotel_ids_arr     = dwh_hotel_id(); /* current hotel ID */
		$internal_style    = array();

		if( is_array($saved_fonts) && count($saved_fonts) > 0 ){

			foreach( $saved_fonts as $fonts=>$name ){/*fonts saved in the options field: this is also the name of the folder located in the upload font directory*/
				/* upload font directory is 'wp-content/uploads/fonts' */

				/*retrieve fonts from dwh_fonts table*/
				$condition          = "font_title = '$name' AND type = 'internal'";
				$field_to_return    = 'hotel_ids';
				$specific_field_to_return = 'hotel_ids';
				$table_name         = 'dwh_fonts';
				$allowed_hotel_ids  = dwh_get_value_from_table( $table_name, $field_to_return, $condition, $specific_field_to_return);
				$allowed_hotel_ids  = trim($allowed_hotel_ids['hotel_ids']);

				$saved_fonts_global = false; /* fonts saved in the dwh_fonts table, if no fonts found it will consider as global */
				$compare_ids        = array(); /* prepare an array to hold hotel IDs  who is allowed to use the uploaded fonts */
				$fontname           = preg_replace( "/\s+/", "-", $name ); /*font name is also used as the folder name in the font upload directory*/
				$font_dir           = ABSPATH.'wp-content/uploads/fonts/'.$fontname; /* the font upload directory */

				/* if the hotel_ids column field in the dwh_fonts table is null or empty, it means that the font is accessible for all hotel website */
				if($allowed_hotel_ids == null || $allowed_hotel_ids == ''){
					$saved_fonts_global = true;
				}else{
					$allowed_hotel_ids_arr = explode(',',$allowed_hotel_ids); /*convert the hotel ids saved in the dwh_fonts table to array*/

					/* if the current hotel id is found from the hotel_ids field it means the font is allowed to be used for this hotel */
					$compare_ids = array_intersect($allowed_hotel_ids_arr, $hotel_ids_arr);
				}

				/* check if directory exists*/
				/* and check if this hotel has the right to use the font style */
				if( is_dir( $font_dir ) && (count($compare_ids) > 0 || $saved_fonts_global) ){

					$font_directory = ABSPATH.'wp-content/uploads/fonts/'.$fontname;
					$css_file = dwh_get_internal_css_file($font_directory);

					if( is_array($css_file) && count($css_file) > 0 ){
						foreach( $css_file as $fontkey=>$fontstyle){
							/* check file if exists*/
							if($fontstyle != '' && file_exists($font_directory.'/'.$fontstyle)){
								$internal_style[] = home_url().'/wp-content/uploads/fonts/'.$fontname.'/'.$fontstyle;
							}
						}
					}
				}
			}
		}

		return $internal_style; /* return absolute css file to enqueue */
	}
}

/* prepare external fonts to enqueue*/
if ( !function_exists( 'dwh_get_external_fonts_style' ) )
{
	function dwh_get_external_fonts_style()
	{
		$saved_fonts       = dwh_font_type_details('external'); /* get the font saved from the options table */
		$hotel_ids_arr     = dwh_hotel_id(); /* current hotel ID */
		$external_style    = array();

		if( is_array($saved_fonts) && count($saved_fonts) > 0 ){

			foreach( $saved_fonts as $fonts=>$link ){

				/*retrieve fonts from dwh_fonts table*/
				$condition          = "font_title = '$fonts' AND type = 'external'";
				$field_to_return    = 'hotel_ids';
				$specific_field_to_return = 'hotel_ids';
				$table_name         = 'dwh_fonts';
				$allowed_hotel_ids  = dwh_get_value_from_table( $table_name, $field_to_return, $condition, $specific_field_to_return);
				$allowed_hotel_ids  = trim($allowed_hotel_ids['hotel_ids']);

				$saved_fonts_global = false; /* fonts saved in the dwh_fonts table, if no fonts found it will consider as global */
				$compare_ids        = array(); /* prepare an array to hold hotel IDs  who is allowed to use the uploaded fonts */

				/* if the hotel_ids column field in the dwh_fonts table is null or empty, it means that the font is accessible for all hotel website */
				if($allowed_hotel_ids == null || $allowed_hotel_ids == ''){
					$saved_fonts_global = true;
				}else{
					$allowed_hotel_ids_arr = explode(',',$allowed_hotel_ids); /*convert the hotel ids saved in the dwh_fonts table to array*/

					/* if the current hotel id is found from the hotel_ids field it means the font is allowed to be used for this hotel */
					$compare_ids = array_intersect($allowed_hotel_ids_arr, $hotel_ids_arr);
				}

				/* check if this hotel has the right to use the font style */
				if( count($compare_ids) > 0 || $saved_fonts_global ){

					$external_style[] = dwh_get_href_attribute_from_tag( $link );
				}
			}
		}

		return $external_style; /* return the href value link to be enqueue */
	}
}

if( !function_exists('dwh_enqueue_fontstyle') )
{
	function dwh_enqueue_fontstyle($array,$type)
	{
		if( is_array($array) && count($array) > 0 ){
			$count = 0;
			foreach($array as $keys=>$fonts){
				$count++;
				wp_register_style($type.'-'.$count, $fonts);
				wp_enqueue_style($type.'-'.$count);
			}
		}
	}
}

if ( !function_exists( 'dwh_font_type_details' ) )
{
    function dwh_font_type_details($type)
    {
        $saved_fonts = dwh_get_data( 'fonts', 'onetheme_customizer_options' );
        $detail = array();
		if( is_array($saved_fonts) && count($saved_fonts) > 0 ){
			foreach( $saved_fonts as $fonts=>$details ){
				$font_type = $details['type'];
				if($font_type == $type && $type == 'internal'){
					$detail[] = $details['internal_name'];
				}elseif($font_type == $type && $type == 'external'){
					$detail[$details['external_name']] = $details['external_tag'];
				}
			}
		}
		return $detail;
    }
}
