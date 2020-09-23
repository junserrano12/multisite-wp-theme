<?php
check_ajax_referer( 'dwh-upload-fonts', 'security-nonce' );
// $data = $_POST['data'];

global $wpdb;

$valid_formats    = array("jpg", "gif", "png", "css", "eot", "svg", "ttf", "woff", "woff2", "txt"); /* Supported file types */
$max_file_size    = 1024 * 500; /* in kb */
$max_image_upload = 10;
$upload_directory = ABSPATH.'wp-content/uploads/fonts/';
$count          = 0;
$dwh_font_table = 'dwh_fonts';
$class_err      = '';
$result         = array();
$upload_message = array();
$error          = true;


if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
    $countUpload = $_POST['counter'];
    $font_tile   = $_POST['title'];
    $hotels      = $_POST['hotels'];
    $font_dir    = preg_replace( "/\s+/", "-", $font_tile );
    $font_dir    = trim( $font_dir );
    $patternA    = "/^[a-zA-Z0-9- ]+$/";
    $patternB    = "/^[0-9, ]+$/";

    $font_exists      = $wpdb->get_results( "SELECT font_id FROM $dwh_font_table WHERE font_name = '$font_tile'" ); /* //check title if exist */
    $font_directory   = $upload_directory.$font_dir;

    if ( !preg_match( $patternA, $font_dir ) ) {
        $upload_message[] = "Font title must not be empty.";
        dwh_delete_font_directory( $font_directory );
        $class_err = 'font-title';
    } else if ( !preg_match( $patternB,$hotels ) && $hotels != '' ) {
        $upload_message[] = "Invalid input found in Hotel IDs field";
        $class_err = 'hotel-ids';
        dwh_delete_font_directory( $font_directory );
    } else if ( !dwh_upload_font_dir_is_empty( $font_directory ) && ( count( $font_exists ) > 0 || is_dir( $upload_directory.$font_dir ) ) ) { /* //already exists but folder is empty */
        $upload_message[] = "Font title already exist";
        dwh_delete_font_directory( $font_directory );
        $class_err = 'font-title';
    } else if ( $countUpload > $max_image_upload ) {
        $upload_message[] = "Sorry you can only upload " . $max_image_upload . " maximum file at a time";
        dwh_delete_font_directory( $font_directory );
        $class_err = 'files-data';
    } else if ( $countUpload == 0 ) {
        $upload_message[] = "Oops! please select font to upload";
        dwh_delete_font_directory( $font_directory );
        $class_err = 'files-data';
    } else {
        $error = false;
    }

    if( !$error ){
        if ( !is_dir( $upload_directory ) ) {
            mkdir( $upload_directory, 0775 );
        }

        if ( !is_dir( $font_directory ) ) {
            if ( preg_match( $patternA,$font_dir ) ) {
                mkdir( $font_directory, 0775 );
            }
        }

        foreach ( $_FILES['files']['name'] as $f => $name ) {
            $filename  = pathinfo( $name );
            $extension = pathinfo( $name, PATHINFO_EXTENSION );
            $fName     = $filename['filename'];

            $full_filename = $fName .'.' . $extension;

            if ( $_FILES['files']['error'][$f] == 4 ) {
                continue;
            }

            if ( $_FILES['files']['error'][$f] == 0 ) {
                /*  // Check if image size is larger than the allowed file size  */
                if ( $_FILES['files']['size'][$f] > $max_file_size ) {
                    $upload_message[] = "$name is too large!.";
                    continue;

                 /* // Check if the file being uploaded is in the allowed file types */
                }  else if ( ! in_array( strtolower( $extension ), $valid_formats ) ) {
                    $upload_message[] = "$name is not a valid format";
                    continue;

                } else {
                   /*  // If no errors, upload the file  */
                    if ( move_uploaded_file( $_FILES["files"]["tmp_name"][$f], $font_directory.'/'.$full_filename ) ) {
                        $count++;
                    } else {
                        $upload_message[] = "Server error, refresh the page and sleep ".$font_directory.'/'.$full_filename;
                    }
                }
            }
        }

    }

}

if ( isset( $upload_message ) ) {
    foreach ( $upload_message as $msg ){
        $result = array( 'message'=>'<p class="font-upload-error-msg">'.$msg.'</p>', 'class_err' => $class_err );
    }
}

/* If no error, show success message and save the title in the database */
if ( $count != 0 ) {
    $wpdb->insert( $dwh_font_table, array( 'font_title' => $font_tile, 'type'=>'internal', 'hotel_ids'=>$hotels ) );
    $suc_msg = $count > 1 ? ' files uploaded successfully!' : ' file uploaded successfully!';
    $result  = array( 'message'=>'<p class = "font-upload-success-msg">'.$count.$suc_msg.'</p>', 'class_err' => '' );
}

echo json_encode( $result );

wp_die();