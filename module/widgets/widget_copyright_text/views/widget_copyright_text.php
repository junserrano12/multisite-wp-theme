<?php

if( $data )
{	
	$site_copyright_text = "";
	extract($data);

	if($form_instance){
		extract($form_instance);
		$site_copyright_text = $form_instance['site_copyright_text'];
	}
	else{
		$site_copyright_text = $form_fields['site_copyright_text']['properties']['field_value'];
	}
}

?>
<p class="small"> <?php echo esc_html( $site_copyright_text ); ?></p>		

