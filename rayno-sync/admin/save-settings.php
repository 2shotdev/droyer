<?php
  /* ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL); */
  require_once("../../../../wp-load.php");
  global $wpdb;
  $user = wp_get_current_user();
  if(is_user_logged_in()){
    $days = $_GET["days"];
    $tme = $_GET["tme"];
    $usr = $user->display_name;
    $table_name = $wpdb->prefix . "rayno_sync"; 
    $sql = "UPDATE $table_name SET days = '".$days."', tme = '".$tme."', usr = '".$usr."' WHERE id=1;" ;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    $wpdb->query($sql);
    header('Content-Type: application/json');
    echo  '{"d":{"__type":"Contact.Status","ReturnCode":0,"ErrorMessage":"The setting were saved successfully."}}';
  } else {
    header('Content-Type: application/json');
    echo  '{"d":{"__type":"Contact.Status","ReturnCode":1,"ErrorMessage":"There was an error saving the settings."}}';
  }
?>