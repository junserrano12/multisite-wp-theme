		<footer id="footer">
			<div class="content">
				<!-- Footer Address -->
				<?php the_widget('widget_address_text');?>
				<!-- Footer Address -->

				<!-- Footer Address -->
				<?php the_widget('widget_copyright_text');?>
				<!-- Footer Address -->
			</div>
		</footer>
	</div> <!-- /wrapper -->
<?php 
$data['dir'] = array( 'module/themes','page');
$data['view'] = 'footer';
load_view( $data );
?>