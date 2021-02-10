<?php
/**
 * theme_name theme functions and definitions
 *
 * @package WordPress
 * @subpackage theme_name
 */
if(!session_id()) {
   session_start();
}
add_action( 'after_setup_theme', 'theme_name_setup' );
function theme_name_setup() {
            require( get_template_directory().'/inc/general.php' );
            require( get_template_directory().'/inc/shared.php' );
            require( get_template_directory().'/inc/social.php' );
	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );
	// Enable thumbnails
	add_theme_support( 'post-thumbnails' );
	// This theme uses wp_nav_menus() in one location.
	register_nav_menus(array(
                                'utility' => __( 'Utility Navigation', 'dl' ),
		                        'primary' => __( 'Primary Navigation', 'dl' ),
                                'footer' => __( 'Footer Navigation', 'dl' ),
                                'mobile' => __( 'Mobile Navigation', 'dl' ),
	));
}
add_filter( 'wp_nav_menu_footer-legal_items', 'cw_footer_menu_filter' );
function cw_footer_menu_filter( $items){
	$ext = '<li>'.sprintf(get_cw_option( 'site_copyright' ), date('Y')).'</li>';
	$items = $items.$ext;	 
	return $items; 
}
function get_social_large() {
     get_theme_part( 'global', 'social' );
}
add_shortcode( 'social', 'get_social' );
function my_mce_buttons( $buttons ) {
   array_unshift( $buttons, 'styleselect' );
   return $buttons;
}
function sub_pages_shortcode() {
    ob_start();
    include(get_theme_part( 'global', 'sub-pages' ));
    $output = ob_get_clean();
    return $output;
}
add_shortcode('sub-pages', 'sub_pages_shortcode');
add_filter('mce_buttons', 'my_mce_buttons');
function mce_mod( $init ) {
   $init['block_formats'] = "Paragraph=p;";
   $style_formats = array(
    array('title' => 'H1','classes' => 'uppercase ','block' => 'h1','wrapper' => false),
    array('title' => 'H2','classes' => 'uppercase','block' => 'h2','wrapper' => false),
    array('title' => 'H3','classes' => 'uppercase','block' => 'h3','wrapper' => false),
    array('title' => 'BlockQuote','classes' => 'left ','block' => 'blockquote','wrapper' => false),
    array('title' => 'Content Block','classes' => '','block' => 'div','wrapper' => true),
    array('title' => 'Paragraph','classes' => '','block' => 'p','wrapper' => true),
    array('title' => 'Bold','classes' => 'bold','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,ul,li'),
    array('title' => 'Italic','classes' => 'italic','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,ul,li'),
    array('title' => 'Uppercase','classes' => 'uppercase','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,ul,li'),
    array('title' => 'Black Button','classes' => 'black-button button','selector' => 'a'),
    array('title' => 'Font White','classes' => 'white','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Black','classes' => 'black','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Yellow','classes' => 'darkgrey','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 11','classes' => 'f11','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 12','classes' => 'f12','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 14','classes' => 'f14','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 16','classes' => 'f16','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 18','classes' => 'f18','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 20','classes' => 'f20','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 22','classes' => 'f22','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 24','classes' => 'f24','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 26','classes' => 'f26','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 28','classes' => 'f28','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 30','classes' => 'f30','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 32','classes' => 'f32','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 34','classes' => 'f34','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 36','classes' => 'f36','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 38','classes' => 'f38','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 40','classes' => 'f40','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 42','classes' => 'f42','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 44','classes' => 'f44','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 46','classes' => 'f46','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 48','classes' => 'f48','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 50','classes' => 'f50','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 52','classes' => 'f52','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 54','classes' => 'f54','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 56','classes' => 'f56','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 60','classes' => 'f60','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 62','classes' => 'f62','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 64','classes' => 'f64','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Size 66','classes' => 'f66','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Margin Top Extra Extra Small','classes' => 'mxxsmall','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Margin Top Extra Small','classes' => 'mxsmall','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Margin Top Small','classes' => 'msmall','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Margin Top Medium','classes' => 'mmedium','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Margin Bottom Extra Extra Small','classes' => 'mbxxsmall','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Margin Bottom Extra Small','classes' => 'mxsmall','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Margin Bottom Small','classes' => 'mbsmall','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Margin Bottom Medium','classes' => 'mbmedium','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Width 40','classes' => 'w40','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Width 45','classes' => 'w45','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Width 67','classes' => 'w67','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Width 75','classes' => 'w75','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6')
   );
   $init['style_formats'] = json_encode( $style_formats );
   return $init;
}
add_action('admin_head', 'ot_fixes');
function ot_fixes() {
  echo '<style>.type-checkbox{max-height:300px;overflow-y:scroll;}</style>';
}
add_filter('tiny_mce_before_init', 'mce_mod');
remove_filter( 'the_content', 'wpautop' );
function the_slug($post) {
    $post_data = get_post($post, ARRAY_A);
    $slug = $post_data['post_name'];
    return $slug; 
}
function get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}
add_action('admin_print_footer_scripts','my_admin_print_footer_scripts',99);
add_filter( 'wp_mail_from_name', 'custom_wp_mail_from_name' );
function custom_wp_mail_from_name( $original_email_from ) {
    return 'Castle Windows';
}
function search_url_rewrite_rule() {
    if ( is_search() && !empty($_GET['s'])) {
        wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
        exit();
    }   
}
//add_action('template_redirect', 'search_url_rewrite_rule');
function custom_excerpt_length( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
add_filter('the_excerpt', 'my_the_excerpt', 5, 1);
function my_the_excerpt($excerpt)
{
    return $excerpt . '...';
}
function wpb_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'wpb_move_comment_field_to_bottom' );
add_filter('post_limits', 'postsperpage');
function postsperpage($limits) {
    if (is_search()) {
        global $wp_query;
        $wp_query->query_vars['posts_per_page'] = get_act_option('search_count');
    }
    return $limits;
}
function my_custom_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Castle Windows Blog', 'your-theme-domain' ),
            'id' => 'custom-side-bar',
            'description' => __( 'Blog Sidebar', 'your-theme-domain' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'my_custom_sidebar' );
flush_rewrite_rules();


function cw_theme_styles() {
	wp_enqueue_style( 'cw_extra_css', get_template_directory_uri() . '/style.css' );

}
add_action( 'wp_enqueue_scripts', 'cw_theme_styles' );



add_action('wp_footer', 'elementor_form_hide');
function elementor_form_hide() {
?>

<script>
	jQuery( document ).ready(function( $ ){
		$( document ).on('submit_success', function(){
			$( ".elementor-form-fields-wrapper" ).css( "display", "none" );
		});
	});
</script>

<?php
};