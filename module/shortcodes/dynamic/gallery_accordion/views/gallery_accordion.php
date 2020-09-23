<?php 

	extract( $data );
	
	$imageids = explode(',', $atts['ids']);	
	$accordioncontainername = isset($atts['name']) ? $atts['name'] : 'accordion-container';
	$ctabuttonlink = isset($atts['ctabuttonlink']) ? $atts['ctabuttonlink'] : 'Check availability and price';
	$class = isset($atts['class']) ? $atts['class'] : 'button ctapackage';
	$spanimageclass = isset($atts['spanimageclass']) ? $atts['spanimageclass'] : 3;
	$spandetailclass = isset($atts['spanimageclass']) ? 12 - $spanimageclass : 9;
	$ctabutton = isset($atts['ctabutton']) ? $atts['ctabutton'] : 'false';
	$imageiscolorbox = isset($atts['iscolorbox']) ? $atts['iscolorbox'] : 'true';
	$showfirst = isset($atts['showfirst']) ? $atts['showfirst'] : 'true';
	$isfirst = 'active';
	
	$showfirstclass = $showfirst == 'true' ? ' showfirst' : '';
	
	
	$rel = isset($atts['rel']) ? $atts['rel'] : 'group';
	$colorbox = isset($atts['colorbox']) ? $atts['colorbox'] : 'colorbox';
	$imagesize = isset($atts['imagesize']) ? $atts['imagesize'] : 'medium';
?>
	<div id="<?php echo $accordioncontainername; ?>">
		<ul class="list-accordion<?php echo $showfirstclass; ?>">
		<?php 
			foreach( $imageids as $key => $imageid ){

				$attachment = get_post($imageid);
				
				/* check if attachment id exists */
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

					<li class="accordion-item">
						<div class="accordion-caption">
							<a href="#accordion-content-<?php echo $key; ?>" class="<?php echo $isfirst; ?>"><?php echo $attachment->post_title; ?></a>
						</div>
						<div id="accordion-content-<?php echo $key; ?>" class="accordion-content">
							<div class="row-fluid">
								<div class="span<?php echo $spanimageclass; ?>">
									<div class="image-container">
											
										<?php 
											if( $colorbox === 'colorbox-inline' ) : 
										?>
												<a class="<?php echo $colorbox;?>" rel="" href="#box-<?php echo $imageid;?>"  <?php echo $cboxtitle; ?>>
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

												<a class="<?php echo $customlink == '' ? $colorbox : ' ' .$customclass; ?>"  href="<?php echo $imagelink; ?>" <?php echo $cboxtitle; ?>>
													<img src="<?php echo makeAbsoluteToRelative(wp_get_attachment_image_src($imageid, $imagesize )[0]); ?>" alt="<?php echo $alttext; ?>" title="<?php echo $titletext; ?>"/>						
												</a>
												
										<?php 
											else :
										?>
												<a class="<?php echo $colorbox; ?> <?php echo $customlink != '' ? $customclass : ''; ?>" href="<?php echo $imagelink; ?>" <?php echo $cboxtitle; ?>>
													<img src="<?php echo makeAbsoluteToRelative(wp_get_attachment_image_src($imageid, $imagesize)[0]); ?>" alt="<?php echo $alttext; ?>" title="<?php echo $titletext; ?>"/>
												</a>	
										
										<?php 
											endif;
										?>
									</div>
								</div>
								<div class="span<?php echo $spandetailclass; ?>">
									<p class="sub-title"><?php echo $attachment->post_title; ?></p>
									<?php echo wpautop( $attachment->post_content ); ?>
									
									<?php 
										/* 
										* the second OR condition is support for old shortcodes
										*/
										if( strtolower($ctabutton) == 'true' ){ 
									?>
											<a href="<?php echo $customlink; ?>" class="<?php echo $class . ' ' . $customclass; ?>"><?php echo $ctabuttonlink; ?></a>
									<?php 
										} 
									?>
								</div>
							</div>
						</div>
					</li>
				
					<?php $isfirst = null; ?>
		<?php 
				}
			} 
		?>
		</ul>
	</div>
