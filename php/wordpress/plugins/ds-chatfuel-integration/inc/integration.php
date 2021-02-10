<?php
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);
	define('WP_USE_THEMES', false);
	require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
	function myplugin_scripts() {
	    wp_register_style('ds-chatfuel',  plugin_dir_url( __FILE__ ) . 'style/styles.css');
	    wp_enqueue_style('ds-chatfuel');
	    wp_register_script('ds-chatfuel-js',  plugin_dir_url( __FILE__ ) . 'js/scripts.js');
	    wp_enqueue_script('ds-chatfuel-js');
	}
	add_action('admin_enqueue_scripts', 'myplugin_scripts');
	function ds_chatfuel_admin_page(){
	$args = array(
	  'post_type'   => 'plans',
	  'post_status' => 'publish',
	  'numberposts' => -1
	);
	$my_posts = get_posts($args);
	?>
	<div class="wrap">
		<h2>Dasmen Chatfuel Integration</h2>
		<div class="ds-integration">
			<h3>Current Specials</h3>
			<p>Here is the URL to enter into the Chatfuel block for the Current Specials</p>
			<div class="ds-specials ds-info"></div><div class="ds-specials-copy ds-copy">Copy URL</div>
			<div class="clearing">&nbsp;</div>
			<h3>Pricing</h3>
			<p>Here is the URL's to enter into the Chatfuel block for the Current Pricing per Floorplan</p>
			<?php foreach($my_posts as $post) { ?>
				<div class="item-price">
					<p class="sub-item"><?php echo $post->post_title; ?></p>
					<div class="ds-pricing ds-info" ref="<?php echo $post->post_name; ?>"></div><div class="ds-pricing-copy ds-copy">Copy URL</div>
					<div class="clearing">&nbsp;</div>
				</div>
			<?php } ?>
			<div class="clearing">&nbsp;</div>
			<h3>Gallery</h3>
			<p>Here is the URL's to enter into the Chatfuel block for the all of the Gallery Images</p>
			<div class="ds-gallery ds-info"></div><div class="ds-gallery-copy ds-copy">Copy URL</div>
			<div class="clearing">&nbsp;</div>
			<h3>Apprent</h3>
			<h6>Get Site ID</h6>
			<div class="ds-id ds-info"></div><div class="ds-id-copy ds-copy">Copy URL</div>
			<h6>Get Tour Date</h6>
			<div class="ds-tour ds-info"></div><div class="ds-tour-copy ds-copy">Copy URL</div>
		</div>
		<div class="overlay">
			<div class="overlay-content">
				<div class="overlay-message"></div>
			</div>
		</div>
	</div>
	<script>
		var directory="<?php echo plugins_url('ds-chatfuel-integration'); ?>";
	</script>
	<?php
}