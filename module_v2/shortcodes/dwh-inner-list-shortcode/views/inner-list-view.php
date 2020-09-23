<?php	
	$device 			= dwh_detect_device();
	$atts 				= $viewData['atts'];

	$list_atts 			= $viewData['list_atts'];
	$list_content 		= $viewData['content'];

	$item_atts			= get_item_atts( $list_content );
	$item_contents 		= get_item_content( $list_content );
	$item_default_show 	= 0;

	foreach( $item_atts as $key => $value ) {
		preg_match_all('/(title\=\")(.*?)(\")/', $value, $title);
		$item_default_show  	= ( preg_match( '/\b(show\=true)\b/', $value ) ) ? $key : $item_default_show;
		$item_titles[] 			= array_shift( $title[2] );
	}

	if ( $device->mobile ) {
		$layout = ( $device->tablet ) ? $list_atts['tabletlayout'] : $list_atts['mobilelayout'];
	} else {
		$layout = $list_atts['desktoplayout'];
	}

	$list_id 			 = $list_atts['id'];
	$list_class			 = $list_atts['class'].$layout.'-wrapper';
	$list_attritubes	 = 'id="'.$list_id.'" class="'.$list_class.'"';
	$list_attritubes 	.= ' data-show="'.$item_default_show.'"';
	$list_attritubes 	.= ' data-desktoplayout="'.$list_atts['desktoplayout'].'" data-tabletlayout="'.$list_atts['tabletlayout'].'" data-mobilelayout="'.$list_atts['mobilelayout'].'"';
	if ( in_array( 'accordion', array( $list_atts['desktoplayout'], $list_atts['tabletlayout'], $list_atts['mobilelayout'] ) ) )	
	$list_attritubes	.= ' data-display="'.$list_atts['accordiondisplay'].'" data-effect="'.$list_atts['accordioneffect'].'" data-toggle="'.$list_atts['accordiontoggle'].'"';

	switch ( $layout ) {
		case 'dropdown'?>
		
		<div <?php echo $list_attritubes; ?>>
			<div class="dropdown-title-container">
				<select class="dropdown-select">
				<?php foreach ( $item_titles as $key => $item_title ) { ?>
					<?php $active_class = ( $key == $item_default_show ) ? ' item-active' : null; ?>
					<option class="item-title<?php echo $active_class; ?>" <?php echo ( $key == $item_default_show ) ? 'selected' : null; ?> value="<?php echo '#'.$list_id.'-dropdown-content-'.$key; ?>"><?php echo $item_title; ?></option>
				<?php } ?>
				</select>
			</div>
			<div class="dropdown-content-container">
				<?php foreach ( $item_contents as $key => $item_content ) { ?>
				<?php $active_class = ( $key == $item_default_show ) ? ' item-active' : null; ?>
				<div id="<?php echo $list_id.'-dropdown-content-'.$key; ?>" class="item-content<?php echo $active_class; ?>">
					<?php echo dwh_modify_the_content( $item_content ); ?>
				</div>
				<?php } ?>
			</div>
		</div>

		<?php break;
		case 'accordion': ?>
		
		<div <?php echo $list_attritubes; ?>>
			<ul class="accordion-list">
			<?php foreach ( $item_contents as $key => $item_content ) { ?>
				<?php 
					if ( $list_atts['accordiondisplay'] == 'all' ) {
						$display_block 	= 'block';
						$list_class 	= ' item-active';
					} else if ( $list_atts['accordiondisplay'] == 'none' ) {
						$display_block 	= 'none';
						$list_class 	= null;
					} else {
						$display_block 	= ( $key == $item_default_show ) ? 'block' : 'none';
						$list_class 	= ( $key == $item_default_show ) ? ' item-active' : null;
					}		
				?>

				<li class="accordion-item">
					<a href="<?php echo '#'.$list_id.'-accordion-content-'.$key; ?>" class="item-title<?php echo $list_class; ?>"><?php echo $item_titles[$key]; ?></a>
					<div id="<?php echo $list_id.'-accordion-content-'.$key; ?>" class="item-content<?php echo $list_class; ?>" style="display:<?php echo $display_block; ?>">
						<?php echo dwh_modify_the_content( $item_content ); ?>
					</div>
				</li>
			<?php } ?>
			</ul>
		</div>

		<?php break;
		case 'tab': ?>

		<div <?php echo $list_attritubes; ?>>
			<div class="tab-title-container">
				<ul class="tab-title-list">
				<?php foreach ( $item_titles as $key => $item_title ) { ?>
				<?php $active_class = ( $key == $item_default_show ) ? ' item-active' : null; ?>
					<li class="item-title<?php echo $active_class; ?>">
						<a class="item-link tab-link" href="<?php echo '#'.$list_id.'-tab-content-'.$key; ?>"><?php echo $item_title; ?></a>
					</li>
				<?php } ?>
				</ul>
			</div>
			<div class="tab-content-container">
				<?php foreach ( $item_contents as $key => $item_content ) { ?>
				<?php $active_class = ( $key == $item_default_show ) ? ' item-active' : null; ?>
				<div id="<?php echo $list_id.'-tab-content-'.$key; ?>" class="item-content<?php echo $active_class; ?>">
					<?php echo dwh_modify_the_content( $item_content ); ?>
				</div>
				<?php } ?>
			</div>
		</div>

		<?php break;
		default: ?>

		<div <?php echo $list_attritubes; ?>>
			<?php foreach ( $item_contents as $key => $item_content ) { ?>
				<?php $active_class = ( $key == $item_default_show ) ? ' item-active' : null; ?>
				<p class="item-title<?php echo $active_class; ?>"><?php echo $item_titles[$key]; ?></p>
				<div class="item-content<?php echo $active_class; ?>">
					<?php echo dwh_modify_the_content( $item_content ); ?>
				</div>
			<?php } ?>
		</div>

		<?php break;
	}