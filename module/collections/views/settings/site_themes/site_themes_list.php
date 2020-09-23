<?php  
global $DWH_Admin;
$site_themes = $DWH_Admin->get_site_themes();
?>
<div id="sitethemes" class="tab-container show">
	<table class="dwh-datatable display hover cell-border" cellspacing="0" width="100%">
	    <thead>
	        <tr>
	        	<th> Details </th>
	        	<th> Category </th>
	            <th> Screenshots </th>
	        </tr>
	    </thead>
	    <tbody>
	    <?php foreach ($site_themes as $key => $site_theme_info):?> 
	    	<tr>
				<td width="30%"> 
					<h2><?php echo $site_theme_info['name'];?></h2> 
					<h4 class="section-title"> Description: </h4>
					<?php echo $site_theme_info['description'];?>
				</td>
				<td width="10%"> 
					<h4 class="section-title"> Category: </h4>
					<?php echo $site_theme_info['category'];?>
				</td>
				<td width="60%"> 	
				 	<img height="200px" src="<?php echo $site_theme_info['screenshot'];?>">
				</td>
			</tr>
	    <?php endforeach;?>
   		</tbody>
	</table>
</div>