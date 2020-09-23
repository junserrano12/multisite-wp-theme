<?php 
extract($data);
global $DWH_Widget;
?>

<?php foreach( $form_fields as $key => $field ):?>
	<?php 
		$field_html = $DWH_Widget->get_form_field_element( $key , $field['properties'] );
		echo $field_html;
	?>
<?php endforeach;?>