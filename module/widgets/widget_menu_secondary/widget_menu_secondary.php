<?php 
class widget_menu_secondary extends WP_Widget {
	
	function __construct() {
		
		parent::__construct(
			'widget_menu_secondary', 
			__('Secondary Menu', 'basetheme'),
			array( 'description' => __( 'Add Secondary Menu Navigation', 'basetheme' ), ) 
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
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}
		
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
	
}  
?>