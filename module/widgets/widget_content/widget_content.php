<?php 
class widget_content extends WP_Widget {
	
	function __construct() {
		
		parent::__construct(
			'widget_content', 
			__('Content', 'basetheme'),
			array( 'description' => __( 'Add Content', 'basetheme' ), ) 
		);

	}

	public function widget( $args, $instance ) {

/*		$data['args'] = $args;
		$data['instance'] = $instance;
		$data['name'] = 'widget_content';
		$data['view'] = 'widget_content';

		load_view('widgets',$data);
*/
		if($instance) extract($instance);
		$content = isset($content) ? $content : '';
		$displayinfront = isset($displayinfront) ? $displayinfront : false;

		if($displayinfront){
			if(is_front_page()) { 
				echo _process_custom_content($content);
			}
		} else {
			echo _process_custom_content($content);
		}

	}
	
	public function form( $instance ) {
		
		if($instance) extract($instance);
		$content = isset($content) ? $content : '';
		$displayinfront = isset($displayinfront) ? $displayinfront : false;
		?>
		<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e( 'Content:' ); ?></label> 
		<textarea class="textarea-editor widefat" rows="5" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>"><?php echo esc_attr( $content ); ?></textarea>
		<a href="#<?php echo $this->get_field_id( 'content' ); ?>" class="button button-upload-media-item">Add/Upload Media</a>
		<div class="control-wrapper">
			<input class="checkbox" id="<?php echo $this->get_field_id( 'displayinfront' ); ?>" name="<?php echo $this->get_field_name( 'displayinfront' ); ?>" type="checkbox" value="<?php echo esc_attr($displayinfront); ?>" <?php echo ($displayinfront) ? 'checked' : null; ?>>
			<label for="<?php echo $this->get_field_id( 'displayinfront' ); ?>">Display in Front Page Only</label> 
		</div>
		<?php 
	}
		
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['content'] = ( ! empty( $new_instance['content'] ) ) ? $new_instance['content'] : '';
		$instance['displayinfront'] = ( ! empty( $new_instance['displayinfront'] ) ) ? $new_instance['displayinfront'] : false;
		return $instance;
	}
}  
?>