<?php 
class widget_slider extends WP_Widget {
	
	public $slider;
	public $custom_field_set;
	public $custom_field_item;
	
	function __construct() {
		
		parent::__construct(
			'widget_slider', 
			__('Feature Slider', 'basetheme'),
			array( 'description' => __( 'Add Feature Slider', 'basetheme' ), ) 
		);

	}

	public function widget( $args, $instance ) {
	
		global $DWH_Data;

		$DWH_Data->get_slider();

	}
	
	public function form( $instance ) {
		
	}
		
	public function update( $new_instance, $old_instance ) {
		
	}
	
}
?>