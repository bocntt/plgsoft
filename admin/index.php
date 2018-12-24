<?php
require_once(wp_plugin_plgsoft_admin_dir . "/languages.php");

// wp_enqueue_style('admin_plgsoft_styling', plgsoft_domain . 'admin/plgsoft.css', false, plgsoft_version, "all");
// Begin need change by chiennv
// wp_enqueue_style('admin_plgsoft_jquery_ui', 'http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', false, "1.11.4", "all");
// wp_deregister_script('jquery');
// wp_register_script('jquery', "http://code.jquery.com/jquery-1.10.2.js", false, '1.10.2', false);
// wp_enqueue_script('jquery');
// wp_deregister_script('jquery-ui');
// wp_register_script('jquery-ui', "http://code.jquery.com/ui/1.11.4/jquery-ui.js", false, '1.11.4', false);
// wp_enqueue_script('jquery-ui');
// End need change by chiennv

/**
 * Add Scripts Change
 * By Bo Nguyen
 */
if ( ! function_exists( 'plgsoft_scripts' )) {
	function plgsoft_scripts() {
		wp_enqueue_style('admin_plgsoft_jquery_ui', 'http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', false, "1.11.4", "all");
		wp_enqueue_style('admin_plgsoft_styling', plgsoft_domain . 'plgsoft.css', false, plgsoft_version, "all");
		// wp_deregister_script('jquery');
		// wp_register_script('jquery', "http://code.jquery.com/jquery-1.10.2.js", false, '1.10.2', false);
		wp_enqueue_script('jquery');
		// wp_deregister_script('jquery-ui');
		// wp_register_script('jquery-ui', "http://code.jquery.com/ui/1.11.4/jquery-ui.js", false, '1.11.4', false);
		wp_enqueue_script('jquery-ui');
	}
}
add_action( 'admin_enqueue_scripts', 'plgsoft_scripts' );

function manage_fields() {
	global $table_name;
	$table_name = "plgsoft_fields";
	require_once(wp_plugin_plgsoft_admin_dir . "/fields/index.php");
}

function manage_countries() {
	global $table_name;
	$table_name = "plgsoft_countries";
	require_once(wp_plugin_plgsoft_admin_dir . "/countries/index.php");
}

function manage_membership() {
	global $table_name;
	$table_name = "plgsoft_membership";
	require_once(wp_plugin_plgsoft_admin_dir . "/membership/index.php");
}

function manage_package() {
	global $table_name;
	$table_name = "plgsoft_package";
	require_once(wp_plugin_plgsoft_admin_dir . "/package/index.php");
}

function manage_states() {
	global $table_name;
	$table_name = "plgsoft_states";
	require_once(wp_plugin_plgsoft_admin_dir . "/states/index.php");
}

function manage_cities() {
	global $table_name;
	$table_name = "plgsoft_cities";
	require_once(wp_plugin_plgsoft_admin_dir . "/cities/index.php");
}

function manage_coupon() {
	global $table_name;
	$table_name = "plgsoft_coupon";
	require_once(wp_plugin_plgsoft_admin_dir . "/coupon/index.php");
}

function manage_quotes() {
	global $table_name;
	$table_name = "quotes";
	require_once(wp_plugin_plgsoft_admin_dir . "/quotes/index.php");
}

function manage_quotesmeta() {
	global $table_name;
	$table_name = "quotes_meta";
	require_once(wp_plugin_plgsoft_admin_dir . "/quotesmeta/index.php");
}

function manage_coreorders() {
	global $table_name;
	$table_name = "core_orders";
	require_once(wp_plugin_plgsoft_admin_dir . "/coreorders/index.php");
}

function manage_messages() {
	global $table_name;
	$table_name = "plgsoft_messages";
	require_once(wp_plugin_plgsoft_admin_dir . "/messages/index.php");
}

function manage_favorite() {
	global $table_name;
	$table_name = "plgsoft_favorite";
	require_once(wp_plugin_plgsoft_admin_dir . "/favorite/index.php");
}

function manage_blocked() {
	global $table_name;
	$table_name = "plgsoft_blocked";
	require_once(wp_plugin_plgsoft_admin_dir . "/blocked/index.php");
}

function manage_friend() {
	global $table_name;
	$table_name = "plgsoft_friend";
	require_once(wp_plugin_plgsoft_admin_dir . "/friend/index.php");
}

function manage_question() {
	global $table_name;
	$table_name = "plgsoft_question";
	require_once(wp_plugin_plgsoft_admin_dir . "/question/index.php");
}

function manage_answer() {
	global $table_name;
	$table_name = "plgsoft_answer";
	require_once(wp_plugin_plgsoft_admin_dir . "/answer/index.php");
}

function manage_reply() {
	global $table_name;
	$table_name = "plgsoft_reply";
	require_once(wp_plugin_plgsoft_admin_dir . "/reply/index.php");
}

function manage_maincategories() {
	global $table_name;
	$table_name = "plgsoft_main_categories";
	require_once(wp_plugin_plgsoft_admin_dir . "/maincategories/index.php");
}

function manage_categories() {
	global $table_name;
	$table_name = "plgsoft_categories";
	require_once(wp_plugin_plgsoft_admin_dir . "/categories/index.php");
}

function manage_business_service() {
	global $table_name;
	$table_name = "plgsoft_business_service";
	require_once(wp_plugin_plgsoft_admin_dir . "/business_service/index.php");
}

function manage_payment_type() {
	global $table_name;
	$table_name = "plgsoft_payment_type";
	require_once(wp_plugin_plgsoft_admin_dir . "/payment_type/index.php");
}
?>
