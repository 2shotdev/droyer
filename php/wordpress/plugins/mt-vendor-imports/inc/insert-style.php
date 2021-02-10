<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
define('WP_USE_THEMES', false);
require_once("../../../../wp-load.php");
$post_id = 0;
if(wc_get_product_id_by_sku($_GET['sku']) == 0) {
	$post_id = wp_insert_post(array('post_title' => $_GET['title'],'post_type' => 'product','post_staus' => 'publish', 'post_content' => $_GET['description'],'post_excerpt' => ''), true);
} else {
	$post_id = wc_get_product_id_by_sku($_GET['sku']);
}
wp_set_object_terms($post_id, 'variable', 'product_type');
update_post_meta( $post_id, '_visibility', 'visible' );
update_post_meta( $post_id, '_stock_status', 'instock');
update_post_meta( $post_id, 'total_sales', '0' );
update_post_meta( $post_id, '_downloadable', 'no' );
update_post_meta( $post_id, '_virtual', 'no' );
update_post_meta( $post_id, '_sku', $_GET['sku'] );
update_post_meta( $post_id, '_sold_individually', 'no' );
update_post_meta( $post_id, '_manage_stock', 'no' );
update_post_meta( $post_id, '_price', '0.00' );
$atts = array(
	'color' => array("Base"),
	'size' => array("Base"),
    'xe_is_designer' => 1
);
$product_attributes = array();
foreach( $atts as $key => $terms ){
    $taxonomy = wc_attribute_taxonomy_name($key); // The taxonomy slug
    $attr_label = ucfirst($key); // attribute label name
    $attr_name = (wc_sanitize_taxonomy_name($key)); // attribute slug
    // NEW Attributes: Register and save the
    if( ! taxonomy_exists( $taxonomy ) )
        save_product_attribute_from_name( $attr_name, $attr_label );

    $product_attributes[$taxonomy] = array (
        'name'         => $taxonomy,
        'value'        => '',
        'position'     => '',
        'is_visible'   => 1,
        'is_variation' => 1,
        'is_taxonomy'  => 1
    );
    foreach( $terms as $value ){
        $term_name = ucfirst($value);
        $term_slug = sanitize_title($value);
        // Check if the Term name exist and if not we create it.
        if( ! term_exists( $value, $taxonomy ) )
            wp_insert_term( $term_name, $taxonomy, array('slug' => $term_slug ) ); // Create the term

        // Set attribute values
        wp_set_post_terms( $product_id, $term_name, $taxonomy, true );
    }
}
update_post_meta($post_id, '_product_attributes', $product_attributes );
attach_product_thumbnail($post_id, $_GET['image'], 0);
if(!term_exists($_GET['category'])) {
	$term = wp_insert_term($_GET['category'], 'product_cat');
	wp_set_object_terms($post_id, $term,'product_cat');
} else {
	$term = get_term_by('name', $_GET['category'], 'product_cat');
	wp_set_object_terms($post_id, $term->term_id,'product_cat');
}
function clean($string) {
   $string = str_replace(' ', '-', $string);
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}
/* wp_set_object_terms( $post_id, 'simple', 'product_type' );
update_post_meta( $post_id, '_visibility', 'visible' );
update_post_meta( $post_id, '_stock_status', 'instock');
update_post_meta( $post_id, 'total_sales', '0' );
update_post_meta( $post_id, '_downloadable', 'no' );
update_post_meta( $post_id, '_virtual', 'no' );
update_post_meta( $post_id, '_regular_price', '' );
update_post_meta( $post_id, '_sale_price', '' );
update_post_meta( $post_id, '_purchase_note', '' );
update_post_meta( $post_id, '_featured', 'no' );
update_post_meta( $post_id, '_sku', 'SKU11' );
update_post_meta( $post_id, '_product_attributes', array() );
update_post_meta( $post_id, '_sale_price_dates_from', '' );
update_post_meta( $post_id, '_sale_price_dates_to', '' );
update_post_meta( $post_id, '_price', '1' );
update_post_meta( $post_id, '_sold_individually', '' );
update_post_meta( $post_id, '_manage_stock', 'yes' );
/*
//wc_update_product_stock($post_id, $single['qty'], 'set');

foreach($single['genres'] as $prod_cat){
    if(!term_exists($prod_cat, 'product_cat')){
        $term = wp_insert_term($prod_cat, 'product_cat');
        array_push($tag, $term['term_id']);
    } else {
        $term_s = get_term_by( 'name', $prod_cat, 'product_cat' );
        array_push($tag , $term_s->term_id);
    }
}

*/
function save_product_attribute_from_name( $name, $label='', $set=true ){
    if( ! function_exists ('get_attribute_id_from_name') ) return;
    global $wpdb;
    $label = $label == '' ? ucfirst($name) : $label;
    $attribute_id = get_attribute_id_from_name( $name );
    if( empty($attribute_id) ){
        $attribute_id = NULL;
    } else {
        $set = false;
    }
    $args = array(
        'attribute_id'      => $attribute_id,
        'attribute_name'    => $name,
        'attribute_label'   => $label,
        'attribute_type'    => 'select',
        'attribute_orderby' => 'menu_order',
        'attribute_public'  => 0,
    );
    if( empty($attribute_id) ) {
        $wpdb->insert(  "{$wpdb->prefix}woocommerce_attribute_taxonomies", $args );
        set_transient( 'wc_attribute_taxonomies', false );
    }
    if( $set ){
        $attributes = wc_get_attribute_taxonomies();
        $args['attribute_id'] = get_attribute_id_from_name( $name );
        $attributes[] = (object) $args;
        //print_r($attributes);
        set_transient( 'wc_attribute_taxonomies', $attributes );
    } else {
        return;
    }
}
/**
 * Get the product attribute ID from the name.
 *
 * @since 3.0.0
 * @param string $name | The name (slug).
 */
function get_attribute_id_from_name( $name ){
    global $wpdb;
    $attribute_id = $wpdb->get_col("SELECT attribute_id
    FROM {$wpdb->prefix}woocommerce_attribute_taxonomies
    WHERE attribute_name LIKE '$name'");
    return reset($attribute_id);
}
function attach_product_thumbnail($post_id, $url, $flag){
	$image_url = $url;
	$url_array = explode('/',$url);
	$image_name = $url_array[count($url_array)-1];
    $image_data = file_get_contents($image_url);
	$upload_dir = wp_upload_dir(); // Set upload folder
	$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); //    Generate unique name
	$filename = basename( $unique_file_name ); // Create image file name
	// Check folder permission and define file location
	if( wp_mkdir_p( $upload_dir['path'] ) ) {
	    $file = $upload_dir['path'] . '/' . $filename;
	} else {
	    $file = $upload_dir['basedir'] . '/' . $filename;
	}
	// Create the image file on the server
	file_put_contents( $file, $image_data );
	// Check image file type
	$wp_filetype = wp_check_filetype( $filename, null );
	// Set attachment data
	$attachment = array(
	    'post_mime_type' => $wp_filetype['type'],
	    'post_title' => sanitize_file_name( $filename ),
	    'post_content' => '',
	    'post_status' => 'inherit'
	);
	// Create the attachment
	$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
	// Include image.php
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	// Define attachment metadata
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
	// Assign metadata to attachment
	wp_update_attachment_metadata( $attach_id, $attach_data );
	// asign to feature image
	if( $flag == 0){
	    // And finally assign featured image to post
	    set_post_thumbnail( $post_id, $attach_id );
	}
	// assign to the product gallery
	if( $flag == 1 ){
	    // Add gallery image to product
	    $attach_id_array = get_post_meta($post_id,'_product_image_gallery', true);
	    $attach_id_array .= ','.$attach_id;
	    update_post_meta($post_id,'_product_image_gallery',$attach_id_array);
	}
}
echo  '{"d":{"__type":"Contact.Status","ReturnCode":0,"ProductID":"'.$post_id.'"}}';