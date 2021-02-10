<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	define('WP_USE_THEMES', false);
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/json');
	$msg = "For more information on our pricing, please reach out to our leasing staff!";
	try {
		require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
		$args = array(
		  'name'        => htmlspecialchars($_GET['type']),
		  'post_type'   => 'plans',
		  'post_status' => 'publish',
		  'numberposts' => 1
		);
		$my_posts = get_posts($args);
		$msg = strip_tags(get_field('rent_information', $my_posts[0]->ID));
	} catch (Exception $e) {}
?>
{
 "messages": [
   {"text": "<?php echo $msg; ?>"}
 ]
}