<?php 
class widget_logo extends WP_Widget {
	
	function __construct() {
		
		parent::__construct(
			'widget_logo', 
			__('Company Logo', 'basetheme'),
			array( 'description' => __( 'Add Company Logo', 'basetheme' ), ) 
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
		
	}
	
}  
?>