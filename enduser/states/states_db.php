<?php
class states_db {
	var $table_name = "plgsoft_states";
	var $array_country_key = array();

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

	function get_total_states($country_key="US") {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(state_id) AS cnt FROM " .$table_name.
				" WHERE is_active='1'";
		if (strlen($country_key) > 0) {
			$sql .= "AND country_key='".$country_key."'";
		}
		$total_states = $wpdb->get_var($sql);
		return $total_states;
	}

	function get_all_states($country_key="US", $limit=0, $offset=0) {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT state_id, state_name, state_code, order_listing, country_key, is_active, seo_title, seo_description FROM " .$table_name.
				" WHERE is_active='1'";
		if (strlen($country_key) > 0) {
			$sql .= "AND country_key='".$country_key."'";
		}
		$sql .= " ORDER BY order_listing";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
		}
		$list_results = $wpdb->get_results($sql);
		$index = 0;
		foreach ($list_results as $item_obj) {
			if (!in_array($item_obj->country_key, $this->array_country_key)) {
				$this->array_country_key[] = $item_obj->country_key;
			}
			$results[$index]['state_id'] = $item_obj->state_id;
			$results[$index]['state_name'] = $item_obj->state_name;
			$results[$index]['state_code'] = strtolower($item_obj->state_code);
			$results[$index]['order_listing'] = $item_obj->order_listing;
			$results[$index]['country_key'] = strtolower($item_obj->country_key);
			$results[$index]['is_active'] = $item_obj->is_active;
			$results[$index]['seo_title'] = $item_obj->seo_title;
			$results[$index]['seo_description'] = $item_obj->seo_description;
			$index++;
		}
		return $results;
	}

	function get_array_states($country_key="US", $limit=0, $offset=0) {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT state_id, state_name, state_code, order_listing, country_key, is_active, seo_title, seo_description FROM " .$table_name.
				" WHERE is_active='1'";
		if (strlen($country_key) > 0) {
			$sql .= "AND country_key='".$country_key."'";
		}
		$sql .= " ORDER BY order_listing";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
		}
		$list_results = $wpdb->get_results($sql);
		foreach ($list_results as $item_obj) {
			if (!in_array($item_obj->country_key, $this->array_country_key)) {
				$this->array_country_key[] = $item_obj->country_key;
			}
			$results[strtolower($item_obj->state_name)] = strtolower($item_obj->state_code);
		}
		return $results;
	}

	function get_all_plgsoft_states_by_array_state_id($array_state_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_state_id) == 0) {
			return array();
		} else {
			$string_state_id = implode("','", $array_state_id);
			$sql = "SELECT state_id, state_name " .
				" FROM " . $table_name;
			$sql .= " WHERE state_id IN ('".$string_state_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->state_id] = $item_obj->state_name;
			}
			return $array_result;
		}
	}

	function get_plgsoft_states_by_state_id($state_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE state_id='" . $state_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['state_id'] = $item_obj->state_id;
				$result_obj['state_name'] = $item_obj->state_name;
				$result_obj['state_code'] = strtolower($item_obj->state_code);
				$result_obj['order_listing'] = $item_obj->order_listing;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['country_key'] = strtolower($item_obj->country_key);
				$result_obj['permalink'] = $item_obj->permalink;
				$result_obj['seo_title'] = $item_obj->seo_title;
				$result_obj['seo_description'] = $item_obj->seo_description;
			}
			return $result_obj;
		}
	}

	function get_plgsoft_states_by_state_name($state_name) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$state_name = strtolower($state_name);
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE LOWER(state_name) = '" . $state_name . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['state_id'] = $item_obj->state_id;
				$result_obj['state_name'] = $item_obj->state_name;
				$result_obj['state_code'] = strtolower($item_obj->state_code);
				$result_obj['order_listing'] = $item_obj->order_listing;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['country_key'] = strtolower($item_obj->country_key);
				$result_obj['permalink'] = $item_obj->permalink;
				$result_obj['seo_title'] = $item_obj->seo_title;
				$result_obj['seo_description'] = $item_obj->seo_description;
			}
			return $result_obj;
		}
	}
}
?>
