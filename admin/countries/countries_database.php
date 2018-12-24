<?php
class countries_database {
	var $table_name;

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_total_plgsoft_countries($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(country_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(country_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(country_key) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_title) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_description) LIKE '%".$keyword."%')";
			}
			$total_countries = $wpdb->get_var($sql);
			return $total_countries;
		}
	}

	function get_list_plgsoft_countries($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT country_id, country_key, country_name, is_active, order_listing, seo_title, seo_description " .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(country_name) LIKE '%".$keyword."%')";
				$sql .= " AND (LOWER(country_key) LIKE '%".$keyword."%')";
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
				$array_result[$index]['country_id'] = $item_obj->country_id;
				$array_result[$index]['country_key'] = strtolower($item_obj->country_key);
				$array_result[$index]['country_name'] = $item_obj->country_name;
				$array_result[$index]['order_listing'] = $item_obj->order_listing;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$index++;
			}
			return $array_result;
		}
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

	function get_plgsoft_countries_by_country_key($country_key) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE country_key='" . $country_key . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['country_id'] = $item_obj->country_id;
				$result_obj['country_key'] = strtolower($item_obj->country_key);
				$result_obj['country_name'] = $item_obj->country_name;
				$result_obj['order_listing'] = $item_obj->order_listing;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['seo_title'] = $item_obj->seo_title;
				$result_obj['seo_description'] = $item_obj->seo_description;
			}
			return $result_obj;
		}
	}

	function get_plgsoft_countries_by_country_id($country_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE country_id='" . $country_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['country_id'] = $item_obj->country_id;
				$result_obj['country_key'] = strtolower($item_obj->country_key);
				$result_obj['country_name'] = $item_obj->country_name;
				$result_obj['order_listing'] = $item_obj->order_listing;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['seo_title'] = $item_obj->seo_title;
				$result_obj['seo_description'] = $item_obj->seo_description;
			}
			return $result_obj;
		}
	}

	function check_exist_country_name($country_name, $country_id = 0) {
		global $wpdb;
		$country_name = strtolower(trim($country_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(country_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(country_name)='".esc_sql($country_name)."' AND country_id <> '".$country_id."'";
			$total_countries = $wpdb->get_var($sql);
			if ($total_countries == 0)
				return false;
			else
				return true;
		}
	}

	function check_exist_country_key($country_key, $country_id = 0) {
		global $wpdb;
		$country_key = strtolower(trim($country_key));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(country_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(country_key)='".esc_sql($country_key)."' AND country_id <> '". $country_id ."'";
			$total_countries = $wpdb->get_var($sql);
			if ($total_countries == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_countries($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$country_key     = isset($item_obj['country_key']) ? trim($item_obj['country_key']) : "";
			$order_listing   = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$country_name    = isset($item_obj['country_name']) ? trim($item_obj['country_name']) : "";
			$is_active       = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$permalink       = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			$seo_title       = isset($item_obj['seo_title']) ? trim($item_obj['seo_title']) : "";
			$seo_description = isset($item_obj['seo_description']) ? trim($item_obj['seo_description']) : "";
			if (strlen($permalink) == 0) $permalink = get_plgsoft_permalink($country_name);
			$sql = "INSERT INTO ".$table_name."(country_key, country_name, order_listing, is_active, permalink, seo_title, seo_description) " .
				" VALUES ('%s', '%s', '%d', '%d', '%s', '%s', '%s')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$country_key,
						$country_name,
						$order_listing,
						$is_active,
						$permalink,
						$seo_title,
						$seo_description
					)
				)
			);
		}
	}

	function update_plgsoft_countries($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$country_id     = isset($item_obj['country_id']) ? (int) trim($item_obj['country_id']) : 0;
			$country_key     = isset($item_obj['country_key']) ? trim($item_obj['country_key']) : "";
			$order_listing   = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$country_name    = isset($item_obj['country_name']) ? trim($item_obj['country_name']) : "";
			$is_active       = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$permalink       = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			$seo_title       = isset($item_obj['seo_title']) ? trim($item_obj['seo_title']) : "";
			$seo_description = isset($item_obj['seo_description']) ? trim($item_obj['seo_description']) : "";
			if (strlen($permalink) == 0) $permalink = get_plgsoft_permalink($country_name);
			$sql = "UPDATE ".$table_name." SET country_name='%s', " .
				" country_key='%s', " .
				" order_listing='%d', " .
				" permalink='%s', " .
				" seo_title='%s', " .
				" seo_description='%s', " .
				" is_active='%d' " .
			" WHERE country_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$country_name,
						$country_key,
						$order_listing,
						$permalink,
						$seo_title,
						$seo_description,
						$is_active,
						$country_id
					)
				)
			);
		}
	}

	function delete_plgsoft_countries($country_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if ((strlen($country_id) > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE country_id='" .esc_sql($country_id). "'";
			$wpdb->query($sql);
		}
	}

	function active_plgsoft_countries($country_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE country_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $country_id));
		}
	}

	function deactive_plgsoft_countries($country_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE country_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $country_id));
		}
	}
}
?>
