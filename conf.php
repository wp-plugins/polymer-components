<?php
define( 'POLYMER_COMPONENTS_MAIN', 'polymer-components/polymer-components.php' );

// Default options values
$polymer_options = array(
	'polymer-js-pages' => TRUE,
	'polymer-js-posts' => TRUE
);
define( 'POLYMER_OPTIONS', serialize( $polymer_options ) );

define( 'POLYMER_CORE_ICONS', 'core-icons' );
