<?php
/*
Function: Core Slider Class
*/

Class DWH_Slider
{
	
	public $post_type;


	function __construct() { 

		$this->post_type = array( 'page', 'promocentric', 'flashdeal' );

	}
	
	/* backend load scripts and styles */
	function initialize( $slider_name )
	{
		if( is_admin() )
		{
			$this->load_admin_scripts();
			$this->load_admin_styles();
		}

	}


	/*
	Render or load slider - front end rendering
	@param (array) - $param - slider parameters
	*/
	function render( $data ){
		
		$slider_name = $data['slider_name'];

		/* load styles */
		$this->load_frontend_styles( $slider_name );
		
		/* load view */
		load_view( $data );

	}

	
	function load_admin_scripts()
	{

		/* Admin scripts */
		if( is_admin() )
		{
			
			$site_scripts_global_dir = get_template_directory().'/module/sliders/base/admin/config/config.scripts.global.php'; 
			$config_scripts = array();
			if(file_exists($site_scripts_global_dir)) $config_scripts = include($site_scripts_global_dir);

			add_action('init',function() use ( $config_scripts ){

				foreach ($config_scripts as $key) {
		
					switch ($key['type']) {
						case 'api':
								wp_register_script($key['handle'],$key['src'],$key['deps'],$key['ver'],$key['in_footer']);
								wp_enqueue_script($key['handle'],$key['src'],$key['deps'],$key['ver'],$key['in_footer']);
							break;
						case 'local':
								wp_register_script($key['handle'],$key['src'],$key['deps'],$key['ver'],$key['in_footer']);
								wp_enqueue_script($key['handle'],$key['src'],$key['deps'],$key['ver'],$key['in_footer']);
							break;
						default:
								/* Wordpress script library */ 
								wp_enqueue_script($key['handle']);

							break;
					}

				}
				
			});

		
			$dir = get_template_directory().'/module/sliders/base/admin/js/';

			if( file_exists( $dir) )
			{	
				
				$dir_scan = scandir( $dir );

				foreach($dir_scan as $dir_item){	
				
					$handle = explode('.', $dir_item);
					$src = "";

					if($dir_item!='.'&& $dir_item!='..')
					{	 
						if($handle[1] === 'php') /* PHP Extension */
						{	
							$src_path = get_template_directory().'/module/sliders/base/admin/js/' . $dir_item;
							add_action('admin_footer', function() use ( $handle, $src_path ){
								include($src_path);
							});
						}
						else if($handle[1] === 'js') /* JS Extension */ 
						{		
							$src_url = get_template_directory_uri().'/module/sliders/'.$slider_name.'/admin/js/'.$dir_item;
							add_action( 'admin_footer', function() use ( $handle , $src_url ){
								wp_enqueue_script( $handle[0] , $src_url , '', '1.0', true );
							});

						}
					}
					
				}

			}
			
		}
	}
	
	function load_admin_styles()
	{
		/* Admin styles */
		if ( is_admin() ) {

			$site_styles_global_dir = get_template_directory().'/module/sliders/base/admin/config/config.styles.global.php'; 
			$site_styles_global_config = array();
			if(file_exists($site_styles_global_dir)) $site_styles_global_config = include($site_styles_global_dir);
			
			foreach ($site_styles_global_config as $key) {
				
				$type = $key['type'];
				switch( $type ){
					case 'api':
							/* enqueue default style */		
							add_action('admin_init', function() use( $key ){		
								wp_enqueue_style( $key['handle'], $key['src'], $key['deps'], $key['ver'] );
							});
						break;
					default:
							add_action('admin_footer',function() use( $key ){
								wp_enqueue_style( 'sliders-' .$key['handle'], $key['src'], $key['deps'], $key['ver'] );
							});
						break;
				}
			}

		}
		
	}
	

	/* Loads Front end scripts 
	   @param (string) - name of the slider - slider folder
	*/
	function load_frontend_scripts( $slider_name )
	{

		if( !is_admin() && $slider_name )
		{	
			
			/* add base js */
			$slider_scripts_global_dir = get_template_directory().'/module/sliders/'. $slider_name .'/config/config.scripts.php'; 
			$config_scripts = array();
			if(file_exists($slider_scripts_global_dir)) $config_scripts = include($slider_scripts_global_dir);

			add_action('init',function() use ( $config_scripts ){
			
				foreach ($config_scripts as $key) {
		
					switch ($key['type']) {
						case 'api':
								wp_register_script($key['handle'],$key['src'],$key['deps'],$key['ver'],$key['in_footer']);
								wp_enqueue_script($key['handle'],$key['src'],$key['deps'],$key['ver'],$key['in_footer']);
							break;
						case 'local':
								wp_register_script($key['handle'],$key['src'],$key['deps'],$key['ver'],$key['in_footer']);
								wp_enqueue_script($key['handle'],$key['src'],$key['deps'],$key['ver'],$key['in_footer']);
							break;
						default:
								/* Wordpress script library */ 
								wp_enqueue_script($key['handle']);

							break;
					}

				}

				
			});
		
			
			/* add scripts js */
			$dir = get_template_directory().'/module/sliders/'.$slider_name.'/js/';

			if( file_exists( $dir) )
			{	
				
				$dir_scan = scandir( $dir );

				foreach($dir_scan as $dir_item){
				
					$handle = explode('.', $dir_item);
					$src = "";

					if($dir_item!='.'&& $dir_item!='..')
					{	 
						if($handle[1] === 'php') /* PHP Extension */
						{	
							$src_path = get_template_directory().'/module/sliders/'.$slider_name.'/js/' . $dir_item;
							add_action('init', function() use ( $handle, $src_path ){
								include($src_path);
							});
						}
						else if($handle[1] === 'js') /* JS Extension */ 
						{		
							$src_url = get_template_directory_uri().'/module/sliders/'.$slider_name.'/js/'.$dir_item;
							wp_enqueue_script( $handle[0] , $src_url , '', '1.0', true );
						
						}
					}
					
				}

			}
			
		}
	}

	/* Loads Front end styles 
	   @param (string) - name of the slider - slider folder
	*/
	function load_frontend_styles( $slider_name )
	{
		
		if( !is_admin() && $slider_name )
		{
			global $DWH_Theme;
		
			/* add base css */
			$slider_styles_global_dir = get_template_directory().'/module/sliders/'. $slider_name .'/config/config.styles.php';
			$slider_styles_global_config = array();
			if(file_exists($slider_styles_global_dir)) $slider_styles_global_config = include($slider_styles_global_dir);

			foreach ( $slider_styles_global_config as $key ) {
					
					$src = $key['src'];
					if( DWH_SSL == true ) $src = $DWH_Theme->http_to_https( $src );
					
					wp_enqueue_style( 'sliders-style-' . $key['handle'], $src, $key['deps'], $key['ver'] );
				}
		
		}	
	}
	
	
	/* 
	* loop through sliders directory
	* exclude base folder
	*/
	function get_slider_list(){
		
		$dir = get_template_directory().'/module/sliders/';
		$slider_name_arr = array();
		
		if( file_exists( $dir) )
		{	
			
			$dir_scan = scandir( $dir );

			foreach($dir_scan as $dir_item)
			{	
				$handle = explode('.', $dir_item);

				if( $dir_item!='.' && $dir_item!='..' && $dir_item!='base' )
				{	 
					array_push( $slider_name_arr, $dir_item );
				}
				
			}

		}
		
		return $slider_name_arr;
		
	}
	
	
	/* 
	* return slider items list
	*/
	function get_slider_items_list( $folder, $items ){
		
		if( is_array( $items ) ){
		
			$slider_items = array();
			foreach( $items as $key => $val ){
				
				$slider_config = get_template_directory().'/module/sliders/'. $folder .'/config.slider.'. $val .'.php';
				if( file_exists($slider_config) ){
					$slider_items_config = include($slider_config);
					array_push( $slider_items, $slider_items_config );
				}
			}
			
			return $slider_items;
		}
		
	}
	
	
	function get_slider_settings_default(){
		
		$dir = get_template_directory().'/module/sliders/base/config.settings.php';

		$slider_settings_config = array();
		if( file_exists($dir) ) $slider_settings_config = include($dir);
		
		return $slider_settings_config;
		
	}

	
	
	/* Return Slider config 
	*  @param (string) - mode( 'slider name, slider type, all' )
	*/
	function get_slider_config( $mode = 'all', $items = array( 'image', 'map', 'iframe') ){
		
		switch( $mode ){
			
			case 'all':
					return $this->get_slider_items_list( 'base', $items );
					
				break;
			case 'slider-name':			
					return $this->get_slider_list();
					
				break;
				
			case 'slider-type':
			case 'slider-mode':
					$slider_type_arr = $this->get_slider_settings_default();					
					
					if( isset( $slider_type_arr[$mode] ) ){
						return $slider_type_arr[$mode];
					}
				break;
				
			default: break;
		
		}
	
	}
	
	
	function new_slider( $settings, $data, $mode = '' ){	
		
		$el_slider = '<div class="box">
								<h4> Slider Items </h4>
								<div class="form-header-slider">';
								
								if( $data ){
									
									$slider_count = count( $data['slider-item-type'] );
									
									for( $i = 0; $i < $slider_count; $i++ ){
										$el_slider .= $this->add_item( $settings, $data, $i );
										
									}
								}	
				
		$el_slider .= '  </div>
						<br clear="all">
						<a class="create-new-slider-row button-primary" data-mode="'. $mode .'" href="#">Add Slider Item</a>
					</div>';
		
		return $el_slider;
		
	}

	
	function add_item( $settings, $data, $ctr ){
	
		if( $settings  )
		{
			
			$slider_title = "Slider Item";
			$expireditem = '';
			
			if( $data ){
			
				$slider_title = $data['slider-item-title'][ $ctr ] != "" ? $data['slider-item-title'][ $ctr ] : $slider_title;
				
				$datenow = strtotime(date('d-M-Y'));
				$expiredate = $datenow;
				if( isset( $data['slider-item-expire'][ $ctr ] ) ){
					$expiredate = $data['slider-item-expire'][ $ctr ] != '' ? strtotime($data['slider-item-expire'][ $ctr ]) : $datenow;
				}
				
				$expireditem = $expiredate < $datenow ? 'item-expired' : '';
			
			}
			
			/* slider settings */
			$el_slider = '<div class="accordion-wrapper slider-group '. $expireditem .'">
								<a class="remove-slider-item" href="#">Remove</a>
								<h4 class="accordion-head">
									<span class="slider-item-title">'. $slider_title .'</span>
								</h4>
								<div class="accordion-content slider-item-wrapper">';
									
									if( $settings ){
										
										/* setup slider type */
										$el_slider .= $this->get_item_type( $settings, $data, $ctr );
										
										/* setup slider Fields */
										$el_slider .= $this->get_item_fields( $settings, $data, $ctr );
									
									}

			$el_slider .= '	</div>
						</div>';
			
			
			return $el_slider;

		}

	}


	function get_item_type( $settings, $field_value, $ctr, $mode = 'category', $field_key = null, $slider_settings = null ){
		
		if( $settings ){
			
			$slider_item = [];
			$itemtype_obj = [];
			$fieldvalue = '';
			
			$itemtype_obj['item_type'] = 'slider-item-type'; 	
				
			$el_slider = '<div class="radio-wrapper">';
							
								if( $mode == 'category' ){
									
									foreach( $settings as $key => $val ){
										
										$checked = '';
										
										if( $field_value ){
											$checked = $field_value[ $itemtype_obj['item_type'] ][ $ctr ] == $val['details']['category'] ? 'checked="checked"' : '';
										}
										elseif( $val['details']['category'] == 'slider' ){
											$checked = 'checked="checked"';
										}
										
										$itemtype_obj['checked'] = $checked;
										$itemtype_obj['name'] = 'item-type'. $ctr;
										$itemtype_obj['value'] = $val['details']['category'];
										$itemtype_obj['title'] = $val['details']['title'];
										$itemtype_obj['description'] = $val['details']['description'];
										$itemtype_obj['withclass'] = 'with-radio';
										
										$el_slider .= $this->get_item_type_markup( $itemtype_obj );
										
										if( $val['details']['category'] == 'slider' ){
											$slider_item = $val['settings'];
										}
										
									}
									
									/* load hidden field */
									if( $slider_item ){
										
										$fieldvalue = 'slider';
										
										if( $field_value ){
											$fieldvalue = $field_value[ $itemtype_obj['item_type'] ][ $ctr ];
										}

										$el_slider .= $this->get_field_type( $slider_item[ $itemtype_obj['item_type'] ], $itemtype_obj['item_type'], $fieldvalue, $ctr );
									
									}
									
								}
								
								else{
									
									if( $settings['selections'] ){
										
										foreach( $settings['selections'] as $key => $val ){
											
											$checked = '';
											
											if( $field_value ){
												$checked = $field_value[ $field_key ][ $ctr ] == $val['field_value'] ? 'checked="checked"' : '';
											}
											elseif( $slider_settings['details']['category'] == 'slider' ){
												$checked = 'checked="checked"';
											}
											
											$itemtype_obj['checked'] = $checked;
											$itemtype_obj['name'] = $val['field_name'] . $ctr;
											$itemtype_obj['value'] = $val['field_value'];
											$itemtype_obj['title'] = $val['field_title'];
											$itemtype_obj['description'] = $val['field_description'];
											$itemtype_obj['withclass'] = $val['class'];
											
											$el_slider .= $this->get_item_type_markup( $itemtype_obj );
											
										}
										
										/* load hidden field */
										if( $settings['properties'] ){
											
												if( $field_value ){
													$fieldvalue = $field_value[ $field_key ][ $ctr ];
												}
										
												$el_slider .= $this->get_field_type( $settings, $field_key, $fieldvalue, $ctr );
									
											}

									}

								}
								
			$el_slider .= '</div>';

			return $el_slider;
		
		}
		
	}


	function get_item_type_markup( $settings ){
		
		if( $settings ){
			
			$el_slider = '<div class="control-wrapper '. $settings['withclass'] .'">
								<label>
									<input type="radio" name="'. $settings['name'] .'" value="'. $settings['value'] .'" '. $settings['checked'] .'/> '. $settings['title'] .'
									<p class="description">'. $settings['description'] .'</p>
								</label>
							</div>';
		
			return $el_slider;
		
		}
		
	}



	function get_item_fields( $settings, $field_value, $ctr ){
		
		if( $settings ){
			
			$mode = '';
			$el_slider = '';
			
			foreach( $settings as $key => $val ){
				
				$category = $val['details']['category'];
				$display_mode = 'style="display:none"';
				
				switch( $category ){
					case 'slider':
							$mode = ' slider-wrap';
						break;
					case 'map': 
							$mode = ' map-wrap';
						break;
					case 'iframe':
							$mode = ' iframe-wrap';
						break;
				}
				
				
				if( $field_value ){
					if( $field_value['slider-item-type'][ $ctr ] == $category ){
						$display_mode = 'style="display:block"';
					}
				}
				
				
				
				$el_slider .= '<div class="slide-fields-wrapper'. $mode .'" '. $display_mode .'>';
					
					if( $val['settings'] ){
						$fieldvalue = '';
						
						foreach( $val['settings'] as $key1 => $val1 ){
							
							if( $key1 != 'slider-item-type' ){
							
								/* whitelist radio fields with radio */
								$fieldradio = array( 'slider-item-popup' );
								
								if( in_array( $key1, $fieldradio ) ){
									$el_slider .= $this->get_item_type( $val1, $field_value, $ctr, 'custom', $key1, $val );
								
								}
								else{
									
									if( $field_value ){
										if( isset( $field_value[ $key1 ] ) ){
											$fieldvalue = $field_value[ $key1 ][ $ctr ];
										}
									} 
									
									/* filter value */
									$filtervalue = array(
													'return_br2nl2' => array( 'slider-item-description' ),
													'htmlentities' => array( 'slider-item-overlaycontent' )
												);
									
									foreach( $filtervalue as $filter_key => $filter_val ){
										if( in_array( $key1, $filter_val ) ){
										
											$fieldvalue = call_user_func( $filter_key, $fieldvalue );
											break;
										}
									}
									
								
									$el_slider .= $this->get_field_type( $val1, $key1, $fieldvalue, $ctr, $field_value );
									
								}
								
							}
							
							
						}
						
					}
				
				$el_slider .= '</div>';
				
				
			}

			return $el_slider;
		
		}
		
	}

	
	
	function get_field_type( $field_settings, $field_name, $field_value, $ctr, $data = null ){
	
		$control_type = $field_settings['properties']['control_type'];
		$el_slider = '';
		$field_class = '';
		
		if( isset( $field_settings['properties']['class'] ) ){
			$field_class = 'class="'. $field_settings['properties']['class'] .'"';
		}
		
		switch( $control_type ){
			
			case 'text':
					
					$el_slider .= '<div class="control-wrapper">
										<label>'. $field_settings['properties']['field_title'] .'
											<input type="text" name="'. $field_name .'[]" '. $field_class .' value="'. $field_value .'" />
											<p class="description">'. $field_settings['properties']['field_description'] .'</p>
										</label>
									</div>';
					
				break;
				
			case 'textarea':
					
					$field_class1 = '';
					if( $field_settings['properties']['class'] ){
						$field_class1 = $field_settings['properties']['class'];
					}
					
					$field_class = 'class="button-secondary button-add-uploaded-media-item '. $field_class1 .'"';

					$el_slider .= '<div class="control-wrapper">
										<label>'. $field_settings['properties']['field_title'] .'
											<a href="#image_desc_editor_'. $ctr .'" '. $field_class .'>Add/Upload Media</a>
											<textarea row="8" col="4" id="image_desc_editor_'. $ctr .'" name="'. $field_name .'[]">'. $field_value .'</textarea>
											<p class="description">'. $field_settings['properties']['field_description'] .'</p>
										</label>
									</div>';
					
				break;
				
			case 'tag':

					$el_slider .= '<div class="control-wrapper">
										<label>'. $field_settings['properties']['field_title'] .'
											<textarea row="4" col="4" name="'. $field_name .'[]">'. $field_value .'</textarea>
											<p class="description">'. $field_settings['properties']['field_description'] .'</p>
										</label>
									</div>';
					
				break;
			
			case 'image':
					
					$imgsrc = get_template_directory_uri() . '/images/default-noimage-150x150.jpg';
					
					if( $data['slider-item-id'] ){
					
						$imgid = $data['slider-item-id'][ $ctr ];
						$img_srcarr = wp_get_attachment_image_src( $imgid, 'medium');
						
						if( $img_srcarr ) $imgsrc = $img_srcarr[0];
					}
					
					$el_slider .= '<div class="control-wrapper">
										<label>'. $field_settings['properties']['field_title'] .'
											<input type="text" name="'. $field_name .'[]" '. $field_class .' value="'. $field_value .'" />
										</label>
										<div class="slider-image-holder">
											<img src="'. $imgsrc .'" alt="" width="100px" height="100px" />
										</div>
										<a class="add-slider-item-image button-primary" href="#">Add Image</a>
									</div><br>';
									
				break;
			
			case 'hidden':
					
					$el_slider .= '<br clear="all">
								  <input type="hidden" name="'. $field_name .'[]" '. $field_class .' value="'. $field_value .'"/>';
				break;
				
			default: break;
		}
		
		return $el_slider;

	}


}	

?>