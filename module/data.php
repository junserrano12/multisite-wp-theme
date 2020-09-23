<?php
/* Data Class */
$dir = get_template_directory().'/module/core/class.data.php';
if(file_exists($dir)) require_once( $dir );

$DWH_Data = new DWH_Data();