<?php 
class widget_scroll extends WP_Widget {
	
	function __construct() {
		
		parent::__construct(
			'widget_scroll', 
			__('Scroll Down', 'basetheme'),
			array( 'description' => __( 'Add Scroll Arrow', 'basetheme' ), ) 
		);

	}

	public function widget( $args, $instance ) {
	
		global $DWH_Options;
		$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field( 'dwh_api_google_analytics', 0 );

		/* Check for GA info */
		if( $google_analytics_info )
		{
			$ga_code = isset( $google_analytics_info->ga_code ) && $google_analytics_info->ga_code!='' ? $google_analytics_info->ga_code : '';
			$ga_code2 = isset( $google_analytics_info->ga_code_2 ) && $google_analytics_info->ga_code_2!='' ? $google_analytics_info->ga_code_2 : '';
		}
		
		$onlickstr = "";
		if( $ga_code ){
		
			$onlickstr = 'onclick="_gaq.push([\'_trackEvent\', \'clickable-widget\', \'arrow-down\', \'bounce-arrow\']);';
			$onlickstr .= '_gaq.push([\'_trackEvent\', \'clickable-widget\', \'arrow-up\', \'bounce-arrow\'])"';
			
			/* if universal analytics */
			$gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
			$ga_onclick_event = $gtm_flag == 0 ? $onlickstr : '';
			
		}
		
		if($instance) extract($instance);
		
		$displayinfront = isset( $displayinfront ) ? $displayinfront : false;
		$caption 		= isset( $caption ) ? $caption : 'Discover';
		$content 		= 	'<div class="bounce-container">
								<div class="bounce">
									<a href="#?" class="bounce-arrow" '. $ga_onclick_event .'></a>
									<a class="bounce-caption" '. $ga_onclick_event .'>'. $caption .'</a>
								</div>
							</div>';

		if($displayinfront){
			if(is_front_page()) { 
				echo $content;
			}
		} else {
			echo $content;
		}

	}
	
	public function form( $instance ) {
		
		if($instance) extract($instance);
		$caption = isset($caption) ? $caption : '';
		$displayinfront = isset($displayinfront) ? $displayinfront : false;
		?>
		<div class="control-wrapper">
			<label for="<?php echo $this->get_field_id( 'caption' ); ?>"><?php _e( 'Caption:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'caption' ); ?>" name="<?php echo $this->get_field_name( 'caption' ); ?>" value="<?php echo esc_attr( $caption ); ?>"/>
		</div>		
		<div class="control-wrapper">
			<input class="checkbox" id="<?php echo $this->get_field_id( 'displayinfront' ); ?>" name="<?php echo $this->get_field_name( 'displayinfront' ); ?>" type="checkbox" value="<?php echo esc_attr($displayinfront); ?>" <?php echo ($displayinfront) ? 'checked' : null; ?>>
			<label for="<?php echo $this->get_field_id( 'displayinfront' ); ?>">Display in Front Page Only</label> 
		</div>
		<?php 
	}
		
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['caption'] = ( ! empty( $new_instance['caption'] ) ) ? $new_instance['caption'] : 'Discover';
		$instance['displayinfront'] = ( ! empty( $new_instance['displayinfront'] ) ) ? $new_instance['displayinfront'] : false;
		return $instance;
	}
}  
?>