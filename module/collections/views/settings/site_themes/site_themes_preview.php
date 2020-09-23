<?php  
global $DWH_Admin;
$site_themes = $DWH_Admin->get_site_themes();
?>
<div class="control-wrapper" id="site-themes">
	<div id="site-themes-list">
		<?php foreach ($site_themes as $key => $site_theme_info) :?>
			<?php if(!empty($site_theme_info)):?>
			    <div id="<?php echo $site_theme_info['name'];?>" class="info">
		   		 	<div class="screenshot"> 
						<img src="<?php echo $site_theme_info['screenshot'];?>">						
					</div>
					<div class="description"> 
						<h3><?php echo $site_theme_info['name'];?></h3>
						<div><?php echo $site_theme_info['description'];?></div>
					</div>					
			    </div>
		    <?php endif;?>
		<?php endforeach;?>
	</div>
</div>