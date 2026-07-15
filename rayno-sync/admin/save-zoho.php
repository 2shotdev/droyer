<?php
  /* ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL); */
  require_once("../../../../wp-load.php");
  global $wpdb;
  $user = wp_get_current_user();
  if(is_user_logged_in()){
    $id = $_GET["clientid"];
    $secret = $_GET["clientsecret"];
    $grant = $_GET["clientgranttype"];
    $scope = $_GET["clientscope"];
    $soid = $_GET["clientsoid"];
    $usr = $user->display_name;
    $table_name = $wpdb->prefix . "rayno_zoho"; 
    $sql = "INSERT INTO $table_name (clientid, clientsecret, clientgranttype, clientscope, clientsoid, usr)  values ('".$id."', '".$secret."', '".$grant."', '".$scope."', '".$soid."', '".$usr."');" ;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    $wpdb->query($sql);
    header('Content-Type: application/json');
    echo  '{"d":{"__type":"Contact.Status","ReturnCode":0,"ErrorMessage":"The setting were saved successfully."}}';
  } else {
    header('Content-Type: application/json');
    echo  '{"d":{"__type":"Contact.Status","ReturnCode":1,"ErrorMessage":"There was an error saving the settings."}}';
  }
?>