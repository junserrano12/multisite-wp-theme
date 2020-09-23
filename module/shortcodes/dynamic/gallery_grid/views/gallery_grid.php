<?php

	extract( $data );
	
	$imageids = explode(',', $atts['ids']);	
	$gridcontainername = isset($atts['name']) ? $atts['name'] : 'gallery-grid-container';

	$caption = isset($atts['caption']) ? $atts['caption'] : 'false';
	$title = isset($atts['title']) ? $atts['title'] : 'false';
	$titleontop = isset($atts['titleontop']) ? $atts['titleontop'] : 'false';
	$textalign = isset($atts['textalign']) ? $atts['textalign'] : 'center';
	$spandiv = isset($atts['columns']) ? $atts['columns'] : 4;
	$columns = 12 / $spandiv;
	$rel = isset($atts['rel']) ? $atts['rel'] : 'group';
	$colorbox = isset($atts['colorbox']) ? $atts['colorbox'] : 'colorbox';
	$imagesize = isset($atts['imagesize']) ? $atts['imagesize'] : 'medium';
	$displaycolorboxtitle = isset($atts['displaycolorboxtitle']) ? $atts['displaycolorboxtitle'] : 'false';

?>
	<div class="<?php echo $gridcontainername;?>">
		
		<div class="row-fluid">
		
			<?php
				
				foreach( $imageids as $key => $imageid ):
					
					$attachment = get_post($imageid);
					
					if( $attachment ){
					
						$ctr = $key + 1;						
						$customlink = get_post_meta( $imageid, 'attachment_image_link', true );		
						$customclass = get_post_meta( $imageid, 'attachment_image_class', true );		
						$titletext = get_value( get_post_meta( $imageid, 'attachment_image_title', true ), $attachment->post_title );
						$alttext = get_value( get_post_meta( $imageid, 'attachment_image_alt', true ), $attachment->post_title );
						$imagelink = get_value( $customlink, wp_get_attachment_image_src( $imageid, array(800, 800) )[0] );

						$cboxtitle = '';
						if( strtolower($displaycolorboxtitle) != 'false' ){
							
							$cboxtitle = 'title ="'. $attachment->post_title .'"';
						}

			   ?>
						<div id="grid-item-<?php echo $key;?>" class="span<?php echo $columns;?>">

							<?php 
								if( strtolower($titleontop) != 'false' ):
							?>
									<p class="align-<?php echo $textalign;?> <?php echo $caption;?>"> <?php echo $attachment->post_title;?> </p>
							
							<?php 
								endif;
							?>

							<div class="image-container">
							
								<?php 
									if( $colorbox === 'colorbox-inline' || $colorbox === 'colorbox-inline-img' ) : 
								?>
										<a class="<?php echo $colorbox;?>" rel="<?php echo $rel;?>" href="#box-<?php echo $imageid;?>"  <?php echo $cboxtitle; ?>>
											<img src="<?php echo makeAbsoluteToRelative(wp_get_attachment_image_src( $imageid, $imagesize )[0]);?>" alt="<?php echo $alttext;?>" title="<?php echo $titletext;?>"/>
										</a>
										<div class="hide">
											<div id="box-<?php echo $imageid; ?>">
												
												<?php
													if( $customlink ):
												?>
														<a href="<?php echo $customlink; ?>" class="<?php echo $customclass; ?>">
															<img src="<?php echo makeAbsoluteToRelative(wp_get_attachment_image_src($imageid, array(800, 800))[0]); ?> " alt="<?php echo $alttext; ?>" title="<?php echo $titletext; ?>" />
														</a>
												<?php
													else:
												?>
														<img src="<?php echo makeAbsoluteToRelative(wp_get_attachment_image_src($imageid, array(800, 800))[0]); ?> " alt="<?php echo $alttext; ?>" title="<?php echo $titletext; ?>" />
												<?php
													endif;
												?>
												
											</div>
										</div>
									
								<?php 
									elseif( $colorbox === 'colorbox') : 
								?>

										<a class="<?php echo $customlink == '' ? $colorbox : ' ' .$customclass; ?>" rel="<?php echo $rel; ?>" href="<?php echo $imagelink; ?>" <?php echo $cboxtitle; ?>>
											<img src="<?php echo makeAbsoluteToRelative(wp_get_attachment_image_src($imageid, $imagesize )[0]); ?>" alt="<?php echo $alttext; ?>" title="<?php echo $titletext; ?>"/>						
										</a>
										
								<?php 
									else :
								?>
										<a class="<?php echo $colorbox; ?> <?php echo $customlink != '' ? $customclass : ''; ?>" rel="<?php echo $rel .'-'. $imageid; ?>" href="<?php echo $imagelink; ?>" <?php echo $cboxtitle; ?>>
											<img src="<?php echo makeAbsoluteToRelative(wp_get_attachment_image_src($imageid, $imagesize)[0]); ?>" alt="<?php echo $alttext; ?>" title="<?php echo $titletext; ?>"/>
										</a>	
								
								<?php 
									endif;
								?>
							</div>

							<?php 
								if( ( strtolower($caption) != 'false' || strtolower($title) != 'false' ) && ( strtolower($titleontop) == 'false' ) ):
							?>
									<p class="align-<?php echo $textalign;?> <?php echo $caption;?>"> <?php echo $attachment->post_title ;?> </p>  
							
							<?php 
								endif;
							?>

						</div>
				
						<!-- Open new div container if reached the row items limit -->
						<?php 
							
							if( ( $ctr % $spandiv ) === 0 ){
								
								if( $ctr != count( $imageids ) ){
						?>	
									</div>
									<div class="row-fluid">
									
						<?php
								}
							}
						?>
			
			<?php 
					}
					
				endforeach;
			?>		
	
		</div>
		
	</div>