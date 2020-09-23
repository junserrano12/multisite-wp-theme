<?php

	extract( $data );

	$brstr = "";
	$hotel_contact_mode = "";
	$hotel_contact_count = 0;
	$html = "";
	
	$hotel_name = $hotel_info->hotel_name;
	
	/* Hotel Address */
	if( $hotel_address )
	{	
		$hotel_address = (array)$hotel_address;

		foreach ($hotel_address as $key => $hotel_address_info) {

			if(isset( $hotel_address_info['value'] ))
			{
				 $hotel_address_info = $hotel_address_info['value'];
			}
			
			$htmladdress = '';
			
			if( is_array( $hotel_address_info ) )
			{	
				$street_1 = isset( $hotel_address_info['street_1'] ) ? $hotel_address_info['street_1'] :'';
				$street_2 = isset( $hotel_address_info['street_2']) ? $hotel_address_info['street_2'] : ''; 
				$city_town = isset( $hotel_address_info['city_town'] ) ? $hotel_address_info['city_town'] : '';
				$state_region = isset( $hotel_address_info['state_region'] ) ? $hotel_address_info['state_region'] : '';
				$zip_code = isset( $hotel_address_info['zip_code'] ) ? $hotel_address_info['zip_code'] : '';
				$country = isset( $hotel_address_info['country'] ) ? $hotel_address_info['country'] : '';
				
				$htmladdress .= '<span class="fn name">'. $hotel_name .'</span>';
					if( $hotel_name && ( $street_1 OR $street_2 OR $city_town OR $state_region OR $zip_code OR $country ) ) $htmladdress .= ' | ';
				
				$htmladdress .= '<span class="adr">';
				$htmladdress .= '<span class="street-address">'. $street_1 .'</span>';
					if( $street_1 && ( $street_2 OR $city_town OR $state_region OR $zip_code OR $country ) ) $htmladdress .= ', ';
				
				$htmladdress .= $brstr .'<span class="street-address">'. $street_2 .'</span>';
					if( $street_2 && ( $city_town OR $state_region OR $zip_code OR $country ) ) $htmladdress .= ', ';
				
				$htmladdress .= $brstr .'<span class="locality">'. $city_town .'</span>';
					if( $city_town && ( $state_region OR $zip_code OR $country ) ) $htmladdress .= ', ';
					
				$htmladdress .= '<span class="region">'. $state_region .'</span> ';
					if( $state_region && ( $zip_code OR $country ) ) $htmladdress .= ', ';
				
				$htmladdress .= '<span class="postal-code">'. $zip_code .'</span>';
					if( $zip_code && ( $country ) ) $htmladdress .= ', ';
					
				$htmladdress .= $brstr .'<span class="country">'. $country .'</span>';
				
				$htmladdress .= '</span>';
			}
			else
			{
				$htmladdress = "";
			}


		}

	}
	
	
	/* Hotel Contact Information */
	if( $hotel_contact )
	{	
		$hotel_contact1 = (array)$hotel_contact;
		
		if( array_key_exists( 0, $hotel_contact ) ){
			$hotel_contact_count = count( $hotel_contact1 );
		}
		else{
			$hotel_contact_count = 1;
		}
		
		$htmlcontact = "";
		$hotelcontactctr = 0;
		
		
		if( $hotel_contact1  )
		{
			
			/* if multiple contact */
			if( array_key_exists( 0, $hotel_contact ) ){
			
				$htmlcontact .= ' | ';
				
				foreach( $hotel_contact1 as $key => $val ){
					if( $val['value']['telephone'] ) $hotelcontactctr++;
				}
				
				if( $hotelcontactctr > 1 ){
				
					$htmlcontact .= ' Phone Numbers: ';
					$hotel_contact_mode = "multiple";
				}
				else{
					$htmlcontact .= ' Phone Number: ';
					$hotel_contact_mode = "single";
				}
			}
			
			/* if single contact */
			else{
			
				if( $hotel_contact1['value']['telephone'] ){
					
					$htmlcontact .= ' | ';
					$htmlcontact .= ' Phone Number: ';
					$hotel_contact_mode = "single";
				}
			
			}
			
		}
		

		foreach ($hotel_contact as $key => $hotel_contact_info) {

			if(isset( $hotel_contact_info['value'] ))
			{
				 $hotel_contact_info = $hotel_contact_info['value'];
			}
			

			if( array( $hotel_contact_info ) )
			{	

				$country_code = isset( $hotel_contact_info['country_code'] ) ? $hotel_contact_info['country_code'] :'';
				$area_code = isset( $hotel_contact_info['area_code'] ) ? $hotel_contact_info['area_code'] :''; 
				$telephone = isset( $hotel_contact_info['telephone'] ) ? $hotel_contact_info['telephone'] :''; 

				$htmlcontact .= '<span class="tel">' . $country_code . '</span>';
					if( $country_code && ( $area_code OR $telephone ) ) $htmlcontact .= '-';
				
				$htmlcontact .= '<span class="tel">' . $area_code .'</span>';
					if( $area_code && $telephone ) $htmlcontact .= '-';
					
				$htmlcontact .= '<span class="tel">' . $telephone . '</span>';
					if( $hotel_contact_count < $hotelcontactctr ) $htmlcontact .= '';
					elseif( $hotel_contact_mode == 'multiple' && $hotelcontactctr > 1 ) $htmlcontact .= ', ';
			}
			else
			{
				$htmlcontact = "";
			}

			$hotel_contact_count--;
		}

	}
	

	$html .= '<span class="vcard">';
	$html .= $html . $htmladdress . $htmlcontact ;
	$html .= '</span>';

	if(!empty( $html ))
	{
		echo $html;
	}

?>