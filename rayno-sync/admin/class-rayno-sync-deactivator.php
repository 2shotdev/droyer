<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://raynofilm.com/
 * @since      1.0.0
 *
 * @package    Rayno Sync
 * @subpackage rayno-sync/includes
 */
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Rayno Sync
 * @subpackage rayno-sync/includes
 * @author     Daniel Royer
 */
class Rayno_Sync_Deactivator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
	    $table_name = $wpdb->prefix . "rayno_sync";
	    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
	        $sql = "DROP TABLE $table_name;";
	        $wpdb->query($sql);
	    }
	    $table_name = $wpdb->prefix . "rayno_files";
	    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
	        $sql = "DROP TABLE $table_name;";
	        $wpdb->query($sql);
	    }
	    $table_name = $wpdb->prefix . "rayno_zoho";
	    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
	        $sql = "DROP TABLE $table_name;";
	        $wpdb->query($sql);
	    }
	}

}