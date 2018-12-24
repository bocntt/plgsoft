<?php
class business_database {
	var $table_name = "business";
	var $array_business_id = array();

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_array_business_id() {
		return $this->array_business_id;
	}
	function set_array_business_id($array_business_id) {
		$this->array_business_id = $array_business_id;
	}

	function get_total_plgsoft_business($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(business_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(business_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_title) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_description) LIKE '%".$keyword."%')";
			}
			$total_business = $wpdb->get_var($sql);
			return $total_business;
		}
	}

	function get_list_plgsoft_business($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT * FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(business_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_title) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_description) LIKE '%".$keyword."%')";
			}
			$sql .= " ORDER BY business_id DESC";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				foreach ($item_obj as $key => $value) {
					$array_result[$index][$key] = $value;
				}
				if (!in_array($item_obj->business_id, $this->array_business_id)) {
					$this->array_business_id[] = $item_obj->business_id;
				}
				$index++;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_business_by_array_business_id($array_business_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_business_id) == 0) {
			return array();
		} else {
			$string_business_id = implode("','", $array_business_id);
			$sql = "SELECT business_id, business_name " .
				" FROM " . $table_name;
			$sql .= " WHERE business_id IN ('".$string_business_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->business_id] = $item_obj->business_name;
			}
			return $array_result;
		}
	}

	function get_plgsoft_business_by_business_id($business_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE business_id='" . $business_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				foreach ($item_obj as $key => $value) {
					$result_obj[$key] = $value;
				}
			}
			return $result_obj;
		}
	}

	function check_exist_business_name($business_name, $business_id=0) {
		global $wpdb;
		$business_name = strtolower(trim($business_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(business_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(business_name)='".esc_sql($business_name)."' AND business_id <> '".$business_id."'";
			$total_business = $wpdb->get_var($sql);
			if ($total_business == 0)
				return false;
			else
				return true;
		}
	}

	function check_exist_permalink($permalink, $business_id=0) {
		global $wpdb;
		$permalink = strtolower(trim($permalink));
		$permalink = get_plgsoft_permalink($permalink);
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(business_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(permalink)='".esc_sql($permalink)."' AND business_id <> '".$business_id."'";
			$total_business = $wpdb->get_var($sql);
			if ($total_business == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_business($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$business_name = isset($item_obj['business_name']) ? trim($item_obj['business_name']) : "";
			$cat_image     = isset($item_obj['cat_image']) ? trim($item_obj['cat_image']) : "";
			$description   = isset($item_obj['description']) ? trim($item_obj['description']) : "";
			$keywords      = isset($item_obj['keywords']) ? trim($item_obj['keywords']) : "";
			$is_active     = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$permalink     = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			if (strlen($permalink) == 0) $permalink = $business_name;
			$permalink = get_plgsoft_permalink($permalink);
			$sql = "INSERT INTO ".$table_name."(business_name, cat_image, description, keywords, permalink, is_active) " .
				" VALUES ('%s', '%s', '%s', '%s', '%s', '%d')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$business_name,
						$cat_image,
						$description,
						$keywords,
						$permalink,
						$is_active
					)
				)
			);
		}
	}

	function update_plgsoft_business($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$business_id   = isset($item_obj['business_id']) ? (int) trim($item_obj['business_id']) : 0;
			$business_name = isset($item_obj['business_name']) ? trim($item_obj['business_name']) : "";
			$cat_image     = isset($item_obj['cat_image']) ? trim($item_obj['cat_image']) : "";
			$description   = isset($item_obj['description']) ? trim($item_obj['description']) : "";
			$keywords      = isset($item_obj['keywords']) ? trim($item_obj['keywords']) : "";
			$is_active     = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$permalink     = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			if (strlen($permalink) == 0) $permalink = $business_name;
			$permalink = get_plgsoft_permalink($permalink);
			$sql = "UPDATE ".$table_name." SET business_name='%s', " .
				" cat_image='%s', " .
				" description='%s', " .
				" keywords='%s', " .
				" permalink='%s', " .
				" is_active='%d' " .
			" WHERE business_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$business_name,
						$cat_image,
						$description,
						$keywords,
						$permalink,
						$is_active,
						$business_id
					)
				)
			);
		}
	}

	function delete_plgsoft_business($business_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($business_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE business_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$business_id
				)
			);
		}
	}

	function active_plgsoft_business($business_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE business_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$business_id
				)
			);
		}
	}

	function deactive_plgsoft_business($business_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE business_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$business_id
				)
			);
		}
	}

	function get_total_plgsoft_business_by_business_id($business_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(business_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if ($business_id > 0) {
				$sql .= " AND business_id = '".$business_id."'";
			}
			$total_business = $wpdb->get_var($sql);
			return $total_business;
		}
	}

	function get_all_plgsoft_business_by_business_id($business_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT * FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if ($business_id > 0) {
				$sql .= " AND business_id = '".$business_id."'";
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				foreach ($item_obj as $key => $value) {
					$array_result[$index][$key] = $value;
				}
				$index++;
			}
			return $array_result;
		}
	}
}
?>
