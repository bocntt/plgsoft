<?php
if (!defined('plgsoft_constant')) {	
	if (!defined('plgsoft_site_url')) define('plgsoft_site_url', get_option('siteurl'));	
	if (!defined('plgsoft_constant')) define('plgsoft_constant', 1);
	if (!defined('WP_PLUGIN_DIR')) define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins'); 
	if (!defined('wp_plugin_plgsoft_dir')) define('wp_plugin_plgsoft_dir', WP_PLUGIN_DIR . '/plgsoft');
	if (!defined('wp_plugin_plgsoft_common_dir')) define('wp_plugin_plgsoft_common_dir', wp_plugin_plgsoft_dir . '/common'); 
	if (!defined('wp_plugin_plgsoft_admin_dir')) define('wp_plugin_plgsoft_admin_dir', wp_plugin_plgsoft_dir . '/admin');
	if (!defined('wp_plugin_plgsoft_enduser_dir')) define('wp_plugin_plgsoft_enduser_dir', wp_plugin_plgsoft_dir . '/enduser');
	if (!defined('wp_plugin_plgsoft_upload_img_dir')) define('wp_plugin_plgsoft_upload_img_dir', WP_CONTENT_DIR . '/uploads/plgsoft/');
	if (!defined('wp_plugin_plgsoft_upload_images')) define('wp_plugin_plgsoft_upload_images', WP_CONTENT_DIR . '/plugins/plgsoft/images/');
	if (!defined('plgsoft_max_size')) define('plgsoft_max_size', 500);
	if (!defined('WP_PLUGIN_URL')) define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');
	if (!defined('wp_plugin_plgsoft_url')) define('wp_plugin_plgsoft_url', WP_PLUGIN_URL . '/plgsoft');
	if (!defined('plgsoft_version')) define('plgsoft_version', '1.0');
	if (!defined('plgsoft_domain')) define('plgsoft_domain', plgsoft_site_url.'/wp-content/plugins/plgsoft/');
	
	if (!defined('wp_plugin_plgsoft_upload_img_url')) define('wp_plugin_plgsoft_upload_img_url', plgsoft_site_url.'/wp-content/uploads/plgsoft/');
	
	if (!defined('plgsoft_member_small_thumnail_width')) define('plgsoft_member_small_thumnail_width', 27);
	if (!defined('plgsoft_member_small_thumnail_height')) define('plgsoft_member_small_thumnail_height', 27);
	if (!defined('plgsoft_member_thumnail_width')) define('plgsoft_member_thumnail_width', 300);
	if (!defined('plgsoft_member_thumnail_height')) define('plgsoft_member_thumnail_height', 150);
	if (!defined('plgsoft_member_appicon_width')) define('plgsoft_member_appicon_width', 71);
	if (!defined('plgsoft_member_appicon_height')) define('plgsoft_member_appicon_height', 64);
	if (!defined('plgsoft_cause_thumnail_width')) define('plgsoft_cause_thumnail_width', 220);
	if (!defined('plgsoft_cause_thumnail_height')) define('plgsoft_cause_thumnail_height', 194);
	if (!defined('plgsoft_event_thumnail_width')) define('plgsoft_event_thumnail_width', 220);
	if (!defined('plgsoft_event_thumnail_height')) define('plgsoft_event_thumnail_height', 194);
	if (!defined('plgsoft_scall_factor')) define('plgsoft_scall_factor', 13);
	if (!defined('plgsoft_date_format')) define('plgsoft_date_format', "yy-mm-dd");
	if (!defined('plgsoft_twitter_url')) define('plgsoft_twitter_url', "http://twitter.com/");
}	
?>