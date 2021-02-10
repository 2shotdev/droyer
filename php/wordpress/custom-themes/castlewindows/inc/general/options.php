<?php
/**
 * Populate product meta boxes
 *
 * @package WordPress
 * @subpackage ACT
 */
add_filter( 'populate_theme_options', 'populate_cw_general_options' );
function populate_cw_general_options( $settings = array() ) {
	$settings['sections'][] = array(
		'title' => __('General', 'cw'),
		'id'    => 'general_settings'
	);
	$settings['settings'][] = array(
		'id'    => 'site_logo',
		'label' => __( 'Site Logo', 'cw' ),
		'type'  => 'upload',
		'section' => 'general_settings'
	);
	$settings['settings'][] = array(
		'id'    => 'site_icons',
		'label' => __( 'Site Icons', 'cw' ),
		'type'  => 'upload',
		'section' => 'general_settings'
	);
	$settings['settings'][] = array(
		'id'    => 'social_icons',
		'label' => __( 'Social Icons', 'cw' ),
		'type'  => 'upload',
		'section' => 'social_settings'
	);
	return $settings;
}
add_filter( 'populate_theme_options', 'populate_cw_footer_options' );
function populate_cw_footer_options( $settings = array() ) {
	$settings['sections'][] = array(
		'title' => __('Footer', 'cw'),
		'id'    => 'footer_settings'
	);
	$settings['settings'][] = array(
		'id'    => 'footer_section1',
		'label' => __( 'Left Content', 'cw' ),
		'type'  => 'textarea',
		'section' => 'footer_settings'
	);
	$settings['settings'][] = array(
		'id'    => 'footer_section2',
		'label' => __( 'Center Content', 'cw' ),
		'type'  => 'textarea',
		'section' => 'footer_settings'
	);
	$settings['settings'][] = array(
		'id'    => 'footer_section3',
		'label' => __( 'Right Content', 'cw' ),
		'type'  => 'textarea',
		'section' => 'footer_settings'
	);
	return $settings;
}
add_filter( 'populate_theme_options', 'populate_cw_search_options' );
function populate_cw_search_options( $settings = array() ) {
	$settings['sections'][] = array(
		'title' => __('Search Options', 'cw'),
		'id'    => 'search_settings'
	);
	$settings['settings'][] = array(
		'id'    => 'search_title',
		'label' => __( 'Search Title', 'cw' ),
		'type'  => 'text',
		'section' => 'search_settings',
	);
	$settings['settings'][] = array(
		'id'    => 'search_count',
		'label' => __( 'Search Results per page', 'cw' ),
		'type' => 'numeric-slider',
		'min_max_step'=> '0,25,1',
		'section' => 'search_settings',
	);
	$settings['settings'][] = array(
		'id'    => 'search_found',
		'label' => __( 'Search results found', 'cw' ),
		'type'  => 'textarea',
		'section' => 'search_settings',
	);
	$settings['settings'][] = array(
		'id'    => 'search_none',
		'label' => __( 'No Search results', 'cw' ),
		'type'  => 'text',
		'section' => 'search_settings',
	);
	$settings['settings'][] = array(
		'id'    => 'search_none_content',
		'label' => __( 'No Search results content', 'cw' ),
		'type'  => 'textarea',
		'section' => 'search_settings',
	);
	$settings['settings'][] = array(
		'id'    => 'search_image',
		'label' => __( 'Search Image', 'cw' ),
		'type'  => 'upload',
		'section' => 'search_settings'
	);
	return $settings;
}
add_filter( 'populate_theme_options', 'populate_cw_under_the_hood_options' );
function populate_cw_under_the_hood_options( $settings = array() ) {
	$settings['sections'][] = array(
		'title' => __('Under The Hood', 'cw'),
		'id'    => 'under_the_hood_settings'
	);
 	$settings['settings'][] = array(
		'id'    => 'header_scripts',
		'label' => __( 'Header Content', 'cw' ),
		'desc' => 'The information entered will be added to the header of every page.',
		'type'  => 'textarea-simple',
		'section' => 'under_the_hood_settings',
	);
 	$settings['settings'][] = array(
		'id'    => 'footer_scripts',
		'label' => __( 'Footer Content', 'cw' ),
		'desc' => 'The information entered will be added to the footer of every page.',
		'type'  => 'textarea-simple',
		'section' => 'under_the_hood_settings',
	);
 	$settings['settings'][] = array(
		'id'    => 'ga_events',
		'label' => __( 'Google Analytics Event Tracking', 'cw' ),
		'desc' => 'The script below will allow you to add specific event tracking to the site.  This will be placed on every page of the site.',
		'type'  => 'javascript',
		'section' => 'under_the_hood_settings',
	);
	return $settings;
}
add_filter( 'populate_theme_options', 'populate_cw_404_options' );
function populate_cw_404_options( $settings = array() ) {
	$settings['sections'][] = array(
		'title' => __('404', 'cw'),
		'id'    => '404_settings'
	);
	$settings['settings'][] = array(
		'id'    => '404_lead_text',
		'label' => __( '404 Page Lead Text', 'cw' ),
		'type'  => 'text',
		'section' => '404_settings',
	);
	$settings['settings'][] = array(
		'id'    => '404_content',
		'label' => __( '404 Content', 'cw' ),
		'type'  => 'textarea',
		'section' => '404_settings',
	);
	return $settings;
}