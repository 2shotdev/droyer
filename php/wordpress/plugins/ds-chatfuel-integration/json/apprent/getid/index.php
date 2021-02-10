<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	define('WP_USE_THEMES', false);
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/json');
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://application.apprent.com/api/properties");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = json_decode(curl_exec($ch), TRUE);
    curl_close($ch);
	//try {
		require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
		$name = get_bloginfo("name");
		$id = "";
		foreach($output as $prop) {
			if(strtolower($prop["name"]) == strtolower($name)) {
				$id = $prop["id"];
			}
		}
	//} catch (Exception $e) {}
?>
{
  "set_attributes":
    {
      "site-id": "<?php echo $id; ?>"
    },
  "messages":[
    {"text": "When would you like to schedule a tour? Keep in mind we are open Monday-Friday, from 8:30am - 5:30pm. Tours typically take around 30 minutes."}
  ]
}