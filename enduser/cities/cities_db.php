<?php
class cities_db {
	var $table_name = "plgsoft_cities";
	var $array_country_key = array();
	var $array_state_id = array();

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_array_country_key() {
		return $this->array_country_key;
	}
	function set_array_country_key($array_country_key) {
		$this->array_country_key = $array_country_key;
	}

	function get_array_state_id() {
		return $this->array_state_id;
	}
	function set_array_state_id($array_state_id) {
		$this->array_state_id = $array_state_id;
	}

	function get_total_cities($state_id=0) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(city_id) AS cnt FROM " .$table_name.
				" WHERE is_active='1'";
		if ($state_id > 0) {
			$sql .= " AND state_id='".$state_id."'";
		}
		$total_cities = $wpdb->get_var($sql);
		return $total_cities;
	}

	function get_all_cities($state_id=0) {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT city_id, city_name, city_code, order_listing, is_active, state_id, permalink, country_key, seo_title, seo_description FROM " .$table_name.
				" WHERE is_active='1'";
		$sql .= " AND state_id='".$state_id."'";
		$sql .= " ORDER BY city_name";
		$list_results = $wpdb->get_results($sql);
		$index = 0;
		foreach ($list_results as $item_obj) {
			$results[$index]['city_id'] = $item_obj->city_id;
			$results[$index]['city_name'] = $item_obj->city_name;
			$results[$index]['city_code'] = strtolower($item_obj->city_code);
			$results[$index]['order_listing'] = $item_obj->order_listing;
			$results[$index]['is_active'] = $item_obj->is_active;
			$results[$index]['state_id'] = $item_obj->state_id;
			$results[$index]['permalink'] = $item_obj->permalink;
			$results[$index]['country_key'] = strtolower($item_obj->country_key);
			$results[$index]['seo_title'] = $item_obj->seo_title;
			$results[$index]['seo_description'] = $item_obj->seo_description;
			if (!in_array($item_obj->country_key, $this->array_country_key)) {
				$this->array_country_key[] = $item_obj->country_key;
			}
			if (!in_array($item_obj->state_id, $this->array_state_id)) {
				$this->array_state_id[] = $item_obj->state_id;
			}
			$index++;
		}
		return $results;
	}

	function get_all_top_cities() {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT city_id, city_name, city_code, order_listing, is_active, state_id, permalink, country_key, seo_title, seo_description FROM " .$table_name.
				" WHERE is_active='1' AND is_top='1'";
		$sql .= " ORDER BY order_listing";
		$list_results = $wpdb->get_results($sql);
		$index = 0;
		foreach ($list_results as $item_obj) {
			$results[$index]['city_id'] = $item_obj->city_id;
			$results[$index]['city_name'] = $item_obj->city_name;
			$results[$index]['city_code'] = strtolower($item_obj->city_code);
			$results[$index]['order_listing'] = $item_obj->order_listing;
			$results[$index]['is_active'] = $item_obj->is_active;
			$results[$index]['state_id'] = $item_obj->state_id;
			$results[$index]['permalink'] = $item_obj->permalink;
			$results[$index]['country_key'] = strtolower($item_obj->country_key);
			$results[$index]['seo_title'] = $item_obj->seo_title;
			$results[$index]['seo_description'] = $item_obj->seo_description;
			if (!in_array($item_obj->country_key, $this->array_country_key)) {
				$this->array_country_key[] = $item_obj->country_key;
			}
			if (!in_array($item_obj->state_id, $this->array_state_id)) {
				$this->array_state_id[] = $item_obj->state_id;
			}
			$index++;
		}
		return $results;
	}

	function get_all_more_cities() {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT city_id, city_name, city_code, order_listing, is_active, state_id, permalink, country_key, seo_title, seo_description FROM " .$table_name.
				" WHERE is_active='1' AND is_more='1'";
		$sql .= " ORDER BY order_listing";
		$list_results = $wpdb->get_results($sql);
		$index = 0;
		foreach ($list_results as $item_obj) {
			$results[$index]['city_id'] = $item_obj->city_id;
			$results[$index]['city_name'] = $item_obj->city_name;
			$results[$index]['city_code'] = strtolower($item_obj->city_code);
			$results[$index]['order_listing'] = $item_obj->order_listing;
			$results[$index]['is_active'] = $item_obj->is_active;
			$results[$index]['state_id'] = $item_obj->state_id;
			$results[$index]['permalink'] = $item_obj->permalink;
			$results[$index]['country_key'] = strtolower($item_obj->country_key);
			$results[$index]['seo_title'] = $item_obj->seo_title;
			$results[$index]['seo_description'] = $item_obj->seo_description;
			if (!in_array($item_obj->country_key, $this->array_country_key)) {
				$this->array_country_key[] = $item_obj->country_key;
			}
			if (!in_array($item_obj->state_id, $this->array_state_id)) {
				$this->array_state_id[] = $item_obj->state_id;
			}
			$index++;
		}
		return $results;
	}

	function get_all_plgsoft_cities_by_array_city_id($array_city_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_city_id) == 0) {
			return array();
		} else {
			$string_city_id = implode("','", $array_city_id);
			$sql = "SELECT city_id, city_name " .
				" FROM " . $table_name;
			$sql .= " WHERE city_id IN ('".$string_city_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->city_id] = $item_obj->city_name;
			}
			return $array_result;
		}
	}

	function get_plgsoft_cities_by_city_id($city_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE city_id='" . $city_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['city_id'] = $item_obj->city_id;
				$result_obj['city_name'] = $item_obj->city_name;
				$result_obj['city_code'] = $item_obj->city_code;
				$result_obj['order_listing'] = $item_obj->order_listing;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['country_key'] = strtolower($item_obj->country_key);
				$result_obj['state_id'] = $item_obj->state_id;
				$result_obj['permalink'] = $item_obj->permalink;
				$result_obj['seo_title'] = $item_obj->seo_title;
				$result_obj['seo_description'] = $item_obj->seo_description;
			}
			return $result_obj;
		}
	}
}
?>
