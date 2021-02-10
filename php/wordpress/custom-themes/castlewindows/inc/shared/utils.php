<?php
/**
 * Theme utilities functions
 *
 * @package WordPress
 * @subpackage theme_name
 */


/* =$wp_query Helper Functions
-------------------------------------------------------------- */

/**
 * Output number of posts on current page
 * @return void
 */
function post_count( $query_obj = null ) {
	echo get_post_count( $query_obj );
}

/**
 * Return number of posts on current page
 * @return int number of posts on current page
 */
function get_post_count( $query_obj = null ) {

	// Use passed WP_Query instance
	$query_obj = empty( $query_obj ) ? $GLOBALS['wp_query'] : $query_obj;

	return $query_obj->post_count;
}

/**
 * Output number of found posts
 * @return void
 */
function found_posts( $query_obj = null ) {
	echo get_found_posts( $query_obj );
}

/**
 * Return number of all found posts if this variable is not empty
 * @return int number of posts
 */
function get_found_posts( $query_obj = null ) {

	// Use passed WP_Query instance
	$query_obj = empty( $query_obj ) ? $GLOBALS['wp_query'] : $query_obj;

	return $query_obj->found_posts ? $query_obj->found_posts : get_post_count( $query_obj );
}

/**
 * Output post number, starting from 1
 * @return void
 */
function the_post_number() {
	echo get_the_post_number()+1;
}

/**
 * Get post number in the query
 * @return int
 * @todo post number must calculate also page number and offset if isset
 */
function get_the_post_number( $query_obj = null ) {

	$query_obj = empty( $query_obj ) ? $GLOBALS['wp_query'] : $query_obj;

	// Post number in current loop
	$number = $query_obj->current_post;

	// Include previuos page posts
	if ( !is_first_page() )
		$number += $query_obj->get( 'posts_per_page' )*get_the_page_number(false, $query_obj);

	return $number;
}

/**
 * Is first post in the loop
 * @return bool
 * @todo add additional param to count page
 */
function is_first_post( $query_obj = null ) {
	return get_the_post_number( $query_obj ) == 0;
}

/**
 * Is last post in the loop
 * @return bool
 * @todo add additional param to count page
 */
function is_last_post( $query_obj = null ) {
	return get_post_count( $query_obj ) == ( get_the_post_number( $query_obj ) + 1 );
}

/**
 * Get page number in the loop
 * @return int page index number
 */
function get_the_page_number( $start_from_first = false, $query_obj = null ) {

	// Use passed WP_Query instance
	$query_obj = empty( $query_obj ) ? $GLOBALS['wp_query'] : $query_obj;

	return ( $start_from_first && $query_obj->get( 'paged' ) == 0 ) ? 1 : $query_obj->get( 'paged' );
}

/**
 * Is first page in the loop
 * @return bool 
 */
function is_first_page() {
	return get_the_page_number()==0;
}

/**
 * Is last page in the query
 * @return bool
 */
function is_last_page( $query_obj = null ) {

	// Use passed WP_Query instance
	$query_obj = empty( $query_obj ) ? $GLOBALS['wp_query'] : $query_obj;

	return get_the_page_number( true, $query_obj ) >= $query_obj->max_num_pages;
}

/**
 * Get max_num_pages attriute of current wp_query
 * @return int total pages number in current query
 */
function get_max_num_pages( $query_obj = null ) {
	
	// Use passed WP_Query instance
	$query_obj = empty( $query_obj ) ? $GLOBALS['wp_query'] : $query_obj;

	return $query_obj->max_num_pages;
}

/* =Post meta helper functions
-------------------------------------------------------------- */

/**
 * Output post meta value
 *
 */
function the_post_meta($key, $default='') {
	echo get_the_post_meta($key) ? get_the_post_meta($key) : $default;
}

/**
 * Output post meta value
 *
 */
function get_the_post_meta($key, $single=true) {
	return get_post_meta(get_the_ID(), $key, $single);
}


/* = Usefull theme functions
-------------------------------------------------------------- */

/**
 * This is rewrite of default function get_template_part
 * Add ability to searches for theme files in subdirectories
 */
function get_theme_part( $slug, $name = null ) {
	$templates = array();
	if ( isset($name) )
	{
		$templates[] = "{$slug}/{$name}.php";
		$templates[] = "{$slug}-{$name}.php";
	}

	$templates[] = "{$slug}.php";

	locate_template($templates, true, false);
	do_action('theme_part_after', $slug, $name);		
}


/**
 * Output even or odd post class
 */
function even_odd_post_class($even='even', $odd='odd') {
	echo 'class="'.get_even_odd_post_class($even, $odd).'"';
}

/**
 * Return either even or odd class_name
 * can be used only inside the loop
 */
function get_even_odd_post_class($even='even', $odd='odd') {
	return (0==get_the_post_number()%2) ? $even : $odd;
}


/* = Other usefull functions
-------------------------------------------------------------- */

/**
 * Returns requested $value
 *
 * @since 6.0
 * @access public
 *
 * @param string $value The value to retrieve
 * @return string|bool The value if it exists, false if not
 */
function get_posted_value( $value ) {
	if ( isset( $_REQUEST[$value] ) )
		return stripslashes( $_REQUEST[$value] );
	return false;
}

/**
 * Outputs requested value
 *
 * @since 6.0
 * @access public
 *
 * @param string $value The value to retrieve
 */
function the_posted_value( $value ) {
	echo esc_attr( get_posted_value( $value ) );
}

/**
 * Cut Strings (detects words)
 *
 * @return string
 */
function cut($string, $max_length){
	$string = strip_tags($string);
	if (strlen($string) > $max_length){
		$string = substr($string, 0, $max_length);
		$pos = strrpos($string, " ");
		if($pos === false) {
				return substr($string, 0, $max_length)."...";
		}
			return substr($string, 0, $pos)."...";
	}else{
		return $string;
	}
}

/**
 * Function to return current page url
 *
 * @return string (page url)
 */
function current_url() {
	$pageURL = 'http';
	if (isset($_SERVER["HTTPS"]) AND $_SERVER["HTTPS"] == "on")
		{$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80")
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	else
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	return $pageURL;
}

/**
 * Get image id by image url
 *
 * @param string $url url to image
 */
function get_image_id_by_url($url='') {
	global $wpdb;
	// checck if image is in upload dir
	$uploads = wp_upload_dir();
	if (strpos($url, $uploads['baseurl'])===false)
		return 0;
	// remove home url from image url
	$url = substr($url, strlen(home_url()), ( strlen($url) - strlen(home_url()) ));
	// search for image id 
	$sql = "SELECT ID FROM $wpdb->posts WHERE guid LIKE '%$url%' LIMIT 1";
	$id = $wpdb->get_var($sql);

	return absint($id);
}
/**
  Get Single Post Category
*/
  function get_single_post_category($id, $category) {
  	$cat;
  	$terms = get_the_terms( $id, $category );
  	if ( $terms != null ){
	 	foreach( $terms as $term ) {
	  		$cat=$term->slug ;
		}
	} 
  	return $cat;
  }
  /**
  Get Multiple Post Category
*/
  function get_multiple_post_category($id, $category) {
  	$cat = array();
  	$terms = get_the_terms( $id, $category );
  	if ( $terms != null ){
	 	foreach( $terms as $term ) {
	  		$cat[]=$term->slug ;
		}
	} 
  	return $cat;
  }