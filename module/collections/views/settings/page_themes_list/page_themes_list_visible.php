<?php  
global $DWH_Admin;
global $post;
$page_themes = $DWH_Admin->get_page_themes();
$post_type_theme = get_post_meta( $post->ID , 'page_theme');
$post_type_theme = isset( $post_type_theme[0] ) ? $post_type_theme[0] : '';
?>
<div class="control-wrapper">
	<select id="post-type-theme" name="page_theme">
	<?php foreach ($page_themes as $key => $page_theme_info) :?>
		<?php if( $page_theme_info['category'] == get_post_type( $post ) ):?>
			<?php if(!empty($page_theme_info)):?>
			 	 <option value="<?php echo $key;?>" <?php echo $post_type_theme == $key ? 'selected' : '';?>> <?php echo $page_theme_info['name'];?> </option>
			<?php endif;?>
		<?php endif;?>
	<?php endforeach;?>
	</select>

	<div id="post-type-theme-list">
		<?php foreach ($page_themes as $key => $page_theme_info) :?>
			<?php if( $page_theme_info['category'] == get_post_type( $post ) ):?>
			    <div id="<?php echo $key;?>" class="info">
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
			<?php endif;?>
		<?php endforeach;?>
	</div>
</div>
