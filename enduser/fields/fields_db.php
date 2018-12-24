<?php
class fields_db {
	var $table_name = "plgsoft_fields";

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_total_fields($array_keywords=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(field_key) AS cnt FROM " .$table_name.
				" WHERE is_active='1'";
		$total_fields = $wpdb->get_var($sql);
		return $total_fields;
	}

	function get_all_fields($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT field_key, field_name, order_listing, is_active, field_description, field_placeholder, field_type, field_business_type, field_option_type, field_option_value FROM " .$table_name.
				" WHERE is_active='1'" .
				" ORDER BY order_listing";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
		}
		$list_results = $wpdb->get_results($sql);
		$index = 0;
		foreach ($list_results as $item_obj) {
			$results[$index]['field_key'] = strtolower($item_obj->field_key);
			$results[$index]['field_name'] = $item_obj->field_name;
			$results[$index]['order_listing'] = $item_obj->order_listing;
			$results[$index]['is_active'] = $item_obj->is_active;
			$results[$index]['field_description'] = $item_obj->field_description;
			$results[$index]['field_placeholder'] = $item_obj->field_placeholder;
			$results[$index]['field_type'] = $item_obj->field_type;
			$results[$index]['field_business_type'] = $item_obj->field_business_type;
			$results[$index]['field_option_type'] = $item_obj->field_option_type;
			$results[$index]['field_option_value'] = $item_obj->field_option_value;
			$index++;
		}
		return $results;
	}

	function get_all_array_fields() {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT field_key, field_name, order_listing, is_active, field_description, field_placeholder, field_type, field_business_type, field_option_type, field_option_value FROM " .$table_name.
				" WHERE is_active='1'" .
				" ORDER BY order_listing";
		$list_results = $wpdb->get_results($sql);
		$results["preferred_date_of_service"] = "Preferred date of service";
		foreach ($list_results as $item_obj) {
			$results[strtolower($item_obj->field_key)] = $item_obj->field_name;
		}
		return $results;
	}

	function get_all_plgsoft_fields_by_array_field_key($array_field_key=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_field_key) == 0) {
			return array();
		} else {
			$string_field_key = implode("','", $array_field_key);
			$sql = "SELECT field_key, field_name " .
				" FROM " . $table_name;
			$sql .= " WHERE field_key IN ('".$string_field_key."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->field_key] = $item_obj->field_name;
			}
			return $array_result;
		}
	}
}
?>
