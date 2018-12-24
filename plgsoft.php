<?php
/*
 Plugin Name: Plg Soft Plugin
 Plugin URI: http://www.google.com/
 Description: The plugin is using for Plg Soft Plugin.
 Version: 1.0
 Author: Mr Nguyen
 */
require_once(dirname(__FILE__) . "/constant.php");
require_once(dirname(__FILE__) . "/common.php");

// wp_enqueue_style('plgsoft_styling', plgsoft_domain . 'plgsoft.css', false, plgsoft_version, "all");

function plgsoft_styling() {
	wp_register_style( 'plgsoft_style', plugins_url('plgsoft.css', __FILE__) );
	wp_enqueue_style( 'plgsoft_style' );
	wp_enqueue_script('jQuery');
	// wp_enqueue_style('plgsoft-bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css');
	// wp_enqueue_script('plgsoft-bootstrap-script', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js');
	wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
}
add_action( 'admin_enqueue_scripts', 'plgsoft_styling' );

require_once(wp_plugin_plgsoft_common_dir . "/index.php");
require_once(wp_plugin_plgsoft_enduser_dir . "/index.php");
/**
 * Begin for administrator area
 */
if(is_admin()) {
	require_once(wp_plugin_plgsoft_admin_dir . "/index.php");

	add_action('admin_menu', 'plgsoft_admin_menu');
	function plgsoft_admin_menu() {
		add_menu_page("Plg Soft Plugin", "Plg Soft Plugin", 'manage_options', 'manage_cities', 'manage_cities', plgsoft_domain . 'images/menu_icon.png');
		add_submenu_page('manage_cities', "Coupon", "Coupon", 'manage_options', 'manage_coupon', 'manage_coupon');
		add_submenu_page('manage_cities', "Quotes", "Quotes", 'manage_options', 'manage_quotes', 'manage_quotes');
		add_submenu_page('manage_cities', "Quotes Meta", "Quotes Meta", 'manage_options', 'manage_quotesmeta', 'manage_quotesmeta');
		add_submenu_page('manage_cities', "Core Orders", "Core Orders", 'manage_options', 'manage_coreorders', 'manage_coreorders');
		add_submenu_page('manage_cities', "Messages", "Messages", 'manage_options', 'manage_messages', 'manage_messages');
		add_submenu_page('manage_cities', "Favorite", "Favorite", 'manage_options', 'manage_favorite', 'manage_favorite');
		add_submenu_page('manage_cities', "Blocked", "Blocked", 'manage_options', 'manage_blocked', 'manage_blocked');
		add_submenu_page('manage_cities', "Friend", "Friend", 'manage_options', 'manage_friend', 'manage_friend');
		add_submenu_page('manage_cities', "Question", "Question", 'manage_options', 'manage_question', 'manage_question');
		add_submenu_page('manage_cities', "Answer", "Answer", 'manage_options', 'manage_answer', 'manage_answer');
		add_submenu_page('manage_cities', "Reply", "Reply", 'manage_options', 'manage_reply', 'manage_reply');

		add_submenu_page('manage_cities', "Main Categories", "Main Categories", 'manage_options', 'manage_maincategories', 'manage_maincategories');
		add_submenu_page('manage_cities', "Categories", "Categories", 'manage_options', 'manage_categories', 'manage_categories');
		add_submenu_page('manage_cities', "Business Service", "Business Service", 'manage_options', 'manage_business_service', 'manage_business_service');

		add_submenu_page('manage_cities', "Countries", "Countries", 'manage_options', 'manage_countries', 'manage_countries');
		add_submenu_page('manage_cities', "Memberships", "Memberships", 'manage_options', 'manage_membership', 'manage_membership');
		add_submenu_page('manage_cities', "Packages", "Packages", 'manage_options', 'manage_package', 'manage_package');
		add_submenu_page('manage_cities', "States", "States", 'manage_options', 'manage_states', 'manage_states');
		add_submenu_page('manage_cities', "Cities", "Cities", 'manage_options', 'manage_cities', 'manage_cities');
		add_submenu_page('manage_cities', "Fields", "Fields", 'manage_options', 'manage_fields', 'manage_fields');
		add_submenu_page('manage_cities', "Payment Type", "Payment Type", 'manage_options', 'manage_payment_type', 'manage_payment_type');
	}
}
/**
 * End for administrator area
 */

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'plgsoft_install');

function plgsoft_install() {
	if(is_admin()) {
		require_once(wp_plugin_plgsoft_dir . "/install.plgsoft.php");

		/* Creates new database field */
		add_option("plgsoft_data", 'Default', '', 'yes');
	}
}

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'plgsoft_remove');

function plgsoft_remove() {
	if(is_admin()) {
		require_once(wp_plugin_plgsoft_dir . "/uninstall.plgsoft.php");
		delete_option('plgsoft_data');
	}
}
?>
