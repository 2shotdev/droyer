<?php
/*
 * Plugin Name: Model Tees Vendor Imports
 * Plugin URI: https://wp-fail2ban.com/
 * Description: This plugin imports product data from different vendors.
 * Text Domain: mt-vendor-imports
 * Version: 1.0
 * Author: Territory 3
 * Author URI: https://territory3.com
 */

require_once plugin_dir_path( __FILE__ ) . 'inc/mt-vendor-admin-page.php';
//require_once plugin_dir_path( __FILE__ ) . 'inc/mt-vendor-admin-sub-page.php';

add_action( 'admin_menu', 'mt_vendor_import_admin_menu' );

function mt_vendor_import_admin_menu() {
  add_menu_page( 'Vendors', 'Vendors', 'manage_options', 'mt-vendor-admin-page', 'mt_vendor_admin_page', 'dashicons-tickets', 6  );
  //add_submenu_page( 'myplugin/myplugin-admin-page.php', 'My Sub Level Menu Example', 'Sub Level Menu', 'manage_options', 'mt-vendor-imports/inc/mt-vendor-admin-sub-page.php', 'mt_vendor_admin_sub_page' );
}
