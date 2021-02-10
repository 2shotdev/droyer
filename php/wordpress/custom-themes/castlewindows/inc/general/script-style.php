<?php
/**
 * Include Styles and Scripts
 *
 * @package WordPress
 * @subpackage CW
 */
/**
 * Register and enqueue some theme scripts and styles
 * 
 * @todo enqueue some scripts only if they are required
 */
function cw_scripts_styles() {
	// Scripts
	wp_enqueue_script( 'cw-inputs', get_stylesheet_directory_uri() .'/inc/assets/js/jquery.maskedinput.js', array( 'jquery' ), '1.0' , true );
	wp_enqueue_script( 'jquery-validation', '//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js', array( 'jquery' ), '1.11.1', true );
	wp_enqueue_script( 'cw', get_stylesheet_directory_uri() .'/inc/assets/js/cw.min.js', array( 'jquery' ), '1.0' , true );
	// Fonts //
	wp_enqueue_style( 'cw-font1', add_query_arg( 'family', 'Open+Sans:400,700', "//fonts.googleapis.com/css" ) );
	wp_enqueue_style( 'cw-font2', add_query_arg( 'family', 'Nunito+Sans:300,400,700', "//fonts.googleapis.com/css" ) );
	// Include theme compiled style
	wp_enqueue_style( 'cw-style', get_stylesheet_directory_uri() . '/inc/assets/css/cw.min.css' );
	wp_enqueue_style( 'cw-select', get_stylesheet_directory_uri() . '/inc/assets/css/chosen.css' );
	wp_enqueue_style( 'carousel-style', get_stylesheet_directory_uri() . '/inc/assets/css/owl.carousel.css' );
	wp_enqueue_script( 'carousel', get_stylesheet_directory_uri() .'/inc/assets/js/owl.carousel.min.js', array( 'jquery' ), '1.0' , true );
};
add_action('wp_enqueue_scripts', 'cw_scripts_styles');
/**
 * Output some theme scripts
 */
add_action('wp_head', 'cw_header_scripts');
function cw_header_scripts() { ?>
	<script type="text/javascript">
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	</script>
	<?php if ( $styles = get_cw_option( 'site_css' ) ): ?>
		<style><?php echo $styles; ?></style>
	<?php endif ?>
<?php }
/**
 * Output some theme scripts
 */
add_action('wp_footer', 'cw_footer_scripts');
function cw_footer_scripts() {
	cw_option( 'footer_scripts' );
}