<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	define('WP_USE_THEMES', false);
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/json');
	$days = array("sunday","monday","tuesday","wednesday","thursday","friday","saturday");
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://application.apprent.com/api/showings/".$_GET["id"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = json_decode(curl_exec($ch), TRUE);
    curl_close($ch);
    $closures = $output["closures"];
	require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
	$dte = explode("-",$_GET["dte"]);
	$fulldte = $_GET["dte"];
	if(checkdate($dte[1],$dte[2],$dte[0])) {
		$day = date("l",strtotime($fulldte));
		$dayweek = 0;
		$ctr = 0;
		foreach($days as $d) {
			if($d == strtolower($day)) {
				$dayweek = $ctr;
			}
			++$ctr;
		}
		if($dayweek > 0 && $dayweek < 6) {
			foreach($closures as $c) {
				if($c["date"] == $fulldte) { ?>
					{ "redirect_to_blocks": ["Holiday Reset"] }
				<?php break;
				}
			} ?>
			{ "redirect_to_blocks": ["Valid Date"] }
		<?php } else { ?>
			{ "redirect_to_blocks": ["Weekend Reset"] }
		<?php }
	} else { ?>
		{ "redirect_to_blocks": ["Invalid Reset"] }
	<?php }?>