<?php
$sidebar_class_dir = get_template_directory().'/module/core/class.sidebar.php';
if(file_exists( $sidebar_class_dir )) require_once( $sidebar_class_dir );
$DWH_Sidebar = new DWH_Sidebar();  
?>