<?php
	wp_nonce_field( 'load_custom_fields_view_specific', 'load_custom_fields_view_specific_nonce' );


?>
	
	<div class="box">
		<div class="control-wrapper">
			<label for="tagline">Tag Line</label>
			<input type="text" id="tagline" name="tagline" value="<?php echo $data['customfields']['tagline']; ?>" style="width:100%" />
			<p class="description">Display Tagline</p>
		</div>
		
		<!-- Page themes list -->
		<?php 
		$data['dir'] = array( 'module','collections','views','settings','page_themes_list' );
		$data['view'] = 'page_themes_list_visible';
		load_view( $data );
		?>
		<!-- Page themes list -->
		
			
		<br clear="all">
		
		<br>
		<h4>Promo Group</h4>
		<div class="form-promo-group">
		
		<?php

			$promogroup = $data['customfields']['promo_group'];

			if($promogroup){
				
				/* add hidden input for migrated promo group */
				if( isset( $promogroup['migrated'] ) ) 
					echo '<input type="hidden" name="migrated" value="yes"/>';
				
				$promocount = count($promogroup['promo-name']);
				
				for($i = 0; $i < $promocount; $i++){
				
		?>
		
					<div class="promo-group" style="display:block">
						<a class="remove-this-group" href="#">Remove</a>
						<div class="control-wrapper">
							<label for="promo-image-<?php echo $i; ?>"> Promo Image ID:</label>
							<input type="text" id="promo-image-<?php echo $i; ?>" name="promo-image[]" value="<?php echo $promogroup['promo-image'][$i]; ?>" />
							
							<div class="promo-image-holder">
							
								<?php 
									
									$imgids = explode(',', $promogroup['promo-image'][$i] );
									
									if($imgids):
										
										foreach($imgids as $imgid):
											$imgattr = wp_get_attachment_image_src( $imgid, 'medium');
								?>
												
												<img src="<?php echo $imgattr[0]; ?>" alt="" width="100px" height="100px" />
								
								<?php
										endforeach;
										
									endif;
								?>
							</div>

							<a class="add-promo-image button-primary" href="#">Add Image</a>
							<p class="description">Upload or insert promo image from media library.</p>
						</div>
						<div class="control-wrapper">
							<label for="promo-name-<?php echo $i; ?>"> Promo Name:</label>
							<input type="text" id="promo-name-<?php echo $i; ?>" name="promo-name[]" value="<?php echo $promogroup['promo-name'][$i]; ?>" />
							<p class="description">What is your promo name?</p>
						</div>
						<div class="control-wrapper">
							<label for="promo-label-<?php echo $i; ?>"> Promo Offer Label:</label>
							<input type="text" id="promo-label-<?php echo $i; ?>" name="promo-label[]" value="<?php echo $promogroup['promo-label'][$i]; ?>" />
							<p class="description">Display Promo Offer Label</p>
						</div>
						<div class="control-wrapper">
							<label for="promo-desc-<?php echo $i; ?>"> Promo Description:</label>
							<textarea row="4" col="4" id="promo-desc-<?php echo $i; ?>" name="promo-desc[]"><?php echo $promogroup['promo-desc'][$i]; ?></textarea>
							<p class="description">What is your promo description?</p>
						</div>
						<div class="control-wrapper">
							<label for="promo-rate-plan-id-<?php echo $i; ?>"> Rate Plan ID:</label>
							<input type="text" id="promo-rate-plan-id-<?php echo $i; ?>" name="promo-rate-plan-id[]" value="<?php echo $promogroup['promo-rate-plan-id'][$i]; ?>" />
							<p class="description">Input Promo Id</p>
						</div>
						<div class="control-wrapper">
							<label for="promo-stay-start-<?php echo $i; ?>">Stay Period Start Date:</label>
							<input type="text" id="promo-stay-start-<?php echo $i; ?>" name="promo-stay-start[]" class="datepicker" value="<?php echo $promogroup['promo-stay-start'][$i]; ?>" />
							<p class="description">Stay Period Start Date (d-M-YYYY)</p>
						</div>
						<div class="control-wrapper">
							<label for="promo-stay-end-<?php echo $i; ?>"> Stay Period End Date: </label>
							<input type="text" id="promo-stay-end-<?php echo $i; ?>" name="promo-stay-end[]" class="datepicker" value="<?php echo $promogroup['promo-stay-end'][$i]; ?>" />
							<p class="description">Stay Period End Date (d-M-YYYY)</p>
						</div>
						<div class="control-wrapper">
							<label for="promo-period-end-<?php echo $i; ?>"> Promo End Date: </label>
							<input type="text" id="promo-period-end-<?php echo $i; ?>" name="promo-period-end[]" class="datepicker" value="<?php echo $promogroup['promo-period-end'][$i]; ?>" />
							<p class="description">Promo End Date (d-M-YYYY)</p>
						</div>
					</div>
				
		<?php		
				}
			}
		?>
			
			<a class="create-new-promo-group button-primary" href="#">Add New Promo</a>
		</div>
	</div>