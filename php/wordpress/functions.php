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
            require( get_template_directory().'/inc/shared.php' );
            require( get_template_directory().'/inc/social.php' );
            require( get_template_directory().'/inc/module.php' );
            require( get_template_directory().'/inc/recipe.php' );
            require( get_template_directory().'/inc/faqs.php' );
            require( get_template_directory().'/inc/hcp.php' );
            require( get_template_directory().'/inc/news.php' );
            require( get_template_directory().'/inc/blog.php' );
            require( get_template_directory().'/inc/story.php' );
            require( get_template_directory().'/inc/general.php' );
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
add_filter( 'wp_nav_menu_footer-legal_items', 'neo_footer_menu_filter' );
function neo_footer_menu_filter( $items){
	$ext = '<li>'.sprintf(get_rg_option( 'site_copyright' ), date('Y')).'</li>';
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
    array('title' => 'H3 White','classes' => 'white uppercase f24 lato-bold','block' => 'h3','wrapper' => false),
    array('title' => 'H3 Purple','classes' => 'purple uppercase f24 lato-bold','block' => 'h3','wrapper' => false),
    array('title' => 'H3 Grey','classes' => 'grey uppercase f24 lato-bold','block' => 'h3','wrapper' => false),
    array('title' => 'H4 White','classes' => 'white uppercase f18 lato-bold','block' => 'h4','wrapper' => false),
    array('title' => 'H4 Purple','classes' => 'purple uppercase f18 lato-bold','block' => 'h4','wrapper' => false),
    array('title' => 'H4 Grey','classes' => 'grey uppercase f18 lato-bold','block' => 'h4','wrapper' => false),
    array('title' => 'Blog Author Name','classes' => 'lato-bold italic','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,ul,li'),
    array('title' => 'Content Block','classes' => '','block' => 'div','wrapper' => true),
    array('title' => 'Paragraph','classes' => '','block' => 'p','wrapper' => true),
    array('title' => 'Lato Bold','classes' => 'lato-bold','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,ul,li'),
    array('title' => 'LunchBox','classes' => 'lunchbox','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,ul,li'),
    array('title' => 'LunchBox Bold','classes' => 'lunchbox-bold','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,ul,li'),
    array('title' => 'Bold','classes' => 'bold','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,ul,li'),
    array('title' => 'Italic','classes' => 'italic','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,ul,li'),
    array('title' => 'Uppercase','classes' => 'uppercase','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,ul,li'),
    array('title' => 'Font Purple','classes' => 'purple','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Light Purple','classes' => 'lt-purple','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Pink','classes' => 'pink','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Violet','classes' => 'violet','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Magenta','classes' => 'magenta','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Green','classes' => 'green','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Blue','classes' => 'blue','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Orange','classes' => 'orange','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Turquois','classes' => 'turquois','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font Peach','classes' => 'peach','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Font White','classes' => 'white','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
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
    array('title' => 'Width 40','classes' => 'w40','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Width 45','classes' => 'w45','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Width 67','classes' => 'w67','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'Width 75','classes' => 'w75','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6'),
    array('title' => 'White Button','classes' => 'white-button button purple f16 uppercase','selector' => 'a'),
    array('title' => 'Purple Button','classes' => 'purple-button button white f16 uppercase','selector' => 'a'),
    array('title' => 'Light Purple Button','classes' => 'lt-purple-button button white f16 uppercase','selector' => 'a'),
    array('title' => 'Pink Button','classes' => 'pink-button button white f16 uppercase','selector' => 'a'),
    array('title' => 'Grey Button','classes' => 'grey-button button white f16 uppercase','selector' => 'a'),
    array('title' => 'Purple Border Top','classes' => 'border-top1-lt-purple','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Grey Border Top','classes' => 'border-top1-grey','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Purple Border Bottom','classes' => 'border-bottom1-lt-purple', 'selector'=> 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Grey Border Bottom','classes' => 'border-bottom1-grey','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Padding Top Large','classes' => 'plarge','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Padding Top Medium','classes' => 'pmedium','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Padding Top Small','classes' => 'psmall','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Padding Top Extra Small','classes' => 'pxsmall','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Padding Top Mini','classes' => 'pxxsmall','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Padding Bottom Large','classes' => 'pblarge','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Padding Bottom Medium','classes' => 'pbmedium','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Padding Bottom Small','classes' => 'pbsmall','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Padding Bottom Extra Small','classes' => 'pbxsmall','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
    array('title' => 'Padding Bottom Mini','classes' => 'pbxxsmall','selector' => 'a,span,div,p,h1,h2,h3,h4,h5,h6,h1,h2,h3,h4,h5,h6,table,tr,td,ul,li'),
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
    return 'Neocate';
}
function search_url_rewrite_rule() {
    if ( is_search() && !empty($_GET['s'])) {
        wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
        exit();
    }   
}
add_action('template_redirect', 'search_url_rewrite_rule');
function custom_excerpt_length( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
add_filter('the_excerpt', 'my_the_excerpt', 5, 1);
function my_the_excerpt($excerpt)
{
    return $excerpt . '...';
}
add_action( 'admin_head', 'load_admin_style' );
function load_admin_style() {
        wp_enqueue_style( 'admin_css', get_stylesheet_directory_uri() . '/neocate.css', false, '1.0.0' );
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
        $wp_query->query_vars['posts_per_page'] = get_neo_option('search_count');
    }
    return $limits;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
    foreach($classes as $class) :
        if(isset($_COOKIE['LoggedIn']) && strtolower($_COOKIE['LoggedIn']) == "true") {
            if($class == "loggedout") {
            $classes[] = "force-nav-hide";
            }
        } else {
            if($class == "loggedin") {
            $classes[] = "force-nav-hide";
            }
        }
    endforeach;
    return $classes;
}
add_filter( 'wpseo_sitemap_index', 'add_sitemap_custom_items' );
function add_sitemap_custom_items() {
   $sitemap_custom_items = '
<sitemap>
<loc>'.get_home_url().'/product-sitemap.xml</loc>
<lastmod>2018-03-01T23:12:27+00:00</lastmod>
</sitemap>';
 
/* DO NOT REMOVE ANYTHING BELOW THIS LINE
 * Send the information to Yoast SEO
 */
return $sitemap_custom_items;
}
//flush_rewrite_rules();