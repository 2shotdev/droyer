<?php
/**
 * Options tree theme adapter
 *
 * Each theme option is retrieved via get_theme_option filter
 */

/**
* Add sort ability for all options tree checkboxes
*/
class Theme_OptionTree_Sortable {

	function __construct() {
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_script' ) );
			add_filter( 'ot_display_by_type', array( &$this, 'store_sortable_values' ) );

			add_action( 'admin_footer', array( &$this, 'localize_sortable_fields' ) );
		}
	}

	public function store_sortable_values( $args ) {
		if ( !isset( $GLOBALS['theme_screen_sortable_options'] ) )
			$GLOBALS['theme_screen_sortable_options'] = array();

		if ( strpos( $args['field_class'], 'theme-sortable-option' ) !== false )
			$GLOBALS['theme_screen_sortable_options'][ $args['field_id'] ] = is_array( $args['field_value'] ) ? array_values( $args['field_value'] ) : $args['field_value'];

		return $args;
	}

	/**
	 * Additional OptionTree Scripts
	 */
	function enqueue_script() {
		wp_enqueue_script( 'theme_sortable_option', get_stylesheet_directory_uri() .'/inc/shared/sortable-options/assets/sortable-options.js', array( 'jquery-ui-sortable' ), '1.0' , true );
	}

	public function localize_sortable_fields() {
		if ( !isset( $GLOBALS['theme_screen_sortable_options'] ) || empty( $GLOBALS['theme_screen_sortable_options'] ) )
			return;

		wp_localize_script( 'theme_sortable_option', 'screenSortableOptions' , $GLOBALS['theme_screen_sortable_options'] );
	}
}

new Theme_OptionTree_Sortable;