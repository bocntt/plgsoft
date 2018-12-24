<?php
require_once(dirname(__FILE__). "/../../../../wp-config.php");

$result_string = ''; 
$result_string .= '<option value="">Select Question</option>';
global $wpdb;		
$table_name = $wpdb->prefix . "plgsoft_question";
$category_id = isset($_REQUEST["category_id"]) ? trim($_REQUEST["category_id"]) : 0;
if ($category_id > 0) {
	$sql = "SELECT question_id, question_name, question_description, question_type, have_other_answer, order_listing, is_active, category_id, date_added " .
		" FROM " . $table_name;
	$sql .= " WHERE category_id = '".$category_id."'";
	$list_results = $wpdb->get_results($sql);
	foreach ($list_results as $item_obj) {
		$result_string .= '<option value="' .$item_obj->question_id. '">' .$item_obj->question_name. '</option>';
	}
}
echo $result_string;
?>