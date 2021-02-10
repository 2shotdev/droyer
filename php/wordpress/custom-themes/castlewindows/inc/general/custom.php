<?php
/**
 * Different Template functions here
 */

/* Enabling theme options */
function get_cw_option( $key, $default = '' ) {
	return apply_filters( 'theme_option', $default, $key );
}
function cw_option( $key, $default = '' ) {
	echo apply_filters( 'theme_option', $default, $key );
}

/* =Theme Filters
-------------------------------------------------------------- */

/**
 * Replace defult empty selection option '---' with 'Select One' text
 * @param  string $html form html
 * @return string       filtered form html
 */
function cw_wpcf7_form_elements($html) {
	$text = 'Select One';
	$html = str_replace('<option value="">---</option>', '<option value="">' . $text . '</option>', $html);
	return $html;
}
add_filter('wpcf7_form_elements', 'cw_wpcf7_form_elements');

/**
 * Replace special chars in the title
 *
 * @param string post title
 * @return string filtered post title
 */
if ( !is_admin() ) {
	add_filter( 'the_title', 'cw_the_title_replace_specials', 100 );
	add_filter( 'single_term_title', 'cw_the_title_replace_specials', 100 );
}
	
function cw_the_title_replace_specials($title) {
	return str_replace(
		array(
			'&reg;',
			'®',
			'\n',
			'™',
			'&trade;'
		),
		array(
			'<sup>&reg;</sup>',
			'<sup>&reg;</sup>',
			'<br />',
			'<sup>&trade;</sup>',
			'<sup>&trade;</sup>'
		),
		$title);
}

/**
 * Sets the post excerpt length to 40 words.
 * Use global $excerpt_length to change excerpt length
 *
 * @param int number of words
 * @return int filtered number of words
 */
if (!is_admin())
	add_filter( 'excerpt_length', 'theme_name_excerpt_length' );
function theme_name_excerpt_length( $length ) {
	global $excerpt_length;

	$length = !empty($excerpt_length) ? absint($excerpt_length) : 37;

	// Unset global var
	if (!empty($excerpt_length))
		unset($GLOBALS['excerpt_length']);

	return $length;
}


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with nothing.
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
if (!is_admin())
	add_filter( 'excerpt_more', 'theme_name_auto_excerpt_more' );
function theme_name_auto_excerpt_more( $more ) {
	return '';
}

if ( !is_admin() )
	add_filter( 'wp_trim_excerpt', 'theme_name_custom_excerpt_more', 100 );
/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @param string $output post content or excerpt
 * @return string post excerpt with more link
 */
function theme_name_custom_excerpt_more( $output ) {
	return $output;
}
add_filter( 'wp_title', 'theme_name_wp_title', 10, 2 );
/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since nys 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function theme_name_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}

/**
 * Order terms by terms include arg
 * @param  string $orderby    Current orderby statement
 * @param  array $args        get_terms arguments
 * @param  array $taxonomies  get_terms taxonomies
 * @return string             Orderby Statement
 */
function dl_set_terms_orderby_include( $orderby, $args, $taxonomies ) {
	if ( isset( $args['orderby'] ) && 'include' == $args['orderby'] && is_array( $args['include'] ) )
		$orderby = "FIELD( t.term_id, ". implode(',', array_map( 'absint', $args['include'] )) ." )";

	return $orderby;
}

/**
 * Set global var for excerpt lenght
 *
 * @param int $length of excerpt
 */
function set_excerpt_length($length) {
	$GLOBALS['excerpt_length'] = absint($length);
}

/**
 * Set global var for comment lenght
 *
 * @param int $length of content
 */
function set_comment_length($length) {
	$GLOBALS['comment_length'] = $length;
}

/**
 * Returns a "Continue Reading" link for excerpts
 */
function theme_name_continue_reading_link() {
	return ( 'episode' == get_post_type() ) ? '' : ' <a class="continue-reading" href="'. esc_url( get_permalink() ) . '">' . __( 'Continue Reading &raquo;', 'ab' ) .'</a>';
}

/**
 * Gallery is styled by theme css
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Create HTML dropdown list of Categories with category slug as options values.
 *
 * @package WordPress
 * @since 2.1.0
 * @uses Walker
 */
class dl_Walker_CategoryNameDropdown extends Walker_CategoryDropdown {
	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $category Category data object.
	 * @param int $depth Depth of category. Used for padding.
	 * @param array $args Uses 'selected' and 'show_count' keys, if they exist.
	 */
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		$pad = str_repeat('&nbsp;', $depth * 3);

		$cat_name = apply_filters('list_cats', $category->name, $category);
		$output .= "\t<option class=\"level-$depth\" value=\"".$category->slug."\"";
		if ( $category->slug == $args['selected'] )
			$output .= ' selected="selected"';
		$output .= '>';
		$output .= $pad.$cat_name;
		if ( $args['show_count'] )
			$output .= '&nbsp;&nbsp;('. $category->count .')';
		$output .= "</option>\n";
	}
}
