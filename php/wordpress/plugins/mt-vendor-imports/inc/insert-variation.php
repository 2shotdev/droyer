<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../../../../wp-load.php");
$pid = $_GET['pid'];
$cat = $_GET['cat'];
$vdata = array(
	'attributes' => array (
		'color' => array($_GET['color']),
		'size' => array($_GET['size'])
	),
	'sku' => $_GET['sku'],
	'regular_price' => '0.00'
);
$vid = create_product_variation_old($pid,$vdata);

// $product = wc_get_product($pid);
// $varpost = array(
//     'title'  => $product->get_name(),
//     'content' => $product->post_content,
//     'excerpt' => '',
//     'attributes' => array (
// 		'color' => array($_GET['color']),
// 		'size' => array($_GET['size'])
// 	),
// 	'stock' => '1000',
// 	'sku' => $_GET['sku'],
// 	'regular_price' => '0.00'
// );

// create_product_variation($varpost, $cat);
/**
 * Save a new product attribute from his name (slug).
 *
 * @since 3.0.0
 * @param string $name  | The product attribute name (slug).
 * @param string $label | The product attribute label (name).
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

/**
 * Create a new variable product (with new attributes if they are).
 * (Needed functions:
 *
 * @since 3.0.0
 * @param array $data | The data to insert in the product.
 */

function create_product_variation($data, $category){
    if( ! function_exists ('save_product_attribute_from_name') ) return;
    if(wc_get_product_id_by_sku($_GET['sku']) == 0) {
	    $postname = sanitize_title( $data['title'] );
	    $author = empty( $data['author'] ) ? '1' : $data['author'];

	    $post_data = array(
	        'post_author'   => $author,
	        'post_name'     => $postname,
	        'post_title'    => $data['title'],
	        'post_content'  => $data['content'],
	        'post_excerpt'  => $data['excerpt'],
	        'post_status'   => 'publish',
	        'ping_status'   => 'closed',
	        'post_type'     => 'product',
	        'guid'          => home_url( '/product/'.$postname.'/' ),
	    );

	    // Creating the product (post data)
	    $product_id = wp_insert_post( $post_data );
	    $trm = get_term_by('name', $category, 'product_cat');
		wp_set_object_terms($product_id, $trm->term_id,'product_cat');
	} else {
		$post_id = wc_get_product_id_by_sku($_GET['sku']);
	}
    // Get an instance of the WC_Product_Variable object and save it
    $product = new WC_Product_Variable( $product_id );
    $product->save();

    ## ---------------------- Other optional data  ---------------------- ##
    ##     (see WC_Product and WC_Product_Variable setters methods)

    // THE PRICES (No prices yet as we need to create product variations)

    // IMAGES GALLERY
    if( ! empty( $data['gallery_ids'] ) && count( $data['gallery_ids'] ) > 0 )
        $product->set_gallery_image_ids( $data['gallery_ids'] );

    // SKU
    if( ! empty( $data['sku'] ) )
        $product->set_sku( $data['sku'] );

    // STOCK (stock will be managed in variations)
    $product->set_stock_quantity( $data['stock'] ); // Set a minimal stock quantity
    $product->set_manage_stock(true);
    $product->set_stock_status('');

    // Tax class
    if( empty( $data['tax_class'] ) )
        $product->set_tax_class( $data['tax_class'] );

    // WEIGHT
    if( ! empty($data['weight']) )
        $product->set_weight(''); // weight (reseting)
    else
        $product->set_weight($data['weight']);

    $product->validate_props(); // Check validation

    ## ---------------------- VARIATION ATTRIBUTES ---------------------- ##

    $product_attributes = array();

    foreach( $data['attributes'] as $key => $terms ){
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
    update_post_meta( $product_id, '_product_attributes', $product_attributes );
    $product->save();
}
function create_product_variation_old( $product_id, $variation_data ){
    // Get the Variable product object (parent)
    $product = wc_get_product($product_id);
    $variation_id=0;
    if(wc_get_product_id_by_sku($_GET['sku']) == 0) {
	    $variation_post = array(
	        'post_title'  => $product->get_name(),
	        'post_name'   => 'product-'.$product_id.'-variation',
	        'post_status' => 'publish',
	        'post_parent' => $product_id,
	        'post_type'   => 'product_variation',
	        'guid'        => $product->get_permalink()
	    );
	    // Creating the product variation
	    $variation_id = wp_insert_post($variation_post);
    	$variation = new WC_Product_Variation($variation_id);
	    // Get an instance of the WC_Product_Variation object
	} else {
		$variation_id = wc_get_product_id_by_sku($_GET['sku']);
    	$variation = new WC_Product_Variation($variation_id);
	}
    // Iterating through the variations attributes
	attach_product_thumbnail($variation_id, $_GET['image'], 0);
    foreach ($variation_data['attributes'] as $attribute => $term_name )
    {
        $taxonomy = 'pa_'.$attribute; // The attribute taxonomy
        if( ! taxonomy_exists( $taxonomy ) ){
            register_taxonomy(
                $taxonomy,
               'product_variation',
                array(
                    'hierarchical' => false,
                    'label' => ucfirst( $attribute ),
                    'query_var' => true,
                    'rewrite' => array( 'slug' => sanitize_title($attribute) ), // The base slug
                ),
            );
        }
        // Check if the Term name exist and if not we create it.
        if( ! term_exists( $term_name, $taxonomy ) )
            wp_insert_term( $term_name, $taxonomy ); // Create the term

        $term_slug = get_term_by('name', $term_name, $taxonomy )->slug; // Get the term slug
        // Get the post Terms names from the parent variable product.
        $post_term_names =  wp_get_post_terms( $product_id, $taxonomy, array('fields' => 'names') );
        // Check if the post term exist and if not we set it in the parent variable product.
        if( ! in_array( $term_name, $post_term_names ) )
            wp_set_post_terms( $product_id, $term_name, $taxonomy, true );

        // Set/save the attribute data in the product variation
        update_post_meta($variation_id, 'attribute_'.$taxonomy, sanitize_title(strtolower($term_name[0])) );
        //wp_set_post_terms($variation_id, $term_name, $taxonomy, true );
    }
    ## Set/save all other data
    // SKU
    if( ! empty( $variation_data['sku'] ) )
        $variation->set_sku( $variation_data['sku'] );
    // Prices
    if( empty( $variation_data['sale_price'] ) ){
        $variation->set_price( $variation_data['regular_price'] );
    } else {
        $variation->set_price( $variation_data['sale_price'] );
        $variation->set_sale_price( $variation_data['sale_price'] );
    }
    $variation->set_regular_price( $variation_data['regular_price'] );
    // Stock
    if( ! empty($variation_data['stock_qty']) ){
        $variation->set_stock_quantity( $variation_data['stock_qty'] );
        $variation->set_manage_stock(true);
        $variation->set_stock_status('');
    } else {
        $variation->set_manage_stock(false);
    }
    $variation->set_weight(''); // weight (reseting)
    $variation->save(); // Save the data
    return $variation_id;
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
echo  '{"d":{"__type":"Contact.Status","ReturnCode":0,"ProductID":"'.$vid.'"}}';