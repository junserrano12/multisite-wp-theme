<?php extract($data);?>

<?php if( !empty( $link_collection ) ):?>
<div id="social-media-container">	
	<nav id="social-media">
		<ul class="list-social-media">
			<?php foreach ($link_collection as $key => $link_info):?>
				<?php if( $link_info['category'] == 'social_media'):?>
				<?php
					$url = isset( $link_info['url'] ) ? $link_info['url'] : '';
					$icon = isset( $link_info['icon'] ) ? $link_info['icon'] : '';
				?>
				<li><a target="_blank" href="<?php echo $url; ?>" class="<?php echo $icon; ?>"></a></li>	
				<?php endif;?>
			<?php endforeach;?>		
		</ul>
	</nav>
</div>
<?php endif;?>