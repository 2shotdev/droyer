<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../../../../wp-load.php");
global $wpdb;

function RaynoGetZohoTokens() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://accounts.zoho.com/oauth/v2/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'client_id' => '1000.1OKJV7NHGYH1XQ41QJDBETLYTQNAJV',
        'client_secret' => 'cf1c718d0754ae8ea72dcc7fa70ccb7e08523d6a6c',
        'grant_type' => 'client_credentials',
        'scope' => 'ZohoCRM.modules.READ',
        'soid' => 'ZohoCRM.629222914'
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

function RaynoGetAccounts($tokens, $endpoint) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Zoho-oauthtoken ' . $tokens["access_token"]
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    return $data;
}

function RaynoGetRecordById($id, $tokens) {
    $endpoint = "https://www.zohoapis.com/crm/v8/Accounts/search?criteria=id:equals:".$id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Zoho-oauthtoken ' . $tokens["access_token"]
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch); 
    $data = json_decode($response, true);
    return $data["data"];
}

function RaynoGetRecords($page, $tokens) {
    $base = "https://www.zohoapis.com/crm/v8/Accounts/search?page=1&criteria=";
    $endpoint = "Rating:starts_with:Current";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $base.urlencode($endpoint));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Zoho-oauthtoken ' . $tokens["access_token"]
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}
function RaynoAllRecords($page, $tokens) {
	$more = $page;
	$recs;
	$ctr = 1;
	while($more == true) {
		$tmp = RaynoGetRecords($ctr, $tokens);
		$recs = $tmp["data"];
        var_dump($recs);
        //$pro = RaynoProcessRecords($recs);
		$info = $tmp["info"];
        //if($info["more_records"] == 0) {
            $more = false;
        //}
	}
	return $recs;
}
function RaynoProcessRecords($recss) {
    foreach($recss as $record){
        foreach($record as $recs){
            if(array_search("Show_in_Dealer_Locator", $recs)) {
                if($recs["Show_in_Dealer_Locator"] == 1) {
                    $wpsl = "wpsl_";
                    $fulladdress = "";
                    $accountname = substr($recs["Account_Name"],3);
                    // Get The Title and Description
                    $args = array(
                        'post_content' => $recs["Sote_Description"],
                        'post_title' => $accountname,
                        'post_type' => 'wpsl_stores',
                        'post_status' => 'publish'
                    );
                    $pid = RaynoInsertPost($args);
                    RaynoInsertPostMeta($pid, $wpsl."country", "US");
                    //echo '<br />Post ID: '.$pid;
                    // Get and insert the meta information for the newly created dealer
                    foreach($zohometas as $meta) {
                        if(is_array($recs[$meta])) {
                            $tmps = $recs[$meta];
                            $ameta=""; $bfe= "";
                            foreach($tmps as $tmp) {
                                $ameta .= $bfe.$tmp;
                                $bfe= ",";
                            }
                            RaynoInsertPostMeta($pid, strtolower($meta), $ameta);
                            //echo $meta.": ".$ameta."<br />";
                        } else {
                            switch($meta) {
                                case "Shipping_Street":
                                    RaynoInsertPostMeta($pid, $wpsl."address", $recs[$meta]);
                                    $fulladdress .= $recs[$meta];
                                    break;
                                case "Shipping_City":
                                    RaynoInsertPostMeta($pid, $wpsl."city", $recs[$meta]);
                                    $fulladdress .= $recs[$meta];
                                    break;
                                case "Shipping_State":
                                    RaynoInsertPostMeta($pid, $wpsl."state", $recs[$meta]);
                                    $fulladdress .= $recs[$meta];
                                    break;
                                case "Shipping_Code":
                                    RaynoInsertPostMeta($pid, $wpsl."zip", $recs[$meta]);
                                    $fulladdress .= $recs[$meta];
                                    break;
                                case "id":
                                    RaynoInsertPostMeta($pid, "zoho_id", $recs[$meta]);
                                    break;
                                case "Phone":
                                    RaynoInsertPostMeta($pid, $wpsl."phone", $recs[$meta]);
                                    break;
                                case "Main_Email":
                                    RaynoInsertPostMeta($pid, $wpsl."email", $recs[$meta]);
                                    break;
                                case "Featured_Dealer":
                                    if($recs["Featured_Dealer"] == 1) {
                                        RaynoInsertPostMeta($pid, "wpsl_featured_dealer", "platinum");
                                    }
                                    break;
                                case "Featured_Image_URL":
                                    RaynoInsertPostMeta($pid, strtolower($meta), RaynoGetGoogleImageId($recs[$meta]));
                                    fifu_dev_set_image($pid, "https://lh3.googleusercontent.com/d/".RaynoGetGoogleImageId($recs[$meta])."?authuser=0");
                                    break;
                                default:
                                    if(strpos($meta, "_URL")) {
                                        if($recs[$meta] != "") {
                                            RaynoInsertPostMeta($pid, strtolower($meta), RaynoGetGoogleImageId($recs[$meta]));
                                        }
                                    } else {
                                        RaynoInsertPostMeta($pid, strtolower($meta), $recs[$meta]);
                                    }
                            }
                        }
                    }
                    // Get and Add the latitude and longitude
                    $locs = RaynoGetLocation($fulladdress);
                    foreach($locs as $loc => $val){
                        if($loc == "features" ) {
                            $tmp = $val[1];
                            //var_dump($tmp);
                            $tmp2 = ($tmp["properties"]);
                            RaynoInsertPostMeta($pid, $wpsl."lat", $tmp2["lat"]);
                            RaynoInsertPostMeta($pid, $wpsl."lng", $tmp2["lon"]);
                        }
                    }
                }
            }
        }
    }
}

if(is_user_logged_in()){
    $atokens = RaynoGetZohoTokens();

    $records = RaynoAllRecords(true, $atokens);

    //RaynoProcessRecords($records);
}


?>