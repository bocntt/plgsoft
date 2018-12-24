<?php
require_once(dirname(__FILE__). "/../../../../wp-config.php");

$result_string = ''; 
$result_string .= '<option value="">Select city</option>';
global $wpdb;		
$table_name = $wpdb->prefix . "plgsoft_cities";
$state_id = isset($_REQUEST["state_id"]) ? $_REQUEST["state_id"] : 0;
if ($state_id > 0) {
	$sql = "SELECT city_id, city_name " .
		" FROM " . $table_name;
	$sql .= " WHERE is_active='1' AND state_id = '".$state_id."'";
	$list_results = $wpdb->get_results($sql);
	foreach ($list_results as $item_obj) {
		$result_string .= '<option value="' .$item_obj->city_id. '">' .$item_obj->city_name. '</option>';
	}
}
echo $result_string;
?>