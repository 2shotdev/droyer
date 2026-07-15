<?php 
	$ch = curl_init('https://drive.google.com/file/d/1a_8ub_v2b3FnLyliOUeR0Pex7PYKIoyA/view');
	$cookieFile = tempnam(sys_get_temp_dir(), 'gdrive_cookie_');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);  // Save cookies
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
	$imageContent = curl_exec($ch);
	file_put_contents('local_image.webp', $imageContent);
	curl_close($ch);
?>