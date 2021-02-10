<?php
/*
 * Plugin Name: Dasmen Chatfuel Integration
 * Plugin URI: https://dasmen-reality.com/
 * Description: This plugin pushes site data to the Chatfuel API.
 * Text Domain: ds-chatfuel-integration
 * Version: 1.0
 * Author: Two Shot Developers
 * Author URI: https://twoshotdevelopers.com
 */

require_once plugin_dir_path( __FILE__ ) . 'inc/integration.php';
add_action( 'admin_menu', 'ds_chatfuel_integration_menu' );
function ds_chatfuel_integration_menu() {
  add_menu_page( 'Dasmen', 'Dasmen', 'manage_options', 'ds_chatfuel_admin_page', 'ds_chatfuel_admin_page', 'dashicons-admin-comments', 35);
}