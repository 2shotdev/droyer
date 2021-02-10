<?php
/**
 * General CW theme handler
 */

class cw_General {

	function __construct() {

		// Remove unused taxonomies and post types
		// add_action( 'init', array( &$this, 'unregister_post_type' ), 1 );
		// add_action( 'registered_taxonomy', array( &$this, 'unregister_post_terms' ), 1 );

		// if ( is_admin() )
		// 	add_action( 'admin_print_styles', array( &$this, 'hide_posts_menu_item') );

		$this->include_modules();
	}

	private function include_modules() {
		$include_path = get_template_directory() . '/inc/general/';
		require( $include_path . 'custom.php' );
		require( $include_path . 'script-style.php' );
		require( $include_path . 'options.php' );
		require( $include_path . 'meta.php' );
	}
 
	 /* Unregister default post_type
	 * @param string post type to unregister
	 */
	public function unregister_post_type( $post_type = '' ) {
		global $wp_post_types;

		$post_type = empty($post_type) ? 'post' : '';
		if ( isset( $wp_post_types[ $post_type ] ) )
			unset( $wp_post_types[ $post_type ] );
	}

	/**
	 * Hide posts menu item in admin panel
	 */
	function hide_posts_menu_item() {
		?>
			<style type="text/css">
				#menu-posts {display:none}
			</style>
		<?php
	}	

	public function unregister_post_terms( $taxonomy ) {
		global $wp_taxonomies, $wp_rewrite;

		if ( !in_array( $taxonomy, array( 'post_tag', 'category', 'post_format' ) ) )
			return;

		if ( isset( $wp_taxonomies[ $taxonomy ] ) ) {
			unset( $wp_taxonomies[ $taxonomy ] );

			// unset rewrites
			unset( $wp_rewrite->extra_permastructs[ $taxonomy ] );
			$position = array_search( '%'.$taxonomy.'%', $wp_rewrite->rewritecode );
			unset( $wp_rewrite->rewritecode[ $position ] );
			unset( $wp_rewrite->rewritereplace[ $position ] );
			unset( $wp_rewrite->queryreplace[ $position ] );

			remove_filter( 'wp_ajax_add-' . $taxonomy, '_wp_ajax_add_hierarchical_term' );
		}
	}
}

new cw_General;