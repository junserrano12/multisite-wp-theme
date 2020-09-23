<?php 

class widget_ga_translate extends WP_Widget {

	function __construct() {

		parent::__construct(
			'widget_ga_translate', 
			__('Google Translate', 'basetheme'),
			array( 'description' => __( 'Add Google Translate', 'basetheme' ), ) 
		);

	}

	public function widget( $args, $instance ) {
	
		$data['args'] = $args;
		$data['instance'] = $instance;
		$data['dir'] = array('module/widgets', get_class($this) , 'views');
		$data['view'] = get_class($this);
		load_view( $data );
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