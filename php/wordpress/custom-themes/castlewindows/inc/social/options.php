<?php
/**
 * Populate Social Options
 *
 * @package WordPress
 * @subpackage ACT
 */

add_filter( 'populate_theme_options', 'populate_cw_social_options' );
function populate_cw_social_options( $settings = array() ) {
	$settings['sections'][] = array(
		'title' => __('Social', 'cw'),
		'id'    => 'social_settings'
	);
	$settings['settings'][] = array(
		'id'    => 'site_social',
		'label' => __('Site Social Links', 'cw'),
		'type'  => 'list-item',
		'settings'    => array(
			array(
				'label'       => 'Url',
				'id'          => 'url',
				'type'        => 'text',
			),
			array(
				'label'       => 'Class',
				'id'          => 'class',
				'type'        => 'text',
			),
		),
		'section' => 'social_settings',
	);
	$settings['settings'][] = array(
		'id'    => 'social_share_services',
		'label' => __( 'AddThis Sharing Services', 'cw' ),
		'type'  => 'list-item',
		'settings'    => array(
			array(
				'label'       => 'Add This Sevice Code',
				'id'          => 'code',
				'type'        => 'text',
				'desc'        => __( 'All available codes are listed here http://www.addthis.com/services/list', 'cw' )
			),
			array(
				'label'       => 'Custom Icon',
				'id'          => 'image',
				'type'        => 'upload',
			)
		),
		'section' => 'social_settings',
	);

	$settings['settings'][] = array(
		'id'    => 'addthis_id',
		'label' => __( 'AddThis Profile ID', 'cw' ),
		'type'  => 'text',
		'section' => 'social_settings',
	);
	return $settings;
}