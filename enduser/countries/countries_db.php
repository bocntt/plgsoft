<?php
class countries_db {
	var $table_name = "plgsoft_countries";

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_total_countries($array_keywords=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(country_key) AS cnt FROM " .$table_name.
				" WHERE is_active='1'";
		$total_countries = $wpdb->get_var($sql);
		return $total_countries;
	}

	function get_all_countries($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT country_key, country_name, order_listing, is_active, seo_title, seo_description FROM " .$table_name.
				" WHERE is_active='1'" .
				" ORDER BY order_listing";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
		}
		$list_results = $wpdb->get_results($sql);
		$index = 0;
		foreach ($list_results as $item_obj) {
			$results[$index]['country_key'] = strtolower($item_obj->country_key);
			$results[$index]['country_name'] = $item_obj->country_name;
			$results[$index]['order_listing'] = $item_obj->order_listing;
			$results[$index]['is_active'] = $item_obj->is_active;
			$results[$index]['seo_title'] = $item_obj->seo_title;
			$results[$index]['seo_description'] = $item_obj->seo_description;
			$index++;
		}
		return $results;
	}

	function get_all_plgsoft_countries_by_array_country_key($array_country_key=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_country_key) == 0) {
			return array();
		} else {
			$string_country_key = implode("','", $array_country_key);
			$sql = "SELECT country_key, country_name " .
				" FROM " . $table_name;
			$sql .= " WHERE country_key IN ('".$string_country_key."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->country_key] = $item_obj->country_name;
			}
			return $array_result;
		}
	}
}
?>
