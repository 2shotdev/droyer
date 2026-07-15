<?php
/**
* Plugin Name: Rayno Sync
* Plugin URI: https://raynofilm.com/
* Description: Sycing the Zoho CRM with the Store Locator plugin
* Version: 0.1
* Author: Daniel Royer
* Author URI: https://raynofilm.com/
**/
//require_once("../../../wp-load.php");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0", true);
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache", true);
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  */
// if ( ! defined( 'WPINC' ) ) {
// 	die;
// }
include __DIR__ .'/admin/functions.php';
if(!session_id()) session_start();
$_SESSION['rayno_filename'] = '';
$_SESSION['rayno_user'] = '';
$_SESSION['rayno_date'] = '';
$_SESSION['rayno_days'] = '';
$_SESSION['rayno_time'] = '';
$_SESSION['rayno_code'] = '';
$_SESSION['rayno_clientid'] = '';
$_SESSION['rayno_clientsecret'] = '';
$_SESSION['rayno_grantype'] = '';
$_SESSION['rayno_scope'] = '';
$_SESSION['rayno_soid'] = '';

RaynoGetSetup();

function activate_rayno_sync() {
	require_once plugin_dir_path( __FILE__ ) . 'admin/class-rayno-sync-activator.php';
	Rayno_Sync_Activator::activate();
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_rayno_sync() {
	require_once plugin_dir_path( __FILE__ ) . 'admin/class-rayno-sync-deactivator.php';
	Rayno_Sync_Deactivator::deactivate();
}
register_activation_hook( __FILE__, 'activate_rayno_sync' );
register_deactivation_hook( __FILE__, 'deactivate_rayno_sync' );
function rayno_sync_admin() {
	if ( is_admin() ) {
		add_menu_page('Rayno Synce Admin', 'Rayno Sync', 'manage_options', 'rayno-sync', 'rayno_init');
	}
}
add_action('admin_menu', 'rayno_sync_admin');
function rayno_init() {
?>
<html>
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width">
	    <link rel="stylesheet" href="/wp-content/plugins/rayno-sync/styles/rs-styles.css">
	    <script src="/wp-content/plugins/rayno-sync/scripts/rs-scripts.js?v=2"></script>
	    <title>Scheduled Maintenance</title>
	</head>
	<body>
		<header>
			<div class="w25"><img src="/wp-content/plugins/rayno-sync/images/rs-logo.jpg" class="header-logo" title="Rayno-Sync" alt="Rayno-Sync" /></div>
			<div class="w75"></div>
		</header>
		<div class="intro">
			<h1>Settings</h1>
			<p>Add description here</p>
		</div>
		<div class="salesinfo">
			<h2>Upload the CSV file with the sales information</h2>
			<p>Add description here</p>
			<form method="post" enctype="multipart/form-data" id="formdata">
				<input type="file" id="salesFile" class="salesFile" name="salesFile" accept=".csv" />
		  		<a href="#" class="fUpload rsButton" title="Upload File" alt="Upload File">Upload File</a>
			</form>
			<div class="currentfile">
				<b>Current File:</b>&nbsp;<span class="currentfile"><?php echo $_SESSION['rayno_filename'];  ?></span><br>
				<b>User:</b>&nbsp;<span class="currentuser"><?php echo $_SESSION['rayno_user'];  ?></span><br>
				<b>Date:</b>&nbsp;<span class="currentdate"><?php echo $_SESSION['rayno_date'];  ?></span><br>
			</div>
		</div>
		<div class="schedule">
			<h2>Please select the days and the time you want the sync to run</h2>
			<p>Add description here</p>
			<h4>Choose Days &amp; Time</h4>
			<form method="post" enctype="multipart/form-data" id="formschedule" ref="<?php echo $_SESSION['rayno_days']; ?>" ref2="<?php echo $_SESSION['rayno_time']; ?>">
				<div class="rscheck"><input type="checkbox" class="sSub" value="1" /><label>Sunday</label></div>
				<div class="rscheck"><input type="checkbox" class="sMon" value="2" /><label>Monday</label></div>
				<div class="rscheck"><input type="checkbox" class="sTue" value="3" /><label>Tuesday</label></div>
				<div class="rscheck"><input type="checkbox" class="sWed" value="4" /><label>Wednesday</label></div>
				<div class="rscheck"><input type="checkbox" class="sThu" value="5" /><label>Thursday</label></div>
				<div class="rscheck"><input type="checkbox" class="sFri" value="6" /><label>Friday</label></div>
				<div class="rscheck"><input type="checkbox" class="sSat" value="7" /><label>Saturday</label></div><br />&nbsp;<br />
				<div class="rstime"><input type="time" id="rsTime" /><label>Time</label></div><br />&nbsp;<br />
		  		<a href="#" class="sSchedule rsButton" title="Save Schedule" alt="Save Schedule">Save Schedule</a>
			</form>
		</div>
		<div class="apiinfo">
			<h2>Please enter the Zoho connection information</h2>
			<p>Add description here</p>
			<form method="post" enctype="multipart/form-data" id="apiinformation">
				<input type="text" id="clientid" class="clientid" name="clientid" placeholder="Client ID" value="<?php echo $_SESSION['rayno_clientid']; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="clientsecret" class="clientsecret" name="clientsecret" placeholder="Client Secret" value="<?php echo $_SESSION['rayno_clientsecret']; ?>" /><br />&nbsp;<br />
				<input type="text" id="granttype" class="granttype" name="granttype" placeholder="Grant Type" value="<?php echo $_SESSION['rayno_granttype']; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="scope" class="scope" name="scope" placeholder="Scope" value="<?php echo $_SESSION['rayno_scope']; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="soid" class="soid" name="soid" placeholder="SOID" value="<?php echo $_SESSION['rayno_soid']; ?>" /><br />&nbsp;<br />
		  		<a href="#" class="zohoinfo rsButton" title="Update Key" alt="Update Key">Update Zoho Information</a>
			</form>
		</div>
		<div class="bulkimport">
			<h2>Use this function to do the initial bulk import of the dealers from Zoho.</h2>
			<p>Add description here</p>
			<p><a href="#" class="doimport rsButton" title="Do Import" alt="Do Import">Do Import</a></p>
			<p><a href="#" class="geolocation rsButton" title="Run Geolocation" alt="Run Geolocation">Run Geolocation</a></p>
		</div>
		<div class="overlay"><div class="overlay-content"></div></div>
	</body>
</html>
<?php
}

?>