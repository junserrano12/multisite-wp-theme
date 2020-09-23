<?php
global $DWH_Admin;
$site_fonts = $DWH_Admin->get_site_fonts();
?>

<div id="fonts" class="tab-container">

	<table class="dwh-datatable display hover cell-border" cellspacing="0" width="100%">
	    <thead>
	        <tr>
	        	<th> Details </th>
	            <th> Screenshots </th>
	        </tr>
	    </thead>
	    <tbody>

	    <?php foreach ($site_fonts as $key => $site_fonts_info):?> 	
	    	<tr>
				<td width="30%"> 
					<h2><?php echo $site_fonts_info['name'];?></h2> 
					<h4 class="section-title"> Description: </h4>
					<?php echo $site_fonts_info['description'];?>
				</td>
				<td width="60%"> 	
				 	<img height="200px" src="<?php echo $site_fonts_info['screenshot'];?>">
				</td>
			</tr>
	    <?php endforeach;?>
		
   		</tbody>
	</table>

</div>
