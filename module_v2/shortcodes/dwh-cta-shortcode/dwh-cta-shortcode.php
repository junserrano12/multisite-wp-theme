<?php

if ( !function_exists( 'dwh_cta_shortcode' ) )
{
	function dwh_cta_shortcode( $atts )
	{
		ob_start();
		dwh_cta( $atts );
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}

if ( !function_exists( 'dwh_cta' ) )
{
	function dwh_cta( $atts, $return = false )
	{
		global $DWH_wponetheme_cta;

		$DWH_wponetheme_cta->counter = $DWH_wponetheme_cta->counter + 1;

		$ctaconfig  = dwh_cta_config();
		$hashotelid = ( dwh_empty( $ctaconfig->hotelsingle['hotel_id'] ) && $ctaconfig->type != 'corpsite' ) || ( dwh_empty( $ctaconfig->hotelgroup[0]['hotel_id'] ) && $ctaconfig->type == 'corpsite' );

		wp_enqueue_script( 'jquery-ui-datepicker' );

		if ( $hashotelid ) {
			$pattern = array(
							'/\[cta_select_properties\]/',
							'/\[cta_button\]/',
							'/\[cta_modify_cancel\]/',
							'/\[cta_calendar(\]|[\s\w]*[placeholder|multiview][\s\w]*\])/',
							'/\[cta_promocode(\]|[\s\w]*placeholder[\s\w]*\])/',
							'/\[cta_mobile_button\]/',
							'/\[cta_bpg_terms\]/',
							'/\[cta_bpg_title\]/'
						);
			$replace = array(
							dwh_cta_select_properties_view( $ctaconfig ),
							dwh_cta_button_view( $ctaconfig ),
							dwh_modify_cancel_view( $ctaconfig ),
							dwh_calendar_view( $ctaconfig ),
							dwh_promocode_view( $ctaconfig ),
							dwh_cta_button_mobile_view( $ctaconfig ),
							dwh_cta_bpg_terms_view( $ctaconfig ),
							dwh_cta_bpg_title_view( $ctaconfig )
						);

			$content = preg_replace( $pattern, $replace, $ctaconfig->content );
		} else {
			$content = '<div id="cta-container"><p class="cta-warning" style="color:red; position:relative; text-align:center; z-index:999;">Add Hotel ID to Display CTA</p></div>';
		}

		if ( $return ) return $content;
		echo $content;
	}
}

if ( !function_exists( 'dwh_localize_cta_shortcode_scripts' ) )
{
	add_action( 'wp_head', 'dwh_localize_cta_shortcode_scripts' );
	function dwh_localize_cta_shortcode_scripts()
	{
		$theme_option_object = dwh_cta_config( true );
		unset( $theme_option_object['content'] );
		unset( $theme_option_object['bpg_tips'] );
		unset( $theme_option_object['bpg_terms'] );
		$theme_option_objects = array( 'objects' => $theme_option_object );
		wp_localize_script( 'global', 'theme_option_objects', $theme_option_objects );
	}
}

function dwh_cta_config( $isarray = false )
{
	$device 	 						= dwh_detect_device();

	$date_format 						= ( $device->phone ) ? 'Y-m-d' : 'd M Y'; //get_option( 'date_format' );
	$time_format 						= 'Y-m-d'; //get_option( 'time_format' );

	$ctaconfig['url'] 					= dwh_get_config( 'config.cta.links', 'json' );
	$ctaconfig['base_url']				= $ctaconfig['url']->base_url.$ctaconfig['url']->base_url_dir;

	$ctaconfig['content']				= dwh_empty( dwh_get_data( 'cta-layout', 'onetheme_customizer_options' ) ) ? dwh_get_data( 'cta-layout', 'onetheme_customizer_options' ) : '<div id="cta-container"><h3 class="cta-title">Easy booking at Low Rates</h3>[cta_select_properties][cta_calendar][cta_button][cta_promocode]<div class="cta-moc-wrapper control-wrapper">[cta_modify_cancel] your reservation</div></div>';
	$ctaconfig['type'] 					= dwh_empty( dwh_get_data( 'type', 'onetheme_hotel_options' ) ) ? dwh_get_data( 'type', 'onetheme_hotel_options' ) : 'single';
    $ctaconfig['hotelsingle']           = dwh_empty( dwh_get_data( 'hotel-single', 'onetheme_hotel_options' ) ) ? dwh_get_data( 'hotel-single', 'onetheme_hotel_options' ) : false;
	$ctaconfig['hotelgroup'] 			= dwh_empty( dwh_get_data( 'hotel-group', 'onetheme_hotel_options' ) ) ? dwh_get_data( 'hotel-group', 'onetheme_hotel_options' ) : false;

	$labels								= dwh_empty( dwh_get_data( 'cta-label', 'onetheme_customizer_options' ) ) ? dwh_get_data( 'cta-label', 'onetheme_customizer_options' ) : null;
    $ctaconfig['button']                = isset( $labels['cta_button'] ) && dwh_empty( $labels['cta_button'] ) ? $labels['cta_button'] : 'Check Availability and Prices';
    $ctaconfig['link']                  = isset( $labels['cta_link'] ) && dwh_empty( $labels['cta_link'] ) ? $labels['cta_link'] : 'Check Availability and Prices';
    $ctaconfig['moc']                   = isset( $labels['cta_modify_cancel'] ) && dwh_empty( $labels['cta_modify_cancel'] ) ? $labels['cta_modify_cancel'] : 'Modify or Cancel';
    $ctaconfig['datefromlabel']         = isset( $labels['cta_calendar_arrival'] ) && dwh_empty( $labels['cta_calendar_arrival'] ) ? $labels['cta_calendar_arrival'] : 'Check In';
    $ctaconfig['datetolabel']           = isset( $labels['cta_calendar_departure'] ) && dwh_empty( $labels['cta_calendar_departure'] ) ? $labels['cta_calendar_departure'] : 'Check Out';
    $ctaconfig['promocodelabel']        = isset( $labels['cta_promocode'] ) && dwh_empty( $labels['cta_promocode'] ) ? $labels['cta_promocode'] : 'Promo Code';
    $ctaconfig['selectoption']          = isset( $labels['cta_select_option'] ) && dwh_empty( $labels['cta_select_option'] ) ? $labels['cta_select_option'] : 'Choose a Property';

	$bpg								= dwh_empty( dwh_get_data( 'cta-bpg', 'onetheme_customizer_options' ) ) ? dwh_get_data( 'cta-bpg', 'onetheme_customizer_options' ) : null;
    $ctaconfig['bpg_title'] 			= isset( $bpg['bpg_title'] ) ? $bpg['bpg_title'] : 'Best Price Guarantee';
	$ctaconfig['bpg_tips'] 				= isset( $bpg['bpg_tips'] ) ? $bpg['bpg_tips'] : '';
	$ctaconfig['bpg_terms'] 			= isset( $bpg['bpg_terms'] ) ? $bpg['bpg_terms'] : '';

	$ctaconfig['datefrom'] 				= date( "{$time_format}", current_time( 'timestamp' ) );
	$ctaconfig['dateto']				= date( "{$time_format}", current_time( 'timestamp' ) + DAY_IN_SECONDS );

	$ctaconfig['readabledatefrom'] 		= date( "{$date_format}", current_time( 'timestamp' ) );
	$ctaconfig['readabledateto']		= date( "{$date_format}", current_time( 'timestamp' ) + DAY_IN_SECONDS );

	$ctaconfig['mindate'] 				= date( "{$date_format}", current_time( 'timestamp' ) );
	$ctaconfig['maxdate']				= date( "{$date_format}", current_time( 'timestamp' ) + YEAR_IN_SECONDS + 30 * DAY_IN_SECONDS );

	$ctaconfig['has_calendar'] 			= ( strpos( $ctaconfig['content'], 'cta_calendar' ) !== false ) ? true : false;
	$ctaconfig['has_promocode'] 		= ( strpos( $ctaconfig['content'], 'cta_promocode' ) !== false ) ? true : false;
	$ctaconfig['calendar_placeholder'] 	= ( strpos( dwh_get_cta_config_content( dwh_get_data( 'cta-container', 'dwh_cta_option' ), 'cta_calendar' ), 'placeholder' ) !== false ) ? true : false;
	$ctaconfig['calendar_multiview'] 	= ( strpos( dwh_get_cta_config_content( dwh_get_data( 'cta-container', 'dwh_cta_option' ), 'cta_calendar' ), 'multiview' ) !== false ) ? true : false;
	$ctaconfig['promocode_placeholder'] = ( strpos( dwh_get_cta_config_content( dwh_get_data( 'cta-container', 'dwh_cta_option' ), 'cta_promocode' ), 'placeholder' ) !== false ) ? true : false;

	if ( $ctaconfig['type'] === 'single' && $ctaconfig['hotelsingle'] ) {
		$ctaconfig['base_url']			= ( $ctaconfig['hotelsingle']['hotel_subdomain'] ) ? $ctaconfig['hotelsingle']['hotel_subdomain'].$ctaconfig['url']->base_url_dir : $ctaconfig['base_url'];
	}

	if ( $ctaconfig['type'] === 'corpsite' && $ctaconfig['hotelgroup'] ) {
		$ctaconfig['ibe_urls']['select'] = $ctaconfig['url']->base_url.$ctaconfig['url']->base_url_dir;
		foreach( $ctaconfig['hotelgroup'] as $key => $hotel ) {
			$ibe_url = ( $hotel['hotel_subdomain'] ) ? $hotel['hotel_subdomain'] : $ctaconfig['url']->base_url;
			$ctaconfig['ibe_urls'][$hotel['hotel_id']] = $ibe_url.$ctaconfig['url']->base_url_dir;
			$ctaconfig['hotel_languages'][$hotel['hotel_id']] = $hotel['hotel_language'];
		}
	}

	if ( $ctaconfig['type'] === 'corpsite' && $ctaconfig['hotelgroup'] ) {
		$ctaconfig['default_hotel_id'] 			= $ctaconfig['hotelgroup'][0]['hotel_id'];
		$ctaconfig['default_hotel_language'] 	= isset( $ctaconfig['hotelgroup'][0]['hotel_language'] ) ? $ctaconfig['hotelgroup'][0]['hotel_language'] : 'en' ;
	} else {
		$ctaconfig['default_hotel_id'] 			= $ctaconfig['hotelsingle']['hotel_id'];
		$ctaconfig['default_hotel_language'] 	= isset( $ctaconfig['hotelsingle']['hotel_language'] ) ? $ctaconfig['hotelsingle']['hotel_language'] : 'en';
	}


	if ( $isarray ) {
		return $ctaconfig;
	} else {
		return (object)$ctaconfig;
	}
}

function dwh_get_cta_config_content( $content, $pattern )
{
	preg_match_all( '/(\['.$pattern.'[\d\s\w]*\])/', $content, $matches );

	$content = ( isset( $matches[0][0] ) ) ? $matches[0][0] : $content;

	return $content;
}

function dwh_cta_select_properties_view( $ctaconfig )
{
	if ( $ctaconfig->hotelgroup && $ctaconfig->type == 'corpsite' ) {

		$class 	  = ( dwh_get_theme_template() === 'v1' ) ? ' cta-calendar-container' : '';

		$output	  = '<div class="control-wrapper cta-select-wrapper'.$class.'">';
		$output  .= '	<div class="input-container">';
		$output  .= '		<select class="input-field cta-select-property">';
		if ( $ctaconfig->selectoption )
		$output  .= '			<option value="select">'.$ctaconfig->selectoption.'</option>';

		foreach ( $ctaconfig->hotelgroup as $hotel ) {
		$output  .= '			<option value="'.$hotel['hotel_id'].'">'.$hotel['hotel_name'].'</option>';
		}
		$output  .= '		</select>';
		$output  .= '	</div>';
		$output  .= '</div>';
		return $output;
	}
}

function dwh_cta_button_mobile_view( $ctaconfig )
{
	/*default language for hotel button only*/
	$default_language = ( $ctaconfig->default_hotel_language == 'en' ) ? '' : $ctaconfig->default_hotel_language.'/';

	$dwhreservationurl  = $ctaconfig->base_url;
	$dwhreservationurl .= ( !$ctaconfig->has_calendar ) ? $ctaconfig->url->calendar.$ctaconfig->hotelsingle['hotel_id'].'/'.$ctaconfig->datefrom.'/'.$ctaconfig->dateto.$default_language.$ctaconfig->url->param_1 : $ctaconfig->url->default.$ctaconfig->default_hotel_id.$default_language;

	$output	 	 = '<div class="control-wrapper cta-mobile-button-wrapper">';
	$output 	.= '	<a href="'.$dwhreservationurl.'" class="cta-button cta-mobile-button">'.$ctaconfig->button.'</a>';
	$output 	.= '</div>';

	return $output;
}

function dwh_cta_button_view( $ctaconfig )
{

	$default_hotel_id = ( $ctaconfig->type === 'corpsite' ) ? 'select' : $ctaconfig->default_hotel_id;
	$default_language = ( $ctaconfig->default_hotel_language === 'en' ) ? '' : $ctaconfig->default_hotel_language.'/';
	$default_class    = ( dwh_get_theme_template() === 'v1' ) ? ' cta-button-container' : null;

	$dwhreservationurl  = $ctaconfig->base_url;

	if ( $ctaconfig->has_calendar ) {

		$dwhreservationurl .= $ctaconfig->url->calendar;
		$dwhreservationurl .= $default_hotel_id.'/';

		/*promocode*/

		$dwhreservationurl .= $ctaconfig->datefrom.'/';
		$dwhreservationurl .= $ctaconfig->dateto.'/';

	} else {

		$dwhreservationurl .= $default_hotel_id.'/';

	}

	$dwhreservationurl .= $default_language;

	$output	 	 = '<div class="control-wrapper cta-button-wrapper'.$default_class.'">';
	$output 	.= '	<a href="'.$dwhreservationurl.'" class="cta-button button">'.$ctaconfig->button.'</a>';
	$output 	.= '</div>';

	return $output;
}

function dwh_modify_cancel_view( $ctaconfig )
{
	$default_language  = ( $ctaconfig->default_hotel_language === 'en' ) ? '' : $ctaconfig->default_hotel_language.'/';
	$dwhreservationurl = $ctaconfig->base_url.$ctaconfig->url->moc.$ctaconfig->default_hotel_id.'/'.$default_language;
	$output            = '<a href="'.$dwhreservationurl.'" class="cta-modify-cancel-link ctamodify">'.$ctaconfig->moc.'</a>';
	return $output;
}

function dwh_calendar_view( $ctaconfig )
{
	global $DWH_wponetheme_cta;

	$device      = dwh_detect_device();
	$counter     = ( $DWH_wponetheme_cta->counter > 1 ) ? $DWH_wponetheme_cta->counter : null;
	$ie9andbelow = ( $device->browser === 'ie9' || $device->browser === 'ie8' || $device->browser === 'ie7' );

	$labelclass     = ( dwh_get_theme_template() === 'v1' ) ? 'calendar-label' : 'input-label';
	$containerclass = ( dwh_get_theme_template() === 'v1' ) ? 'calendar-input' : 'input-container';
	$inputclass     = ( dwh_get_theme_template() === 'v1' ) ? ' text_reserve' : '';

	// $fromvalue 	 = ( $ctaconfig->calendar_placeholder && !$ie9andbelow ) ? 'placeholder="'.$ctaconfig->datefromlabel.'"' : 'value="'.$ctaconfig->readabledatefrom.'"';
	// $tovalue 	 = ( $ctaconfig->calendar_placeholder  && !$ie9andbelow ) ? 'placeholder="'.$ctaconfig->datetolabel.'"' : 'value="'.$ctaconfig->readabledateto.'"';
	$fromvalue 	 = ( $ctaconfig->calendar_placeholder && !$ie9andbelow ) ? 'placeholder="'.$ctaconfig->datefromlabel.'"' : 'value=""';
	$tovalue 	 = ( $ctaconfig->calendar_placeholder  && !$ie9andbelow ) ? 'placeholder="'.$ctaconfig->datetolabel.'"' : 'value=""';

	$output	 	 = '<div class="control-wrapper cta-calendar-wrapper">';
	if ( dwh_empty( $ctaconfig->datefromlabel ) && !$ctaconfig->calendar_placeholder || $ie9andbelow )
	$output 	.= '	<span class="'.$labelclass.'">'.$ctaconfig->datefromlabel.'</span>';
	$output 	.= '	<div class="'.$containerclass.'">';
	$output 	.= '		<input class="cta-arrival-date'.$inputclass.'" id="arrival_date'.$counter.'" name="arrival" '.$fromvalue.' type="text" readonly>';
	$output 	.= '	</div>';
	$output 	.= '</div>';
	$output		.= '<div class="control-wrapper cta-calendar-wrapper">';
	if ( dwh_empty( $ctaconfig->datetolabel ) && !$ctaconfig->calendar_placeholder || $ie9andbelow )
	$output 	.= '	<span class="'.$labelclass.'">'.$ctaconfig->datetolabel.'</span>';
	$output 	.= '	<div class="'.$containerclass.'">';
	$output 	.= '		<input class="cta-departure-date'.$inputclass.'" id="departure_date'.$counter.'" name="departure" '.$tovalue.' type="text" readonly>';
	$output 	.= '	</div>';
	$output 	.= '</div>';
	if ( $ctaconfig->calendar_multiview )
	$output 	.= '<input class="cta-date-range-picker" style="display: none; position: relative;" type="text">';

	return $output;
}

function dwh_promocode_view( $ctaconfig )
{
	$device 	 = dwh_detect_device();
	$ie9andbelow = ( $device->browser === 'ie9' || $device->browser === 'ie8' || $device->browser === 'ie7' );
	$value 	 	 = ( $ctaconfig->promocode_placeholder  && !$ie9andbelow ) ? 'placeholder="'.$ctaconfig->promocodelabel.'"' : 'value=""';

	if ( $ctaconfig->has_calendar ) {
		$output	 = '<div class="control-wrapper cta-promocode-wrapper">';
		if ( dwh_empty( $ctaconfig->promocodelabel ) && !$ctaconfig->promocode_placeholder || $ie9andbelow )
		$output .= '	<span class="input-label">'.$ctaconfig->promocodelabel.'</span>';
		$output .= '	<div class="input-container">';
		$output .= '		<input class="input-field cta-promocode" name="promo_code" '.$value.' type="text" autocomplete="off">';
		$output .= '	</div>';
		$output .= '</div>';
		return $output;
	}
}

function dwh_cta_bpg_title_view( $ctaconfig )
{
	add_action('wp_footer', function() use ( $ctaconfig ) {
		echo dwh_cta_bpg_terms_view( $ctaconfig );
	} );

	$class = ( dwh_get_theme_template() === 'v1' ) ? ' cta-title-container' : ' cta-title-wrapper';

	$output	 = '	<div class="control-wrapper'.$class.'">';
	$output	.= '		<span class="bpglinkcontainer cta-title">';
	$output .= '			<a class="colorbox-inline bpglinksmall" href="#bpgmodal"><span class="bpgcheck"></span>'.$ctaconfig->bpg_title.'</a>';
	$output	.= '			<a class="bpgtip">';
	$output	.= '				<div id="bpgtipcontent" class="hide">';
	$output	.= '					<span>'.$ctaconfig->bpg_tips.'</span>';
	$output	.= '				</div>';
	$output	.= '			</a>';
	$output	.= '		</span>';
	$output	.= '	</div>';

	return $output;
}

function dwh_cta_bpg_terms_view( $ctaconfig )
{
	$default_language = ( $ctaconfig->default_hotel_language === 'en' ) ? '/' : $ctaconfig->url->param_1.$ctaconfig->default_hotel_language;
	$dwhreservationurl  = $ctaconfig->base_url;
	$dwhreservationurl .= ( $ctaconfig->has_calendar ) ? $ctaconfig->url->calendar.$ctaconfig->default_hotel_id.'/'.$ctaconfig->datefrom.'/'.$ctaconfig->dateto.'/'.$ctaconfig->default_hotel_language.$ctaconfig->url->param_1 : $ctaconfig->url->default.$ctaconfig->default_hotel_id.$default_language;

	$output	 = '<div class="hide">';
	$output	.= '    <div id="bpgmodal">';
	$output	.= '		<div class="content">';
	$output	.= '			<div class="bpgmodal-content">';
	$output	.= $ctaconfig->bpg_terms;
	$output .= ' 				<div class="cta-bpglink-wrapper">';
	$output .= '					<a href="'.$dwhreservationurl.'" class="cta-button button cta-bpglink">'.$ctaconfig->button.'</a>';
	$output .= '				</div>';
	$output	.= '			</div>';
	$output	.= '		</div>';
	$output	.= '	</div>';
	$output	.= '</div>';
	return $output;
}
