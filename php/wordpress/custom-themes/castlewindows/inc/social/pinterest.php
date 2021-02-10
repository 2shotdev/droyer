<?php
/**
 * Addthis Pinterest integration handlers
 *
 * Allow using custom pinterest share icons
 * Pass additional pinterest button meta
 */

class cw_Pinterest_Integration {

	function __construct() {

		// Additional attributes for pinterest share button
		add_filter( 'share_button', array( &$this, 'button_attrs' ), 10, 3 );

		// Pinterest icon styles
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue' ) );

		// Pinterest icon image
		add_action( 'wp_head', array( &$this, 'pinterest_styles' ) );
	}

	/**
	 * Add custom attributes for pinterest button
	 * @param  string  $button  Pinit AddThis Button
	 * @param  string  $service Addthis Service name, may contain several classes
	 * @param  integer $post_id Target post ID
	 * @return string           Filtered button code
	 */
	public function button_attrs( $button, $service, $post_id = 0 ) {
		if ( ! ( isset( $service['code'] ) && strpos( $service['code'], 'pinterest' ) !== false ) )
			return $button;

		if ( empty( $post_id ) || !$post = get_post( $post_id ) )
			return $button;

		$attrs = '';

		// Use post thumbnail as featured pinit image
		if ( $attachment_id = get_post_thumbnail_id( $post_id ) ) {
			$src = wp_get_attachment_image_src( $attachment_id, 'full' );
			if ( $src ) {
				$attrs .= ' pi:pinit:media="'. $src[0] .'" ';
			}
		}

		// Pinit buttons are rendered on the front page and also on arcive pages
		$attrs .= ' pi:pinit:url="'. esc_attr( get_permalink( $post_id ) ) .'" ';

		// For some reasons addthis doesn't read description neither from target page url nor from 
		$attrs .= ' pi:pinit:description="'. esc_attr( get_the_title( $post_id ) ) .'" ';

		$href_media = ( isset( $src ) && !empty( $src ) ) ? '&media='. urlencode( $src[0] ) : '';
		$attrs .= ' href="http://pinterest.com/pin/create/button/?url='. urlencode( get_permalink( $post_id ) ) . $href_media .'&description='. urlencode( get_the_title( $post_id ) ) .'"';
		$attrs .= ' target="_blank"';

		$button = str_replace( '<a ', '<a '. $attrs .' ' , $button );

		return $button;
	}

	/**
	 * Custom Pinterest icon css
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_style( 'act_pinterest', get_template_directory_uri() . '/inc/social/pinterest.css' );
	}

	/**
	 * Pinterest icon image styles
	 * @return void
	 */
	public function pinterest_styles() {
		$services = get_act_option( 'social_share_services' );

		if ( empty( $services ) )
			return;

		foreach ( $services as $service ) {
			if ( !isset( $service['code'] ) || empty( $service['code'] ) || strpos( $service['code'] , 'addthis_button_pinterest_pinit') === false )
				continue;

			$mobile = $desktop = '';

			// Add Icon as link style attribute
			if ( isset( $service['image_id'] ) ) {
				$src = wp_get_attachment_image_src( absint( $service['image_id'] ), 'full' );

				if ( $src ) {
					$desktop = 'background-image: url(\''. $src[0] .'\');height:'. $src[2] .'px;width:'. $src[1] .'px;line-height:'. $src[2] .'px;';
				}
			}

			// Add mobile icon
			if ( isset( $service['mobile_image_id'] ) ) {
				$src = wp_get_attachment_image_src( absint( $service['mobile_image_id'] ), 'full' );

				if ( $src ) {
					$mobile = 'background-image: url(\''. $src[0] .'\');height:'. $src[2] .'px;width:'. $src[1] .'px;line-height:'. $src[2] .'px;';
				}
			}

			?>
			<style type="text/css">
				.addthis_button_pinterest_pinit {
					<?php echo $desktop; ?>
				}
				@media only screen and (max-width: 640px) {
					.with-mobile-social-icons .addthis_button_pinterest_pinit {
						<?php echo $mobile; ?>
					}
				}
			</style>
			<?php

			break;
		}
	}
}

// Front-end only integration
if ( !is_admin() )
	new cw_Pinterest_Integration;