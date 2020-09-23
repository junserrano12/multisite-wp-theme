<?php 
class widget_cta extends WP_Widget {


	function __construct() {
		
		parent::__construct(
			'widget_cta', 
			__('Cta', 'basetheme'),
			array( 'description' => __( 'Add Cta Button', 'basetheme' ), ) 
		);

	}

	public function widget( $args, $instance ) 
	{	
		global $DWH_Data;

		$DWH_Data->get_cta_widget();

	}
			
	public function form( $instance ) {
		
	}
		
	public function update( $new_instance, $old_instance ) {

		global $DWH_Widget;

		$instance 		= array();
		$form_fields 	= $DWH_Widget->get_form_fields( get_class($this) );

		foreach ($data['form_fields'] as $key => $value) {
			 $field_name = $form_fields[$key]['properties']['field_name'];
			 $new_instance[$field_name] = isset(  $new_instance[$field_name] ) ?  $new_instance[$field_name] : '';
		}

		return $new_instance;
	}
}
?>