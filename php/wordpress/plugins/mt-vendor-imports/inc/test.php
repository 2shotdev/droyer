<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../../../../wp-load.php");

$pid = 1479;
$vdata = array(
	'attributes' => array (
		'color' => array('Stone'),
		'size' => array($_GET['size'])
	),
	'sku' => $_GET['sku'],
	'regular_price' => '0.00'
);
//var_dump(get_post_meta($pid));
var_dump(wc_get_product_id_by_sku("B71695700"));
// foreach ($vdata['attributes'] as $attribute => $term_name ) {
// 	var_dump($term_name[]);
// }