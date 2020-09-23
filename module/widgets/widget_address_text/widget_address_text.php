<?php 
class widget_address_text extends WP_Widget {
		
	public $view;

	function __construct() {
		
		parent::__construct(
			'widget_address_text', 
			__('Address', 'basetheme'),
			array( 'description' => __( 'Add Address', 'basetheme' ), ) 
		);

	}

	public function widget( $args, $instance ) {
		
		global $DWH_Data;
		$address_type = "";

		if( $instance )
		{
			$address_type = $instance['address_text_layout'];	
		}
		else
		{
			$address_type = 'inline';
		}

		$DWH_Data->get_hotel_address( $address_type , true , '' );
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