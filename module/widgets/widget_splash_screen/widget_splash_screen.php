<?php

class widget_splash_screen extends WP_Widget {

	function __construct() {

		parent::__construct(
			'widget_splash_screen', 
			__('Splash Page', 'basetheme'),
			array( 'description' => __( 'Add Splash Page', 'basetheme' ), ) 
		);

		
	}

	public function widget( $args, $instance ) {
		

		/* 1st level - detect if not disable*/	
		if($instance['disable'] == 'no'){
			
			$handle = 'widget_splash_screen';
			$base_path = str_replace('\\', '/',TEMPLATEPATH).'/module/widgets/'.$handle.'/js/'.$handle.'.js';
			$src = get_template_directory_uri().'/module/widgets/'.$handle.'/js/'.$handle.'.js';
			$version = '';
			$in_footer = true;

			$data['args'] = $args;
			$data['instance'] = $instance;
			$data['name'] = 'widget_splash_screen';
			$data['dir'] = array('module/widgets', get_class($this) , 'views');
			$data['view'] = 'view_front';
			
				/* 2nd level*/
				if($instance['show_inner_pages'] == 'yes'){
					load_view( $data );
				}
				else{
					if(is_front_page() || is_home()) load_view( $data );
				}

			
			if(file_exists($base_path))
			{	
				wp_register_script($handle,$src,'',$version,$in_footer);
				wp_enqueue_script($handle,$src,'',$version,$in_footer);
			}
		
		}
		
	}

	public function form( $instance ) {
	
	
		if($instance) extract($instance);
			
		$data['title'] = isset($title) ? $title : 'Title';
		$data['content'] = isset($content) ? $content : '';
		$data['disable'] = isset($disable) ? $disable : 'no';
		$data['show_only_once'] = isset($show_only_once) ? $show_only_once : 'no';
		$data['show_inner_pages'] = isset($show_inner_pages) ? $show_inner_pages : 'no';
		$data['field_ids'] = array( 
								'title' => array('id' => $this->get_field_id('title'),'name' => $this->get_field_name( 'title' )),
								'content' => array('id' => $this->get_field_id('content'),'name' => $this->get_field_name( 'content' )),
								'disable' => array('id' => $this->get_field_id('disable'),'name' => $this->get_field_name( 'disable' )),
								'show_only_once' => array('id' => $this->get_field_id('show_only_once'),'name' => $this->get_field_name( 'show_only_once' )),
								'show_inner_pages' => array('id' => $this->get_field_id('show_inner_pages'),'name' => $this->get_field_name( 'show_inner_pages' ))
							);
		$data['instance'] = $instance;
		$data['dir'] = array('module/widgets', get_class($this) , 'views');
		$data['view'] = 'view_form';
		load_view( $data );

	}
		
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? $new_instance['title'] : '';
		$instance['content'] = ( ! empty( $new_instance['content'] ) ) ? $new_instance['content'] : '';
		$instance['disable'] = ( ! empty( $new_instance['disable'] ) ) ? $new_instance['disable'] : 'no';
		$instance['show_only_once'] = ( ! empty( $new_instance['show_only_once'] ) ) ? $new_instance['show_only_once'] : 'no';
		$instance['show_inner_pages'] = ( ! empty( $new_instance['show_inner_pages'] ) ) ? $new_instance['show_inner_pages'] : 'no';
		return $instance;
	}
}

?>