<?php  
global $DWH_Admin;
$page_themes = $DWH_Admin->get_page_themes();
?>

<div id="pagethemes" class="tab-container">

	<table class="dwh-datatable display hover cell-border" cellspacing="0" width="100%">
	    <thead>
	        <tr>
	        	<th> Details </th>
	        	<th> Category </th>
	            <th> Screenshots </th>
	        </tr>
	    </thead>
	    <tbody>

	    <?php foreach ($page_themes as $key => $page_theme_info):?> 	
	    	<tr>
				<td width="30%"> 
					<h2><?php echo $page_theme_info['name'];?></h2> 
					<h4 class="section-title"> Description: </h4>
					<?php echo $page_theme_info['description'];?>
				</td>
				<td width="10%"> 
					<h4 class="section-title"> Category: </h4>
					<?php echo $page_theme_info['category'];?>
				</td>
				<td width="60%"> 	
				 	<img height="200px" src="<?php echo $page_theme_info['screenshot'];?>">
				</td>
			</tr>
	    <?php endforeach;?>
		
   		</tbody>
	</table>

</div>
