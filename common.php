<?php
function get_array_access_fields() {
	$array_fields = array("post_title" => "Listing Title",
		"post_content" => "Description",
		"category" => "Business Category",
		"business_service" => "Business Service",
		"hours" => "Business Hours",
		"price_from" => "Price From",
		"price" => "Price To",
		"year_in_business" => "Years in Business",
		"year_of_exp" => "Years of Experience",
		"map_state" => "State",
		"map_city" => "City",
		"image" => "Image",
		"logo_business" => "Business Logo",
		"slogan" => "Slogan",
		"website" => "Website",
		"job_service_business" => "Select your business type",
		"map_location" => "Location",
		"listing_status" => "Listing Status");
	return $array_fields;
}

function get_array_messages_status() {
	$array_messages_status = array("unread" => "New", "read" => "Read", "delete" => "Delete");
	return $array_messages_status;
}

function get_array_quotes_status() {
	$array_quotes_status = array("active" => "Active", "draft" => "Inactive", "pending" => "Pending Review");
	return $array_quotes_status;
}

function get_array_coupon_type() {
	return array("P" => "Percentage",
		"F" => "Fixed Amount");
}

function get_array_question_type() {
	return array("checkbox" => "More Than One Answers",
		"radio" => "One Answers");
}

function get_array_position() {
	$array_position = array("left" => "Left", "right" => "Right");
	return $array_position;
}

function get_array_button() {
	$array_button = array("subscribe-for-free" => "Subscribe for free!",
		"sign-up-today" => "Sign-up today",
		"upgrade-today" => "Upgrade Today");
	return $array_button;
}

function get_array_yes_no_plgsoft_property() {
	$array_yes_no_property = array("0" => "No", "1" => "Yes");
	return $array_yes_no_property;
}

function get_array_yes_no_plgsoft_text() {
	$array_yes_no_property = array("no" => "No", "yes" => "Yes");
	return $array_yes_no_property;
}

function get_array_plgsoft_field_type() {
	$array_field_type = array("text" => "Text", "textarea" => "Text Area", "select" => "SelectBox");
	return $array_field_type;
}

function get_array_plgsoft_field_option_type() {
	$array_field_type = array("services" => "Services", "manual" => "Manual");
	return $array_field_type;
}

function get_array_plgsoft_field_business_type() {
	$array_field_business_type = array("job_service_business" => "Job Service Business",
		"professional_service_business" => "Professional Service Business",
		"retail_business" => "Retail Business",
		"both_types_of_services" => "Both Types of Business");
	return $array_field_business_type;
}

function get_array_months_plgsoft() {
	$array_months = array("" => "Month", "1" => "January", "2" => "February", "3" => "March", "4" => "April", "5" => "May", "6" => "June",
					"7" => "July", "8" => "August", "9" => "September", "10" => "October", "11" => "November", "12" => "December");
	return $array_months;
}

function get_extension_images(){
	$array_extensions = array("image/jpeg", "image/gif", "image/png", "image/bmp");
	return $array_extensions;
}

function get_array_days_plgsoft() {
	$array_days = array();
	$array_days[""] = "Day";
	for($i=1; $i<=31; $i++) {
		$array_days[$i] = $i;
	}
	return $array_days;
}

function get_array_years_plgsoft() {
	$start_year = 1907;
	$end_year = date("Y");
	$array_years = array();
	$array_years[""] = "Year";
	for($i=$start_year; $i<=$end_year; $i++) {
		$array_years[$i] = $i;
	}
	return $array_years;
}

function get_array_card_years_plgsoft() {
	$start_year = date("Y");
	$end_year = $start_year + 15;
	$array_years = array();
	$array_years[""] = "Year";
	for($i=$start_year; $i<=$end_year; $i++) {
		$array_years[$i] = $i;
	}
	return $array_years;
}

function convert_month_and_year_todate($month, $year) {
	$day = 28;
	return $year. "-" .$month. "-" .$day;
}

function convert_month_day_year_todate($month, $day, $year) {
	return $year. "-" .$month. "-" .$day;
}

function round_up_number($number) {
	if ($number == 0) $numberTemp = 0;
	else $numberTemp = round($number);
	$numberTemp = round($number);
	if ($number <= $numberTemp) return $numberTemp;
	else return $numberTemp + 1;
}

function get_plgsoft_admin_url($query = array()) {
	global $plugin_page;

	if (!isset($query['page'])) $query['page'] = $plugin_page;
	$path = 'admin.php';
	if ($query = build_query($query)) $path .= '?' . $query;
	$url = admin_url($path);

	return esc_url_raw($url);
}

function get_plgsoft_file_extension($filename) {
	return "." . end(explode(".", $filename));
}

function check_plgsoft_format_email($email) {
	if (($email==null) || (strlen($email) == 0)) {
		return false;
	} else {
		if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
			return false;
		} else {
			return true;
		}
	}
}

function get_plgsoft_member_date_header() {
	if (isset($_SESSION['plgsoft_member_date_header'])) {
		return $_SESSION['plgsoft_member_date_header'];
	} else {
		$_SESSION['plgsoft_member_date_header'] = date('l dS F Y');
		$_SESSION['plgsoft_member_date'] = date("Y-m-d");
		$current_date = date('l dS F Y');
		return $current_date;
	}
}

function get_plgsoft_member_date() {
	if (isset($_SESSION['plgsoft_member_date'])) {
		return $_SESSION['plgsoft_member_date'];
	} else {
		$_SESSION['plgsoft_member_date_header'] = date('l dS F Y');
		$_SESSION['plgsoft_member_date'] = date("Y-m-d");
		$current_date = date("Y-m-d");
		return $current_date;
	}
}

function get_users_by_array_user_id($array_user_id=array()) {
	$users_array = array();
	if (sizeof($array_user_id) == 0) {
		return $users_array;
	} else {
		$string_user_id = "'" .implode("','", $array_user_id). "'";
		global $wpdb;
		$sql = "SELECT ID, user_login, display_name";
		$sql .= " FROM $wpdb->users";
		if (strlen($string_user_id) > 0) {
			$sql .= " WHERE ID IN (" .$string_user_id. ")";
		}
		$sql .= " ORDER BY ID";
		$users_list = $wpdb->get_results($sql);
		foreach ($users_list as $user_item) {
			$user_id = $user_item->ID;
			$user_login = stripslashes($user_item->user_login);
			$display_name = stripslashes($user_item->display_name);
			$users_array[$user_id]['user_login'] = $user_login;
			$users_array[$user_id]['display_name'] = $display_name;
		}
		return $users_array;
	}
}

function get_post_listings_by_array_post_id($array_post_id=array()) {
	$posts_array = array();
	if (sizeof($array_post_id) == 0) {
		return $posts_array;
	} else {
		$string_post_id = "'" .implode("','", $array_post_id). "'";
		global $wpdb;
		$inner_join_sql = "INNER JOIN ".$wpdb->prefix."information_posts AS mt_information ON ".$wpdb->prefix."posts.ID = mt_information.post_id ";
		$sql = "SELECT SQL_CALC_FOUND_ROWS ".$wpdb->prefix."posts.ID, ".$wpdb->prefix."posts.post_author, ".$wpdb->prefix."posts.post_date,
			".$wpdb->prefix."posts.post_date_gmt, ".$wpdb->prefix."posts.post_content, ".$wpdb->prefix."posts.post_title,
			".$wpdb->prefix."posts.post_excerpt, ".$wpdb->prefix."posts.post_status, ".$wpdb->prefix."posts.comment_status,
			".$wpdb->prefix."posts.ping_status, ".$wpdb->prefix."posts.post_password, ".$wpdb->prefix."posts.post_name,
			".$wpdb->prefix."posts.to_ping, ".$wpdb->prefix."posts.pinged, ".$wpdb->prefix."posts.post_modified,
			".$wpdb->prefix."posts.post_modified_gmt, ".$wpdb->prefix."posts.post_content_filtered, ".$wpdb->prefix."posts.post_parent,
			".$wpdb->prefix."posts.guid, ".$wpdb->prefix."posts.menu_order, ".$wpdb->prefix."posts.post_type,
			".$wpdb->prefix."posts.post_mime_type, ".$wpdb->prefix."posts.comment_count, mt_information.* FROM ".$wpdb->prefix."posts ";
		$sql .= $inner_join_sql;
		if (strlen($string_post_id) > 0) {
			$sql .= " WHERE ID IN (" .$string_post_id. ")";
		}
		$sql .= " ORDER BY ID";
		$posts_list = $wpdb->get_results($sql);
		foreach ($posts_list as $post_item) {
			$post_id = $post_item->ID;
			$post_type = $post_item->post_type;
			$post_title = stripslashes($post_item->post_title);
			$post_name = stripslashes($post_item->post_name);
			$post_city = stripslashes($post_item->map_city);
			$post_state = stripslashes($post_item->map_state);
			$post_permalink = custom_performance_permalink($post_id, $post_type, $post_name, $post_city, $post_state);
			$posts_array[$post_id]['post_title'] = $post_title;
			$posts_array[$post_id]['post_name'] = $post_name;
			$posts_array[$post_id]['post_permalink'] = $post_permalink;
		}
		return $posts_array;
	}
}

function get_id_by_post_name($post_name) {
	global $wpdb;
	$id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name = '%s'"), $post_name);
	return $id;
}

function get_array_post_names() {
	$array_post_names = array();
	return $array_post_names;
}

function get_plgsoft_link_by_post_name($post_name, $siteurl="") {
	$array_post_names = get_array_post_names();
	if (strlen($siteurl) == 0) return $array_post_names[$post_name];
	else return $siteurl . '/' . $array_post_names[$post_name];
}

function get_plgsoft_permalink($permalink_name) {
	$permalink_key = "";
	$array_characters = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
	$permalink_name = strtolower(trim($permalink_name));
	if (strlen($permalink_name) > 0) {
		for($i=0; $i<strlen($permalink_name); $i++) {
			if (in_array($permalink_name[$i], $array_characters)) {
				$permalink_key .= $permalink_name[$i];
			} elseif ($permalink_name[$i] == ' ') {
				$permalink_key .= "-";
			}
		}
	}
	$characters = array("-----", "----", "---", "--");
	$permalink_key = str_replace($characters, "-", $permalink_key);
	return $permalink_key;
}

function get_plgsoft_code($code_name) {
	$code_key = "";
	$array_characters = array("_", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
	$code_name = strtolower(trim($code_name));
	if (strlen($code_name) > 0) {
		for($i=0; $i<strlen($code_name); $i++) {
			if (in_array($code_name[$i], $array_characters)) {
				$code_key .= $code_name[$i];
			} elseif ($code_name[$i] == ' ') {
				$code_key .= "-";
			}
		}
	}
	$characters = array("-----", "----", "---", "--");
	$code_key = str_replace($characters, "_", $code_key);
	return $code_key;
}


function print_tabs_menus() {
	$url_site = plgsoft_site_url;
	$admin_url_site = esc_url( $url_site . '/wp-admin/admin.php?page=' );
	$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : "";
	$normal_style = "padding: 0 5px 10px 5px; font-size: 1.2em;";
	$current_style = "padding: 0 5px 10px 5px; font-weight: bold; color: #333; font-size: 1.2em;";
	echo '<script type="text/javascript">var url_site="'.$url_site.'";</script>';
	echo '<script type="text/javascript" src="' . plgsoft_domain . 'admin/plgsoft.js"></script>';
	echo '<ul class="plgsoft-tabs-nav" id="ndizi_tabs">';
	if ($page == 'manage_coupon') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_coupon"><i class="fa fa-tags"></i>'. __( "Coupon" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_coupon"><i class="fa fa-tags"></i>'. __( "Coupon" ) . '</a></li>';
	}
	if ($page == 'manage_quotes') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_quotes"><i class="fa fa-quote-right"></i>' . __( "Quotes" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_quotes"><i class="fa fa-quote-right"></i>' . __( "Quotes" ) . '</a></li>';
	}
	if ($page == 'manage_quotesmeta') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_quotesmeta"><i class="fa fa-quote-left"></i>' . __( "Quotes Meta" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_quotesmeta"><i class="fa fa-quote-left"></i>' . __( "Quotes Meta" ) . '</a></li>';
	}
	if ($page == 'manage_coreorders') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_coreorders"><i class="fa fa-reorder"></i>' . __( "Core Orders" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_coreorders"><i class="fa fa-reorder"></i>' . __( "Core Orders" ) . '</a></li>';
	}
	if ($page == 'manage_messages') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_messages"><i class="fa fa-inbox"></i>' . __( "Messages" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_messages"><i class="fa fa-inbox"></i>' . __( "Messages" ) . '</a></li>';
	}
	if ($page == 'manage_favorite') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_favorite"><i class="fa fa-star"></i>' . __( "Favorite" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_favorite"><i class="fa fa-star"></i>' . __( "Favorite" ) . '</a></li>';
	}
	if ($page == 'manage_blocked') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_blocked"><i class="fa fa-minus-circle"></i>' . __( "Blocked" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_blocked"><i class="fa fa-minus-circle"></i>' . __( "Blocked" ) . '</a></li>';
	}
	if ($page == 'manage_friend') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_friend"><i class="fa fa-users"></i>' . __( "Friend" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_friend"><i class="fa fa-users"></i>' . __( "Friend" ) . '</a></li>';
	}
	if ($page == 'manage_question') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_question"><i class="fa fa-question"></i>' . __( "Question" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_question"><i class="fa fa-question"></i>' . __( "Question" ) . '</a></li>';
	}
	if ($page == 'manage_answer') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_answer"><i class="fa fa-reply-all"></i>' . __( "Answer" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_answer"><i class="fa fa-reply-all"></i>' . __( "Answer" ) . '</a></li>';
	}
	if ($page == 'manage_reply') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_reply"><i class="fa fa-reply"></i>' . __( "Reply" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_reply"><i class="fa fa-reply"></i>' . __( "Reply" ) . '</a></li>';
	}
	if ($page == 'manage_maincategories') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_maincategories"><i class="fa fa-list-alt"></i>' . __( "Main Categories" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_maincategories"><i class="fa fa-list-alt"></i>' . __( "Main Categories" ) . '</a></li>';
	}
	if ($page == 'manage_categories') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_categories"><i class="fa fa-list-alt"></i>' . __( "Categories" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_categories"><i class="fa fa-list-alt"></i>' . __( "Categories" ) . '</a></li>';
	}
	if ($page == 'manage_business_service') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_business_service"><i class="fa fa-suitcase"></i>' . __( "Business Service" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_business_service"><i class="fa fa-suitcase"></i>' . __( "Business Service" ) . '</a></li>';
	}
	if ($page == 'manage_countries') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_countries"><i class="fa fa-flag"></i>' . __( "Countries" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_countries"><i class="fa fa-flag"></i>' . __( "Countries" ) . '</a></li>';
	}
	if ($page == 'manage_membership') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_membership"><i class="fa fa-users"></i>' . __( "Memberships" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_membership"><i class="fa fa-users"></i>' . __( "Memberships" ) . '</a></li>';
	}
	if ($page == 'manage_package') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_package"><i class="fa fa-briefcase"></i>' . __( "Packages" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_package"><i class="fa fa-briefcase"></i>' . __( "Packages" ) . '</a></li>';
	}
	if ($page == 'manage_states') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_states"><i class="fa fa-map"></i>' . __( "States" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_states"><i class="fa fa-map"></i>' . __( "States" ) . '</a></li>';
	}
	if ($page == 'manage_cities') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_cities"><i class="fa fa-map-pin"></i>' . __( "Cities" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_cities"><i class="fa fa-map-pin"></i>' . __( "Cities" ) . '</a></li>';
	}
	if ($page == 'manage_fields') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_fields"><i class="fa fa-columns"></i>' . __( "Fields" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_fields"><i class="fa fa-columns"></i>' . __( "Fields" ) . '</a></li>';
	}
	if ($page == 'manage_payment_type') {
		echo '<li class="list-nav-item-active"><a class="" href="'.$admin_url_site.'manage_payment_type"><i class="fa fa-money"></i>' . __( "Payment Type" ) . '</a></li>';
	} else {
		echo '<li class="list-nav-item"><a class="" href="'.$admin_url_site.'manage_payment_type"><i class="fa fa-money"></i>' . __( "Payment Type" ) . '</a></li>';
	}
	echo '</ul>';
}

function check_number_order_listing($order_listing) {
	$array_characters = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
	$order_listing = trim($order_listing);
	$is_check = false;
	for($i=0; $i<strlen($order_listing); $i++) {
		if (in_array($order_listing[$i], $array_characters)) {
			$is_check = true;
		} else {
			$is_check = false;
		}
	}
	return $is_check;
}

function check_number_price($price) {
	$array_characters = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", ".");
	$price = trim($price);
	$is_check = false;
	for($i=0; $i<strlen($price); $i++) {
		if (in_array($price[$i], $array_characters)) {
			$is_check = true;
		} else {
			$is_check = false;
		}
	}
	return $is_check;
}

function get_plgsoft_latitude_longitude_by_address($address) {
	$array_lat_lng = array('scall_factor' => plgsoft_scall_factor, 'latitude' => 0, 'longitude' => 0);
	$address = urlencode(str_replace(" ", "+", $address));
	$url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$address."&sensor=true";
	$xml = simplexml_load_file($url);
	$status = $xml->status;
	if (strcmp($status, "OK") == 0) {
		$lat = $xml->result->geometry->location->lat;
		$lng = $xml->result->geometry->location->lng;
		if (($lat != "") && ($lng != "")) {
			$array_lat_lng['scall_factor'] = plgsoft_scall_factor;
			$array_lat_lng['latitude'] = $lat;
			$array_lat_lng['longitude'] = $lng;
		}
	}
	return $array_lat_lng;
}

function get_array_cause_minutes(){
	$array_minutes = array("00" => "0", "15" => "15", "30" => "30", "45" => "45");
	return $array_minutes;
}

function get_array_cause_hours(){
	$array_hours = array("00" => "0", "01" => "1", "02" => "2", "03" => "3", "04" => "4", "05" => "5", "06" => "6", "07" => "7", "08" => "8", "09" => "9", "10" => "10", "11" => "11",
			"12" => "12", "13" => "13", "14" => "14", "15" => "15", "16" => "16", "17" => "17", "18" => "18", "19" => "19", "20" => "20", "21" => "21", "22" => "22", "23" => "23");
	return $array_hours;
}

function convert_event_time_to_array_time($event_time) {
	$array_times = array("hour" => "00", "minute" => "00", "second" => "00");
	if (strlen($event_time) == 0) {
		return $array_times;
	} else {
		$array_event_time = explode(":", $event_time);
		if (isset($array_event_time[0])) $array_times["hour"] = trim($array_event_time[0]);
		if (isset($array_event_time[1])) $array_times["minute"] = trim($array_event_time[1]);
		if (isset($array_event_time[2])) $array_times["second"] = trim($array_event_time[2]);
	}
	return $array_times;
}

function check_event_date($event_date, $dateFormat=plgsoft_date_format) {
}

function categories_checkbox_list() {
	$args = array('taxonomy' => 'listing', 'hide_empty' => 0, 'hierarchical' => true);
	$categories = get_categories($args);
	return $categories;
}

function get_array_question_categories() {
	$args = array('taxonomy' => 'listing', 'hide_empty' => 0, 'hierarchical' => true);
	$categories = get_categories($args);
	$array_categories = array();
	foreach ($categories as $category) {
		$array_categories[$category->term_id] = $category->name;
	}
	return $array_categories;
}

function get_view_quotes($total_question, $list_question, $list_answer, $array_answer_id, $array_reply, $quotes_obj, $category_name) {
	$id = isset($quotes_obj['id']) ? $quotes_obj['id'] : "";
	$from_user = isset($quotes_obj['from_user']) ? $quotes_obj['from_user'] : "";
	$to_user = isset($quotes_obj['to_user']) ? $quotes_obj['to_user'] : "";
	$message = isset($quotes_obj['message']) ? $quotes_obj['message'] : "";
	$image = isset($quotes_obj['image']) ? $quotes_obj['image'] : "";
	$status = isset($quotes_obj['status']) ? $quotes_obj['status'] : "";
	$anything_else = isset($quotes_obj['anything_else']) ? $quotes_obj['anything_else'] : "";
	$about_yourself = isset($quotes_obj['about_yourself']) ? $quotes_obj['about_yourself'] : "";
	$zip_code = isset($quotes_obj['zip_code']) ? $quotes_obj['zip_code'] : "";
	$email_address = isset($quotes_obj['email_address']) ? $quotes_obj['email_address'] : "";
	$phone_number = isset($quotes_obj['phone_number']) ? $quotes_obj['phone_number'] : "";
	$full_name = isset($quotes_obj['full_name']) ? $quotes_obj['full_name'] : "";
	$category_id = isset($quotes_obj['category_id']) ? $quotes_obj['category_id'] : 0;
	$send_date = isset($quotes_obj['send_date']) ? $quotes_obj['send_date'] : "";
	$result = '';
	if (isset($total_question) && ($total_question > 0)) {
		$result .= '<div class="row-fluid">';
			$index_question = 1;
			$number_column_question = ceil($total_question/2);
			foreach ($list_question as $item_question) {
				$question_id = $item_question["question_id"];
				$question_type = $item_question["question_type"];
				$have_other_answer = $item_question["have_other_answer"];
				$list_each_answer = isset($list_answer[$question_id]) ? $list_answer[$question_id] : array();
				$total_each_answer = sizeof($list_each_answer);

				$question_class_container = isset($array_errors[$question_id]) ? 'question_errors_container' : 'question_container';
				$answer_class = isset($array_errors[$question_id]) ? 'answer_errors' : 'answer';
				if ($index_question % $number_column_question == 1) { $result .= '<div style="float: left; width: 49%;">'; }
					$result .= '<div class="question">';
						$result .= '<input type="hidden" id="is_optional'.$question_id.'" name="is_optional'.$question_id.'" value="'.$item_question["is_optional"].'">';
						$result .= $item_question["question_name"];
					$result .= '</div>';
					$result .= '<div class="'.$question_class_container.'">';
						if (isset($total_each_answer) && ($total_each_answer > 0)) {
							$index_answer = 0;
							foreach ($list_each_answer as $item_each_answer) {
								$result .= '<div>';
									if (isset($question_type) && ($question_type == 'checkbox')) {
										$result .= '<input disabled="disabled" style="border: 1px solid #077acc;" type="checkbox" id="answer'.$question_id.'" name="answer'.$question_id.'[]" ';
										$result .= 'value="'.$item_each_answer["answer_id"].'" ';
										if (isset($array_answer_id) && sizeof($array_answer_id) && in_array($item_each_answer["answer_id"], $array_answer_id)) {
											$result .= 'checked="checked" ';
										}
										$result .= '>';
									} else {
										$result .= '<input disabled="disabled" style="border: 1px solid #077acc;" type="radio" id="answer'.$question_id.'" name="answer'.$question_id.'" ';
										$result .= 'value="'.$item_each_answer["answer_id"].'" ';
										if (isset($array_answer_id) && sizeof($array_answer_id) && in_array($item_each_answer["answer_id"], $array_answer_id)) {
											$result .= 'checked="checked" ';
										}
										$result .= '>';
									}
									$result .= $item_each_answer["answer_name"];
								$result .= '</div>';
								$index_answer++;
							}
							if (isset($have_other_answer) && ($have_other_answer == 1)) {
								$result .= '<div>';
									$reply_name = isset($array_reply[$question_id]["reply_name"]) ? $array_reply[$question_id]["reply_name"] : "";
									if (isset($question_type) && ($question_type == 'checkbox')) {
										$result .= '<input disabled="disabled" style="border: 1px solid #077acc;" type="checkbox" name="question'.$question_id.'" value="1" ';
										if (isset($reply_name) && (strlen($reply_name) > 0)) { $result .= 'checked="checked" '; }
										$result .= '>';
									} else {
										$result .= '<input disabled="disabled" style="border: 1px solid #077acc;" type="radio" name="question'.$question_id.'" value="1" ';
										if (isset($reply_name) && (strlen($reply_name) > 0)) { $result .= 'checked="checked" '; }
										$result .= '>';
									}
									$result .= '<input disabled="disabled" style="border: 1px solid #077acc;" type="text" id="reply_name'.$question_id.'" ';
									$result .= 'name="reply_name'.$question_id.'" value="'.$reply_name.'" size="40" placeholder="Other" />';
								$result .= '</div>';
							}
						}
					$result .= '</div>';
					if ($index_question == $total_question) {
						$result .= '<div class="question">Is there anything else the business should know?</div>';
						$result .= '<div class="question_container">';
							$result .= '<div class="top-answer">';
								$result .= '<input disabled="disabled" style="border: 1px solid #077acc;" type="radio" name="anything_else" value="0" ';
								if (isset($anything_else) && ($anything_else == 0)) { $result .= 'checked="checked" '; }
								$result .= '> No';
							$result .= '</div>';
							$result .= '<div class="answer">';
								$result .= '<input disabled="disabled" style="border: 1px solid #077acc;" type="radio" name="anything_else" value="1" ';
								if (isset($anything_else) && ($anything_else == 0)) { $result .= 'checked="checked" '; }
								$result .= '> Yes';
							$result .= '</div>';
						$result .= '</div>';
						$result .= '<div class="question">Which city do you need '.$category_name.'?</div>';
						$result .= '<div>';
							$result .= '<div>';
								$result .= 'Zip code <input disabled="disabled" style="border: 1px solid #077acc;" type="text" id="zip_code" name="zip_code" value="'.$zip_code.'" size="30" placeholder="Zip code" />';
							$result .= '</div>';
						$result .= '</div>';
						$result .= '<div class="question">Your information.</div>';
						$result .= '<div>';
							$result .= '<div class="top-answer">';
								$result .= '<input disabled="disabled" style="border: 1px solid #077acc;" type="radio" name="about_yourself" value="0" ';
								if (isset($about_yourself) && ($about_yourself == 0)) { $result .= 'checked="checked" '; }
								$result .= '> I want quotes by email and text message';
							$result .= '</div>';
							$result .= '<div class="answer">';
								$result .= '<input disabled="disabled" style="border: 1px solid #077acc;" type="radio" name="about_yourself" value="1" ';
									if (isset($about_yourself) && ($about_yourself == 1)) { $result .= 'checked="checked" '; }
									$result .= '> I want quotes by email only';
							$result .= '</div>';
							$result .= '<div>';
								$result .= '<div>Email address</div>';
								$result .= '<input disabled="disabled" style="border: 1px solid #077acc;" type="text" id="email_address" name="email_address" value="'.$email_address.'" size="30" placeholder="Email address" />';
							$result .= '</div>';
							$result .= '<div>';
								$result .= '<div>Phone number</div>';
								$result .= '<input disabled="disabled" style="border: 1px solid #077acc;" type="text" id="phone_number" name="phone_number" value="'.$phone_number.'" size="30" placeholder="Phone number" />';
							$result .= '</div>';
							$result .= '<div>';
								$result .= '<div>Full name</div>';
								$result .= '<input disabled="disabled" style="border: 1px solid #077acc;" type="text" id="full_name" name="full_name" value="'.$full_name.'" size="30" placeholder="Full name" />';
							$result .= '</div>';
						$result .= '</div>';
					}
				if ($index_question % $number_column_question == 0) { $result .= '</div>'; }
				$index_question++;
			}
			$result .= '<div class="clearfix"></div>';
		$result .= '</div>';
	}
	return $result;
}
?>
