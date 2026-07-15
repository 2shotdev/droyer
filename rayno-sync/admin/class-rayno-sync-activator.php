<?php

/**
 * Fired during plugin activation
 *
 * @link       https://raynofilm.com/
 * @since      1.0.0
 *
 * @package    Rayno Sync
 * @subpackage rayno-sync/includes
 */
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Rayno Sync
 * @subpackage rayno-sync/includes
 * @author     Daniel Royer
 */
class Rayno_Sync_Activator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
	    $table_name = $wpdb->prefix . "rayno_sync";
	    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	        $sql = "CREATE TABLE $table_name (
	                id int NOT NULL AUTO_INCREMENT,
	                days text NOT NULL,
	                tme text NOT NULL,
	                usr text NOT NULL,
	                PRIMARY KEY  (id)
	                );";
	        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	        dbDelta($sql);
	        $sql = "INSERT INTO $table_name (days, tme, usr) values ('1,2,3,4,5,6,7','12:00','None')";
	        $wpdb->query($sql);
	    	$table_name = $wpdb->prefix . "rayno_files";
	        $sql = "CREATE TABLE $table_name (
	                id int NOT NULL AUTO_INCREMENT,
	                filename text NOT NULL,
	                dte text NOT NULL,
	                usr text NOT NULL,
	                PRIMARY KEY  (id)
	                );";
	        dbDelta($sql);
	    	$table_name = $wpdb->prefix . "rayno_zoho";
	        $sql = "CREATE TABLE $table_name (
	                id int NOT NULL AUTO_INCREMENT,
	                clientid text NOT NULL,
	                clientsecret text NOT NULL,
	                clientgranttype text NOT NULL,
	                clientscope text NOT NULL,
	                clientsoid text NOT NULL,
	                usr text NOT NULL,
	                PRIMARY KEY  (id)
	                );";
	        dbDelta($sql);
	    }
	}
}