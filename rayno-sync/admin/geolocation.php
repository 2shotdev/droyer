<?php
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);
	require_once("../../../../wp-load.php");
	global $wpdb;
	function RaynoGetLocation($address) {
	    $base = "https://api.geoapify.com/v1/geocode/search?text=";
	    $apikey = "d003b70b95854995a553626d83b188f3";
	    $url = $base.rawurlencode($address)."&limit=1&format=json&apiKey=".$apikey;
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 90);
	    $response = curl_exec($ch);
	    curl_close($ch);
	    return json_decode($response, true);
	}
	function RaynoInsertPostMeta($postid, $metakey, $metavalue) {
	    return add_post_meta($postid, $metakey, $metavalue, true);
	}
	$dealers = new WP_Query(array('post_type' => 'wpsl_stores', 'posts_per_page' => 10, 'paged' => $_GET['page'], 'orderby' => 'post_title', 'order' => 'ASC'));
	$errorsids = "";
	if ($_GET['page'] <= $dealers->max_num_pages) {
		while($dealers->have_posts()) {
			$dealers->the_post();
			$pid = get_the_ID();
			$address = get_post_meta($pid,'wpsl_address',true);
			$city = get_post_meta($pid,'wpsl_city',true);
			$state = get_post_meta($pid,'wpsl_state',true);
			$zip = get_post_meta($pid,'wpsl_zip',true);
			$wpsl = "wpsl_";
			$fulladdress = $address.", ".$city.", ".$state.", ".$zip;
			if($fulladdress != "") {
	            $locs = RaynoGetLocation($fulladdress);
	            $tmp = $locs["results"];
	            $tmp2= $tmp[0];
	            if($tmp2["lat"] != "") {
		            RaynoInsertPostMeta($pid, $wpsl."lat", $tmp2["lat"]);
	                RaynoInsertPostMeta($pid, $wpsl."lng", $tmp2["lon"]);
	            } else {
	            	$errorsids .= $pid." - ";
	            }
	        }
	        usleep(250000);
		}
		header('Content-Type: application/json');
    	echo  '{"d":{"__type":"Contact.Status","ReturnCode":0,"ErrorMessage":"'.$errorids.'","MoreRecords":"1"}}';
	} else {
		header('Content-Type: application/json');
    	echo  '{"d":{"__type":"Contact.Status","ReturnCode":0,"ErrorMessage":"'.$errorids.'","MoreRecords":"0"}}';
	}
?>