								</div><!-- #primary-main -->	
						<div id="primary-footer"></div>
					</div><!-- #primary -->	
				</div><!-- #main-container -->
				<?php if ( is_active_sidebar( 'main-container-bottom' ) ) { dynamic_sidebar( 'main-container-bottom' ); } ?>
			</section><!-- #main -->
			<footer id="footer">
				<div id="footer-container">
					<div id="footer-top">
						<?php if ( is_active_sidebar( 'footer-container-top' ) ) { dynamic_sidebar( 'footer-container-top' ); } ?>
					</div>
					<div id="footer-main">
						<?php if ( is_active_sidebar( 'footer-container-content' ) ) { dynamic_sidebar( 'footer-container-content' ); } ?>
					</div>
					<div id="footer-bottom">
						<?php if ( is_active_sidebar( 'footer-container-bottom' ) ) { dynamic_sidebar( 'footer-container-bottom' ); } ?>
					</div>
				</div>
			</footer>
		</div><!-- #content-section -->
	</div><!-- .content -->