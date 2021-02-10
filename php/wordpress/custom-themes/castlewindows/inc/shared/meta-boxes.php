<?php
/**
 * Register meta boxes
 * Including the meta boxes class
 * Meta boxes are added using options tree plugin
 */

/**
 * This module is backend only and for special pages
 */
global $pagenow;
if ( !is_admin() ) {

	return;
}

// Hide the settings & documentation pages.
add_filter( 'ot_show_pages', '__return_false' );

// Enable Theme mode
add_filter( 'ot_theme_mode', '__return_true' );

// Include OptionTree after providing all necessary filters
include_once( get_template_directory() . '/option-tree/ot-loader.php' );


/**
 * Register meta boxes
 *
 * @return void
 */
add_action( 'admin_init', 'theme_register_meta_boxes' );
function theme_register_meta_boxes() {

	$meta_boxes = apply_filters( 'populate_theme_meta_boxes', array() );

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !function_exists( 'ot_register_meta_box' ) )
		return;

	foreach ( $meta_boxes as $meta_box )
	{
		if ( isset( $meta_box['only_on'] ) && !theme_meta_box_maybe_include( $meta_box['only_on'] ) )
			continue;

		//new RW_Meta_Box( $meta_box );
		ot_register_meta_box( $meta_box );
	}
	// unset global variable
	unset( $meta_boxes );
}

/**
 * Check if meta boxes is included
 *
 * @return bool
 */
function theme_meta_box_maybe_include( $conditions ) {
	// Include in back-end only
	if ( !defined( 'WP_ADMIN' ) || !WP_ADMIN )
		return false;

	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		return true;


	if ( isset( $_GET['post'] ) )
		$post_id = $_GET['post'];
	elseif ( isset( $_POST['post_ID'] ) )
		$post_id = $_POST['post_ID'];
	else
		$post_id = false;

	$post_id = (int) $post_id;

	foreach ( $conditions as $cond => $v )
	{
		switch ( $cond )
		{
			case 'id':
				if ( !is_array( $v ) )
					$v = array( $v );
				return in_array( $post_id, $v );
			break;
			case 'slug':
				if ( !is_array( $v ) )
					$v = array( $v );
				$post = get_post( $post_id );
				return in_array( $post->post_name, $v );
			break;
			case 'template':
				if ( !is_array( $v ) )
					$v = array( $v );
				return in_array( get_post_meta( $post_id, '_wp_page_template', true ), $v );
			case 'function':
				if (!empty($v) AND function_exists('rw_'.$v))
					return call_user_func('rw_'.$v);
			case 'meta':
				if (is_array($v) AND (1==count($v)))
				{// We can have only one pair of meta-key and meta value to check
					$result = false;
					foreach ($v as $meta_key => $meta_value) {
						$result = ($meta_value==get_post_meta($post_id, $meta_key, true));
						if (!$result)
							break;
					}
					return $result;
				}
				elseif (false)
				{// We can have several pair of meta to check with conditional operator
					foreach ($v as $meta_key => $meta_value) {
						
					}
				}
				break;
			default:
				
				break;
		}
	}

	// If no condition matched
	return false;
}