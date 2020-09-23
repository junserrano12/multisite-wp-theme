<?php

return array( 

				'details' => array(
											'title' => 'CTA Settings',
											'description' => 'CTA configurations',
											'category' => 'CTA Settings',
											'multiple' => 0,
											'block_list' =>  array( 'editor' )
									),
				'settings' => array(

											'cta_set'  => array(

																'properties' => array(
																						'control_type'	 	=> 'select',
																						'field_title' 		=> 'CTA Type',
																						'field_description' => 'CTA type to disaply',
																						'required'          => 1,
																						'class'             => 'narrow-width'
																					  )

																),
											'bpg_tip'  => array(

																'properties' => array(

																						'control_type'	 	=> 'textarea',
																						'field_title' 		=> 'BPG Tip',
																						'field_description' => 'BPG inclusions. Only show when you mouseover on the small think(?) icon next to the cta button.',
																						'required'          => 0,
																						'class'             => 'narrow-width'

																					
																					  )

															),
											'bpg_inclusion'  => array(

																'properties' => array(

																						'control_type'	 	=> 'textarea',
																						'field_title' 		=> 'BPG inclusions',
																						'field_description' => 'BPG inclusions. Describe why booking online should be very easy and convenient as it should be.',
																						'required'          => 0,
																						'class'             => 'narrow-width'																					
																					  )

															),
											'cta_promo_code'  => array(

																'properties' => array(

																						'control_type'	 	=> 'select',
																						'field_title' 		=> 'Promocode',
																						'field_description' => 'If you want to have promo code field available',
																						'required'          => 0,
																						'class'             => 'narrow-width'
																					  )

															),
											'cta_title'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'CTA Title',
																						'field_description' => 'The title of the CTA. Default (Best Price Guarantee)',
																						'class'             => 'narrow-width'
																						
																					  )

															),
											'cta_label'  => array(

																'properties' => array(

																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'CTA Label',
																						'field_description' => 'CTA Button label. Default (Check Availability and Prices)',
																						'required'          => 0,
																						'class'             => 'narrow-width'

																					
																					  )

															),
											'cta_footer_link'  => array(

																'properties' => array(

																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'CTA Footer link label',
																						'field_description' => 'CTA link label within content normally found on footer. Default (Check availability and prices)',
																						'required'          => 0,
																						'class'             => 'narrow-width'

																					
																					  )

															),
											'cta_modify_cancel_link'  => array(

																'properties' => array(

																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'CTA Modify / Cancel link',
																						'field_description' => 'CTA link label to modify or cancel reservation. Default (Modify or Cancel)',
																						'required'          => 0,
																						'class'             => 'narrow-width'

																					
																					  )

															),
											'cta_modify_cancel_text'  => array(

																'properties' => array(

																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'CTA Modify / Cancel - text after link',
																						'field_description' => 'Text basically show after CTA modify or cancel link. Default (your reservation)',
																						'required'          => 0,
																						'class'             => 'narrow-width'

																					
																					  )

															),
											'terms_and_condition'  => array(

																'properties' => array(
																							'control_type'	 	=> 'textarea',
																							'field_title' 		=> 'Hotel booking terms and condition',
																							'field_description' => 'Add Hotel booking terms and condition',
																							'required'          => 0,
																							'class'             => 'full-width'
																						
																					  )

															)


								)

		);

?>
