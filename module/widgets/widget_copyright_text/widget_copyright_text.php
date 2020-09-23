<?php 
class widget_copyright_text extends WP_Widget {
	
	function __construct() {
		
		parent::__construct(
			'widget_copyright_text', 
			__('Copyright', 'basetheme'),
			array( 'description' => __( 'Add Copyright', 'basetheme' ), ) 
		);

	}

	public function widget( $args, $instance ) {
		global $DWH_Widget;
		$data['args'] = $args;
		$data['form_instance']  = $instance;
		$data['form_fields'] = $DWH_Widget->load_form_fields( $this , $data );
		$data['dir'] = array('module/widgets', get_class($this) , 'views');
		$data['view'] = get_class($this);
		load_view( $data );
	}
	
	public function form( $instance ) {
		
		global $DWH_Widget;
		$data['form_instance']  = $instance;
		$data['form_options'] = get_dwh_option( 'widget_'.get_class($this) );
		$data['form_fields'] = $DWH_Widget->load_form_fields( $this , $data );
		$data['dir'] = array('module/widgets/', get_class($this) , 'admin/views');
		$data['view'] = get_class($this);
		$DWH_Widget->load_form_settings( $data );

	}
		
	public function update( $new_instance, $old_instance ) {
		
		global $DWH_Widget;

		$instance = array();
		$form_fields = $DWH_Widget->get_form_fields( get_class($this) );

		foreach ($data['form_fields'] as $key => $value) {
			 $field_name = $form_fields[$key]['properties']['field_name'];			
			 $new_instance[$field_name] = isset(  $new_instance[$field_name] ) ?  $new_instance[$field_name] : '';
		}

		return $new_instance;
	}
}  
?>