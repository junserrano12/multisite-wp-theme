<?php
global $DWH_Admin;
$site_fonts = $DWH_Admin->get_site_fonts();
?>
<div class="control-wrapper" id="site-fonts">
	<div id="site-fonts-list">
		<?php foreach ($site_fonts as $key => $font_info) :?>
			<?php if(!empty($font_info)):?>
			    <div id="<?php echo $key;?>">
					<p> 
						CSS font name: <h1> <?php echo $font_info['name'];?> </h1>
						Description: <?php echo $font_info['description'];?> 
					</p>
					<img src="<?php echo $font_info['screenshot'];?>" height="150px;">
					<br>
			    </div>
		    <?php endif;?>
		<?php endforeach;?>
	</div>
</div>
