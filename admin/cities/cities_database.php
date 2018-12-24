<?php
class cities_database {
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

	function get_total_plgsoft_cities($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(city_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(city_name) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(seo_title) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(seo_description) LIKE '%%%s%%')";
				$total_cities = $wpdb->get_var(
					$wpdb->prepare(
						$sql,
						array(
							$keyword,
							$keyword,
							$keyword
						)
					)
				);
			} else {
				$total_cities = $wpdb->get_var($sql);
			}
			return $total_cities;
		}
	}

	function get_list_plgsoft_cities($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT city_id, city_name, is_active, is_top, is_more, order_listing, country_key, state_id, permalink, seo_title, seo_description " .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(city_name) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(seo_title) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(seo_description) LIKE '%%%s%%')";
			}
			$sql .= " ORDER BY order_listing";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			if (strlen($keyword) > 0) {
				$list_results = $wpdb->get_results($wpdb->prepare($sql, array($keyword, $keyword, $keyword)));
			} else {
				$list_results = $wpdb->get_results($sql);
			}
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				$array_result[$index]['city_id']         = $item_obj->city_id;
				$array_result[$index]['city_name']       = $item_obj->city_name;
				$array_result[$index]['order_listing']   = $item_obj->order_listing;
				$array_result[$index]['is_active']       = $item_obj->is_active;
				$array_result[$index]['is_top']          = $item_obj->is_top;
				$array_result[$index]['is_more']         = $item_obj->is_more;
				$array_result[$index]['country_key']     = strtolower($item_obj->country_key);
				$array_result[$index]['state_id']        = $item_obj->state_id;
				$array_result[$index]['permalink']       = $item_obj->permalink;
				$array_result[$index]['seo_title']       = $item_obj->seo_title;
				$array_result[$index]['seo_description'] = $item_obj->seo_description;
				if (!in_array($item_obj->country_key, $this->array_country_key)) {
					$this->array_country_key[] = $item_obj->country_key;
				}
				if (!in_array($item_obj->state_id, $this->array_state_id)) {
					$this->array_state_id[] = $item_obj->state_id;
				}
				$index++;
			}
			return $array_result;
		}
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
			$sql .= " WHERE city_id IN ('%s')";
			$list_results = $wpdb->get_results($wpdb->prepare($sql, $string_city_id));
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->city_id] = $item_obj->city_name;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_cities_by_state_id($state_id=0) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if ($state_id == 0) {
			return array();
		} else {
			$sql = "SELECT city_id, city_name " .
				" FROM " . $table_name;
			$sql .= " WHERE state_id = '%d'";
			$list_results = $wpdb->get_results($wpdb->prepare($sql, $state_id));
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
				" FROM " . $table_name . " WHERE city_id='%d'";
			$result_obj = $wpdb->get_row($wpdb->prepare($sql, $city_id), ARRAY_A);
			return $result_obj;
		}
	}

	function check_exist_city_name($city_name, $city_id=0) {
		global $wpdb;
		$city_name = strtolower(trim($city_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(city_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(city_name)='%s' AND city_id <> '%d'";
			$total_cities = $wpdb->get_var($wpdb->prepare($sql, array($city_name, $city_id)));
			if ($total_cities == 0)
				return false;
			else
				return true;
		}
	}

	function check_exist_permalink($permalink, $city_id=0) {
		global $wpdb;
		$permalink = strtolower(trim($permalink));
		$permalink = get_plgsoft_permalink($permalink);
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(city_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(permalink)='%s' AND city_id <> '%d'";
			$total_cities = $wpdb->get_var($wpdb->prepare($sql, array($permalink, $city_id)));
			if ($total_cities == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_cities($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			   $city_name                           = isset($item_obj['city_name']) ? trim($item_obj['city_name']) : "";
			   $is_active                           = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			   $is_top                              = isset($item_obj['is_top']) ? (int) trim($item_obj['is_top']) : 0;
			   $is_more                             = isset($item_obj['is_more']) ? (int) trim($item_obj['is_more']) : 0;
			   $state_id                            = isset($item_obj['state_id']) ? (int) trim($item_obj['state_id']) : 0;
			   $country_key                         = isset($item_obj['country_key']) ? trim($item_obj['country_key']) : "";
			   $order_listing                       = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			   $permalink                           = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			if (strlen($permalink) == 0) $permalink = $city_name;
			   $permalink                           = get_plgsoft_permalink($permalink);
			   $seo_title                           = isset($item_obj['seo_title']) ? trim($item_obj['seo_title']) : "";
			   $seo_description                     = isset($item_obj['seo_description']) ? trim($item_obj['seo_description']) : "";
			$sql = "INSERT INTO ".$table_name."(city_name, order_listing, is_active, is_top, is_more, state_id, country_key, permalink, seo_title, seo_description) " .
				" VALUES ('%s', '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$city_name,
						$order_listing,
						$is_active,
						$is_top,
						$is_more,
						$state_id,
						$country_key,
						$permalink,
						$seo_title,
						$seo_description
					)
				)
			);
		}
	}

	function update_plgsoft_cities($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			   $city_id                             = isset($item_obj['city_id']) ? (int) trim($item_obj['city_id']) : 0;
			   $order_listing                       = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			   $city_name                           = isset($item_obj['city_name']) ? trim($item_obj['city_name']) : "";
			   $is_active                           = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			   $is_top                              = isset($item_obj['is_top']) ? (int) trim($item_obj['is_top']) : 0;
			   $is_more                             = isset($item_obj['is_more']) ? (int) trim($item_obj['is_more']) : 0;
			   $state_id                            = isset($item_obj['state_id']) ? (int) trim($item_obj['state_id']) : 0;
			   $country_key                         = isset($item_obj['country_key']) ? trim($item_obj['country_key']) : "";
			   $permalink                           = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			if (strlen($permalink) == 0) $permalink = $city_name;
			   $permalink                           = get_plgsoft_permalink($permalink);
			   $seo_title                           = isset($item_obj['seo_title']) ? trim($item_obj['seo_title']) : "";
			   $seo_description                     = isset($item_obj['seo_description']) ? trim($item_obj['seo_description']) : "";
			$sql = "UPDATE ".$table_name." SET city_name='%s', " .
					" order_listing='%d', " .
					" state_id='%d', " .
					" country_key='%s', " .
					" permalink='%s', " .
					" seo_title='%s', " .
					" seo_description='%s', " .
					" is_top='%d', " .
					" is_more='%d', " .
					" is_active='%d' " .
				" WHERE city_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$city_name,
						$order_listing,
						$state_id,
						$country_key,
						$permalink,
						$seo_description,
						$seo_description,
						$is_top,
						$is_more,
						$is_active,
						$city_id
					)
				)
			);
		}
	}

	function delete_plgsoft_cities($city_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($city_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE city_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$city_id
				)
			);
		}
	}

	function active_plgsoft_cities($city_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE city_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$city_id
				)
			);
		}
	}

	function is_top_plgsoft_cities($city_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_top='1' WHERE city_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$city_id
				)
			);
		}
	}

	function is_more_plgsoft_cities($city_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_more='1' WHERE city_id= %d";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$city_id
				)
			);
		}
	}

	function deactive_plgsoft_cities($city_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE city_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$city_id
				)
			);
		}
	}

	function is_not_top_plgsoft_cities($city_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_top='0' WHERE city_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$city_id
				)
			);
		}
	}

	function is_not_more_plgsoft_cities($city_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_more='0' WHERE city_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$city_id
				)
			);
		}
	}

	function get_total_plgsoft_cities_by_country_key($country_key) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(city_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($country_key) > 0) {
				$sql .= " AND country_key = '%s'";
				$total_cities = $wpdb->get_var(
					$wpdb->prepare(
						$sql,
						$country_key
					)
				);
			} else {
				$total_cities = $wpdb->get_var($sql);
			}
			return $total_cities;
		}
	}

	function get_total_plgsoft_cities_by_state_id($state_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(city_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if ($state_id > 0) {
				$sql .= " AND state_id = '%d'";
				$total_cities = $wpdb->get_var(
					$wpdb->prepare(
						$sql,
						$state_id
					)
				);
			} else {
				$total_cities = $wpdb->get_var($sql);
			}
			return $total_cities;
		}
	}
}
?>
