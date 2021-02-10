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
    $shows = $output["showings"];
	require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
	$dte = explode("-",$_GET["dte"]);
	$tod = $_GET["tod"];
	$tme = array_map('intval',explode(":",$_GET["tme"]));
	$mid = 0;
	$fulldate = strtotime($dte[1]."/".$date[2]."/".$dte[0]." ");
	$fulldte = $_GET["dte"];
	if($tod == "pm") {
		$tme[0] = $tme[0]+12;
	}
	/* Convert time to minutes from midnight */
	if(count($tme[0])==1) {
		$mid = ($tme[0]*60)+$tme[1];
	} else {
		$mid = ($tme[0]*60);
	}
	if($mid >= 540 && $mid <= 990) {
		$timegood=true;
		/* Check Availability */
		foreach($shows as $s) {
			if($s["date"] == $fulldte) {
				if(intval($s["start_time"]) >= $mid && intval($s["end_time"]) <= $mid) {
					$timegood=false;
				}
			}
		}
		/* Check if the time is valid */
		if($timegood) { ?>
			"set_attributes": { "start-time": "<?php echo $mid; ?>", "end-time": "<?php echo $mid+30; ?>" },
			{ "redirect_to_blocks": ["Time Confirmation"]}
		<?php } else { 
				if($tod == "pm") { ?>
				{ "redirect_to_blocks": ["Pm Time Not Available Reset"]}
			<?php } else { ?>
				{ "redirect_to_blocks": ["Am Time Not Available Reset"]}
			<?php }
	 	}
	} else { 
		if($tod == "pm") {
		?>
		{ "redirect_to_blocks": ["Invalid PM Reset"] }
	<?php } else { ?>
		{ "redirect_to_blocks": ["Invalid AM Reset"] }
	<?php }
	}
 ?>