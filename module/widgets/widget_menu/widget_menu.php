<?php 
class widget_menu extends WP_Widget {
	
	function __construct() {
		
		parent::__construct(
			'widget_menu', 
			__('Main Menu', 'basetheme'),
			array( 'description' => __( 'Add Main Menu Navigation', 'basetheme' ), ) 
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