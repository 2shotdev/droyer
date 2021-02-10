<?php
/*  ----------------------------------------------------------------------------
    Newspaper V9.0+ Child theme - Please do not use this child theme with older versions of Newspaper Theme

    What can be overwritten via the child theme:
     - everything from /parts folder
     - all the loops (loop.php loop-single-1.php) etc
	 - please read the child theme documentation: http://forum.tagdiv.com/the-child-theme-support-tutorial/

*/
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 11);
function theme_enqueue_styles() {
    wp_enqueue_style('td-theme', get_template_directory_uri() . '/style.css', '', TD_THEME_VERSION, 'all' );
    wp_enqueue_style('td-theme-child', get_stylesheet_directory_uri() . '/style.css', array('td-theme'), strval(filemtime(get_template_directory() . '/style.css')), 'all' );
    wp_enqueue_script('moderntips-js', get_stylesheet_directory_uri().'/js/moderntips-old.js', array('jquery'));
    if(in_category('Sponsored', $post->ID)) {
    	wp_enqueue_script( 'moderntips', get_stylesheet_directory_uri() . '/js/moderntips.js', false, '2.0.0' );
    }
}
// Register custom shortcodes
include('custom-shortcodes.php');
add_action('acf/init', 'acf_init_custom');
function acf_init_custom() {
	if( function_exists('acf_register_block') ) {
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'testimonial',
			'title'				=> __('Testimonial'),
			'description'		=> __('A custom testimonial block.'),
			'render_callback'	=> 'my_acf_block_render_callback',
			'category'			=> 'formatting',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'testimonial', 'quote' ),
		));
        // register CTA Button block
		acf_register_block(array(
			'name'				=> 'ctabtn',
			'title'				=> __('CTAButtons'),
			'description'		=> __('Custom block that implements CTA Btn shortcodes'),
			'render_callback'	=> 'my_acf_block_render_callback',
			'category'			=> 'formatting',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'cta', 'shortcode' ),
		));
        // register Mobile Float
		acf_register_block(array(
			'name'				=> 'mobilefloat',
			'title'				=> __('Mobile Float'),
			'description'		=> __('Custom block that renders the actual Mobile Float block'),
			'render_callback'	=> 'my_acf_block_render_callback',
			'category'			=> 'formatting',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'mobile', 'float' ),
		));
        // register RunIt
		acf_register_block(array(
			'name'				=> 'runit',
			'title'				=> __('RunIt()'),
			'description'		=> __('Custom block that provides RunIt() as a function to the post'),
			'render_callback'	=> 'my_acf_block_render_callback',
			'category'			=> 'custom',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'script' ),
		));
	}
}
function remove_pages_from_search($query) {
	if ($query->is_search && !is_admin()) {
		$query->set('post_type', 'post');
		$query->set( 'cat','-35' );
	}
	return $query;
}
add_filter('pre_get_posts','remove_pages_from_search');
function my_acf_block_render_callback( $block ) {
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);

	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/template-parts/block/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/template-parts/block/content-{$slug}.php") );
	}
}
// Remove wpautop from shortcodes
add_filter( 'the_content', 'tgm_io_shortcode_empty_paragraph_fix' );
function tgm_io_shortcode_empty_paragraph_fix( $content ) {
    $array = array(
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']'
    );
    return strtr( $content, $array );
}
function auto_insert_after_post($content) {
	$category_detail=get_the_category(get_the_ID());
	$runnow = "false";
	foreach($category_detail as $cd){
		if($cd->cat_name == "Sponsored" && get_post_type() != "sponsored") {
			$runnow = "true";
		}
	}
	if($runnow == "true") {
		$info = "<div class='acfinfo'";
		$info .= " outboundLink='".get_field("sponsor_link_real",get_the_ID())."' ";
		if(have_rows('outbound_country_links', get_the_ID())):
			while( have_rows('outbound_country_links') ) : the_row();
				$info .= get_sub_field("country_code")."='".get_sub_field("outbound_link")."' ";
			endwhile;
		endif;
		$info .= "fallbackoutboundLink='".get_field("fallback_outbound_link",get_the_ID())."' ";
		if(have_rows('fallback_country_links', get_the_ID())):
			while( have_rows('fallback_country_links') ) : the_row();
				$info .= get_sub_field("fallback_country_code")."fallback='".get_sub_field("fallback_country_link")."' ";
			endwhile;
		endif;
		$info .= "softPop='".get_field("soft_pop",get_the_ID())."' ";
		$info .= "softPopLink='".get_field("soft_exit_pop_link",get_the_ID())."' ";
		$info .= "softPopFallbackLink='".get_field("soft_exit_pop_fallback_link",get_the_ID())."' ";
		$info .= "softPopImage='".get_field("soft_pop_image",get_the_ID())."' ";
		$info .= "leaveBehindLink='".get_field("leave_behind_link",get_the_ID())."' ";
		$info .= "disclaimerSwitch='".get_field("disclaimer_switch",get_the_ID())."' ";
		$info .= "disclaimerText='".get_field("disclaimer_text",get_the_ID())."'>";
		$info .= "&nbsp;</div><input class='holder' type='hidden' name='holder-one' value='null'>";
		return $content.$info;
	} else {
		return $content;
	}
}
add_filter("the_content", "auto_insert_after_post");

/* Old Code for Sponsored Post Types */
/* Please Remove once the sponsored post types are phased out */
$meta_box = array(
    'id' => 'sponsored-post-settings',
    'title' => 'Sponsored Post Settings',
    'page' => 'sponsored',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Sponsor Name',
            'desc' => 'example: The Zebra ',
            'id' => 'sponsor_name',
            'type' => 'text',
            'std' => ''
        ),
           array(
            'name' => 'Disclaimer Area',
            'id' => 'disclaimer_switch',
            'type' => 'radio',
            'options' => array(
                array('name' => 'On', 'value' => 'on'),
                array('name' => 'Off', 'value' => 'off')
            )
        ),
        array(
            'name' => 'Disclaimer Text',
            'desc' => '',
            'id' => 'disclaimer_text',
            'type' => 'textarea',
            'std' => ''
        ),
        array(
            'name' => 'Button Switch',
            'id' => 'button_switch',
            'type' => 'radio',
            'options' => array(
                array('name' => 'On', 'value' => 'on'),
                array('name' => 'Off', 'value' => 'off')
            )
        ),
        array(
            'name' => 'Button Label',
            'desc' => '',
            'id' => 'cta',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Link Switch',
            'id' => 'mask_switch',
            'type' => 'radio',
            'options' => array(
                array('name' => 'On', 'value' => 'on'),
                array('name' => 'Off', 'value' => 'off')
            )
        ),
         array(
            'name' => 'Masked Link',
            'desc' => 'Used for link masking, supply a pretty link. example: <b>http://moderntips.com/producttitle</b>',
            'id' => 'learnmore',
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => 'Fallback CompKey',
            'desc' => '',
            'id' => 'compkey',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'UTM is True Link',
            'desc' => 'If UTM data exists, use this link, pass the following possible parameters: <b>{utm_source} , {utm_medium} , {utm_term} , {utm_campaign}</b>',
            'id' => 'sponsor_link_real',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'UTM is False Link',
            'desc' => 'If no UTM data is present, then forward to this URL.',
            'id' => 'utm_link',
            'type' => 'text',
            'std' => ''
        ),
      /*  array(
            'name' => 'Select box',
            'id' => $prefix . 'select',
            'type' => 'select',
            'options' => array('Option 1', 'Option 2', 'Option 3')
        ),*/
        array(
            'name' => 'Soft Pop',
            'id' => 'sp_switch',
            'type' => 'radio',
            'options' => array(
                array('name' => 'On', 'value' => 'on'),
                array('name' => 'Off', 'value' => 'off')
            )
        ),
        array(
            'name' => 'Soft Pop Link',
            'desc' => 'example: http://track.mysnoring-solution.com/27e86560-fe6d-0132-fbe7-22000b2688d0/partnercodehere',
            'id' => 'soft_exit_pop_link',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Soft Pop Link with UTM',
            'desc' => 'example: http://track.mysnoring-solution.com/27e86560-fe6d-0132-fbe7-22000b2688d0/partnercodehere',
            'id' => 'soft_exit_pop_link_utm',
            'type' => 'text',
            'std' => ''
        ),      
        array(
            'name' => __( 'Horizontal Image', 'cmb' ),
            'desc' => __( 'URL.', 'cmb' ),
            'id'   => 'h_image',
            'type' => 'text',
        ),
        array(
            'name' => __( 'Vertical Image', 'cmb' ),
            'desc' => __( 'URL.', 'cmb' ),
            'id'   => 'v_image',
            'type' => 'text',
        ),
       /* array(
            'name' => 'Checkbox',
            'id' => $prefix . 'checkbox',
            'type' => 'checkbox'
        ) */
        array(
            'name' => 'Pixel Area',
            'desc' => 'Can be used for any Javascript.',
            'id' => 'pixel_area',
            'type' => 'textarea',
            'std' => ''
        ),
        array(
            'name' => 'Below Content Area',
            'desc' => 'Can be used for any Javascript.',
            'id' => 'below_content_area',
            'type' => 'textarea',
            'std' => ''
        ),
        array(
            'name' => 'Leave Behind Url',
            'desc' => 'URL',
            'id' => 'leave_behind_link',
            'type' => 'text'
        ),
		array(
            'name' => 'Lamjs Buttons',
            'id' => 'lamjs_switch',
            'type' => 'radio',
            'options' => array(
                array('name' => 'On', 'value' => 'on'),
                array('name' => 'Off', 'value' => 'off')
            )
        ),
		array(
            'name' => 'Lamjs Partner ID',
            'desc' => '',
            'id' => 'lamjs_partner_id',
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => 'Lamjs Campaign',
            'desc' => '',
            'id' => 'lamjs_campaign',
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => 'Lamjs Sub ID',
            'desc' => '',
            'id' => 'lamjs_subid',
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => 'Lamjs Sub ID Two',
            'desc' => '',
            'id' => 'lamjs_subid_two',
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => 'Lamjs Impression Track URL',
            'desc' => '',
            'id' => 'lamjs_iturl',
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => 'Lamjs Click Track URL',
            'desc' => '',
            'id' => 'lamjs_click_track',
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => 'Lamjs Search Track URL',
            'desc' => '',
            'id' => 'lamjs_search_track',
            'type' => 'text',
            'std' => ''
        )
    )
);

add_action('admin_menu', 'mytheme_add_box');
// Add meta box
function mytheme_add_box() {
    global $meta_box;
    add_meta_box($meta_box['id'], $meta_box['title'], 'mytheme_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}
// Callback function to show fields in meta box
function mytheme_show_box() {
    global $meta_box, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    echo '<table class="form-table">';
    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'file':
                echo '<input type="file" id="', $field['id'], '" name="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="25" />', '<br />', $field['desc'];
                break;
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                break;
            case 'text2':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:100px" />', '<br />', $field['desc'];
                break;
            case 'textarea':
                wp_editor( $meta ? $meta : $field['std'], $field['id']);
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input style="float: left; margin-top: 5px;" type="radio" name="', $field['id'], '"value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' /> <p style="width: 30px; display: block; float: left;">', $option['name'],'</p>';
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
        }
        
        
        echo     '</td><td>',
            '</td></tr>';
    }
    echo '</table>';
}
add_action('save_post', 'mytheme_save_data');
// Save data from meta box
function mytheme_save_data($post_id) {
    global $meta_box;
    // verify nonce
    if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}