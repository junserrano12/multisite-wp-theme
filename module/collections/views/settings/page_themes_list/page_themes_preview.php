<?php  
global $DWH_Admin;
$page_themes = $DWH_Admin->get_page_themes();
?>
<div class="control-wrapper" id="page-themes">
	<div id="page-themes-list">
		<?php foreach ($page_themes as $key => $page_theme_info) :?>
		    <div id="<?php echo $page_theme_info['name'];?>" class="info">
		   		 <?php if(!empty($page_theme_info)):?>
		   		 	<div class="screenshot"> 
						<img src="<?php echo $page_theme_info['screenshot'];?>">						
					</div>
					<div class="description"> 
						<h3><?php echo $page_theme_info['name'];?></h3>
						<div><?php echo $page_theme_info['description'];?></div>
					</div>					
				<?php endif;?>
		    </div>
		<?php endforeach;?>
	</div>
</div>