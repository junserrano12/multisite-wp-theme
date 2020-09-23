<?php
	wp_nonce_field( 'load_custom_fields_view_specific', 'load_custom_fields_view_specific_nonce' );
?>

	<div class="box">
		<h4>Flash Deals</h4>

		<!-- Page themes list -->
		<?php 
		$data['dir'] = array( 'module','collections','views','settings','page_themes_list' );
		$data['view'] = 'page_themes_list_visible';
		load_view( $data );
		?>
		<!-- Page themes list -->
		
		<?php
			/* add hidden input for migrated flashdeal */
			$migrated = $data['customfields']['migrated'];
			if( $migrated == 'yes' )
				echo '<input type="hidden" name="migrated" value="yes"/>';
		
		?>

		<div class="control-wrapper">
			<label for="tagline">Tag Line</label>
			<input type="text" id="tagline" name="tagline" value="<?php echo $data['customfields']['tagline']; ?>" style="width:100%" />
			<p class="description">Display Tagline</p>	
		</div>

		<div class="control-wrapper">
			<label for="catchphrase">Promo Offer Label</label>
			<input type="text" id="catchphrase" name="catchphrase" value="<?php echo $data['customfields']['catchphrase']; ?>" style="width:100%" />
			<p class="description">Display Promo Offer Label</p>
		</div>
		<div class="control-wrapper">
			<label for="promoid">Rate Plan ID</label>
			<input type="text" id="promoid" name="promoid" value="<?php echo $data['customfields']['promoid']; ?>" style="width:100%"/>
			<p class="description">Input Promo Id</p>
		</div>
		<div class="control-wrapper">
			<label for="start_date">Stay Period Start Date</label>
			<input type="text" id="start_date" name="start_date" value="<?php echo $data['customfields']['start_date']; ?>" style="width:100%" class="date-picker"/>
			<p class="description">Stay Period Start Date (d-M-YYYY)</p>
		</div>
		<div class="control-wrapper">
			<label for="end_date">Stay Period End Date</label>
			<input type="text" id="end_date" name="end_date" value="<?php echo $data['customfields']['end_date']; ?>" style="width:100%" class="date-picker"/>
			<p class="description">Stay Period End Date (d-M-YYYY)</p>
		</div>
		<div class="control-wrapper">
			<label for="promo_end_date">Promo End Date</label>
			<input type="text" id="promo_end_date" name="promo_end_date" value="<?php echo $data['customfields']['promo_end_date']; ?>" style="width:100%" class="date-picker"/>
			<p class="description">Promo End Date (d-M-YYYY) countdown</p>
		</div>
	</div>