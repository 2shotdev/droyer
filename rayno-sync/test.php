<?php
	require_once("../../../wp-load.php");
	$user = wp_get_current_user();
	global $wpdb;
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	$table_name = $wpdb->prefix . "rayno_files";
	$sql = 'SELECT * from '.$table_name.';';
	$defaults = $wpdb->get_results($sql);
	echo $sql;
	var_dump($defaults);
?>