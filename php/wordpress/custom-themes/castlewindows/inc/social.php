<?php
/**
 * Handle every social aspect
 */
class cw_Social {
	function __construct() {
		$this->include_partials();
		// Render share buttons on action
		add_action( 'cw_share_buttons', array( &$this, 'buttons' ), 10, 2 );
		// Include Addthis Scripts
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
	} 

	private function include_partials() {
		$include_path = get_template_directory() . '/inc/social/';
		require( $include_path . 'options.php' );
	}

	/**
	 * Render post social Button
	 * @param  integer $post_id     Current post ID
	 * @param  boolean $with_mobile Disabled in this theme
	 * @return void               
	 */
	public function buttons( $post_id = 0, $with_mobile = false ) {
		$post_id = empty( $post_id ) ? get_the_ID() : $post_id;
		// Try to retrieve permalink first
		$permalink = get_permalink( $post_id );
		if ( $permalink ) {
			echo $this->get_buttons( $permalink, $post_id, $with_mobile );
		}
	}

	/**
	 * Get post social button
	 * @param  string  $permalink   Url to share
	 * @param  integer $post_id     Post ID
	 * @param  boolean $with_mobile Disabled in current theme
	 * @return string               Social icons
	 */
	public function get_buttons( $permalink, $post_id = 0, $with_mobile = false ) {
		$services = get_act_option( 'social_share_services' );
		if ( empty( $services ) || !get_cw_option( 'addthis_id' ) )
			return;
		$icons = '';
		foreach ( $services as $service ) {
			if ( isset( $service['code'] ) && !empty( $service['code'] ) ) {
				$desktop_class = $with_mobile ? 'hide-on-mobile' : ''; // Show this images for desktop only
				$icon = ( isset( $service['image'] ) && !empty( $service['image'] ) ) ? '<img class="'.$desktop_class.'" src="' . esc_attr( $service['image'] ) . '" alt="'. esc_attr( $service['title'] ) .'" />' : '';
				$icon_mobile = ( $with_mobile && isset( $service['mobile_image'] ) && !empty( $service['mobile_image'] ) ) ? '<img class="hide-on-desktop" src="' . esc_attr( $service['mobile_image'] ) . '" alt="'. esc_attr( $service['title'] ) .'" />' : '';
				$icons .= apply_filters( 'share_button', '<a class="'. esc_attr( $service['code'] ) .'">'. $icon . $icon_mobile .'</a>', $service, $post_id );
			}
		}
		// Additional icons wrappers
		if ( !empty( $icons ) ) {
			$with_mobile_class = $with_mobile ? 'with-mobile-social-icons' : '';
			$title = get_the_title( $post_id );
			$icons = '<div addthis:url="' . $permalink . '" addthis:title="'. esc_attr( strip_tags( $title ) ) .'" class="addthis_toolbox addthis_default_style act-add-this bg-white round shadow-black'.$with_mobile_class.'">'. $icons .'</div>';
		}
		return $icons;
	}
	public function enqueue_scripts() {
		$addthis_id = get_cw_option('addthis_id');
		if ( $addthis_id ) {
			wp_register_script( 'addthis', '//s7.addthis.com/js/300/addthis_widget.js#pubid=' . $addthis_id );
			wp_enqueue_script( 'addthis' );
			wp_localize_script( 'addthis', 'addthis_config', array( "data_track_addressbar" => false ) );
		}
	}
}
new cw_Social;