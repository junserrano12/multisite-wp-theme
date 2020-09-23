<?php
	
	extract( $data );
	
	$imageids = explode(',', $atts['ids']);	
	$spandiv = isset($atts['columns']) ? $atts['columns'] : 3;
	$columns = 12 / $spandiv;
	$readmore = isset($atts['readmore']) ? $atts['readmore']: 'Read More';
	$imagesize = isset($atts['imagesize']) ? $atts['imagesize'] : 'medium';
	$teaserlink = isset($atts['teaserlink']) ? $atts['teaserlink'] : 'Read More';
	$teaserlinktext = isset($atts['teaserlinktext']) ? $atts['teaserlinktext'] : $teaserlink;
	$titleontop = isset($atts['titleontop']) ? $atts['titleontop'] : 'false';
	
	$gridcontainername = isset($atts['name']) ? $atts['name'] : 'gallery-grid-container';

	$caption = isset($atts['caption']) ? $atts['caption'] : 'false';
	$title = isset($atts['title']) ? $atts['title'] : 'false';
	$textalign = isset($atts['textalign']) ? $atts['textalign'] : 'center';
	$rel = isset($atts['rel']) ? $atts['rel'] : 'group';
	$colorbox = isset($atts['colorbox']) ? $atts['colorbox'] : 'colorbox';
	$displaycolorboxtitle = isset($atts['displaycolorboxtitle']) ? $atts['displaycolorboxtitle'] : 'false';
?>

<div id="teaser-container">
	<div class="row-fluid">
		<?php 
			foreach( $imageids as $key => $imageid ):

				$ctr = $key+1;	
				$attachment = get_post($imageid);
				
				if( $attachment ){
				
					$customlink = get_post_meta( $imageid, 'attachment_image_link', true ); 
					$customclass = get_post_meta( $imageid, 'attachment_image_class', true ); 
					$titletext = get_post_meta( $imageid, 'attachment_image_title', true );		
					$alttext = get_post_meta( $imageid, 'attachment_image_alt', true );	
					$offset = get_post_meta( $imageid, 'attachment_offset', true );
					$offset = $offset != '' ? ' offset'. $offset : '';
						
					$ctr = $key + 1;
					$imagelink = get_value( $customlink, wp_get_attachment_image_src( $imageid, array(800, 800) )[0] );

					$cboxtitle = '';
					if( strtolower($displaycolorboxtitle) != 'false' ){
						
						$cboxtitle = 'title ="'. $attachment->post_title .'"';
					}
		?>	
			
					<div class="span<?php echo $columns . $offset;?>">
					
						<?php 
							if( strtolower($titleontop) != 'false' ) :
						?>
								<p class="sub-title"> <?php echo $attachment->post_title;?> </p>
						<?php 
							endif;
						?>

						<div class="teaser-box">
							<div class="image-container">
																			
										<?php 
											if( $colorbox === 'colorbox-inline' ) : 
										?>
												<a class="the-colorbox-inline <?php echo $colorbox;?>" rel="<?php echo $rel;?>" href="#box-<?php echo $imageid;?>"  <?php echo $cboxtitle; ?>>
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

												<a class="the-colorbox <?php echo $customlink == '' ? $colorbox : ' ' .$customclass; ?>" rel="<?php echo $rel; ?>" href="<?php echo $imagelink; ?>" <?php echo $cboxtitle; ?>>
													<img src="<?php echo makeAbsoluteToRelative(wp_get_attachment_image_src($imageid, $imagesize )[0]); ?>" alt="<?php echo $alttext; ?>" title="<?php echo $titletext; ?>"/>						
												</a>
												
										<?php 
											else :
										?>
												<a class="default <?php echo $colorbox; ?> <?php echo $customlink != '' ? $customclass : ''; ?>" rel="<?php echo $rel .'-'. $imageid; ?>" href="<?php echo $imagelink; ?>" <?php echo $cboxtitle; ?>>
													<img src="<?php echo makeAbsoluteToRelative(wp_get_attachment_image_src($imageid, $imagesize)[0]); ?>" alt="<?php echo $alttext; ?>" title="<?php echo $titletext; ?>"/>
												</a>	
										
										<?php 
											endif;
										?>

							</div>
							<div class="teaser-details">
								
								<?php 
									if( strtolower($titleontop) == 'false' ):
								?>
										<p class="sub-title"> <?php echo $attachment->post_title;?> </p>
								<?php 
									endif;
								?>

								<?php 
									if($attachment->post_excerpt != null):
								?>
										<?php echo wpautop( $attachment->post_excerpt ); ?>
								<?php 
									endif;
									
									
									if( strtolower($teaserlink) != 'false' ) :
									
										if( $customlink !="" ):
								?>
											<a class="teaserlink link <?php echo $customclass; ?>" href="<?php echo $customlink;?>"> <?php echo $teaserlinktext;?> </a>
								<?php 
										endif;
									endif;
								?>
							</div>
						</div>

						<div class="teaser-content">
							<?php echo wpautop( $attachment->post_content ); ?>
							<?php 
								if( strtolower($readmore) != 'false' ) :
									
									if( $customlink!="" ):
							?>
										<a class="readmore link <?php echo $customclass; ?>" href="<?php echo $customlink;?>"> <?php echo $readmore;?> </a>		
							<?php 
									endif;
								endif;
							?>
						</div>

					</div>

					<?php 
						if( ( $ctr % $spandiv ) === 0 ) :
							
							if( $ctr !== count($imageids) ) :
					?>
								</div>
								<div class="row-fluid">							
					<?php 	
							endif;
						endif;
					?> 	

		<?php 
				}
			endforeach;
			
		?>
	</div>
</div>