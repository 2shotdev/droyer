<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	define('WP_USE_THEMES', false);
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/json');
	try {
		require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
		$args = array(
		  'name'        => 'gallery',
		  'post_type'   => 'page',
		  'post_status' => 'publish',
		  'numberposts' => 1
		);
		$my_posts = get_posts($args);
		$gallery = array();
		if(have_rows('gallary', $my_posts[0]->ID)):
			$tmp = get_field('gallary', $my_posts[0]->ID);
			$ctr=1;
			foreach($tmp as $row) {
				if($ctr<10) {
	    			foreach($row['image'] as $images) {
	    				$tmp = $images["caption"];
	    				if($tmp == "") {
	    					$tmp = get_bloginfo("name")." | ".get_bloginfo("description");
	    				}
	    				$gallery[] = '{"title":"'.$tmp.'","image_url":"'.$images["add_slide_image"].'"}';
	        		}
	        		$ctr++;
	        	}
			}
		endif;
	} catch (Exception $e) {}
?>
{
 "messages": [
    {
      "attachment":{
        "type":"template",
        "payload":{
          "template_type":"generic",
          "image_aspect_ratio": "square",
          "elements":[
	        <?php 
	          echo implode(",\n\t\t", $gallery)."\n";
	        ?>
          ]
        }
      }
    }
  ]
}