<?php
class states_database {
	var $table_name;
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

	function get_total_plgsoft_states($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(state_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(state_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_title) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_description) LIKE '%".$keyword."%')";
			}
			$total_states = $wpdb->get_var($sql);
			return $total_states;
		}
	}

	function get_list_plgsoft_states($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT state_id, state_code, state_name, is_active, order_listing, country_key, permalink, seo_title, seo_description " .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(state_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_title) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_description) LIKE '%".$keyword."%')";
			}
			$sql .= " ORDER BY order_listing";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				$array_result[$index]['state_id'] = $item_obj->state_id;
				$array_result[$index]['state_name'] = $item_obj->state_name;
				$array_result[$index]['state_code'] = $item_obj->state_code;
				$array_result[$index]['order_listing'] = $item_obj->order_listing;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$array_result[$index]['country_key'] = strtolower($item_obj->country_key);
				$array_result[$index]['permalink'] = $item_obj->permalink;
				$array_result[$index]['seo_title'] = $item_obj->seo_title;
				$array_result[$index]['seo_description'] = $item_obj->seo_description;
				if (!in_array($item_obj->country_key, $this->array_country_key)) {
					$this->array_country_key[] = $item_obj->country_key;
				}
				$index++;
			}
			return $array_result;
		}
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

	function get_all_plgsoft_states_by_country_key($country_key) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($country_key) == 0) {
			return array();
		} else {
			$sql = "SELECT state_id, state_name " .
				" FROM " . $table_name;
			$sql .= " WHERE country_key = '".$country_key."'";
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
				$result_obj['state_code'] = $item_obj->state_code;
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

	function check_exist_state_name($state_name, $state_id=0) {
		global $wpdb;
		$state_name = strtolower(trim($state_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(state_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(state_name)='".esc_sql($state_name)."' AND state_id <> '".$state_id."'";
			$total_states = $wpdb->get_var($sql);
			if ($total_states == 0)
				return false;
			else
				return true;
		}
	}

	function check_exist_permalink($permalink, $state_id=0) {
		global $wpdb;
		$permalink = strtolower(trim($permalink));
		$permalink = get_plgsoft_permalink($permalink);
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(state_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(permalink)='".esc_sql($permalink)."' AND state_id <> '".$state_id."'";
			$total_states = $wpdb->get_var($sql);
			if ($total_states == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_states($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$state_name    = isset($item_obj['state_name']) ? trim($item_obj['state_name']) : "";
			$state_code    = isset($item_obj['state_code']) ? trim($item_obj['state_code']) : "";
			$order_listing = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$country_key   = isset($item_obj['country_key']) ? trim($item_obj['country_key']) : "";
			$is_active     = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$permalink     = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			if (strlen($permalink) == 0) $permalink = $state_name;
			$seo_title       = isset($item_obj['seo_title']) ? trim($item_obj['seo_title']) : "";
			$seo_description = isset($item_obj['seo_description']) ? trim($item_obj['seo_description']) : "";
			$permalink       = get_plgsoft_permalink($permalink);
			$sql = "INSERT INTO ".$table_name."(state_name, state_code, order_listing, is_active, country_key, permalink, seo_title, seo_description) " .
				" VALUES ('%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$state_name,
						$state_code,
						$order_listing,
						$is_active,
						$country_key,
						$permalink,
						$seo_title,
						$seo_description
					)
				)
			);
		}
	}

	function update_plgsoft_states($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$state_id      = isset($item_obj['state_id']) ? (int) trim($item_obj['state_id']) : 0;
			$order_listing = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$state_name    = isset($item_obj['state_name']) ? trim($item_obj['state_name']) : "";
			$state_code    = isset($item_obj['state_code']) ? trim($item_obj['state_code']) : "";
			$country_key   = isset($item_obj['country_key']) ? trim($item_obj['country_key']) : "";
			$is_active     = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$permalink     = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			if (strlen($permalink) == 0) $permalink = $state_name;
			$permalink       = get_plgsoft_permalink($permalink);
			$seo_title       = isset($item_obj['seo_title']) ? trim($item_obj['seo_title']) : "";
			$seo_description = isset($item_obj['seo_description']) ? trim($item_obj['seo_description']) : "";
			$sql = "UPDATE ".$table_name." SET state_name='%s', " .
				" state_code='%s', " .
				" order_listing='%d', " .
				" country_key='%s', " .
				" permalink='%s', " .
				" seo_title='%s', " .
				" seo_description='%s', " .
				" is_active='%d' " .
			" WHERE state_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$state_name,
						$state_code,
						$order_listing,
						$country_key,
						$permalink,
						$seo_title,
						$seo_description,
						$is_active,
						$state_id
					)
				)
			);
		}
	}

	function delete_plgsoft_states($state_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($state_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE state_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $state_id));
		}
	}

	function active_plgsoft_states($state_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE state_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $state_id));
		}
	}

	function deactive_plgsoft_states($state_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE state_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $state_id));
		}
	}

	function get_total_plgsoft_states_by_country_key($country_key) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(state_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($country_key) > 0) {
				$sql .= " AND country_key = '".$country_key."'";
			}
			$total_states = $wpdb->get_var($sql);
			return $total_states;
		}
	}
}
?>
