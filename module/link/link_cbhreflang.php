<?php	
	global $DWH_Options;
	$hreflang = $DWH_Options->get_dwh_site_option_field('dwh_hreflang',	1); //an object
	$optionsetdata = $DWH_Options->get_option_set_data( 'dwh_hreflang' );
	$arr = (array)$hreflang; //cast the object to array
	$countArr = count($arr);
	/*print_r($optionsetdata);
	 if($hreflang){		
		for($i = 0; $i<$countArr; $i++){
			echo '<link rel="alternate" href="'.$arr[$i]['hreflang_url'].'" hreflang="'.$arr[$i]['hreflang_value'].'" />';
			echo "\n";
		}
	}
	echo "\n"; */
	
	if(count($optionsetdata)> 0 ){		
		for($i = 0; $i<count($optionsetdata); $i++){
			echo '<link rel="alternate" href="'.$optionsetdata[$i]['hreflang_url'].'" hreflang="'.$optionsetdata[$i]['hreflang_value'].'" />';
			echo "\n";
		}
	}
	echo "\n";
	
	