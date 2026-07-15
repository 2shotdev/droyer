<?php 

function RaynoGetSetup() {
	global $wpdb;
    $table_name = $wpdb->prefix . "rayno_sync";
    if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") == $table_name) {
    	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    	$sql = 'SELECT * from '.$table_name.';';
        $defaults = $wpdb->get_results($sql);
        if(is_array($defaults)) {
            $_SESSION['rayno_days'] = $defaults[0]->days;
            $_SESSION['rayno_time'] = $defaults[0]->tme;
            $_SESSION['rayno_apikey'] = $defaults[0]->apikey;
        }
    	
        $table_name = $wpdb->prefix . "rayno_files";
        $sql = 'SELECT * from '.$table_name.' ORDER BY id desc;';
        $defaults = $wpdb->get_results($sql);
        if(is_array($defaults)) {
            $_SESSION['rayno_filename'] = $defaults[0]->filename;
            $_SESSION['rayno_user'] = $defaults[0]->usr;
            $_SESSION['rayno_date'] = $defaults[0]->dte;
        }

        $table_name = $wpdb->prefix . "rayno_zoho";
        $sql = 'SELECT * from '.$table_name.' ORDER BY id desc;';
        $defaults = $wpdb->get_results($sql);
        if(is_array($defaults)) {
            $_SESSION['rayno_clientid'] = $defaults[0]->clientid;
            $_SESSION['rayno_clientsecret'] = $defaults[0]->clientsecret;
            $_SESSION['rayno_granttype'] = $defaults[0]->clientgranttype;
            $_SESSION['rayno_scope'] = $defaults[0]->clientscope;
            $_SESSION['rayno_soid'] = $defaults[0]->clientsoid;
            $_SESSION['rayno_user'] = $defaults[0]->usr;
        }
    }   
}
/*
function RaynoGetZohoTokens() {
    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, "https://accounts.zoho.com/oauth/v2/auth?scope=ZohoCRM.modules.ALL&client_id=1000.1OX5NBDASCGQ10SMGAIT1C3N90JU9I&response_type=code&access_type=offline&redirect_uri=https://www.staging.raynofilm.com/");
    // $testing = curl_exec($ch);
    // curl_close($ch);
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

function RaynoGetAccounts($accessToken, $endpoint) {
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

function RaynoGetRecords($page, $tokens) {
    /* $fields = "Account_Name,Shipping_State,Shipping_City,Shipping_Street,Shipping_Code,Rating,Store_Description,Applications,Products,Brands,Video_1,Video_2,Video_3,Video_4,Video_5,Featured_Image_URL,Gallery_Image_1_URL,Gallery_Image_2_URL,Gallery_Image_3_URL,Gallery_Image_4_URL,Gallery_Image_5_URL,Gallery_Image_6_URL,Gallery_Image_7_URL,Gallery_Image_8_URL,Gallery_Image_9_URL,Gallery_Image_10_URL,Monday_Open_Time,Monday_Close_Time,Tuesday_Open_Time,Tuesday_Close_Time,Wednesday_Open_Time,Wednesday_Close_Time,Thursday_Open_Time,Thursday_Close_Time,Friday_Open_Time,Friday_Close_Time,Saturday_Open_Time,Saturday_Close_Time,Sunday_Open_Time,Sunday_Close_Time";
    $endpoint = "https://www.zohoapis.com/crm/v8/Accounts?fields=".$fields."&page=".$page; */ /*
    $endpoint = "https://www.zohoapis.com/crm/v8/Accounts/search?criteria=Rating:starts_with:Current&page=".$page;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Zoho-oauthtoken ' . $tokens["access_token"]
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

function RaynoUpdateStoreByZoho($zid, $newdata) {
    $args = array(
        'post_type'  => 'wpsl_stores',
        'meta_query' => array(
            array(
                'key'     => 'zoho_id',
                'value'   => $zid,
                'compare' => '=',
            ),
        ),
    );
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            /* Update Data Here */ /*
        }
    }
}

function RaynoGetStores() {
   $args = array(
        'posts_per_page' => -1,
        'post_type' => 'wpsl_stores',
        'post_status' => 'any'
    );
    $query = new WP_Query($args);
    return $query;
}

function RaynoGetPostMeta($id) {
    return get_post_meta($id);
}

function RaynoInsertPost($args) {
    return insert_post($args);
}

function RaynoInsertPostMeta($postid, $metakey, $metavalue) {
    return add_post_meta($postid, $metakey, $metavalue, true);
}

function RaynoGetGoogleImageId($url) {
    $urlparts = parse_url($url);
    $paths = explode("/",$urlparts["path"]);
    return $paths[3];
}

function RaynoGetLocation($address) {
    $base = "https://api.geoapify.com/v1/geocode/search?text=";
    $apikey = "d003b70b95854995a553626d83b188f3";
    $url = $base.urlencode($address)."&apiKey=".$apikey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 90);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}
*/
?>