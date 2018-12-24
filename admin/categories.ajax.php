<?php
require_once(dirname(__FILE__). "/../../../../wp-config.php");

$result_string = '';
$result_string .= '<option value="">Select category</option>';
global $wpdb;
$table_name = $wpdb->prefix . "plgsoft_categories";
$main_category_id = isset($_REQUEST["main_category_id"]) ? $_REQUEST["main_category_id"] : 0;
if ($main_category_id > 0) {
	$sql = "SELECT category_id, category_name " .
		" FROM " . $table_name;
	$sql .= " WHERE main_category_id = '".$main_category_id."'";
	$list_results = $wpdb->get_results($sql);
	foreach ($list_results as $item_obj) {
		$result_string .= '<option value="' .$item_obj->category_id. '">' .$item_obj->category_name. '</option>';
	}
}
echo $result_string;
?>
