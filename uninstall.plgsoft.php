<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb;


$wpdb->query(delete_plgsoft_fields_table_sql());
$wpdb->query(delete_plgsoft_countries_table_sql());
$wpdb->query(delete_plgsoft_membership_table_sql());
$wpdb->query(delete_plgsoft_package_table_sql());
$wpdb->query(delete_plgsoft_states_table_sql());
$wpdb->query(delete_plgsoft_cities_table_sql());
$wpdb->query(delete_plgsoft_coupon_table_sql());
$wpdb->query(delete_plgsoft_quotes_table_sql());
$wpdb->query(delete_plgsoft_quotesdetails_table_sql());
$wpdb->query(delete_plgsoft_quotesmeta_table_sql());
$wpdb->query(delete_plgsoft_coreorders_table_sql());
$wpdb->query(delete_plgsoft_messages_table_sql());
$wpdb->query(delete_plgsoft_favorite_table_sql());
$wpdb->query(delete_plgsoft_question_table_sql());
$wpdb->query(delete_plgsoft_answer_table_sql());
$wpdb->query(delete_plgsoft_reply_table_sql());
$wpdb->query(delete_plgsoft_main_categories_table_sql());
$wpdb->query(delete_plgsoft_categories_table_sql());

$wpdb->query(delete_plgsoft_business_service_table_sql());
$wpdb->query(delete_plgsoft_business_table_sql());
$wpdb->query(delete_plgsoft_payment_type_sql());
$wpdb->query(delete_plgsoft_blocked_sql());
$wpdb->query(delete_plgsoft_friend_sql());

function delete_plgsoft_countries_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_countries";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_membership_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_membership";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_package_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_package";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_fields_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_fields";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_states_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_states";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_cities_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_cities";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_categories_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_categories";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_coupon_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_coupon";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_quotes_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "quotes";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_quotesdetails_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_quotesdetails";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_quotesmeta_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "quotes_meta";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_coreorders_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "core_orders";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_messages_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_messages";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_favorite_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_favorite";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_question_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_question";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_answer_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_answer";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_reply_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_reply";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_main_categories_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_main_categories";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_business_service_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_business_service";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_business_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "business";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_payment_type_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_payment_type";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_blocked_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_blocked";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}

function delete_plgsoft_friend_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_friend";
	$sql = "DROP TABLE IF EXISTS ".$table_name.";";
	return $sql;
}
?>
