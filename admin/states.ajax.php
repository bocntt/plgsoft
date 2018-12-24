<?php
require_once(dirname(__FILE__). "/../../../../wp-config.php");

$result_string = ''; 
$result_string .= '<option value="">Select state</option>';
global $wpdb;		
$table_name = $wpdb->prefix . "plgsoft_states";
$country_key = isset($_REQUEST["country_key"]) ? trim($_REQUEST["country_key"]) : "";
if (strlen($country_key) > 0) {
	$sql = "SELECT state_id, state_name " .
		" FROM " . $table_name;
	$sql .= " WHERE country_key = '".$country_key."'";
	$list_results = $wpdb->get_results($sql);
	foreach ($list_results as $item_obj) {
		$result_string .= '<option value="' .$item_obj->state_id. '">' .$item_obj->state_name. '</option>';
	}
}
echo $result_string;
?>