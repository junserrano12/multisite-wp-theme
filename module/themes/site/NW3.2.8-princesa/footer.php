							</div><!-- #primary-main -->
					</div><!-- #primary -->
				</div><!-- .content -->
			</div><!-- #main-container -->
			<?php if ( is_active_sidebar( 'main-container-bottom' ) ) { dynamic_sidebar( 'main-container-bottom' ); } ?>
		</section><!-- #main -->
		<footer id="footer">
			<div id="footer-container">
				<?php if ( is_active_sidebar( 'footer-container-top' ) ) { dynamic_sidebar( 'footer-container-top' ); } ?>
				<div class="content">
					<?php if ( is_active_sidebar( 'footer-container-content' ) ) { dynamic_sidebar( 'footer-container-content' ); } ?>
				</div>
				<?php if ( is_active_sidebar( 'footer-container-bottom' ) ) { dynamic_sidebar( 'footer-container-bottom' ); } ?>
			</div>
		</footer>