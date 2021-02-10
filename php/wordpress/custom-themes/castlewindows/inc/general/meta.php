<?php
/**
 * Handle every page aspect
 */
$post_id = 0;
//add_filter( 'populate_theme_meta_boxes', 'cw_populate_page_meta_boxes' );
function cw_populate_page_meta_boxes( $meta_boxes = array() ) {
	try {
		$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
	} catch(Exception $e) {
		$post_id = 0;
	}
	$prefix = 'page_';
	$meta_boxes[] = array(
			'id'       => 'page_front_meta',
			'title'    => __( 'Page Options', 'act' ),
			'pages'    => array( 'page' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array(
							'id' => 'show_newsletter',
							'type' => 'on-off',
							'label' => 'Show Newsletter Signup Form'
						)
			)
		);
	return $meta_boxes;
}