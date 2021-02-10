<?php
function myplugin_scripts() {
    wp_register_style('mt-vendor',  plugin_dir_url( __FILE__ ) . 'assets/styles.css');
    wp_enqueue_style('mt-vendor');
    wp_register_script('mt-vendor-js',  plugin_dir_url( __FILE__ ) . 'assets/scripts.js');
    wp_enqueue_script('mt-vendor-js');
}
add_action( 'admin_enqueue_scripts', 'myplugin_scripts');
function mt_vendor_admin_page(){
	?>
	<div class="wrap">
		<h2>Import Vendors from API</h2>
		<div class="api-information">
			<h4>Please enter the API information in the fields below.</h4>
			<input type="text" name="" placeholder="" class="api-url" value="https://api.ssactivewear.com/v2/" /><br />
			<input type="text" name="" placeholder="Username" class="api-username" value="56006" /><br />
			<input type="password" name="" placeholder="Password" class="api-password" value="1d6c4a11-7f0d-402f-9404-5763bb9b64d9" /><br />
			<input type="text" name="" placeholder="Style Directory" class="api-styledir" value="styles/" /><br />
			<input type="text" name="" placeholder="Product Directory" class="api-productdir" value="products/" /><br />
			<input type="text" name="" placeholder="Product Image Base URL" class="api-productimageurl" value="https://www.ssactivewear.com/" /><br />
			<input type="button" class="api-go" value="Get the Styles" />
			<div class="now-products hide">
				Now that we have all the styles in the site.  We can now get all the variations for them.<br />
				<input type="button" class="api-goprod" value="Get the Variations" />
				<div class="complete"></div>
			</div>
			<div class="api-content">
				<h5>Styles</h5>
				<div class="all-styles">
				</div>
				<h5>Product Variations</h5>
				<div class="all-variations">
				</div>
			</div>
		</div>
		<div class="overlay">
			<div class="overlay-content">
				<div class="overlay-message"></div>
			</div>
		</div>
	</div>
	<script>
		var directory="<?php echo plugin_dir_url( __FILE__ ); ?>";
	</script>
	<?php
}
function ssactivewear_products($style_id) {
  $host =  'https://api.ssactivewear.com/v2/products/?style='.$style_id;
  $username = '56006';
  $password = '1d6c4a11-7f0d-402f-9404-5763bb9b64d9';
  $ch = curl_init($host);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
  //curl_setopt($ch, CURLOPT_POST, 1);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  $return = curl_exec($ch);
  $error = curl_error($ch);
  curl_close($ch);

	return json_decode($return);

}
function ssactivewear_styles() {
  $host =  'https://api.ssactivewear.com/v2/styles/';
  $username = '56006';
  $password = '1d6c4a11-7f0d-402f-9404-5763bb9b64d9';
  $ch = curl_init($host);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
  //curl_setopt($ch, CURLOPT_POST, 1);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  $return = curl_exec($ch);
  $error = curl_error($ch);
  curl_close($ch);

	return json_decode($return);
}
function ssactivewear_categories() {
  $host =  'https://api.ssactivewear.com/v2/categories/';
  $username = '56006';
  $password = '1d6c4a11-7f0d-402f-9404-5763bb9b64d9';
  $ch = curl_init($host);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
  //curl_setopt($ch, CURLOPT_POST, 1);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  $return = curl_exec($ch);
  $error = curl_error($ch);
  curl_close($ch);
	return json_decode($return);
}
function isJson() {
	//json_decode($string);
	switch (json_last_error()) {
		case JSON_ERROR_NONE:
		    return ' - No errors';
		break;
		case JSON_ERROR_DEPTH:
		    return ' - Maximum stack depth exceeded';
		break;
		case JSON_ERROR_STATE_MISMATCH:
		    return ' - Underflow or the modes mismatch';
		break;
		case JSON_ERROR_CTRL_CHAR:
		    return ' - Unexpected control character found';
		break;
		case JSON_ERROR_SYNTAX:
		    return ' - Syntax error, malformed JSON';
		break;
		case JSON_ERROR_UTF8:
		    return ' - Malformed UTF-8 characters, possibly incorrectly encoded';
		break;
		default:
		    return ' - Unknown error';
		break;
	}
}
