<?php 

class widget_social_media extends WP_Widget {

	function __construct() {

		parent::__construct(
			'widget_social_media', 
			__('Social Media', 'basetheme'),
			array( 'description' => __( 'Add Social Media Icons', 'basetheme' ),'test') 
		);

	}

	public function widget( $args, $instance) {
	
		global $DWH_Data;
		 $DWH_Data->get_links( get_class($this) , 'social_media' , '' );
	}
			
	public function form( $instance ) {


	}
		
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}	

?>