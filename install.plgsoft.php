<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb;

dbDelta(create_plgsoft_fields_table_sql());
dbDelta(create_plgsoft_countries_table_sql());
dbDelta(create_plgsoft_membership_table_sql());
dbDelta(create_plgsoft_package_table_sql());
dbDelta(create_plgsoft_states_table_sql());
dbDelta(create_plgsoft_cities_table_sql());
dbDelta(create_plgsoft_coupon_table_sql());
dbDelta(create_plgsoft_quotes_table_sql());
dbDelta(create_plgsoft_quotesdetails_table_sql());
dbDelta(create_plgsoft_quotesmeta_table_sql());
//dbDelta(create_plgsoft_coreorders_table_sql());
dbDelta(create_plgsoft_messages_table_sql());
dbDelta(create_plgsoft_favorite_table_sql());
dbDelta(create_plgsoft_question_table_sql());
dbDelta(create_plgsoft_answer_table_sql());
dbDelta(create_plgsoft_reply_table_sql());
dbDelta(create_plgsoft_main_categories_table_sql());
dbDelta(create_plgsoft_categories_table_sql());

dbDelta(create_plgsoft_business_service_table_sql());
dbDelta(create_plgsoft_business_table_sql());
dbDelta(create_plgsoft_payment_type_sql());
dbDelta(create_plgsoft_blocked_sql());
dbDelta(create_plgsoft_friend_sql());

function create_plgsoft_countries_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_countries";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`country_key` varchar(50) NOT NULL,
			`country_name` varchar(250) NOT NULL,
			`order_listing` int(10) NOT NULL DEFAULT '0',
			`permalink` varchar(300) NOT NULL DEFAULT '',
			`is_active` int(1) NOT NULL DEFAULT '0',
			`seo_title` varchar(250) NOT NULL DEFAULT '',
			`seo_description` text NOT NULL DEFAULT '',
			PRIMARY KEY (`country_key`),
			UNIQUE KEY `country_key` (`country_key`),
			UNIQUE KEY `country_permalink` (`permalink`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	return $sql;
}

function create_plgsoft_membership_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_membership";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`membership_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`membership_order` int(10) NOT NULL DEFAULT '0',
			`membership_price` double(10,2) NOT NULL DEFAULT '0.00',
			`membership_submissionamount` double(10,2) NOT NULL DEFAULT '0.00',
			`membership_name` varchar(250) NOT NULL,
			`membership_subtext` text NOT NULL DEFAULT '',
			`membership_description` text NOT NULL DEFAULT '',
			`membership_multiple_cats` text NOT NULL DEFAULT '',
			`membership_multiple_images` text NOT NULL DEFAULT '',
			`membership_image` text NOT NULL DEFAULT '',
			`membership_expires` int(10) NOT NULL DEFAULT '0',
			`membership_access_fields` text NOT NULL DEFAULT '',
			`membership_position` varchar(20) NOT NULL DEFAULT '',
			`membership_button` varchar(50) NOT NULL DEFAULT '',
			`is_front_page` int(1) NOT NULL DEFAULT '0',
			`frontpage` int(1) NOT NULL DEFAULT '0',
			`featured` int(1) NOT NULL DEFAULT '0',
			`html` int(1) NOT NULL DEFAULT '0',
			`visitorcounter` int(1) NOT NULL DEFAULT '0',
			`topcategory` int(1) NOT NULL DEFAULT '0',
			`showgooglemap` int(1) NOT NULL DEFAULT '0',
			`is_active` int(1) NOT NULL DEFAULT '0',
			`package_id` int(11) NOT NULL DEFAULT '0',
			PRIMARY KEY (`membership_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	return $sql;
}

function create_plgsoft_package_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_package";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`package_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`package_order` int(10) NOT NULL DEFAULT '0',
			`package_price` double(10,2) NOT NULL DEFAULT '0.00',
			`package_name` varchar(250) NOT NULL,
			`package_subtext` text NOT NULL DEFAULT '',
			`package_description` text NOT NULL DEFAULT '',
			`package_multiple_cats` text NOT NULL DEFAULT '',
			`package_multiple_images` text NOT NULL DEFAULT '',
			`package_image` text NOT NULL DEFAULT '',
			`package_expires` int(10) NOT NULL DEFAULT '0',
			`package_hidden` varchar(250) NOT NULL,
			`package_multiple_cats_amount` text NOT NULL DEFAULT '',
			`package_max_uploads` text NOT NULL DEFAULT '',
			`package_action` varchar(250) NOT NULL,
			`package_access_fields` text NOT NULL DEFAULT '',
			`package_position` varchar(20) NOT NULL DEFAULT '',
			`package_button` varchar(50) NOT NULL DEFAULT '',
			`is_front_page` int(1) NOT NULL DEFAULT '0',
			`is_active` int(1) NOT NULL DEFAULT '0',
			PRIMARY KEY (`package_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	return $sql;
}

function create_plgsoft_fields_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_fields";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`field_key` varchar(50) NOT NULL,
			`field_name` varchar(250) NOT NULL,
			`order_listing` int(10) NOT NULL DEFAULT '0',
			`field_type` varchar(300) NOT NULL DEFAULT '',
			`field_business_type` varchar(300) NOT NULL DEFAULT '',
			`is_active` int(1) NOT NULL DEFAULT '0',
			`field_description` varchar(250) NOT NULL DEFAULT '',
			`field_placeholder` text NOT NULL DEFAULT '',
			`string_category_id` text NOT NULL DEFAULT '',
			`field_option_type` varchar(250) NOT NULL DEFAULT '',
			`field_option_value` text NOT NULL DEFAULT '',
			PRIMARY KEY (`field_key`),
			UNIQUE KEY `field_key` (`field_key`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	return $sql;
}

function create_plgsoft_states_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_states";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`state_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`state_name` varchar(200) NOT NULL,
			`state_code` varchar(50) NOT NULL DEFAULT '',
			`order_listing` int(10) NOT NULL DEFAULT '0',
			`permalink` varchar(300) NOT NULL DEFAULT '',
			`is_active` int(1) NOT NULL DEFAULT '0',
			`seo_title` varchar(250) NOT NULL DEFAULT '',
			`seo_description` text NOT NULL DEFAULT '',
			`country_key` varchar(50) NOT NULL DEFAULT '',
			PRIMARY KEY (`state_id`),
			UNIQUE KEY `state_permalink` (`permalink`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_cities_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_cities";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`city_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`city_name` varchar(200) NOT NULL,
			`city_code` varchar(50) NOT NULL DEFAULT '',
			`order_listing` int(10) NOT NULL DEFAULT '0',
			`permalink` varchar(300) NOT NULL DEFAULT '',
			`is_active` int(1) NOT NULL DEFAULT '0',
			`is_top` int(1) NOT NULL DEFAULT '0',
			`is_more` int(1) NOT NULL DEFAULT '0',
			`seo_title` varchar(250) NOT NULL DEFAULT '',
			`seo_description` text NOT NULL DEFAULT '',
			`state_id` int(20) NOT NULL DEFAULT '0',
			`country_key` varchar(50) NOT NULL DEFAULT '',
			PRIMARY KEY (`city_id`),
			UNIQUE KEY `city_permalink` (`permalink`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_categories_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_categories";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`category_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`category_name` varchar(200) NOT NULL,
			`order_listing` int(10) NOT NULL DEFAULT '0',
			`permalink` varchar(300) NOT NULL DEFAULT '',
			`is_active` int(1) NOT NULL DEFAULT '0',
			`seo_title` varchar(250) NOT NULL DEFAULT '',
			`seo_description` text NOT NULL DEFAULT '',
			`main_category_id` int(20) NOT NULL DEFAULT '0',
			PRIMARY KEY (`category_id`),
			UNIQUE KEY `category_permalink` (`permalink`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_coupon_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_coupon";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`coupon_id` int(11) NOT NULL AUTO_INCREMENT,
			`coupon_name` varchar(128) NOT NULL,
			`coupon_code` varchar(10) NOT NULL,
			`coupon_type` char(1) NOT NULL,
			`coupon_discount` decimal(15,4) NOT NULL,
			`coupon_total` decimal(15,4) NOT NULL,
			`date_start` date NOT NULL DEFAULT '0000-00-00',
			`date_end` date NOT NULL DEFAULT '0000-00-00',
			`uses_total` int(11) NOT NULL,
			`uses_customer` varchar(11) NOT NULL,
			`is_active` tinyint(1) NOT NULL,
			`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			PRIMARY KEY (`coupon_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_quotes_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "quotes";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`id` int(11) NOT NULL AUTO_INCREMENT,
  			`from_user` int(11) UNSIGNED NOT NULL,
  			`to_user` int(11) UNSIGNED NOT NULL,
  			`content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  			`message` text NOT NULL,
  			`image` varchar(255) NOT NULL,
  			`status` varchar(255) NOT NULL DEFAULT 'pending',
  			`anything_else` tinyint(1) NOT NULL,
  			`about_yourself` tinyint(1) NOT NULL,
  			`zip_code` varchar(50) NOT NULL,
  			`email_address` varchar(250) NOT NULL,
  			`phone_number` varchar(250) NOT NULL,
  			`full_name` varchar(250) NOT NULL,
  			`category_id` int(11) UNSIGNED NOT NULL,
  			`send_date` varchar(255) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_quotesdetails_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_quotesdetails";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`quotesdetails_id` int(11) NOT NULL AUTO_INCREMENT,
			`quotes_id` int(11) NOT NULL DEFAULT '0',
			`question_id` int(11) NOT NULL DEFAULT '0',
			`answer_id` int(11) NOT NULL DEFAULT '0',
			`reply_id` int(11) NOT NULL DEFAULT '0',
			`message` TEXT NOT NULL DEFAULT '',
  			`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			PRIMARY KEY (`quotesdetails_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_quotesmeta_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "quotes_meta";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`id` int(11) NOT NULL AUTO_INCREMENT,
  			`content` text COLLATE utf8_unicode_ci NOT NULL,
  			`estimate` int(11) NOT NULL,
  			`attachment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  			`quotes_id` int(11) NOT NULL,
  			`from_user` int(11) NOT NULL,
  			`to_user` int(11) NOT NULL,
  			`status` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'pending',
  			`time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_coreorders_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "core_orders";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`id` int(11) NOT NULL AUTO_INCREMENT,
  			`content` text COLLATE utf8_unicode_ci NOT NULL,
  			`estimate` int(11) NOT NULL,
  			`attachment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  			`quotes_id` int(11) NOT NULL,
  			`from_user` int(11) NOT NULL,
  			`to_user` int(11) NOT NULL,
  			`status` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'pending',
  			`time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_messages_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_messages";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`messages_id` int(11) NOT NULL AUTO_INCREMENT,
  			`messages_title` varchar(250) NOT NULL,
  			`messages_name` varchar(250) NOT NULL,
  			`username` varchar(250) NOT NULL,
  			`email` varchar(250) NOT NULL,
  			`phone` varchar(100) NOT NULL,
  			`message` TEXT NOT NULL,
  			`status` varchar(100) NOT NULL,
  			`user_id` int(11) NOT NULL,
  			`to_user_id` int(11) NOT NULL,
  			`post_id` int(11) NOT NULL,
  			`ref` varchar(250) NOT NULL,
  			`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  			PRIMARY KEY (`messages_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_favorite_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_favorite";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`favorite_id` bigint(20) NOT NULL AUTO_INCREMENT,
  			`user_id` int(11) NOT NULL,
  			`post_id` int(11) NOT NULL,
  			`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  			PRIMARY KEY (`favorite_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_question_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_question";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`question_id` int(11) NOT NULL AUTO_INCREMENT,
  			`question_name` varchar(250) NOT NULL,
  			`question_description` TEXT NOT NULL,
  			`question_type` varchar(50) NOT NULL,
  			`have_other_answer` tinyint(1) NOT NULL,
  			`order_listing` int(11) NOT NULL,
  			`is_optional` tinyint(1) NOT NULL,
  			`is_active` tinyint(1) NOT NULL,
  			`category_id` int(11) NOT NULL,
  			`date_added` datetime NOT NULL,
  			PRIMARY KEY (`question_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_answer_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_answer";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`answer_id` int(11) NOT NULL AUTO_INCREMENT,
			`answer_name` varchar(250) NOT NULL,
			`answer_description` TEXT NOT NULL,
			`order_listing` int(11) NOT NULL,
			`is_active` tinyint(1) NOT NULL,
			`category_id` int(11) NOT NULL,
			`question_id` int(11) NOT NULL,
			`date_added` datetime NOT NULL,
			PRIMARY KEY (`answer_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_reply_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_reply";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`reply_id` int(11) NOT NULL AUTO_INCREMENT,
			`reply_name` varchar(250) NOT NULL,
			`reply_description` TEXT NOT NULL,
			`order_listing` int(11) NOT NULL,
			`is_active` tinyint(1) NOT NULL,
			`category_id` int(11) NOT NULL,
			`question_id` int(11) NOT NULL,
			`user_id` int(11) NOT NULL,
			`date_added` datetime NOT NULL,
			PRIMARY KEY (`reply_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_main_categories_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_main_categories";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`main_category_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`main_category_name` varchar(200) NOT NULL,
			`order_listing` int(10) NOT NULL DEFAULT '0',
			`permalink` varchar(300) NOT NULL DEFAULT '',
			`is_active` int(1) NOT NULL DEFAULT '0',
			`seo_title` varchar(250) NOT NULL DEFAULT '',
			`seo_description` text NOT NULL DEFAULT '',
			PRIMARY KEY (`main_category_id`),
			UNIQUE KEY `main_category_permalink` (`permalink`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_business_service_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_business_service";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
		`business_service_id` int(11) NOT NULL AUTO_INCREMENT,
		`business_service_name` varchar(250) NOT NULL,
		`description` text NOT NULL DEFAULT '',
		`keywords` text NOT NULL DEFAULT '',
		`permalink` varchar(250) NOT NULL DEFAULT '',
		`is_active` int(1) NOT NULL DEFAULT '0',
		`seo_title` varchar(250) NOT NULL DEFAULT '',
		`seo_description` text NOT NULL DEFAULT '',
		PRIMARY KEY (`business_service_id`),
		UNIQUE KEY `business_service_permalink` (`permalink`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_business_table_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "business";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
		`business_id` bigint(20) NOT NULL AUTO_INCREMENT,
		`business_name` varchar(100) NOT NULL,
		`business_add1` varchar(100) NOT NULL,
		`business_add2` varchar(100) NOT NULL,
		`business_phone` varchar(50) NOT NULL,
		`business_web` varchar(100) NOT NULL,
		`city_id` int(11) NOT NULL,
		`zip` varchar(16) NOT NULL,
		`cat_id` int(11) NOT NULL,
		`sub_cat_id` int(11) NOT NULL,
		`cat_id2` int(11) NOT NULL,
		`sub_cat_id2` int(11) NOT NULL,
		`cat_id3` int(11) NOT NULL,
		`sub_cat_id3` int(11) NOT NULL,
		`user_id` int(11) NOT NULL,
		`rating` double NOT NULL,
		`click` int(11) NOT NULL,
		`reviews_num` int(11) NOT NULL,
		`photo_url` varchar(250) NOT NULL DEFAULT '',
		`x` varchar(21) NOT NULL,
		`y` varchar(21) NOT NULL,
		`mapx` varchar(21) NOT NULL,
		`mapy` varchar(21) NOT NULL,
		`zoom` varchar(5) NOT NULL,
		`video_url` varchar(250) NOT NULL DEFAULT '',
		`description` text NOT NULL DEFAULT '',
		`from_hour` varchar(16) NOT NULL,
		`to_hour` varchar(16) NOT NULL,
		`weeks` varchar(16) NOT NULL,
		`price_range` varchar(1) NOT NULL,
		`submit_date` varchar(14) NOT NULL,
		`approved` int(11) NOT NULL DEFAULT '1',
		`permalink` varchar(250) NOT NULL DEFAULT '',
		`starbiz` int(11) NOT NULL DEFAULT '0',
		`submitter_id` int(11) NOT NULL,
		`open_hours` varchar(128) NOT NULL,
		`seo_title` varchar(250) NOT NULL DEFAULT '',
		`seo_description` text NOT NULL DEFAULT '',
		PRIMARY KEY (`business_id`),
		UNIQUE KEY `business_permalink` (`permalink`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	return $sql;
}

function create_plgsoft_payment_type_sql(){
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_payment_type";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`payment_type_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`payment_type_order` int(10) NOT NULL DEFAULT '0',
			`payment_type_price` double(10,2) NOT NULL DEFAULT '0.00',
			`payment_type_name` varchar(250) NOT NULL,
			`payment_type_subtext` text NOT NULL DEFAULT '',
			`payment_type_description` text NOT NULL DEFAULT '',
			`payment_type_multiple_cats` text NOT NULL DEFAULT '',
			`payment_type_multiple_images` text NOT NULL DEFAULT '',
			`payment_type_image` text NOT NULL DEFAULT '',
			`payment_type_expires` int(10) NOT NULL DEFAULT '0',
			`payment_type_hidden` varchar(250) NOT NULL,
			`payment_type_multiple_cats_amount` text NOT NULL DEFAULT '',
			`payment_type_max_uploads` text NOT NULL DEFAULT '',
			`payment_type_action` varchar(250) NOT NULL,
			`payment_type_access_fields` text NOT NULL DEFAULT '',
			`payment_type_position` varchar(20) NOT NULL DEFAULT '',
			`payment_type_button` varchar(50) NOT NULL DEFAULT '',
			`is_front_page` int(1) NOT NULL DEFAULT '0',
			`is_active` int(1) NOT NULL DEFAULT '0',
			PRIMARY KEY (`payment_type_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	return $sql;
}

function create_plgsoft_blocked_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . "plgsoft_blocked";
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
		`blocked_id` int(11) NOT NULL AUTO_INCREMENT,
		`user_blocked_id` int(11) NOT NULL,
		`user_id` int(11) NOT NULL,
		`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		PRIMARY KEY (`blocked_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	return $sql;
}

function create_plgsoft_friend_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix. "plgsoft_friend";
	$sql = "CREATE TABLE IF NOT EXISTS `wp_plgsoft_friend` (
		`friend_id` int(11) NOT NULL AUTO_INCREMENT,
		`user_friend_id` int(11) NOT NULL,
		`user_id` int(11) NOT NULL,
		`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		PRIMARY KEY (`friend_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1";
	return $sql;
}

?>
