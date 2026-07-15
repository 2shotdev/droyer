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
    $base = "https://www.zohoapis.com/crm/v8/Accounts/search?page=".$page."&criteria=";
    //$endpoint = "Rating:starts_with:Current";
    $endpoint = "Show_in_Dealer_Locator:equals:true";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $base.rawurlencode($endpoint));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Zoho-oauthtoken ' . $tokens["access_token"]
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}
function RaynoInsertPost($args) {
    return wp_insert_post($args);
}
function RaynoInsertPostMeta($postid, $metakey, $metavalue) {
    return add_post_meta($postid, $metakey, $metavalue, true);
}
function RaynoGetGoogleImageId($url) {
    $urlparts = parse_url($url);
    if($urlparts != "") {
        $paths = explode("/",$urlparts["path"]);
        if(array_key_exists(3, $paths)) {
            return $paths[3];
        } else {
            return "";
        }
    }
}
function RaynoGetLocation($address) {
    $base = "https://api.geoapify.com/v1/geocode/search?text=";
    $apikey = "d003b70b95854995a553626d83b188f3";
    $url = $base.rawurlencode($address)."&apiKey=".$apikey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 90);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}
function RaynoSetFeaturedImage($postid, $imageurl, $imagedesc) {
    $image = media_sideload_image( $imageurl, $postid, $imagedesc,'id' );
    set_post_thumbnail( $postid, $image );
}
function RaynoGetFullRecord($id, $tokens) {
    $endpoint = "https://www.zohoapis.com/crm/v8/Accounts/".$id."/actions/fetch_full_data";
    $ch = curl_init();
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Zoho-oauthtoken '.$tokens["access_token"],
        'Cookie: _zcsr_tmp=00c2c77c-e557-424f-be17-9d3cf4e41585; crmcsr=00c2c77c-e557-424f-be17-9d3cf4e41585; group_name=usergroup2'
      ),
    ));
    $response = json_decode(curl_exec($curl), true);
    $response = $response["data"];
    curl_close($curl);
    return $response[0];
}
function RaynoCleanString($string) {
    return preg_replace('/[^a-zA-Z0-9_ -.]/', '', $string);
}
function RaynoProcessRecords($recss, $tokens) {
    $zohometas = array("Shipping_Street","Shipping_City","Shipping_State","Shipping_Code","Rating","Featured_Dealer","Applications","Products","Brands","Video_1","Video_2","Video_3","Video_4","Video_5","Featured_Image_URL","Gallery_Image_1_URL","Gallery_Image_2_URL","Gallery_Image_3_URL","Gallery_Image_4_URL","Gallery_Image_5_URL","Gallery_Image_6_URL","Gallery_Image_7_URL","Gallery_Image_8_URL","Gallery_Image_9_URL","Gallery_Image_10_URL", "id", "Hopper_Phone", "Main_Email");
    $ctr = 1;
    foreach($recss as $recs){
        if($ctr == 10) {break;}
        if(array_search("Show_in_Dealer_Locator", $recs)) {
            if($recs["Show_in_Dealer_Locator"] == 1) {
                $wpsl = "wpsl_";
                $fulladdress = "";
                $accountname = substr($recs["Account_Name"],3);
                // Get The Title and Description
                $fulldesc = RaynoGetFullRecord($recs["id"], $tokens);
                $args = array(
                    'post_content' => $fulldesc["Sote_Description"],
                    'post_title' => $accountname,
                    'post_type' => 'wpsl_stores',
                    'post_status' => 'publish'
                );
                $pid = RaynoInsertPost($args);
                RaynoInsertPostMeta($pid, $wpsl."country", "US");
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
                    } else {
                        if($recs[$meta] != "") {
                            switch($meta) {
                                case "Shipping_Street":
                                    RaynoInsertPostMeta($pid, $wpsl."address", RaynoCleanString($recs[$meta]));
                                    $fulladdress .= $recs[$meta]." ";
                                    break;
                                case "Shipping_City":
                                    RaynoInsertPostMeta($pid, $wpsl."city", RaynoCleanString($recs[$meta]));
                                    $fulladdress .= $recs[$meta]." ";
                                    break;
                                case "Shipping_State":
                                    RaynoInsertPostMeta($pid, $wpsl."state", strtoupper(RaynoCleanString($recs[$meta])));
                                    $fulladdress .= $recs[$meta]." ";
                                    break;
                                case "Shipping_Code":
                                    RaynoInsertPostMeta($pid, $wpsl."zip", RaynoCleanString($recs[$meta]));
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
                                        RaynoInsertPostMeta($pid, "wpsl_featured_dealer", 1);
                                    }
                                    break;
                                case "Featured_Image_URL":
                                    if($recs[$meta] != "") {
                                        RaynoInsertPostMeta($pid, strtolower($meta), RaynoGetGoogleImageId($recs[$meta]));
                                        fifu_dev_set_image($pid, "https://lh3.googleusercontent.com/d/".RaynoGetGoogleImageId($recs[$meta])."?authuser=0");
                                    }
                                    break;
                                default:
                                    if($recs[$meta] != "") {
                                        if(strpos($meta, "_URL")) {
                                            if(RaynoGetGoogleImageId($recs[$meta]) != ""){
                                                RaynoInsertPostMeta($pid, strtolower($meta), RaynoGetGoogleImageId($recs[$meta]));
                                            }
                                        } else {
                                            RaynoInsertPostMeta($pid, strtolower($meta), $recs[$meta]);
                                        }
                                    }
                            }
                        }
                    }
                }
            }
        }
    }
}

if(is_user_logged_in()){
    $atokens = RaynoGetZohoTokens();

    $records = RaynoGetRecords($_GET['page'], $atokens);
    //var_dump($records);

    $info = $records["info"];

    //$tmp = RaynoGetFullRecord("1970065000000657268", $atokens);
    //echo $tmp["Sote_Description"];
    RaynoProcessRecords($records["data"], $atokens);

    header('Content-Type: application/json');
    echo  '{"d":{"__type":"Contact.Status","ReturnCode":0,"ErrorMessage":"The records were processed successfully.","MoreRecords":"'.$info["more_records"].'"}}';
}

?>