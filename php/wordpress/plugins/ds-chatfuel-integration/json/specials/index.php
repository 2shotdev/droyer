<?php
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);
	define('WP_USE_THEMES', false);
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/json');
	$msg = "For more information on our specials, please reach out to our leasing staff!";
	$url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	$title = "Apply Now";
	try {
		require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
		$args = array(
		  'name'        => 'floor-plans',
		  'post_type'   => 'page',
		  'post_status' => 'publish',
		  'numberposts' => 1
		);
		$my_posts = get_posts($args);
		$msg = strip_tags(get_field('add_content', $my_posts[0]->ID));
		$url = get_field('apply_url', $my_posts[0]->ID);
		$title = get_field('apply_button_text', $my_posts[0]->ID);
	} catch(Exception $e) {}
?>
{
 "messages": [
   {"attachment": {
        "type": "template",
        "payload": {
          "template_type": "button",
          "text": "<?php echo $msg; ?>",
          "buttons": [
            {
              "type": "web_url",
              "url": "<?php echo $url; ?>",
              "title": "<?php echo $title; ?>"
            }
          ]
        }
    }
    }
 ]
}