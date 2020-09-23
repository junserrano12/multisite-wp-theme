					</div><!-- #primary-main -->
					<div id="primary-footer">
						<?php if ( is_active_sidebar( 'footer-header-content' ) ) { dynamic_sidebar( 'footer-header-content' ); } ?>
					</div>
				</div><!-- #primary -->
				<?php if ( is_active_sidebar( 'main-container-bottom' ) ) { dynamic_sidebar( 'main-container-bottom' ); } ?>
			</div><!-- #main-container -->
		</section><!-- #main -->
		<footer id="footer">
			<div id="footer-container" class="content">
				<div class="copyright">
					<?php if ( is_active_sidebar( 'footer-container-content' ) ) { dynamic_sidebar( 'footer-container-content' ); } ?>
				</div>				
			</div>
		</footer>