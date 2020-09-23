<?php extract($data); ?>

<?php if( $cta_settings ): ?>
	<div id="cta-container" class="cta-container">
		<?php if ( is_active_sidebar( 'cta-container-top' ) ) { dynamic_sidebar( 'cta-container-top' ); } ?>
		<div class="cta-content">
			<?php
				$data['dir'] 	= array('module/cta');
				$data['view'] 	= isset( $cta_settings['cta_type'] ) ? $cta_settings['cta_type'] : 'nw';
				load_view( $data );
			?>
		</div>
		<?php if ( is_active_sidebar( 'cta-container-bottom' ) ) { dynamic_sidebar( 'cta-container-bottom' ); } ?>
	</div>
<?php endif; ?>
