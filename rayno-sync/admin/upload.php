<?php
  /* ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL); */
  require_once("../../../../wp-load.php");
  global $wpdb;
  $user = wp_get_current_user();
  if(is_user_logged_in()){
    if (isset($_FILES['file'])) {
      $targetDir = ABSPATH . "wp-content/plugins/rayno-sync/csv/";
      $filename = basename($_FILES["file"]["name"]);
      $allowedTypes = ['text/csv'];
      $fileType = $_FILES["file"]["type"];
      $targetFilePath = $targetDir . $filename;
      if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
          $dte = date("Y-m-d");
          $usr = $user->display_name;
          $table_name = $wpdb->prefix . "rayno_files"; 
          $sql = "INSERT INTO $table_name (filename, dte, usr) values ('".$filename."', '".$dte."', '".$usr."')";
          require_once ABSPATH . 'wp-admin/includes/upgrade.php';
          $wpdb->query($sql);
          header('Content-Type: application/json');
          echo  '{"d":{"__type":"Contact.Status","ReturnCode":0,"ErrorMessage":"The file upload was successful.","FileName":"'.$filename.'", "User":"'.$usr.'", "nDate": "'.$dte.'"}}';
        } else {
          header('Content-Type: application/json');
          echo  '{"d":{"__type":"Contact.Status","ReturnCode":1,"ErrorMessage":"The file upload was unsuccessful."}}';
        }
      } else {
        header('Content-Type: application/json');
        echo  '{"d":{"__type":"Contact.Status","ReturnCode":2,"ErrorMessage":"File type not allowed. '.$_FILES["file"]["type"].'"}}';
      }
    } else {
      header('Content-Type: application/json');
      echo  '{"d":{"__type":"Contact.Status","ReturnCode":3,"ErrorMessage":"No file received."}}';
    }
  }
?>