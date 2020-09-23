		<footer id="footer">
			<div class="content">
				<?php the_widget('widget_address_text');?>
				<?php the_widget('widget_copyright_text');?>
			</div>
		</footer>
	</div> <!-- /wrapper -->
<?php 
$data['dir'] = array( 'module/themes','page');
$data['view'] = 'footer';
load_view( $data );
?>