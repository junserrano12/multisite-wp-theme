<?php
include( get_template_directory().'/module-migrate/dwh-migrate.php' );

if ( is_migrated() ) {
    include( get_template_directory().'/module_v2/init.php' );
} else {
    include( get_template_directory().'/module/init.php' );
}

/*end of functions.php*/
?>