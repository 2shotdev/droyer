<?php
/**
 * Options tree theme adapter
 *
 * Each theme option is retrieved via get_theme_option filter
 */


// add_filter( 'get_theme_option', 'ot_get_theme_option_filter', 10, 2 );
/**
 * Get theme option using options tree module
 * @param  mixed $default Default return value
 * @param  string $key    Option key
 * @return mixed          Option value
 */
// function ot_get_theme_option_filter( $default = '', $key = '' ) {
// 	if ( function_exists('ot_get_option') ) {
// 		$default = ot_get_option($key, $default);
// 	}
// 	return $default;
// }

/**
 * Get options tree option
 * Options tree class is loaded for admin only
 *
 * Helper function to return the option value.
 * If no value has been saved, it returns $default.
 *
 * @param     string    The option ID.
 * @param     string    The default option value.
 * @return    mixed
 *
 */
if ( ! function_exists( 'ot_get_option' ) ) {
	function ot_get_option( $option_id, $default = '' ) {
		/* get the saved options */ 
		$options = get_option( 'option_tree' );
		/* look for the saved value */
		if ( isset( $options[ $option_id ] ) && !empty( $options[ $option_id ] ) ) {
			return $options[ $option_id ];
		}
		return $default;
	}
}
/* =Add Theme Options support
 * currently OptionsTree is used
-------------------------------------------------------------- */

/**
 * Filter option extraction for our theme
 * @param  mixed $default Option default value
 * @param  string $key    Options key
 * @return mixed          Option value
 */
function ot_theme_option_adapter( $default, $key ) {
	return ot_get_option( $key, $default );
}
add_filter( 'theme_option', 'ot_theme_option_adapter', 10, 2 );

/**
* Options tree backend is for admin purposes only
*/
if ( is_admin() ) {

	/**
	 * Update theme options for current theme
	 * providing public filter for options fields
	 *
	 * @return    void
	 * @since     2.0
	 */
	add_action( 'admin_init', '_custom_theme_options', 1 );
	function _custom_theme_options() {
		$saved_settings = get_option( 'option_tree_settings', array() );
		$custom_settings = array(
			'sections' => array(),
			'settings' => array()
		);
		$custom_settings = apply_filters( 'populate_theme_options', $custom_settings );
		if ( $saved_settings !== $custom_settings ) {
			update_option( 'option_tree_settings', $custom_settings );
			wp_redirect(current_url());
		}
	}
	/*
	 * Allow using lists for options with title only fields
	 */
	add_filter( 'ot_list_item_settings', 'remove_default_slider_filelds', 12);
	function remove_default_slider_filelds() {
		return array();
	}
	/**
	 * Add images ids to all sliders
	 */
	if ( function_exists( 'get_image_id_by_url' ) ) {
		add_action('ot_after_theme_options_save', 'save_image_ids_in_lists');
		function save_image_ids_in_lists() {
			$options = get_option( 'option_tree' );
			// find front_slides key
			foreach ($options as $slider_key => $list) :
				if (is_array($list))
					foreach ($list as $list_item_key => $list_item)
						if (is_array($list_item))
							foreach ($list_item as $key => $value)
								if (strpos($key, 'image')!==false AND 'image_id'!=$key)
									$options[$slider_key][$list_item_key][$key.'_id'] = get_image_id_by_url($value);
			endforeach;

			$options = apply_filters( 'ab_save_options', $options );

			update_option( 'option_tree', $options );
		}
	}
	// Hide the settings & documentation pages.
	add_filter( 'ot_show_pages', '__return_false' );
	// Enable Theme mode
	add_filter( 'ot_theme_mode', '__return_true' );
	include_once( get_template_directory() . '/inc/shared/sortable-options/sortable.php' );
	// Include OptionTree after providing all necessary filters
	include_once( get_template_directory() . '/option-tree/ot-loader.php' );
}