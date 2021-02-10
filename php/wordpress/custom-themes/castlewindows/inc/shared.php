<?php
/**
 * CW theme shared utilies
 * Initialize theme options amd meta boxes
 *
 * @package WordPress
 * @subpackage CW
 */

class cw_Shared {

	function __construct() {

		
		$this->include_modules();
	}

	private function include_modules() {
		$include_path = get_template_directory() . '/inc/shared/';

		// Load theme Options handler
		require( $include_path . 'utils.php' );

		// Load theme meta box handler
		require( $include_path . 'options.php' );

		// Theme usefull utilities
		require( $include_path . 'meta-boxes.php' );
	}
}
new cw_Shared;